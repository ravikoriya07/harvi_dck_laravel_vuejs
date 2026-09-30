<?php

namespace App\Services\News;

use App\Enums\SocialPlatform;
use App\Models\SocialAccessToken;
use Carbon\CarbonImmutable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * LinkedIn company page posts via the Community Management API (Posts API).
 *
 * - Posts: GET /rest/posts?q=author&author={org urn}&sortBy=CREATED
 *   (the default sort is last-modified, which would make the fetched window
 *   jump whenever an old post is edited).
 * - Media: post content only carries asset URNs; preview URLs come from the
 *   Images / Videos APIs and are signed + expiring.
 * - Removal: GET /rest/posts/{urn} returns 404 for deleted posts.
 *
 * Required scopes: r_organization_social (posts) and w_organization_social
 * (LinkedIn requires it for GET /rest/images and /rest/videos).
 */
final class LinkedInFeedClient implements SocialFeedClient
{
    private const API_URL = 'https://api.linkedin.com/rest';

    private const OAUTH_URL = 'https://www.linkedin.com/oauth/v2/accessToken';

    /** Posts API maximum page size. */
    private const PAGE_SIZE = 100;

    private ?string $accessToken = null;

    public function __construct(private readonly SocialTokenManager $tokens) {}

    public function platform(): SocialPlatform
    {
        return SocialPlatform::LinkedIn;
    }

    public function isConfigured(): bool
    {
        return filled(config('services.linkedin.organization_id'))
            && filled(config('services.linkedin.access_token'));
    }

    public function fetchLatest(int $limit): SocialFeedResult
    {
        $author = 'urn:li:organization:' . config('services.linkedin.organization_id');
        $posts = [];
        $fetched = 0;
        $malformed = 0;
        $windowStart = null;
        $complete = false;
        $start = 0;
        $maxPages = (int) ceil($limit / self::PAGE_SIZE) + 5;

        for ($page = 0; $page < $maxPages && $fetched < $limit; $page++) {
            $body = $this->getJson(self::API_URL . '/posts', 'post list', [
                'q'      => 'author',
                'author' => $author,
                'count'  => min(self::PAGE_SIZE, $limit - $fetched),
                'start'  => $start,
                'sortBy' => 'CREATED',
            ], 'FINDER');

            $elements = $body['elements'] ?? null;

            if (! is_array($elements) || ! array_is_list($elements)) {
                throw SocialFeedException::malformed($this->platform(), 'post list');
            }

            foreach ($elements as $element) {
                $fetched++;
                $createdAt = is_array($element) ? $this->timestamp($element['createdAt'] ?? null) : null;

                if ($createdAt === null || ! is_string($element['id'] ?? null) || ! str_starts_with($element['id'], 'urn:li:')) {
                    $malformed++;

                    continue;
                }

                // Results are sorted by creation time, newest first
                $windowStart = $createdAt;

                if ($post = $this->normalize($element)) {
                    $posts[] = $post;
                }
            }

            // Pages can hold fewer than `count` items while more remain — only the next link means "more"
            $next = $this->nextStart($body);

            if ($next === null) {
                $complete = true;

                break;
            }

            // Pagination that does not advance is an incomplete response — no deletions from it
            if ($next <= $start) {
                $malformed++;

                break;
            }

            $start = $next;
        }

        return new SocialFeedResult($posts, $complete ? null : $windowStart, $complete, $malformed, $fetched);
    }

    /**
     * One GET per asset: the Community Management API Development tier rejects
     * BATCH_GET calls. Lookups only run for new/changed posts, so volume is low.
     */
    public function resolveMediaUrls(array $posts): array
    {
        $byUrn = [];

        foreach ($posts as $post) {
            if ($post->mediaKey !== null) {
                $byUrn[$post->mediaKey][] = $post->externalId;
            }
        }

        $urls = [];

        foreach ($byUrn as $urn => $externalIds) {
            [$endpoint, $field] = match (true) {
                str_starts_with($urn, 'urn:li:image:') => ['/images/', 'downloadUrl'],
                str_starts_with($urn, 'urn:li:video:') => ['/videos/', 'thumbnail'],
                default                                => [null, null],
            };

            if ($endpoint === null) {
                continue;
            }

            try {
                $asset = $this->getJson(self::API_URL . $endpoint . rawurlencode($urn), 'media lookup');
            } catch (SocialFeedException $e) {
                // Throttled or unauthorised: stop and retry next sync. Anything else only skips this asset.
                if (in_array($e->reason, [SocialFeedException::RATE_LIMITED, SocialFeedException::AUTH], true)) {
                    throw $e;
                }

                continue;
            }

            if (is_string($asset[$field] ?? null) && $asset[$field] !== '') {
                foreach ($externalIds as $externalId) {
                    $urls[$externalId] = $asset[$field];
                }
            }
        }

        return $urls;
    }

    public function confirmRemoval(string $externalId): bool
    {
        try {
            $response = $this->request()->get(self::API_URL . '/posts/' . rawurlencode($externalId));
        } catch (ConnectionException $e) {
            throw SocialFeedException::fromConnection($this->platform(), $e, 'post lookup');
        }

        if (in_array($response->status(), [404, 410], true)) {
            return true;
        }

        if ($response->successful() && is_array($response->json())) {
            // Still exists: remove only if it is no longer public on the company page
            return $this->normalize($response->json()) === null;
        }

        throw SocialFeedException::fromResponse($this->platform(), $response, 'post lookup');
    }

    /**
     * Only posts a visitor can see on the company page: published, public and
     * distributed to the feed (sponsored "dark" posts use feedDistribution NONE).
     */
    private function normalize(array $element): ?SocialPostData
    {
        $visible = ($element['lifecycleState'] ?? null) === 'PUBLISHED'
            && ($element['visibility'] ?? null) === 'PUBLIC'
            && ($element['distribution']['feedDistribution'] ?? 'MAIN_FEED') !== 'NONE';

        $id = $element['id'] ?? null;
        $publishedAt = $this->timestamp($element['publishedAt'] ?? null) ?? $this->timestamp($element['createdAt'] ?? null);

        if (! $visible || ! is_string($id) || $publishedAt === null) {
            return null;
        }

        $content = is_array($element['content'] ?? null) ? $element['content'] : [];
        [$mediaType, $mediaKey, $altText] = $this->media($content);

        $caption = LinkedInText::toPlain(is_string($element['commentary'] ?? null) ? $element['commentary'] : null)
            ?? (is_string($content['article']['title'] ?? null) ? trim($content['article']['title']) : null);

        if (blank($caption) && $mediaKey === null) {
            return null;
        }

        return new SocialPostData(
            platform: $this->platform(),
            externalId: $id,
            permalink: "https://www.linkedin.com/feed/update/{$id}/",
            caption: blank($caption) ? null : $caption,
            mediaType: $mediaType,
            publishedAt: $publishedAt,
            mediaKey: $mediaKey,
            altText: is_string($altText) && trim($altText) !== '' ? trim($altText) : null,
            sourceUpdatedAt: $this->timestamp($element['lastModifiedAt'] ?? null),
        );
    }

    /**
     * @return array{0: string, 1: string|null, 2: mixed}
     */
    private function media(array $content): array
    {
        $mediaId = $content['media']['id'] ?? null;

        if (is_string($mediaId)) {
            return match (true) {
                str_starts_with($mediaId, 'urn:li:image:') => [SocialPostData::TYPE_IMAGE, $mediaId, $content['media']['altText'] ?? null],
                str_starts_with($mediaId, 'urn:li:video:') => [SocialPostData::TYPE_VIDEO, $mediaId, null],
                // Documents etc. have no preview image
                default => [SocialPostData::TYPE_TEXT, null, null],
            };
        }

        $images = $content['multiImage']['images'] ?? null;

        if (is_array($images) && is_string($images[0]['id'] ?? null)) {
            $type = count($images) > 1 ? SocialPostData::TYPE_CAROUSEL : SocialPostData::TYPE_IMAGE;

            return [$type, $images[0]['id'], $images[0]['altText'] ?? null];
        }

        $thumbnail = $content['article']['thumbnail'] ?? null;

        if (is_string($thumbnail) && str_starts_with($thumbnail, 'urn:li:image:')) {
            return [SocialPostData::TYPE_IMAGE, $thumbnail, null];
        }

        return [SocialPostData::TYPE_TEXT, null, null];
    }

    private function nextStart(array $body): ?int
    {
        $links = $body['paging']['links'] ?? [];

        foreach (is_array($links) ? $links : [] as $link) {
            if (is_array($link) && ($link['rel'] ?? null) === 'next' && is_string($link['href'] ?? null)) {
                parse_str((string) parse_url($link['href'], PHP_URL_QUERY), $query);

                return isset($query['start']) && is_numeric($query['start']) ? (int) $query['start'] : null;
            }
        }

        return null;
    }

    private function timestamp(mixed $milliseconds): ?CarbonImmutable
    {
        return is_int($milliseconds) || (is_string($milliseconds) && ctype_digit($milliseconds))
            ? CarbonImmutable::createFromTimestampMs((int) $milliseconds)->setTimezone(config('app.timezone'))
            : null;
    }

    /**
     * @throws SocialFeedException
     */
    private function getJson(string $url, string $context, array $query = [], ?string $method = null): array
    {
        try {
            // A `query` option (even empty) replaces the URL's own query string, so only pass one when needed
            $response = $query === []
                ? $this->request($method)->get($url)
                : $this->request($method)->get($url, $query);
        } catch (ConnectionException $e) {
            throw SocialFeedException::fromConnection($this->platform(), $e, $context);
        }

        if (! $response->successful()) {
            throw SocialFeedException::fromResponse($this->platform(), $response, $context);
        }

        $body = $response->json();

        if (! is_array($body)) {
            throw SocialFeedException::malformed($this->platform(), $context);
        }

        return $body;
    }

    private function request(?string $restliMethod = null): PendingRequest
    {
        return Http::withToken($this->accessToken())
            ->withHeaders(array_filter([
                'LinkedIn-Version'          => (string) config('services.linkedin.api_version'),
                'X-Restli-Protocol-Version' => '2.0.0',
                'X-RestLi-Method'           => $restliMethod,
            ]))
            ->acceptJson()
            ->timeout((int) config('news.sync.http_timeout', 20))
            ->connectTimeout(10);
    }

    private function accessToken(): string
    {
        if ($this->accessToken !== null) {
            return $this->accessToken;
        }

        $token = $this->tokens->resolve(
            $this->platform(),
            (string) config('services.linkedin.access_token'),
            config('services.linkedin.refresh_token') ?: null,
        );

        if ($this->canRefresh($token) && $this->tokens->shouldRefresh($token)) {
            $this->refresh($token);
        }

        return $this->accessToken = $token->access_token;
    }

    /** Programmatic refresh tokens are only issued to approved LinkedIn partner apps. */
    private function canRefresh(SocialAccessToken $token): bool
    {
        return filled($token->refresh_token)
            && filled(config('services.linkedin.client_id'))
            && filled(config('services.linkedin.client_secret'))
            && ($token->refresh_token_expires_at === null || $token->refresh_token_expires_at->isFuture());
    }

    private function refresh(SocialAccessToken $token): void
    {
        try {
            $response = Http::asForm()
                ->timeout((int) config('news.sync.http_timeout', 20))
                ->post(self::OAUTH_URL, [
                    'grant_type'    => 'refresh_token',
                    'refresh_token' => $token->refresh_token,
                    'client_id'     => config('services.linkedin.client_id'),
                    'client_secret' => config('services.linkedin.client_secret'),
                ]);
        } catch (ConnectionException) {
            $response = null;
        }

        if ($response?->successful() && is_string($response->json('access_token'))) {
            $this->tokens->recordRefresh(
                $token,
                $response->json('access_token'),
                (int) $response->json('expires_in') ?: null,
                is_string($response->json('refresh_token')) ? $response->json('refresh_token') : null,
                (int) $response->json('refresh_token_expires_in') ?: null,
            );
            Log::info('News sync: LinkedIn access token refreshed.');

            return;
        }

        $this->tokens->recordFailedRefresh($token);
        Log::warning('News sync: LinkedIn token refresh failed; continuing with the current token.', [
            'status' => $response?->status(),
            'error'  => $response?->json('error'),
        ]);
    }
}
