<?php

namespace App\Services\News;

use App\Enums\SocialPlatform;

/**
 * Read-only access to one platform's official API, normalised to SocialPostData.
 */
interface SocialFeedClient
{
    public function platform(): SocialPlatform;

    /** Credentials are present in config — unconfigured platforms are skipped. */
    public function isConfigured(): bool;

    /**
     * Fetch the latest posts, following pagination until `$limit` items or the
     * end of the feed. Throws on any failure — never returns partial data.
     *
     * @throws SocialFeedException
     */
    public function fetchLatest(int $limit): SocialFeedResult;

    /**
     * Remote preview image URLs for posts whose image needs (re)downloading.
     *
     * @param  list<SocialPostData>  $posts
     * @return array<string, string> external id => image URL
     *
     * @throws SocialFeedException
     */
    public function resolveMediaUrls(array $posts): array;

    /**
     * Whether a stored post that is missing from the feed is really gone or
     * hidden. False means it still exists publicly and must be kept.
     *
     * @throws SocialFeedException when this cannot be determined (the post is kept)
     */
    public function confirmRemoval(string $externalId): bool;
}
