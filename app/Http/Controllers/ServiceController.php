<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Services', [
            'services' => self::listingPayload(),
        ]);
    }

    public function show(string $slug): Response
    {
        Service::query()->where('slug', $slug)->firstOrFail();

        return Inertia::render('Services', [
            'services' => self::listingPayload(),
        ]);
    }

    /**
     * @return Collection<int, array{title: string, href: string, desc: string, image: string, alt: string}>
     */
    public static function listingPayload(): Collection
    {
        return Service::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn (Service $service) => $service->toListingArray())
            ->values();
    }
}
