<?php

namespace App\Services\News;

use Carbon\CarbonImmutable;

/**
 * Outcome of one successful feed fetch, including what the fetch covered so
 * the synchroniser only reconciles deletions inside that window.
 */
final class SocialFeedResult
{
    /**
     * @param  list<SocialPostData>  $posts  Posts to display, in API order
     * @param  CarbonImmutable|null  $windowStart  Every post published after this was covered by the fetch (null when complete)
     * @param  bool  $complete  The end of the feed was reached, so the fetch covered the whole account
     * @param  int  $malformed  Items that could not be parsed — deletion reconciliation is unsafe while > 0
     * @param  int  $fetched  Items returned by the API, including ones hidden from the site
     */
    public function __construct(
        public readonly array $posts,
        public readonly ?CarbonImmutable $windowStart,
        public readonly bool $complete,
        public readonly int $malformed = 0,
        public readonly int $fetched = 0,
    ) {}

    /**
     * @return list<string>
     */
    public function presentIds(): array
    {
        return array_map(fn (SocialPostData $post) => $post->externalId, $this->posts);
    }
}
