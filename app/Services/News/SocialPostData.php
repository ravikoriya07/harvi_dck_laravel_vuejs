<?php

namespace App\Services\News;

use App\Enums\SocialPlatform;
use Carbon\CarbonImmutable;

/**
 * A post normalised from a platform API response — the common shape both
 * feed clients produce and the synchroniser consumes.
 */
final class SocialPostData
{
    public const TYPE_IMAGE    = 'image';
    public const TYPE_VIDEO    = 'video';
    public const TYPE_CAROUSEL = 'carousel';
    public const TYPE_TEXT     = 'text';

    /**
     * @param  string|null  $mediaKey  Stable identity of the preview image (asset URN / CDN path)
     * @param  string|null  $mediaUrl  Remote preview image URL when already known (signed, expires)
     */
    public function __construct(
        public readonly SocialPlatform $platform,
        public readonly string $externalId,
        public readonly string $permalink,
        public readonly ?string $caption,
        public readonly string $mediaType,
        public readonly CarbonImmutable $publishedAt,
        public readonly ?string $mediaKey = null,
        public readonly ?string $mediaUrl = null,
        public readonly ?string $altText = null,
        public readonly ?CarbonImmutable $sourceUpdatedAt = null,
    ) {}

    /**
     * Hash of everything an edit on the platform can change. Signed media URLs
     * are deliberately excluded — they rotate on every fetch even when the
     * media itself is unchanged, and would otherwise rewrite every row.
     */
    public function contentHash(): string
    {
        return hash('sha256', json_encode([
            $this->caption,
            $this->mediaType,
            $this->mediaKey,
            $this->altText,
            $this->permalink,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}
