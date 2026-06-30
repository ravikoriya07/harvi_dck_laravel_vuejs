<?php

namespace App\Http\Controllers;

use App\Models\SocialValue;
use Inertia\Inertia;
use Inertia\Response;

class SocialValueController extends Controller
{
    public function index(): Response
    {
        $socialValues = SocialValue::query()
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString()
            ->through(fn (SocialValue $socialValue) => [
                'title'    => $socialValue->title,
                'category' => $socialValue->category,
                'href'     => $socialValue->detail_href,
                'image'    => $socialValue->image_url,
            ]);

        return Inertia::render('SocialValues', [
            'socialValues' => $socialValues,
        ]);
    }

    public function show(string $slug): Response
    {
        $socialValue = SocialValue::query()
            ->where('slug', $slug)
            ->with('galleryImages')
            ->firstOrFail();

        $orderedIds = SocialValue::orderBy('sort_order')->orderBy('id')->pluck('id')->toArray();
        $currentIndex = array_search($socialValue->id, $orderedIds);

        $prevId = ($currentIndex > 0) ? $orderedIds[$currentIndex - 1] : null;
        $nextId = ($currentIndex < count($orderedIds) - 1) ? $orderedIds[$currentIndex + 1] : null;

        $prevSocialValue = $prevId ? SocialValue::find($prevId) : null;
        $nextSocialValue = $nextId ? SocialValue::find($nextId) : null;

        return Inertia::render('SocialValueDetail', [
            'socialValue' => [
                'title'       => $socialValue->title,
                'slug'        => $socialValue->slug,
                'category'    => $socialValue->category,
                'image'       => $socialValue->image_url,
                'value'       => $socialValue->value,
                'date'        => $socialValue->date,
                'status'      => $socialValue->status,
                'client'      => $socialValue->client,
                'scope'       => $socialValue->scope,
                'description' => $socialValue->description,
                'gallery'     => $socialValue->gallery_urls,
            ],
            'prevSocialValue' => $prevSocialValue ? [
                'title' => $prevSocialValue->title,
                'href'  => $prevSocialValue->detail_href,
            ] : null,
            'nextSocialValue' => $nextSocialValue ? [
                'title' => $nextSocialValue->title,
                'href'  => $nextSocialValue->detail_href,
            ] : null,
        ]);
    }
}
