<?php

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

Route::get('/projects', function () {
    return Inertia::render('Projects');
});

Route::get('/blog', function () {
    return Inertia::render('Blog');
});

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
