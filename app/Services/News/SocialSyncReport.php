<?php

namespace App\Services\News;

use App\Enums\SocialPlatform;

/**
 * Per-platform summary of one sync run (logged and shown by `news:sync`).
 */
final class SocialSyncReport
{
    public const OK      = 'ok';
    public const SKIPPED = 'skipped';
    public const FAILED  = 'failed';

    public int $created = 0;

    public int $updated = 0;

    public int $restored = 0;

    public int $deleted = 0;

    public int $unchanged = 0;

    public int $mediaFailed = 0;

    /** Why delete reconciliation did not run (or stopped), if it didn't. */
    public ?string $deletionSkipped = null;

    public function __construct(
        public readonly SocialPlatform $platform,
        public string $status = self::OK,
        public ?string $message = null,
    ) {}

    public function changedContent(): bool
    {
        return $this->created + $this->updated + $this->restored + $this->deleted > 0;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'platform'         => $this->platform->value,
            'status'           => $this->status,
            'created'          => $this->created,
            'updated'          => $this->updated,
            'restored'         => $this->restored,
            'deleted'          => $this->deleted,
            'unchanged'        => $this->unchanged,
            'media_failed'     => $this->mediaFailed,
            'deletion_skipped' => $this->deletionSkipped,
            'message'          => $this->message,
        ];
    }
}
