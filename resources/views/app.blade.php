<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@php
    use App\Support\PageAssets;

    $isJobs = request()->is('jobs*');
    $syncStylesheets = PageAssets::stylesheetsForRequest(request());
    $asyncStylesheets = array_values(array_diff(PageAssets::allStylesheetBundles(), $syncStylesheets));
    $preloadImages = PageAssets::preloadImagesForRequest(request());
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title inertia>{{ config('app.name', 'DCK Construction Ltd') }}</title>

    <link rel="icon" href="/assets/images/favicon/favicon-1.png" type="image/png">

    @foreach ($preloadImages as $image)
        <link rel="preload" as="image" href="{{ $image['href'] }}" fetchpriority="high"@if (! empty($image['media'])) media="{{ $image['media'] }}"@endif>
    @endforeach

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Font Awesome (local CSS + webfonts in /assets/webfonts/) --}}
    <link rel="preload" href="/assets/webfonts/fa-brands-400.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/assets/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="/assets/fonts/all.min.css">

    {{-- Elementor icon font + frontend base --}}
    <link rel="stylesheet" href="/assets/css/elementor-icons.min.css">
    <link rel="stylesheet" href="/assets/css/custom-frontend.min.css">
    <link rel="stylesheet" href="/assets/css/frontend.css">
    <link rel="stylesheet" href="/assets/css/frontend2.css">

    {{-- Swiper / carousel --}}
    <link rel="stylesheet" href="/assets/css/swiper.min.css">
    <link rel="stylesheet" href="/assets/css/e-swiper.min.css">

    {{-- Animations (animate.min.css covers fadeIn, bounce, etc.) --}}
    <link rel="stylesheet" href="/assets/css/animate.min.css">

    {{-- UI plugins (skip jquery-ui on homepage — not used above the fold) --}}
    <link rel="stylesheet" href="/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="/assets/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" href="/assets/css/hint.min.css">
    @if ($isJobs)
        <link rel="stylesheet" href="/assets/css/jquery-ui.css">
    @endif

    {{-- Theme layout + components --}}
    <link rel="stylesheet" href="/assets/css/grid.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/info-card.css">
    <link rel="stylesheet" href="/assets/css/components.css">
    <link rel="stylesheet" href="/assets/css/icons.css">
    <link rel="stylesheet" href="/assets/css/custom-theme.css">

    {{-- Primary theme stylesheet (maiko-style.css is the full 38K-line theme CSS) --}}
    <link rel="stylesheet" href="/assets/css/maiko-style.css">
    <link rel="stylesheet" href="/assets/css/maiko.css">

    {{-- Current page Elementor CSS (sync) + other pages (async, for Inertia SPA navigation) --}}
    @foreach ($syncStylesheets as $stylesheet)
        <link rel="stylesheet" href="/assets/css/{{ $stylesheet }}">
    @endforeach
    @foreach ($asyncStylesheets as $stylesheet)
        <link rel="stylesheet" href="/assets/css/{{ $stylesheet }}" media="print" onload="this.media='all'">
        <noscript><link rel="stylesheet" href="/assets/css/{{ $stylesheet }}"></noscript>
    @endforeach

    {{-- Custom overrides for Vue/Inertia structure (must load last to win specificity) --}}
    <link rel="stylesheet" href="/assets/css/custom-fix.css">

    @inertiaHead
</head>

<body class="pxl-wapper-outer elementor-bc-flex-widget">

    {{-- Page loader (hidden via is-loaded class after page mounts) --}}
    <div id="pxl-loadding" class="pxl-loader">
        <div class="loader-circle">
            <div class="loader-line-mask">
                <div class="loader-line"></div>
            </div>
            <div class="loader-logo">
                <img src="/assets/images/favicon/favicon-1.png" alt="Loading">
            </div>
        </div>
    </div>

    {{-- Inertia app root --}}
    @inertia

    {{-- Custom cursor --}}
    <div class="pxl-cursor pxl-js-cursor">
        <div class="pxl-cursor-wrapper">
            <div class="pxl-cursor--follower pxl-js-follower"></div>
            <div class="pxl-cursor--label pxl-js-label"></div>
            <div class="pxl-cursor--drap pxl-js-drap"></div>
            <div class="pxl-cursor--icon pxl-js-icon"></div>
        </div>
    </div>

    {{-- Scroll to top --}}
    <a class="pxl-scroll-top style-default" href="#">
        <svg id="fi_3114931" height="16" viewBox="0 0 24 24" width="16" fill="#fff" xmlns="http://www.w3.org/2000/svg">
            <path d="m22.707 11.293-7-7a1 1 0 0 0 -1.414 1.414l5.293 5.293h-17.586a1 1 0 0 0 0 2h17.586l-5.293 5.293a1 1 0 1 0 1.414 1.414l7-7a1 1 0 0 0 0-1.414z"></path>
        </svg>
        <svg class="pxl-scroll-progress-circle" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </a>

    {{-- ─────────────────────────────────────────────────────────────────────────
         Vendor / Theme scripts — must remain as global <script> tags because:
         · They rely on and expose window globals (jQuery, Swiper, WOW, maiko_*)
         · They must execute in strict dependency order (jQuery first)
         · Vite module bundling would break their intentional global side-effects
    ───────────────────────────────────────────────────────────────────────── --}}

    {{-- jQuery core (synchronous — all subsequent scripts depend on it) --}}
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/jquery-migrate.min.js" defer></script>

    {{-- jQuery UI plugins --}}
    <script src="/assets/js/waypoints.min.js" defer></script>
    <script src="/assets/js/jarallax.min.js" defer></script>
    <script src="/assets/js/counter.min.js" defer></script>

    {{-- main.js: registers elementorFrontend.waypoint — must load before Elementor JS --}}
    <script src="/assets/js/main.js" defer></script>

    {{-- Elementor frontend config stub (replaces the PHP-injected WordPress global) --}}
    <script>
        var elementorFrontendConfig = {
            "environmentMode": { "edit": false, "wpPreview": false, "isScriptDebug": false },
            "i18n": {
                "shareOnFacebook": "Share on Facebook", "shareOnTwitter": "Share on Twitter",
                "pinIt": "Pin it", "download": "Download", "downloadImage": "Download image",
                "fullscreen": "Fullscreen", "zoom": "Zoom", "share": "Share",
                "playVideo": "Play Video", "previous": "Previous", "next": "Next", "close": "Close",
                "a11yCarouselPrevSlideMessage": "Previous slide",
                "a11yCarouselNextSlideMessage": "Next slide",
                "a11yCarouselFirstSlideMessage": "This is the first slide",
                "a11yCarouselLastSlideMessage": "This is the last slide",
                "a11yCarouselPaginationBulletMessage": "Go to slide"
            },
            "is_rtl": false,
            "breakpoints": { "xs": 0, "sm": 480, "md": 768, "lg": 1025, "xl": 1440, "xxl": 1600 },
            "responsive": {
                "breakpoints": {
                    "mobile":       { "label": "Mobile Portrait",  "value": 767,  "default_value": 767,  "direction": "max", "is_enabled": true },
                    "mobile_extra": { "label": "Mobile Landscape", "value": 880,  "default_value": 880,  "direction": "max", "is_enabled": true },
                    "tablet":       { "label": "Tablet Portrait",  "value": 1024, "default_value": 1024, "direction": "max", "is_enabled": true },
                    "tablet_extra": { "label": "Tablet Landscape", "value": 1200, "default_value": 1200, "direction": "max", "is_enabled": true },
                    "laptop":       { "label": "Laptop",           "value": 1366, "default_value": 1366, "direction": "max", "is_enabled": true },
                    "widescreen":   { "label": "Widescreen",       "value": 1921, "default_value": 2400, "direction": "min", "is_enabled": true }
                },
                "hasCustomBreakpoints": true
            },
            "version": "3.35.3",
            "is_static": false,
            "experimentalFeatures": {
                "additional_custom_breakpoints": true, "container": true,
                "nested-elements": true, "home_screen": true
            },
            "urls": {
                "assets": "/assets/",
                "ajaxurl": "/wp-admin/admin-ajax.php",
                "uploadUrl": "/wp-content/uploads"
            },
            "nonces": { "floatingButtonsClickTracking": "0c0fac3d02" },
            "swiperClass": "swiper",
            "settings": { "page": [], "editorPreferences": [] },
            "kit": {
                "active_breakpoints": ["viewport_mobile","viewport_mobile_extra","viewport_tablet","viewport_tablet_extra","viewport_laptop","viewport_widescreen"],
                "viewport_widescreen": 1921,
                "global_image_lightbox": "yes",
                "lightbox_enable_counter": "yes",
                "lightbox_enable_fullscreen": "yes",
                "lightbox_enable_zoom": "yes",
                "lightbox_enable_share": "yes",
                "lightbox_title_src": "title",
                "lightbox_description_src": "description"
            },
            "post": { "id": 18, "title": "DCK Construction Ltd", "excerpt": "", "featuredImage": false }
        };
    </script>

    {{-- Elementor runtime (must load after elementorFrontendConfig stub) --}}
    <script src="/assets/js/webpack.runtime.min.js" defer></script>
    <script src="/assets/js/frontend-modules.min.js" defer></script>
    <script src="/assets/js/core.min.js" defer></script>
    <script src="/assets/js/frontend.min.js" defer></script>

    {{-- GSAP + scroll animation plugins --}}
    <script src="/assets/js/gsap.min.js" defer></script>
    <script src="/assets/js/scroll-trigger.js" defer></script>
    <script src="/assets/js/scroll-toplpugin.js" defer></script>
    <script src="/assets/js/split-text.js" defer></script>
    <script src="/assets/js/observer.js" defer></script>
    <script src="/assets/js/scrollmagic.min.js" defer></script>
    <script src="/assets/js/tweenmax.min.js" defer></script>

    {{-- Swiper --}}
    <script src="/assets/js/swiper.min.js" defer></script>

    {{-- UI plugins --}}
    <script src="/assets/js/jquery-numerator.min.js" defer></script>
    <script src="/assets/js/magnific-popup.min.js" defer></script>
    <script src="/assets/js/perfect-scrollbar.jquery.min.js" defer></script>
    <script src="/assets/js/wow.min.js" defer></script>
    <script src="/assets/js/progressbar.min.js" defer></script>
    <script src="/assets/js/tilt.min.js" defer></script>
    <script src="/assets/js/modernizr.min.js" defer></script>
    <script src="/assets/js/counter-slide.min.js" defer></script>
    <script src="/assets/js/Snap.svg.js" defer></script>
    <script src="/assets/js/parallax-background.js" defer></script>
    <script src="/assets/js/parallax-scroll.js" defer></script>
    <script src="/assets/js/smoothscroll.js" defer></script>
    <script src="/assets/js/bundled-lenis.min.js" defer></script>

    {{-- Theme carousel / tabs / Elementor hooks --}}
    <script src="/assets/js/carousel.js" defer></script>
    <script src="/assets/js/counter.js" defer></script>
    <script src="/assets/js/tabs.js" defer></script>
    <script src="/assets/js/elementor.js" defer></script>

    {{-- isotope + grid.js: masonry layout and pxl-effect--3d hover direction classes --}}
    <script src="/assets/js/isotope.pkgd.min.js" defer></script>
    <script src="/assets/js/grid.js" defer></script>

    {{-- main_data stub (replaces WordPress localized script object used by theme.js) --}}
    <script>var main_data = { "ajax_url": "/wp-admin/admin-ajax.php" };</script>
    <script>window.__pxlLoaderManagedByVue = true;</script>

    {{-- theme.js: exposes all maiko_* functions --}}
    <script src="/assets/js/theme.js" defer></script>

    {{-- cursor.js: custom mouse cursor behaviour --}}
    <script src="/assets/js/cursor.js" defer></script>

    {{-- Vue/Inertia must mount after legacy globals (jQuery, GSAP, Elementor, WOW) --}}
    @vite(['resources/js/app.js'])

    {{-- Inertia SPA loader + fail-safe hide if Vue bootstrap is delayed --}}
    <script>
        (function () {
            var loader = document.querySelector('.pxl-loader');
            if (!loader) return;

            document.addEventListener('inertia:start', function () {
                loader.classList.remove('is-loaded');
            });

            // Fail-safe: never block the page longer than 8s on slow networks
            setTimeout(function () {
                loader.classList.add('is-loaded');
            }, 8000);
        })();
    </script>

</body>
</html>
