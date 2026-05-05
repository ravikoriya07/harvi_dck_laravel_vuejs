<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BlogController extends Controller
{
    public function index(Request $request): Response
    {
        $posts = Blog::published()
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->paginate(10)
            ->withQueryString()
            ->through(fn (Blog $blog) => [
                'id'        => $blog->id,
                'title'     => $blog->title,
                'slug'      => $blog->slug,
                'href'      => "/blog/{$blog->slug}",
                'image_url' => $blog->image_url,
                'video_url' => $blog->video_url,
                'category'  => $blog->category,
                'author'    => $blog->author,
                'excerpt'   => $blog->excerpt,
            ]);

        $categories = Blog::published()
            ->selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('category')
            ->get(['category', 'count']);

        return Inertia::render('Blog', [
            'posts'      => $posts,
            'categories' => $categories,
        ]);
    }

    public function show(string $slug): Response
    {
        $blog = Blog::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $categories = Blog::published()
            ->selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->orderBy('category')
            ->get(['category', 'count']);

        return Inertia::render('BlogDetail', [
            'post' => [
                'id'           => $blog->id,
                'title'        => $blog->title,
                'slug'         => $blog->slug,
                'image_url'    => $blog->image_url,
                'video_url'    => $blog->video_url,
                'excerpt'      => $blog->excerpt,
                'content'      => $blog->content,
                'author'       => $blog->author,
                'category'     => $blog->category,
                'published_at' => $blog->formatted_date,
            ],
            'categories' => $categories,
        ]);
    }
}
