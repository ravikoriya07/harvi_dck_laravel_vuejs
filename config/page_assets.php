<?php

/**
 * Per-page Elementor CSS bundles (sync on first paint; others load async for SPA visits).
 */
return [

    'bundles' => [
        '/' => ['elementor-generated.css'],
        'about' => ['about-elementor-generated.css'],
        'services' => ['services-elementor-generated.css'],
        'services/*' => ['services-elementor-generated.css'],
        'projects' => ['projects-elementor-generated.css'],
        'works/*' => ['projects-elementor-generated.css'],
        'social-values' => ['projects-elementor-generated.css'],
        'social-values/*' => ['projects-elementor-generated.css'],
        'blog' => ['blog-elementor-generated.css', 'blog-detail-elementor-generated.css'],
        'blog/*' => ['blog-elementor-generated.css', 'blog-detail-elementor-generated.css'],
        'contact' => ['contact-elementor-generated.css'],
        'disclaimer' => ['disclaimer-elementor-generated.css'],
        'jobs' => [],
        'jobs/*' => [],
        'cards/*' => [],
    ],

    'preload_images' => [
        '/' => [
            ['href' => '/assets/images/home-1-01.avif', 'media' => '(min-width: 768px)'],
            ['href' => '/assets/images/bg-2_H-e1760689052181_1_11zon.avif'],
        ],
        'about' => [
            ['href' => '/assets/images/STAFF-52-of-61-scaled-e1750700599226.avif'],
        ],
        'services' => [
            ['href' => '/assets/images/home_bg.avif'],
        ],
        'contact' => [
            ['href' => '/assets/images/pt-about1.avif'],
        ],
        'disclaimer' => [
            ['href' => '/assets/images/pt-about1.webp'],
        ],
        'jobs' => [
            ['href' => '/assets/images/bg-2_H-e1760689052181_1_11zon.avif'],
        ],
        'jobs/*' => [
            ['href' => '/assets/images/bg-2_H-e1760689052181_1_11zon.avif'],
        ],
    ],

];
