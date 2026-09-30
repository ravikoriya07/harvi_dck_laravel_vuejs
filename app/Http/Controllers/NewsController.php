<?php

namespace App\Http\Controllers;

use App\Models\SocialPost;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;
use Inertia\Response;

/**
 * News page. Serves the posts mirrored by `news:sync` from the database —
 * the page never calls LinkedIn/Instagram, so it stays fast and keeps working
 * when a platform API is down.
 */
class NewsController extends Controller
{
    private const PER_PAGE = 12;

    public function index(Request $request): Response
    {
        $unavailable = false;

        try {
            $posts = SocialPost::query()
                ->newestFirst()
                ->paginate(self::PER_PAGE)
                ->onEachSide(1)
                ->withQueryString()
                ->through(fn (SocialPost $post) => [
                    'id'              => $post->id,
                    'platform'        => $post->platform->value,
                    'platform_label'  => $post->platform->label(),
                    'permalink'       => $post->permalink,
                    'caption'         => $post->caption,
                    'media_type'      => $post->media_type,
                    'image_url'       => $post->image_url,
                    'image_alt'       => $post->image_alt_text,
                    'published_at'    => $post->published_at?->toIso8601String(),
                    'published_label' => $post->formatted_date,
                ]);
        } catch (QueryException $e) {
            // Friendly error state for visitors; the details go to the log
            report($e);
            $unavailable = true;
            $posts = new LengthAwarePaginator([], 0, self::PER_PAGE, 1, ['path' => $request->url()]);
        }

        return Inertia::render('News', [
            'posts'       => $posts,
            'profiles'    => config('news.profiles'),
            'unavailable' => $unavailable,
        ]);
    }
}
