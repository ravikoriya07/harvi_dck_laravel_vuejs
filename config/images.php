<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AVIF conversion defaults
    |--------------------------------------------------------------------------
    */
    'avif' => [
        'enabled' => env('IMAGE_AVIF_ENABLED', true),
        'quality' => (int) env('IMAGE_AVIF_QUALITY', 60),
        'speed' => (int) env('IMAGE_AVIF_SPEED', 6),
        'max_dimension' => (int) env('IMAGE_AVIF_MAX_DIMENSION', 2560),
        'memory_limit' => env('IMAGE_AVIF_MEMORY_LIMIT', '512M'),
    ],

    'convertible_extensions' => ['jpg', 'jpeg', 'png', 'webp', 'gif'],

    /*
    |--------------------------------------------------------------------------
    | Paths skipped during bulk conversion (favicons, UI sprites, etc.)
    |--------------------------------------------------------------------------
    */
    'skip_patterns' => [
        'favicon',
        'ui-icons',
        'flags',
        'flags@2x',
        'select-arrow',
        'placeholder',
    ],

    /*
    |--------------------------------------------------------------------------
    | Directories scanned by images:convert-avif
    |--------------------------------------------------------------------------
    */
    'scan_paths' => [
        'public/assets/images',
        'storage/app/public',
    ],

    /*
    |--------------------------------------------------------------------------
    | Code / config locations where image path references are updated
    |--------------------------------------------------------------------------
    */
    'reference_scan_paths' => [
        'resources/js',
        'resources/views',
        'public/assets/css',
        'database/seeders',
        'app',
    ],

    /*
    |--------------------------------------------------------------------------
    | Homepage static images (Vue layout + CSS backgrounds on elementor-18)
    | Used by: php artisan images:convert-avif --homepage-only
    |--------------------------------------------------------------------------
    */
    'homepage_images' => [
        '/assets/images/favicon/favicon-1.png', // kept as PNG — see skip_patterns
        '/assets/images/dck-logo-1.png',
        '/assets/images/home-1-01.webp',
        '/assets/images/bg-2_H-e1760689052181_1_11zon.jpg',
        '/assets/images/About-us_13_11zon.jpg',
        '/assets/images/STAFF-41-of-61-1-scaled_9_11zon.jpg',
        '/assets/images/STAFF-59-of-61-scaled_8_11zon.jpg',
        '/assets/images/home1-vector.webp',
        '/assets/images/image_5-4.jpg',
        '/assets/images/JOB-17-of-155-scaled.jpg',
        '/assets/images/LAS18.jpg',
        '/assets/images/service-sg1.jpg',
        '/assets/images/service-sg2-833x534.jpg',
        '/assets/images/service-sg3-1-360x534.jpg',
        '/assets/images/R-scaled-e1757582678238.png',
        '/assets/images/1-01833329_22_11zon.jpg',
        '/assets/images/hounslowsquare-e1757586426401_21_11zon-removebg-preview.png',
        '/assets/images/hounslowsquare-e1757586426401_21_11zon-1.jpg',
        '/assets/images/southwark_council_logo_thumb_080525-removebg-preview-e1757586556672.png',
        '/assets/images/southwark_council_logo_thumb_080525-removebg-preview-e1757586556672_20_11zon.jpg',
        '/assets/images/o_1172-removebg-preview-e1757586310795.png',
        '/assets/images/o_1172-removebg-preview-e1757586310795_19_11zon.jpg',
        '/assets/images/EQUANS_logotype_RGG-e1757587263463.png',
        '/assets/images/EQUANS_logotype_RGG-e1757587263463_18_11zon.jpg',
        '/assets/images/image-removebg-preview-e1757587302187.png',
        '/assets/images/image-removebg-preview-e1757587302187_17_11zon.jpg',
        '/assets/images/image-removebg-preview.png',
        '/assets/images/image-removebg-preview_16_11zon.jpg',
        '/assets/images/image-removebg-preview-1.png',
        '/assets/images/image-removebg-preview-1_15_11zon.jpg',
        '/assets/images/work4.webp',
        '/assets/images/home1-appro1.webp',
        '/assets/images/home1-appro2.webp',
        '/assets/images/home-3-s3-3.webp',
        '/assets/images/STAFF-52-of-61-scaled-e1750700599226_11_11zon.jpg',
        '/assets/images/Paritet_logo-removebg-preview.png',
        '/assets/images/logo-transparent-png-scaled-e1760627393297.png',
        '/assets/images/Stypix.png',
        '/assets/images/Lets-Talk_10_11zon.jpg',
        '/assets/images/thumbnail_45001-SSIP-e1758120151217_17_11zon.jpg',
        '/assets/images/thumbnail_Cyber-Essentials-Plus-Logo-web-removebg-preview_6_11zon.jpg',
        '/assets/images/thumbnail_Fensa_16_11zon.jpg',
        '/assets/images/thumbnail_Forefront_UKAS_15_11zon.jpg',
        '/assets/images/thumbnail_Gold_RGB_5_11zon.jpg',
        '/assets/images/thumbnail_SSIP_Member_4_11zon.jpg',
        '/assets/images/thumbnail_thermoguard-logo-removebg-preview_3_11zon.jpg',
        '/assets/images/thumbnail_UKAS-Q-Mark-FDI-FDM-FSI-Colour-black-UKAS_14_11zon.jpg',
        '/assets/images/thumbnail_xElite-Badge.png.pagespeed.ic_.2BAm9hdid-.png',
        '/assets/images/thumbnail_LW_logo_employer_rgb-removebg-preview_1_11zon.jpg',
        '/assets/images/home-1-02.webp',
        '/assets/images/home1-01.webp',
        '/assets/images/home1-team-2.webp',
        '/assets/images/home1-team-3.webp',
    ],

    /*
    |--------------------------------------------------------------------------
    | Database columns that store image paths
    |--------------------------------------------------------------------------
    */
    'database_columns' => [
        ['table' => 'projects', 'column' => 'image'],
        ['table' => 'project_images', 'column' => 'path'],
        ['table' => 'blogs', 'column' => 'image_path'],
        ['table' => 'contact_cards', 'column' => 'profile_image'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Archive converted originals here (relative to project root) before deletion
    |--------------------------------------------------------------------------
    */
    'archive_originals' => env('IMAGE_AVIF_ARCHIVE', true),
    'archive_path' => 'storage/app/image-originals-archive',

];
