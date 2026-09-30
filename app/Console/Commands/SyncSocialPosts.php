<?php

namespace App\Console\Commands;

use App\Enums\SocialPlatform;
use App\Services\News\SocialFeedException;
use App\Services\News\SocialFeedSynchronizer;
use App\Services\News\SocialSyncReport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Pulls LinkedIn + Instagram posts into `social_posts` for the News page.
 * Scheduled in routes/console.php; safe to run by hand at any time.
 */
class SyncSocialPosts extends Command
{
    protected $signature = 'news:sync
                            {--platform=* : Only sync these platforms (linkedin, instagram)}
                            {--limit= : Latest posts to fetch per platform (default: news.sync.limit)}';

    protected $description = 'Sync LinkedIn and Instagram posts for the News page (create, update and remove)';

    public function handle(SocialFeedSynchronizer $synchronizer): int
    {
        $platforms = $this->selectedPlatforms();

        if ($platforms === null) {
            $this->error('Unknown platform. Use: ' . implode(', ', array_column(SocialPlatform::cases(), 'value')));

            return self::FAILURE;
        }

        $limit = (int) ($this->option('limit') ?: config('news.sync.limit', 30));

        if ($limit < 1) {
            $this->error('--limit must be at least 1.');

            return self::FAILURE;
        }

        // One sync at a time across scheduled (regular + deep) and manual runs
        $lock = Cache::lock('news:sync', (int) config('news.sync.lock_seconds', 900));

        if (! $lock->get()) {
            $this->warn('A news sync is already running — skipped.');

            return self::SUCCESS;
        }

        $reports = [];

        try {
            foreach ($platforms as $platform) {
                // Each platform is isolated: one failing never stops the other
                try {
                    $reports[] = $synchronizer->sync(app($platform->clientClass()), $limit);
                } catch (Throwable $e) {
                    $message = SocialFeedException::redact($e->getMessage());
                    Log::error("News sync: {$platform->label()} failed unexpectedly.", [
                        'platform'  => $platform->value,
                        'exception' => $e::class,
                        'message'   => $message,
                    ]);
                    $reports[] = new SocialSyncReport($platform, SocialSyncReport::FAILED, $message);
                }
            }
        } finally {
            $lock->release();
        }

        $this->table(
            ['Platform', 'Status', 'Created', 'Updated', 'Restored', 'Deleted', 'Unchanged', 'Notes'],
            array_map(fn (SocialSyncReport $report) => [
                $report->platform->label(),
                $report->status,
                $report->created,
                $report->updated,
                $report->restored,
                $report->deleted,
                $report->unchanged,
                collect([
                    $report->message,
                    $report->deletionSkipped ? "Deletions skipped: {$report->deletionSkipped}" : null,
                    $report->mediaFailed ? "{$report->mediaFailed} image(s) pending" : null,
                ])->filter()->implode(' | '),
            ], $reports),
        );

        $failed = array_filter($reports, fn (SocialSyncReport $report) => $report->status === SocialSyncReport::FAILED);

        return $failed === [] ? self::SUCCESS : self::FAILURE;
    }

    /**
     * @return list<SocialPlatform>|null
     */
    private function selectedPlatforms(): ?array
    {
        $requested = array_filter((array) $this->option('platform'));

        if ($requested === []) {
            return SocialPlatform::cases();
        }

        $platforms = array_map(fn (string $value) => SocialPlatform::tryFrom(strtolower(trim($value))), $requested);

        return in_array(null, $platforms, true) ? null : array_values($platforms);
    }
}
