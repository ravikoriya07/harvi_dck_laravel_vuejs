<?php

namespace Tests\Feature\News;

use App\Enums\SocialPlatform;
use App\Models\SocialAccessToken;
use App\Models\SocialPost;
use App\Services\News\SocialTokenManager;
use Closure;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * `news:sync` against faked LinkedIn / Instagram APIs — no real API is ever called.
 */
class NewsSyncTest extends TestCase
{
    use RefreshDatabase;

    /** Instagram GET /me/media: body array, prepared response, or closure. */
    private mixed $instagramFeed;

    /** @var array<string, mixed> Instagram GET /{media-id}, keyed by id (default: not found) */
    private array $instagramLookups = [];

    /** LinkedIn GET /rest/posts?q=author: body array, prepared response, or closure. */
    private mixed $linkedInFeed;

    /** @var array<string, mixed> LinkedIn GET /rest/posts/{urn}, keyed by URN (default: 404) */
    private array $linkedInLookups = [];

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        config([
            'services.instagram.access_token'           => 'ig-seed-token',
            'services.instagram.graph_version'          => 'v25.0',
            'services.linkedin.organization_id'         => '53510973',
            'services.linkedin.access_token'            => 'li-seed-token',
            'services.linkedin.refresh_token'           => null,
            'services.linkedin.client_id'               => null,
            'services.linkedin.client_secret'           => null,
            'services.linkedin.api_version'             => '202609',
            'news.safeguards.max_delete_percent'        => 50,
            'news.safeguards.suspicious_confirmations'  => 3,
        ]);

        // Tokens far from expiry: no refresh calls unless a test sets that up
        $tokens = app(SocialTokenManager::class);
        $tokens->resolve(SocialPlatform::Instagram, 'ig-seed-token')->forceFill(['expires_at' => now()->addDays(50)])->save();
        $tokens->resolve(SocialPlatform::LinkedIn, 'li-seed-token')->forceFill(['expires_at' => now()->addDays(50)])->save();

        $this->instagramFeed = $this->instagramPage([]);
        $this->linkedInFeed = $this->linkedInPage([]);

        Http::preventStrayRequests();
        Http::fake(fn (Request $request) => $this->respond($request));
    }

    // ── Create ───────────────────────────────────────────────────────────────

    public function test_new_instagram_posts_are_created_with_a_local_image_copy(): void
    {
        $this->instagramFeed = $this->instagramPage([
            $this->igPost('ig-2', '2026-09-20T10:00:00+0000', 'Handover day at Broadwater Farm'),
            $this->igPost('ig-1', '2026-09-10T10:00:00+0000', 'Scaffold down', mediaType: 'VIDEO'),
        ]);

        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();

        $this->assertSame(2, SocialPost::count());

        $post = SocialPost::where('external_id', 'ig-2')->firstOrFail();
        $this->assertSame(SocialPlatform::Instagram, $post->platform);
        $this->assertSame('Handover day at Broadwater Farm', $post->caption);
        $this->assertSame('https://www.instagram.com/p/ig-2/', $post->permalink);
        $this->assertSame('image', $post->media_type);
        $this->assertSame('2026-09-20 10:00:00', $post->published_at->format('Y-m-d H:i:s'));
        $this->assertNotNull($post->image_path);
        Storage::disk('public')->assertExists($post->image_path);
        $this->assertStringContainsString('/storage/news/instagram/', $post->image_url);

        // Video posts use the thumbnail as the preview image
        $video = SocialPost::where('external_id', 'ig-1')->firstOrFail();
        $this->assertSame('video', $video->media_type);
        $this->assertStringContainsString('image:/v/t51/ig-1-thumb.jpg', Storage::disk('public')->get($video->image_path));
    }

    public function test_new_linkedin_posts_are_normalised_and_media_is_resolved(): void
    {
        $this->linkedInFeed = $this->linkedInPage([
            $this->liPost('7001', 1_758_000_000_000, 'Proud of the team {hashtag|\#|construction} with @[Haringey Council](urn:li:organization:123) \(phase 2\)', ['media' => ['id' => 'urn:li:image:IMG1', 'altText' => 'New community centre']]),
            $this->liPost('7000', 1_757_000_000_000, 'Site tour video', ['media' => ['id' => 'urn:li:video:VID1']]),
        ]);

        $this->artisan('news:sync', ['--platform' => ['linkedin']])->assertSuccessful();

        $post = SocialPost::where('external_id', 'urn:li:share:7001')->firstOrFail();
        $this->assertSame('Proud of the team #construction with Haringey Council (phase 2)', $post->caption);
        $this->assertSame('https://www.linkedin.com/feed/update/urn:li:share:7001/', $post->permalink);
        $this->assertSame('urn:li:image:IMG1', $post->media_key);
        $this->assertSame('New community centre', $post->image_alt_text);
        Storage::disk('public')->assertExists($post->image_path);

        $video = SocialPost::where('external_id', 'urn:li:share:7000')->firstOrFail();
        $this->assertSame('video', $video->media_type);
        $this->assertStringContainsString('video-thumb', Storage::disk('public')->get($video->image_path));

        // Works on LinkedIn's Development tier, which rejects batch calls
        Http::assertNotSent(fn (Request $request) => $request->hasHeader('X-RestLi-Method', 'BATCH_GET'));
        Http::assertSent(fn (Request $request) => str_starts_with($request->url(), 'https://api.linkedin.com/rest/images/urn%3Ali%3Aimage%3AIMG1'));
    }

    public function test_linkedin_posts_that_are_not_public_on_the_page_are_not_imported(): void
    {
        $this->linkedInFeed = $this->linkedInPage([
            $this->liPost('7003', 1_758_000_000_000, 'Public post'),
            $this->liPost('7002', 1_757_900_000_000, 'Sponsored dark post', extra: ['distribution' => ['feedDistribution' => 'NONE']]),
            $this->liPost('7001', 1_757_800_000_000, 'Connections only', extra: ['visibility' => 'CONNECTIONS']),
        ]);

        $this->artisan('news:sync', ['--platform' => ['linkedin']])->assertSuccessful();

        $this->assertSame(['urn:li:share:7003'], SocialPost::pluck('external_id')->all());
    }

    public function test_fetching_the_same_posts_again_does_not_create_duplicates(): void
    {
        $this->instagramFeed = $this->instagramPage([$this->igPost('ig-1', '2026-09-10T10:00:00+0000')]);

        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();

        $this->assertSame(1, SocialPost::withTrashed()->count());
        $this->assertCount(1, Storage::disk('public')->allFiles('news/instagram'));
    }

    // ── Update ───────────────────────────────────────────────────────────────

    public function test_edited_caption_and_media_are_updated_on_the_next_sync(): void
    {
        $this->instagramFeed = $this->instagramPage([$this->igPost('ig-1', '2026-09-10T10:00:00+0000', 'Original caption')]);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();
        $oldImage = SocialPost::firstOrFail()->image_path;

        $this->instagramFeed = $this->instagramPage([$this->igPost('ig-1', '2026-09-10T10:00:00+0000', 'Edited caption', file: 'ig-1-cover-v2')]);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();

        $post = SocialPost::firstOrFail();
        $this->assertSame('Edited caption', $post->caption);
        $this->assertNotSame($oldImage, $post->image_path);
        $this->assertStringContainsString('ig-1-cover-v2', Storage::disk('public')->get($post->image_path));
        Storage::disk('public')->assertMissing($oldImage);
        $this->assertSame(1, SocialPost::withTrashed()->count());
    }

    public function test_edited_linkedin_commentary_is_updated(): void
    {
        $this->linkedInFeed = $this->linkedInPage([$this->liPost('7001', 1_758_000_000_000, 'Before edit')]);
        $this->artisan('news:sync', ['--platform' => ['linkedin']])->assertSuccessful();

        $this->linkedInFeed = $this->linkedInPage([$this->liPost('7001', 1_758_000_000_000, 'After edit', extra: ['lastModifiedAt' => 1_758_100_000_000])]);
        $this->artisan('news:sync', ['--platform' => ['linkedin']])->assertSuccessful();

        $post = SocialPost::firstOrFail();
        $this->assertSame('After edit', $post->caption);
        $this->assertSame(1_758_100_000, $post->source_updated_at->getTimestamp());
    }

    public function test_unchanged_posts_are_not_rewritten(): void
    {
        $this->instagramFeed = $this->instagramPage([$this->igPost('ig-1', '2026-09-10T10:00:00+0000')]);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();
        $before = SocialPost::firstOrFail();

        $this->travel(2)->hours();

        // Same post; only the signed CDN query string rotates (as it does on every real fetch)
        $this->instagramFeed = $this->instagramPage([$this->igPost('ig-1', '2026-09-10T10:00:00+0000')]);
        DB::enableQueryLog();
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();
        $postWrites = collect(DB::getQueryLog())->filter(fn (array $query) => preg_match('/^(update|insert) .*"social_posts"/i', $query['query']));

        $after = SocialPost::firstOrFail();
        $this->assertEquals($before->updated_at, $after->updated_at);
        $this->assertSame($before->image_path, $after->image_path);
        $this->assertTrue($after->last_synced_at->gt($before->last_synced_at));
        // Only the single bulk "still present" touch
        $this->assertCount(1, $postWrites);
        $this->assertStringNotContainsString('updated_at', $postWrites->first()['query']);
    }

    // ── Delete ───────────────────────────────────────────────────────────────

    public function test_post_missing_from_a_complete_feed_is_removed_with_its_image(): void
    {
        $this->instagramFeed = $this->instagramPage([
            $this->igPost('ig-3', '2026-09-20T10:00:00+0000'),
            $this->igPost('ig-2', '2026-09-15T10:00:00+0000'),
            $this->igPost('ig-1', '2026-09-10T10:00:00+0000'),
        ]);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();
        $image = SocialPost::where('external_id', 'ig-2')->value('image_path');

        // ig-2 deleted on Instagram (direct lookup: object does not exist)
        $this->instagramFeed = $this->instagramPage([
            $this->igPost('ig-3', '2026-09-20T10:00:00+0000'),
            $this->igPost('ig-1', '2026-09-10T10:00:00+0000'),
        ]);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();

        $this->assertEqualsCanonicalizing(['ig-3', 'ig-1'], SocialPost::pluck('external_id')->all());
        $this->assertSoftDeleted('social_posts', ['external_id' => 'ig-2']);
        Storage::disk('public')->assertMissing($image);
    }

    public function test_linkedin_removal_is_confirmed_with_a_direct_lookup(): void
    {
        $this->linkedInFeed = $this->linkedInPage([
            $this->liPost('7005', 1_758_500_000_000, 'Five'),
            $this->liPost('7004', 1_758_400_000_000, 'Four'),
            $this->liPost('7003', 1_758_300_000_000, 'Three'),
            $this->liPost('7002', 1_758_200_000_000, 'Two'),
            $this->liPost('7001', 1_758_100_000_000, 'One'),
        ]);
        $this->artisan('news:sync', ['--platform' => ['linkedin']])->assertSuccessful();

        // 7002 and 7001 are missing from the list; 7002 is gone (404), 7001 still resolves as published
        $this->linkedInFeed = $this->linkedInPage([
            $this->liPost('7005', 1_758_500_000_000, 'Five'),
            $this->liPost('7004', 1_758_400_000_000, 'Four'),
            $this->liPost('7003', 1_758_300_000_000, 'Three'),
        ]);
        $this->linkedInLookups['urn:li:share:7001'] = $this->liPost('7001', 1_758_100_000_000, 'One');

        $this->artisan('news:sync', ['--platform' => ['linkedin']])->assertSuccessful();

        $this->assertSoftDeleted('social_posts', ['external_id' => 'urn:li:share:7002']);
        $this->assertNotSoftDeleted('social_posts', ['external_id' => 'urn:li:share:7001']);
    }

    public function test_linkedin_pagination_is_followed_and_repeated_items_are_not_duplicated(): void
    {
        // A post published mid-fetch shifts the offset: page 2 repeats the last item of page 1
        $this->linkedInFeed = fn (Request $request) => Http::response(str_contains($request->url(), 'start=2')
            ? $this->linkedInPage([$this->liPost('7002', 1_758_200_000_000, 'Two'), $this->liPost('7001', 1_758_100_000_000, 'One')])
            : $this->linkedInPage([$this->liPost('7003', 1_758_300_000_000, 'Three'), $this->liPost('7002', 1_758_200_000_000, 'Two')], nextStart: 2));

        $this->artisan('news:sync', ['--platform' => ['linkedin']])->assertSuccessful();

        $this->assertEqualsCanonicalizing(
            ['urn:li:share:7003', 'urn:li:share:7002', 'urn:li:share:7001'],
            SocialPost::pluck('external_id')->all(),
        );
        Http::assertSent(fn (Request $request) => str_contains($request->url(), 'sortBy=CREATED')
            && $request->hasHeader('LinkedIn-Version', '202609')
            && $request->hasHeader('X-Restli-Protocol-Version', '2.0.0'));
    }

    public function test_posts_are_not_removed_when_the_removal_check_fails(): void
    {
        $this->instagramFeed = $this->instagramPage([
            $this->igPost('ig-2', '2026-09-15T10:00:00+0000'),
            $this->igPost('ig-1', '2026-09-10T10:00:00+0000'),
        ]);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();

        $this->instagramFeed = $this->instagramPage([$this->igPost('ig-2', '2026-09-15T10:00:00+0000')]);
        $this->instagramLookups['ig-1'] = Http::response(['error' => ['message' => 'Application request limit reached', 'code' => 4]], 400);
        $this->artisan('news:sync', ['--platform' => ['instagram']])
            ->expectsOutputToContain('could not confirm removal')
            ->assertSuccessful();

        $this->assertSame(2, SocialPost::count());
    }

    /**
     * @return array<string, array{0: Closure(): mixed, 1: string}>
     */
    public static function failedFeedResponses(): array
    {
        return [
            'server error'   => [fn () => Http::response(['error' => ['message' => 'Service unavailable', 'code' => 2]], 503), 'HTTP 503'],
            'rate limited'   => [fn () => Http::response(['error' => ['message' => 'Too many calls', 'code' => 4]], 429), 'HTTP 429'],
            'expired token'  => [fn () => Http::response(['error' => ['message' => 'Session has expired', 'type' => 'OAuthException', 'code' => 190]], 400), 're-authorise'],
            'timeout'        => [fn () => Http::failedConnection('cURL error 28: Operation timed out'), 'timed out'],
            'malformed body' => [fn () => Http::response(['unexpected' => true]), 'unexpected response'],
            'non-json body'  => [fn () => Http::response('<html>Gateway</html>', 200, ['Content-Type' => 'text/html']), 'unexpected response'],
        ];
    }

    #[DataProvider('failedFeedResponses')]
    public function test_nothing_is_removed_when_the_feed_request_fails(Closure $failure, string $expectedReason): void
    {
        $this->instagramFeed = $this->instagramPage([
            $this->igPost('ig-2', '2026-09-15T10:00:00+0000'),
            $this->igPost('ig-1', '2026-09-10T10:00:00+0000'),
        ]);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();

        $this->instagramFeed = $failure();
        $this->artisan('news:sync', ['--platform' => ['instagram']])
            ->expectsOutputToContain($expectedReason)
            ->assertFailed();

        $this->assertSame(2, SocialPost::count());
        $this->assertSame(0, SocialPost::onlyTrashed()->count());
    }

    public function test_a_failed_page_in_the_middle_of_pagination_keeps_everything(): void
    {
        $this->instagramFeed = $this->instagramPage([
            $this->igPost('ig-2', '2026-09-15T10:00:00+0000'),
            $this->igPost('ig-1', '2026-09-10T10:00:00+0000'),
        ]);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();

        // Page 1 is fine and points to page 2, which fails
        $this->instagramFeed = fn (Request $request) => str_contains($request->url(), 'after=page-2')
            ? Http::response(['error' => ['message' => 'Internal error', 'code' => 1]], 500)
            : Http::response($this->instagramPage([$this->igPost('ig-3', '2026-09-20T10:00:00+0000')], nextCursor: 'page-2'));

        $this->artisan('news:sync', ['--platform' => ['instagram']])
            ->expectsOutputToContain('HTTP 500')
            ->assertFailed();

        $this->assertEqualsCanonicalizing(['ig-2', 'ig-1'], SocialPost::pluck('external_id')->all());
        Http::assertSent(fn (Request $request) => str_contains($request->url(), 'after=page-2'));
    }

    public function test_an_empty_feed_only_removes_posts_after_repeated_confirmation(): void
    {
        $this->instagramFeed = $this->instagramPage([
            $this->igPost('ig-2', '2026-09-15T10:00:00+0000'),
            $this->igPost('ig-1', '2026-09-10T10:00:00+0000'),
        ]);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();

        $this->instagramFeed = $this->instagramPage([]);

        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();
        $this->assertSame(2, SocialPost::count(), 'An unexpectedly empty result must not delete immediately.');

        // Third identical result in a row: accepted as a genuine clean-up
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();
        $this->assertSame(0, SocialPost::count());
        $this->assertSame(2, SocialPost::onlyTrashed()->count());
    }

    public function test_a_normal_sync_resets_a_pending_suspicious_deletion(): void
    {
        $posts = [
            $this->igPost('ig-2', '2026-09-15T10:00:00+0000'),
            $this->igPost('ig-1', '2026-09-10T10:00:00+0000'),
        ];
        $this->instagramFeed = $this->instagramPage($posts);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();

        $this->instagramFeed = $this->instagramPage([]);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();

        // Glitch over: the full feed is back
        $this->instagramFeed = $this->instagramPage($posts);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();

        $this->instagramFeed = $this->instagramPage([]);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();

        $this->assertSame(2, SocialPost::count());
    }

    public function test_mass_removal_above_the_safety_limit_is_held_back(): void
    {
        $this->instagramFeed = $this->instagramPage([
            $this->igPost('ig-5', '2026-09-25T10:00:00+0000'),
            $this->igPost('ig-4', '2026-09-20T10:00:00+0000'),
            $this->igPost('ig-3', '2026-09-15T10:00:00+0000'),
            $this->igPost('ig-2', '2026-09-10T10:00:00+0000'),
            $this->igPost('ig-1', '2026-09-05T10:00:00+0000'),
        ]);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();

        // 4 of 5 (80%) missing at once
        $this->instagramFeed = $this->instagramPage([$this->igPost('ig-5', '2026-09-25T10:00:00+0000')]);
        $this->artisan('news:sync', ['--platform' => ['instagram']])
            ->expectsOutputToContain('4 of 5 stored posts would be removed')
            ->assertSuccessful();

        $this->assertSame(5, SocialPost::count());
    }

    public function test_older_posts_outside_the_fetched_window_are_not_removed(): void
    {
        // Initial deep sync: everything
        $this->instagramFeed = $this->instagramPage([
            $this->igPost('ig-4', '2026-09-20T10:00:00+0000'),
            $this->igPost('ig-3', '2026-09-15T10:00:00+0000'),
            $this->igPost('ig-2', '2026-09-10T10:00:00+0000'),
            $this->igPost('ig-1', '2026-09-05T10:00:00+0000'),
        ]);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();

        // Regular sync of the latest 2: more pages exist, so ig-2 / ig-1 are outside the window
        $this->instagramFeed = $this->instagramPage([
            $this->igPost('ig-4', '2026-09-20T10:00:00+0000'),
            $this->igPost('ig-3', '2026-09-15T10:00:00+0000'),
        ], nextCursor: 'more');
        $this->artisan('news:sync', ['--platform' => ['instagram'], '--limit' => 2])
            ->doesntExpectOutputToContain('Deletions skipped')
            ->assertSuccessful();

        $this->assertSame(4, SocialPost::count());
        Http::assertNotSent(fn (Request $request) => str_contains($request->url(), 'after=more'));
    }

    public function test_a_post_deleted_inside_a_partial_window_is_still_removed(): void
    {
        $this->instagramFeed = $this->instagramPage([
            $this->igPost('ig-5', '2026-09-25T10:00:00+0000'),
            $this->igPost('ig-4', '2026-09-20T10:00:00+0000'),
            $this->igPost('ig-3', '2026-09-15T10:00:00+0000'),
            $this->igPost('ig-2', '2026-09-10T10:00:00+0000'),
            $this->igPost('ig-1', '2026-09-05T10:00:00+0000'),
        ]);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();

        // Latest 2 fetched, window reaches back to ig-3; ig-4 inside it is gone
        $this->instagramFeed = $this->instagramPage([
            $this->igPost('ig-5', '2026-09-25T10:00:00+0000'),
            $this->igPost('ig-3', '2026-09-15T10:00:00+0000'),
        ], nextCursor: 'more');
        $this->artisan('news:sync', ['--platform' => ['instagram'], '--limit' => 2])->assertSuccessful();

        $this->assertSoftDeleted('social_posts', ['external_id' => 'ig-4']);
        $this->assertSame(4, SocialPost::count());
    }

    public function test_a_malformed_item_disables_removals_for_that_run(): void
    {
        $this->instagramFeed = $this->instagramPage([
            $this->igPost('ig-3', '2026-09-20T10:00:00+0000'),
            $this->igPost('ig-2', '2026-09-15T10:00:00+0000'),
            $this->igPost('ig-1', '2026-09-10T10:00:00+0000'),
        ]);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();

        $broken = $this->igPost('ig-2', '2026-09-15T10:00:00+0000');
        unset($broken['id']);
        $this->instagramFeed = $this->instagramPage([$this->igPost('ig-3', '2026-09-20T10:00:00+0000'), $broken]);
        $this->artisan('news:sync', ['--platform' => ['instagram']])
            ->expectsOutputToContain('could not be parsed')
            ->assertSuccessful();

        $this->assertSame(3, SocialPost::count());
    }

    // ── Restore ──────────────────────────────────────────────────────────────

    public function test_a_removed_post_that_reappears_is_restored_not_duplicated(): void
    {
        $posts = [
            $this->igPost('ig-3', '2026-09-20T10:00:00+0000'),
            $this->igPost('ig-2', '2026-09-15T10:00:00+0000', 'Temporarily archived'),
            $this->igPost('ig-1', '2026-09-10T10:00:00+0000'),
        ];
        $this->instagramFeed = $this->instagramPage($posts);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();
        $id = SocialPost::where('external_id', 'ig-2')->value('id');

        $this->instagramFeed = $this->instagramPage([$posts[0], $posts[2]]);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();
        $this->assertSoftDeleted('social_posts', ['external_id' => 'ig-2']);

        $this->instagramFeed = $this->instagramPage($posts);
        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();

        $restored = SocialPost::where('external_id', 'ig-2')->firstOrFail();
        $this->assertSame($id, $restored->id);
        $this->assertSame(3, SocialPost::withTrashed()->count());
        // Its image was removed with the post and is downloaded again
        Storage::disk('public')->assertExists($restored->image_path);
    }

    // ── Isolation, locking, tokens ───────────────────────────────────────────

    public function test_one_platform_failing_does_not_affect_the_other(): void
    {
        $this->instagramFeed = $this->instagramPage([$this->igPost('ig-1', '2026-09-10T10:00:00+0000')]);
        $this->linkedInFeed = $this->linkedInPage([
            $this->liPost('7002', 1_758_200_000_000, 'Two'),
            $this->liPost('7001', 1_758_100_000_000, 'One'),
        ]);
        $this->artisan('news:sync')->assertSuccessful();

        // LinkedIn token revoked; Instagram publishes a new post and deletes the old one
        $this->linkedInFeed = Http::response(['status' => 401, 'serviceErrorCode' => 65601, 'message' => 'The token used in the request has been revoked by the user'], 401);
        $this->instagramFeed = $this->instagramPage([$this->igPost('ig-2', '2026-09-20T10:00:00+0000')]);
        $this->artisan('news:sync')->assertFailed();

        $this->assertSame(['ig-2'], SocialPost::forPlatform(SocialPlatform::Instagram)->pluck('external_id')->all());
        $this->assertSoftDeleted('social_posts', ['external_id' => 'ig-1']);
        $this->assertSame(2, SocialPost::forPlatform(SocialPlatform::LinkedIn)->count());
    }

    public function test_unconfigured_platforms_are_skipped(): void
    {
        config(['services.linkedin.access_token' => null]);
        $this->instagramFeed = $this->instagramPage([$this->igPost('ig-1', '2026-09-10T10:00:00+0000')]);

        $this->artisan('news:sync')->assertSuccessful();

        $this->assertSame(1, SocialPost::count());
        Http::assertNotSent(fn (Request $request) => str_contains($request->url(), 'linkedin.com'));
    }

    public function test_a_sync_is_skipped_while_another_one_is_running(): void
    {
        $this->instagramFeed = $this->instagramPage([$this->igPost('ig-1', '2026-09-10T10:00:00+0000')]);
        $lock = Cache::lock('news:sync', 60);
        $lock->get();

        $this->artisan('news:sync')->expectsOutputToContain('already running')->assertSuccessful();

        $this->assertSame(0, SocialPost::count());
        Http::assertNothingSent();
        $lock->release();
    }

    public function test_instagram_token_is_refreshed_before_expiry_and_stored_encrypted(): void
    {
        SocialAccessToken::where('platform', SocialPlatform::Instagram)->update(['expires_at' => now()->addDays(3)]);
        $this->instagramFeed = fn (Request $request) => str_contains($request->url(), 'access_token=ig-refreshed-token')
            ? Http::response($this->instagramPage([$this->igPost('ig-1', '2026-09-10T10:00:00+0000')]))
            : Http::response(['error' => ['message' => 'Invalid token', 'code' => 190]], 400);

        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertSuccessful();

        $token = SocialAccessToken::where('platform', SocialPlatform::Instagram)->firstOrFail();
        $this->assertSame('ig-refreshed-token', $token->access_token);
        $this->assertTrue($token->expires_at->gt(now()->addDays(59)));
        $this->assertStringNotContainsString('ig-refreshed-token', DB::table('social_access_tokens')->where('platform', 'instagram')->value('access_token'));
        $this->assertSame(1, SocialPost::count());
    }

    public function test_tokens_are_never_written_to_the_log(): void
    {
        Log::spy();
        $this->instagramFeed = Http::failedConnection(); // default message includes the full URL, token included

        $this->artisan('news:sync', ['--platform' => ['instagram']])->assertFailed();

        Log::shouldHaveReceived('log')->withArgs(fn (string $level, string $message, array $context) => $level === 'warning'
            && str_contains($context['message'], 'timed out or could not connect')
            && ! str_contains($message . json_encode($context), 'ig-seed-token'))->once();
    }

    // ── Fakes ────────────────────────────────────────────────────────────────

    private function respond(Request $request): mixed
    {
        $url = $request->url();
        $path = (string) parse_url($url, PHP_URL_PATH);

        if (str_contains($url, 'cdninstagram.com') || str_contains($url, 'media.licdn.com')) {
            // Bytes derived from the file path: a different file ⇒ different content
            return Http::response('image:' . $path, 200, ['Content-Type' => 'image/jpeg']);
        }

        if (str_starts_with($url, 'https://graph.instagram.com/refresh_access_token')) {
            return Http::response(['access_token' => 'ig-refreshed-token', 'token_type' => 'bearer', 'expires_in' => 5_184_000]);
        }

        if (str_starts_with($url, 'https://graph.instagram.com/v25.0/me/media')) {
            return $this->resolveFake($this->instagramFeed, $request);
        }

        if (str_starts_with($url, 'https://graph.instagram.com/v25.0/')) {
            return $this->resolveFake(
                $this->instagramLookups[basename($path)] ?? Http::response(['error' => ['message' => 'Object with ID does not exist', 'code' => 100, 'error_subcode' => 33]], 400),
                $request,
            );
        }

        if (preg_match('#^https://api\.linkedin\.com/rest/(images|videos)/([^?]+)$#', $url, $match)) {
            // Development tier rejects BATCH_GET — assets are looked up one by one
            if ($request->hasHeader('X-RestLi-Method', 'BATCH_GET')) {
                return Http::response(['status' => 403, 'message' => 'BATCH_GET not allowed on Development tier'], 403);
            }

            $urn = rawurldecode($match[2]);
            $asset = Str::afterLast($urn, ':');

            return Http::response($match[1] === 'images'
                ? ['id' => $urn, 'status' => 'AVAILABLE', 'downloadUrl' => "https://media.licdn.com/dms/image/{$asset}/feedshare-shrink_1280/0/1?e=1760000000&v=beta&t=" . Str::random(12)]
                : ['id' => $urn, 'status' => 'AVAILABLE', 'thumbnail' => "https://media.licdn.com/dms/image/{$asset}/video-thumb_720/0/1?e=1760000000&v=beta&t=" . Str::random(12)]);
        }

        if (str_starts_with($url, 'https://api.linkedin.com/rest/posts/')) {
            return $this->resolveFake(
                $this->linkedInLookups[rawurldecode(basename($path))] ?? Http::response(['status' => 404, 'code' => 'NOT_FOUND', 'message' => 'Not found'], 404),
                $request,
            );
        }

        if (str_starts_with($url, 'https://api.linkedin.com/rest/posts')) {
            return $this->resolveFake($this->linkedInFeed, $request);
        }

        return Http::response('Unexpected request in test: ' . $url, 599);
    }

    private function resolveFake(mixed $fake, Request $request): mixed
    {
        if ($fake instanceof Closure) {
            return $fake($request);
        }

        return is_array($fake) ? Http::response($fake) : $fake;
    }

    private function instagramPage(array $items, ?string $nextCursor = null): array
    {
        $body = ['data' => $items, 'paging' => ['cursors' => ['before' => 'b', 'after' => $nextCursor ?? 'end']]];

        if ($nextCursor !== null) {
            $body['paging']['next'] = "https://graph.instagram.com/v25.0/me/media?after={$nextCursor}&access_token=ig-seed-token";
        }

        return $body;
    }

    private function igPost(string $id, string $timestamp, string $caption = 'Caption', string $mediaType = 'IMAGE', ?string $file = null): array
    {
        $file ??= $id;
        // Signed CDN URL: the query string changes on every fetch, the path does not
        $signed = '?stp=dst-jpg&_nc_ohc=' . Str::random(10) . '&oh=00_' . Str::random(16) . '&oe=66F00000';

        return array_filter([
            'id'            => $id,
            'caption'       => $caption,
            'media_type'    => $mediaType,
            'media_url'     => $mediaType === 'VIDEO' ? "https://scontent.cdninstagram.com/o1/v/{$file}.mp4{$signed}" : "https://scontent.cdninstagram.com/v/t51/{$file}.jpg{$signed}",
            'thumbnail_url' => $mediaType === 'VIDEO' ? "https://scontent.cdninstagram.com/v/t51/{$file}-thumb.jpg{$signed}" : null,
            'permalink'     => "https://www.instagram.com/p/{$id}/",
            'timestamp'     => $timestamp,
        ]);
    }

    private function linkedInPage(array $elements, ?int $nextStart = null): array
    {
        $links = $nextStart === null ? [] : [[
            'rel'  => 'next',
            'type' => 'application/json',
            'href' => "/rest/posts?author=urn%3Ali%3Aorganization%3A53510973&q=author&count=10&start={$nextStart}&sortBy=CREATED",
        ]];

        return ['paging' => ['start' => 0, 'count' => 10, 'links' => $links], 'elements' => $elements];
    }

    private function liPost(string $id, int $createdAtMs, string $commentary, array $content = [], array $extra = []): array
    {
        return array_replace_recursive([
            'id'                => "urn:li:share:{$id}",
            'author'            => 'urn:li:organization:53510973',
            'commentary'        => $commentary,
            'visibility'        => 'PUBLIC',
            'lifecycleState'    => 'PUBLISHED',
            'distribution'      => ['feedDistribution' => 'MAIN_FEED', 'thirdPartyDistributionChannels' => []],
            'content'           => $content,
            'createdAt'         => $createdAtMs,
            'publishedAt'       => $createdAtMs,
            'lastModifiedAt'    => $createdAtMs,
            'lifecycleStateInfo' => ['isEditedByAuthor' => false],
        ], $extra);
    }
}
