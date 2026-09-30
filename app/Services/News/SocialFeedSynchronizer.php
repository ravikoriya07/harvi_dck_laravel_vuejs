<?php

namespace App\Services\News;

use App\Enums\SocialPlatform;
use App\Models\SocialPost;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Mirrors one platform's feed into `social_posts`: create, update, restore,
 * refresh media and remove — so the News page never needs a manual update.
 *
 * Deletions are the risky part and are only reconciled when the fetch is
 * trustworthy: it succeeded end to end (otherwise the client throws and
 * nothing here runs), no item was malformed, and only inside the window the
 * fetch actually covered. Suspicious results need repeated confirmation, and
 * every candidate is checked with the platform before removal.
 */
final class SocialFeedSynchronizer
{
    public function __construct(private readonly SocialMediaStore $media) {}

    public function sync(SocialFeedClient $client, int $limit): SocialSyncReport
    {
        $platform = $client->platform();
        $report = new SocialSyncReport($platform);

        if (! $client->isConfigured()) {
            $report->status = SocialSyncReport::SKIPPED;
            $report->message = 'Credentials not configured.';

            return $report;
        }

        try {
            $result = $client->fetchLatest(max(1, $limit));
        } catch (SocialFeedException $e) {
            // Keep every stored post; no creates, updates or deletions this run
            Log::log($e->reason === SocialFeedException::AUTH ? 'error' : 'warning', "News sync: {$platform->label()} fetch failed — stored posts kept, deletions skipped.", [
                'platform' => $platform->value,
                'reason'   => $e->reason,
                'status'   => $e->status,
                'message'  => $e->getMessage(),
            ]);

            $report->status = SocialSyncReport::FAILED;
            $report->message = $e->getMessage();

            return $report;
        }

        $this->upsert($client, $result, $report, now());
        $this->reconcileDeletions($client, $result, $report);

        Log::info("News sync: {$platform->label()} finished.", $report->toArray());

        return $report;
    }

    private function upsert(SocialFeedClient $client, SocialFeedResult $result, SocialSyncReport $report, CarbonInterface $now): void
    {
        $platform = $client->platform();

        /** @var Collection<string, SocialPost> $existing */
        $existing = SocialPost::withTrashed()
            ->forPlatform($platform)
            ->whereIn('external_id', $result->presentIds())
            ->get()
            ->keyBy('external_id');

        $needsMedia = [];
        $unchangedIds = [];
        $seen = [];

        foreach ($result->posts as $data) {
            // Offset pagination can repeat an item when a post is published mid-fetch
            if (isset($seen[$data->externalId])) {
                continue;
            }

            $seen[$data->externalId] = true;

            $post = $existing->get($data->externalId)
                ?? new SocialPost(['platform' => $platform, 'external_id' => $data->externalId]);

            $isNew = ! $post->exists;
            $wasRemoved = $post->exists && $post->trashed();
            $hash = $data->contentHash();

            if ($isNew || $post->content_hash !== $hash) {
                $post->fill([
                    'permalink'         => $data->permalink,
                    'caption'           => $data->caption,
                    'media_type'        => $data->mediaType,
                    'image_alt'         => $data->altText,
                    'content_hash'      => $hash,
                    'published_at'      => $data->publishedAt,
                    'source_updated_at' => $data->sourceUpdatedAt,
                ]);
            }

            // Different media: drop the old copy now so a failed download can't leave it showing
            if ($post->media_key !== $data->mediaKey) {
                $this->media->delete($post->image_path);
                $post->media_key = $data->mediaKey;
                $post->image_path = null;
                $post->image_source_url = $data->mediaUrl;
            }

            if ($wasRemoved) {
                $post->deleted_at = null;
            }

            if ($isNew || $post->isDirty()) {
                $post->last_synced_at = $now;
                $post->save();

                match (true) {
                    $isNew      => $report->created++,
                    $wasRemoved => $report->restored++,
                    default     => $report->updated++,
                };
            } else {
                $unchangedIds[] = $post->id;
                $report->unchanged++;
            }

            // New/changed media, or the local copy is missing (first download failed, file removed…)
            if ($data->mediaKey !== null && ! $this->media->exists($post->image_path)) {
                $needsMedia[$data->externalId] = [$post, $data];
            }
        }

        if ($unchangedIds !== []) {
            // One statement, no updated_at bump: unchanged posts are only marked as still present
            SocialPost::query()->whereKey($unchangedIds)->toBase()->update(['last_synced_at' => $now]);
        }

        $this->refreshMedia($client, $needsMedia, $report);
    }

    /**
     * @param  array<string, array{0: SocialPost, 1: SocialPostData}>  $needsMedia
     */
    private function refreshMedia(SocialFeedClient $client, array $needsMedia, SocialSyncReport $report): void
    {
        if ($needsMedia === []) {
            return;
        }

        try {
            $urls = $client->resolveMediaUrls(array_column($needsMedia, 1));
        } catch (SocialFeedException $e) {
            Log::warning("News sync: {$client->platform()->label()} media lookup failed; images retried next sync.", [
                'reason'  => $e->reason,
                'message' => $e->getMessage(),
            ]);
            $urls = [];
        }

        foreach ($needsMedia as $externalId => [$post]) {
            $url = $urls[$externalId] ?? null;
            $path = $url !== null ? $this->media->store($post, $url) : null;

            if ($path === null) {
                $report->mediaFailed++;
            }

            $post->image_path = $path;
            // Fresh remote URL as a fallback until a local copy exists
            $post->image_source_url = $url ?? $post->image_source_url;

            if ($post->isDirty()) {
                $post->save();
            }
        }
    }

    private function reconcileDeletions(SocialFeedClient $client, SocialFeedResult $result, SocialSyncReport $report): void
    {
        $platform = $client->platform();

        if ($result->malformed > 0) {
            $this->skipDeletions($report, "{$result->malformed} item(s) in the response could not be parsed");

            return;
        }

        if (! $result->complete && $result->windowStart === null) {
            $this->skipDeletions($report, 'the fetched window could not be determined');

            return;
        }

        // Only posts the fetch covered. Older posts outside a partial window are never touched.
        $candidates = SocialPost::query()
            ->forPlatform($platform)
            ->whereNotIn('external_id', $result->presentIds())
            ->when(! $result->complete, fn ($query) => $query->where('published_at', '>', $result->windowStart))
            ->get();

        $streakKey = "news-sync:{$platform->value}:suspicious-deletions";

        if ($candidates->isEmpty()) {
            Cache::forget($streakKey);

            return;
        }

        $suspicion = $this->suspicion($platform, $result, $candidates);

        if ($suspicion === null) {
            Cache::forget($streakKey);
        } elseif (! $this->confirmedAcrossRuns($streakKey, $candidates)) {
            $this->skipDeletions($report, "suspicious result ({$suspicion}); waiting for it to repeat on consecutive syncs");

            return;
        }

        foreach ($candidates as $post) {
            try {
                $remove = $client->confirmRemoval($post->external_id);
            } catch (SocialFeedException $e) {
                // Platform unstable — keep this and the remaining candidates until the next run
                $this->skipDeletions($report, 'could not confirm removal: ' . $e->getMessage());

                return;
            }

            if (! $remove) {
                continue;
            }

            $this->media->delete($post->image_path);
            $post->delete();
            $report->deleted++;
        }
    }

    private function suspicion(SocialPlatform $platform, SocialFeedResult $result, Collection $candidates): ?string
    {
        if ($result->posts === []) {
            return 'the platform returned no posts';
        }

        $stored = SocialPost::query()->forPlatform($platform)->count();
        $percent = $candidates->count() / max(1, $stored) * 100;

        return $percent > (int) config('news.safeguards.max_delete_percent', 50)
            ? sprintf('%d of %d stored posts would be removed', $candidates->count(), $stored)
            : null;
    }

    /**
     * A suspicious deletion is applied only after the exact same set of posts
     * has been missing on N consecutive syncs — a one-off API glitch never
     * repeats identically, a genuine clean-up does.
     */
    private function confirmedAcrossRuns(string $streakKey, Collection $candidates): bool
    {
        $required = (int) config('news.safeguards.suspicious_confirmations', 3);

        if ($required <= 0) {
            return false;
        }

        $signature = sha1($candidates->pluck('external_id')->sort()->implode('|'));
        $state = Cache::get($streakKey);
        $count = is_array($state) && ($state['signature'] ?? null) === $signature ? (int) $state['count'] + 1 : 1;

        if ($count >= $required) {
            Cache::forget($streakKey);

            return true;
        }

        Cache::put($streakKey, ['signature' => $signature, 'count' => $count], now()->addDays(7));

        return false;
    }

    private function skipDeletions(SocialSyncReport $report, string $reason): void
    {
        $report->deletionSkipped = $reason;

        Log::warning("News sync: {$report->platform->label()} deletions skipped — {$reason}.", [
            'platform' => $report->platform->value,
        ]);
    }
}
