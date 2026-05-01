<?php

use App\Http\Controllers\ContactCardController;
use App\Http\Controllers\ProjectController;
use App\Http\Middleware\UseCardLayout;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/about', function () {
    return Inertia::render('About');
});

Route::get('/contact', function () {
    return Inertia::render('Contact');
});

Route::get('/services', function () {
    return Inertia::render('Services');
});

Route::get('/services/{slug}', function () {
    return Inertia::render('Services');
});

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');

Route::get('/blog', function () {
    return Inertia::render('Blog');
});

Route::get('/cards/{slug}', [ContactCardController::class, 'show'])
    ->middleware(UseCardLayout::class);

Route::get('/blog/{slug}', function (string $slug) {
    $titles = [
        'conversation-with-the-ceo-dck-construction' => 'Conversation with the CEO | DCK Construction',
        'dck-construction-newham-voids-works-overview' => 'DCK Construction: Newham Voids Works Overview',
        'dck-construction-working-with-camden-council-fire-door-installation' => 'DCK Construction Working with Camden Council | Fire Door Installation',
        'kitchen-bathroom-renewal-programme-delivering-quality-upgrades-for-haringey-homes' => 'Kitchen & Bathroom Renewal Programme - Delivering Quality Upgrades for Haringey Homes',
    ];

    return Inertia::render('BlogDetail', [
        'slug' => $slug,
        'title' => $titles[$slug] ?? null,
    ]);
});
