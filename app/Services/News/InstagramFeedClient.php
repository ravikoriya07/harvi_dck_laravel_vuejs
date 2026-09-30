<?php

namespace App\Services\News;

use App\Enums\SocialPlatform;
use App\Models\SocialAccessToken;
use Carbon\CarbonImmutable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Instagram professional account media via the Instagram API with Instagram
 * Login (graph.instagram.com, scope instagram_business_basic).
 *
 * - Media: GET /me/media, newest first, cursor pagination. Captions can be
 *   edited after publishing and are returned as edited on every fetch.
 * - Removal: deleted and archived media disappear from /me/media.
 * - Token: long-lived (60 days), refreshed via /refresh_access_token.
 */
final class InstagramFeedClient implements SocialFeedClient
{
    private const API_URL = 'https://graph.instagram.com';

    private const PAGE_SIZE = 50;

    private const FIELDS = 'id,caption,media_type,media_url,thumbnail_url,permalink,timestamp,children{media_type,media_url,thumbnail_url}';

    /** Graph API "object does not exist / cannot be loaded". */
    private const NOT_FOUND_CODE = 100;

    private ?string $accessToken = null;

    public function __construct(private readonly SocialTokenManager $tokens) {}

    public function platform(): SocialPlatform
    {
        return SocialPlatform::Instagram;
    }

    public function isConfigured(): bool
    {
        return filled(config('services.instagram.access_token'));
    }

    public function fetchLatest(int $limit): SocialFeedResult
    {
        $posts = [];
        $fetched = 0;
        $malformed = 0;
        $windowStart = null;
        $complete = false;
        $query = ['fields' => self::FIELDS, 'limit' => min(self::PAGE_SIZE, $limit)];
        $maxPages = (int) ceil($limit / self::PAGE_SIZE) + 5;

        for ($page = 0; $page < $maxPages && $fetched < $limit; $page++) {
            $body = $this->getJson($this->versioned('/me/media'), 'media list', $query);
            $items = $body['data'] ?? null;

            if (! is_array($items) || ! array_is_list($items)) {
                throw SocialFeedException::malformed($this->platform(), 'media list');
            }

            foreach ($items as $item) {
                $fetched++;
                $publishedAt = is_array($item) ? $this->timestamp($item['timestamp'] ?? null) : null;
                $id = is_array($item) ? ($item['id'] ?? null) : null;

                // The permalink becomes a link on the site — only accept https URLs
                if ($publishedAt === null || ! (is_string($id) || is_int($id)) || ! is_string($item['permalink'] ?? null) || ! str_starts_with($item['permalink'], 'https://')) {
                    $malformed++;

                    continue;
                }

                // Media is returned newest first
                $windowStart = $publishedAt;
                $posts[] = $this->normalize($item, (string) $id, $publishedAt);
            }

            $after = $body['paging']['cursors']['after'] ?? null;

            if (! isset($body['paging']['next'])) {
                $complete = true;

                break;
            }

            // A "next" page without a usable cursor is an incomplete response: keep the
            // posts, but flag it so no deletions are reconciled from it
            if (! is_string($after) || $after === '') {
                $malformed++;

                break;
            }

            // Follow the cursor ourselves — paging.next embeds the access token
            $query['after'] = $after;
            $query['limit'] = min(self::PAGE_SIZE, max(1, $limit - $fetched));
        }

        return new SocialFeedResult($posts, $complete ? null : $windowStart, $complete, $malformed, $fetched);
    }

    public function resolveMediaUrls(array $posts): array
    {
        $urls = [];

        foreach ($posts as $post) {
            if ($post->mediaUrl !== null) {
                $urls[$post->externalId] = $post->mediaUrl;
            }
        }

        return $urls;
    }

    /**
     * A direct lookup is used as a final liveness check before removing a
     * post that is missing from a complete media list. "Not found" means
     * deleted; a post that still resolves but is no longer listed on the
     * profile is archived/hidden — also removed from the site. Any other
     * error (rate limit, outage, token) keeps the post for this run.
     */
    public function confirmRemoval(string $externalId): bool
    {
        try {
            $response = $this->request()->get($this->versioned('/' . rawurlencode($externalId)), ['fields' => 'id']);
        } catch (ConnectionException $e) {
            throw SocialFeedException::fromConnection($this->platform(), $e, 'media lookup');
        }

        if ($response->successful() || $response->status() === 404 || $response->json('error.code') === self::NOT_FOUND_CODE) {
            return true;
        }

        throw SocialFeedException::fromResponse($this->platform(), $response, 'media lookup');
    }

    private function normalize(array $item, string $id, CarbonImmutable $publishedAt): SocialPostData
    {
        [$mediaType, $previewUrl] = match ($item['media_type'] ?? null) {
            'VIDEO'          => [SocialPostData::TYPE_VIDEO, $item['thumbnail_url'] ?? null],
            'CAROUSEL_ALBUM' => [SocialPostData::TYPE_CAROUSEL, $this->firstChildPreview($item) ?? ($item['media_url'] ?? null)],
            default          => [SocialPostData::TYPE_IMAGE, $item['media_url'] ?? null],
        };

        $previewUrl = is_string($previewUrl) && $previewUrl !== '' ? $previewUrl : null;
        $caption = is_string($item['caption'] ?? null) ? trim($item['caption']) : '';

        return new SocialPostData(
            platform: $this->platform(),
            externalId: $id,
            permalink: $item['permalink'],
            caption: $caption === '' ? null : $caption,
            mediaType: $mediaType,
            publishedAt: $publishedAt,
            // CDN path without the signed query string — stable across fetches for the same file
            mediaKey: $previewUrl !== null ? (parse_url($previewUrl, PHP_URL_PATH) ?: $previewUrl) : null,
            mediaUrl: $previewUrl,
        );
    }

    private function firstChildPreview(array $item): ?string
    {
        $child = $item['children']['data'][0] ?? null;

        if (! is_array($child)) {
            return null;
        }

        $url = ($child['media_type'] ?? null) === 'VIDEO' ? ($child['thumbnail_url'] ?? null) : ($child['media_url'] ?? null);

        return is_string($url) ? $url : null;
    }

    private function timestamp(mixed $value): ?CarbonImmutable
    {
        if (! is_string($value) || $value === '') {
            return null;
        }

        try {
            // e.g. 2026-09-01T10:00:00+0000 — stored in the app timezone
            return CarbonImmutable::parse($value)->setTimezone(config('app.timezone'));
        } catch (Throwable) {
            return null;
        }
    }

    private function versioned(string $path): string
    {
        return self::API_URL . '/' . trim((string) config('services.instagram.graph_version', 'v25.0'), '/') . $path;
    }

    /**
     * @throws SocialFeedException
     */
    private function getJson(string $url, string $context, array $query = []): array
    {
        try {
            $response = $this->request()->get($url, $query);
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

    private function request(): PendingRequest
    {
        // Graph API token as a query parameter (documented form). It never
        // reaches logs: exception messages are redacted.
        return Http::withQueryParameters(['access_token' => $this->accessToken()])
            ->acceptJson()
            ->timeout((int) config('news.sync.http_timeout', 20))
            ->connectTimeout(10);
    }

    private function accessToken(): string
    {
        if ($this->accessToken !== null) {
            return $this->accessToken;
        }

        $token = $this->tokens->resolve($this->platform(), (string) config('services.instagram.access_token'));

        if ($this->tokens->shouldRefresh($token)) {
            $this->refresh($token);
        }

        return $this->accessToken = $token->access_token;
    }

    /**
     * Long-lived tokens can be refreshed once they are 24h old and not yet
     * expired; a token not refreshed within 60 days is lost for good.
     */
    private function refresh(SocialAccessToken $token): void
    {
        try {
            $response = Http::timeout((int) config('news.sync.http_timeout', 20))
                ->get(self::API_URL . '/refresh_access_token', [
                    'grant_type'   => 'ig_refresh_token',
                    'access_token' => $token->access_token,
                ]);
        } catch (ConnectionException) {
            $response = null;
        }

        if ($response?->successful() && is_string($response->json('access_token'))) {
            $this->tokens->recordRefresh($token, $response->json('access_token'), (int) $response->json('expires_in') ?: null);
            Log::info('News sync: Instagram access token refreshed.');

            return;
        }

        $this->tokens->recordFailedRefresh($token);
        Log::warning('News sync: Instagram token refresh failed; continuing with the current token.', [
            'status' => $response?->status(),
            'error'  => $response?->json('error.message'),
        ]);
    }
}
