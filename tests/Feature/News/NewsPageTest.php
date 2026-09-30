<?php

namespace Tests\Feature\News;

use App\Enums\SocialPlatform;
use App\Models\SocialPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class NewsPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_news_page_lists_posts_newest_first_and_hides_removed_posts(): void
    {
        $this->makePost('ig-old', SocialPlatform::Instagram, '2026-09-01 09:00:00');
        $this->makePost('li-new', SocialPlatform::LinkedIn, '2026-09-20 09:00:00', caption: 'Latest LinkedIn update');
        $this->makePost('ig-mid', SocialPlatform::Instagram, '2026-09-10 09:00:00');
        $this->makePost('ig-removed', SocialPlatform::Instagram, '2026-09-25 09:00:00')->delete();

        $this->get('/news')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('News')
                ->where('unavailable', false)
                ->has('posts.data', 3)
                ->where('posts.data.0.permalink', 'https://example.com/li-new')
                ->where('posts.data.0.platform', 'linkedin')
                ->where('posts.data.0.platform_label', 'LinkedIn')
                ->where('posts.data.0.caption', 'Latest LinkedIn update')
                ->where('posts.data.0.published_label', '20 Sep 2026')
                ->where('posts.data.0.image_alt', 'LinkedIn post by DCK Construction: Latest LinkedIn update')
                ->where('posts.data.1.permalink', 'https://example.com/ig-mid')
                ->where('posts.data.2.permalink', 'https://example.com/ig-old')
                ->has('profiles.linkedin')
                ->has('profiles.instagram'));
    }

    public function test_news_page_returns_the_latest_synced_content(): void
    {
        $post = $this->makePost('ig-1', SocialPlatform::Instagram, '2026-09-01 09:00:00', caption: 'Before');

        $this->get('/news')->assertInertia(fn (AssertableInertia $page) => $page->where('posts.data.0.caption', 'Before'));

        // What a sync does on an edit — no cache in between, the next request sees it
        $post->update(['caption' => 'After']);

        $this->get('/news')->assertInertia(fn (AssertableInertia $page) => $page->where('posts.data.0.caption', 'After'));
    }

    public function test_news_page_uses_the_local_image_copy_and_falls_back_to_the_remote_url(): void
    {
        $this->makePost('local', SocialPlatform::Instagram, '2026-09-02 09:00:00', imagePath: 'news/instagram/abc-123.jpg');
        $this->makePost('remote', SocialPlatform::Instagram, '2026-09-01 09:00:00', imageSourceUrl: 'https://scontent.cdninstagram.com/v/t51/remote.jpg?oe=1');

        $this->get('/news')->assertInertia(fn (AssertableInertia $page) => $page
            ->where('posts.data.0.image_url', asset('storage/news/instagram/abc-123.jpg'))
            ->where('posts.data.1.image_url', 'https://scontent.cdninstagram.com/v/t51/remote.jpg?oe=1'));
    }

    public function test_news_page_is_paginated(): void
    {
        foreach (range(1, 14) as $day) {
            $this->makePost("ig-{$day}", SocialPlatform::Instagram, sprintf('2026-09-%02d 09:00:00', $day));
        }

        $this->get('/news?page=2')->assertInertia(fn (AssertableInertia $page) => $page
            ->has('posts.data', 2)
            ->where('posts.total', 14)
            ->where('posts.last_page', 2)
            ->where('posts.data.0.permalink', 'https://example.com/ig-2'));
    }

    public function test_news_page_renders_an_empty_state_when_nothing_is_synced(): void
    {
        $this->get('/news')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('News')
                ->has('posts.data', 0)
                ->where('posts.total', 0)
                ->where('unavailable', false));
    }

    private function makePost(
        string $id,
        SocialPlatform $platform,
        string $publishedAt,
        ?string $caption = 'A caption',
        ?string $imagePath = null,
        ?string $imageSourceUrl = null,
    ): SocialPost {
        return SocialPost::create([
            'platform'         => $platform,
            'external_id'      => $id,
            'permalink'        => "https://example.com/{$id}",
            'caption'          => $caption,
            'media_type'       => 'image',
            'image_path'       => $imagePath,
            'image_source_url' => $imageSourceUrl,
            'content_hash'     => hash('sha256', $id),
            'published_at'     => $publishedAt,
            'last_synced_at'   => now(),
        ]);
    }
}
