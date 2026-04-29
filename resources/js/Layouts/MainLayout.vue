<template>
    <div id="pxl-wapper" class="pxl-wapper">
        <AppHeader />
        <div id="pxl-main">
            <slot />
        </div>
        <AppFooter />
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import AppHeader from '@/Components/AppHeader.vue';
import AppFooter from '@/Components/AppFooter.vue';

onMounted(() => {
    if (typeof jQuery === 'undefined') return;
    const $ = jQuery;

    // ── 1. Theme layout / UI functions ──────────────────────────────────────
    // theme.js calls these on window.load and $(document).ready, both of
    // which fire before Vue renders the DOM.  We re-call them here so they
    // actually bind to the rendered elements.
    const themeLayout = [
        'maiko_header_sticky', 'maiko_header_mobile', 'maiko_menu_divider_move',
        'maiko_scroll_to_top', 'maiko_footer_fixed', 'maiko_check_scroll',
        'maiko_submenu_responsive', 'maiko_panel_anchor_toggle',
        'maiko_slider_column_offset', 'maiko_height_ct_grid',
        'maiko_bgr_parallax', 'maiko_fit_to_screen', 'maiko_el_parallax',
        'maiko_backtotop_progess_bar', 'maiko_button_progess_bar',
        'maiko_bgr_hv', 'maiko_zoom_point',
    ];
    themeLayout.forEach(fn => {
        if (typeof window[fn] === 'function') window[fn]();
    });

    if ($(window).width() > 767 && typeof window.maiko_button_parallax === 'function') {
        window.maiko_button_parallax();
    }

    // ── 1b. elementor.js parallax effects (pinned-zoom-clipped etc.) ────────
    // maiko_parallax_bg() in elementor.js handles GSAP-driven parallax effects
    // including the pinned-zoom-clipped (scale 0.86→1) animation. It runs at
    // original page-load before Vue mounts so Vue-rendered sections are missed.
    if (typeof window.maiko_parallax_bg === 'function') {
        window.maiko_parallax_bg();
    }

    // ── 2. Make Swiper sliders visible (opacity:0 until JS init by theme) ───
    $('.pxl-swiper-slider, .pxl-header-mobile-elementor').css('opacity', '1');

    // ── 3. Trigger Elementor widget-ready hooks ──────────────────────────────
    // carousel.js, counter.js and elementor.js register their widget handlers
    // inside the elementor/frontend/init event, which fires synchronously from
    // frontend.min.js BEFORE Vue mounts.  The handlers are now in the hooks
    // registry; we just need to doAction with a broad $scope to scan the DOM.
    if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
        const $body = $('body');

        // Global handler: scroll animations (.pxl-animate, .pxl-border-animated,
        // .pxl-image-single.circle, .pxl-divider.animated, etc.)
        elementorFrontend.hooks.doAction('frontend/element_ready/global', $body);

        // Swiper carousels — every carousel type in carousel.js calls the same
        // pxl_swiper_handler($scope), which does $scope.find('.pxl-swiper-slider').
        // Calling ANY ONE type with $body finds and inits ALL sliders on the page.
        // Do NOT loop over all types — that would init each slider N times.
        elementorFrontend.hooks.doAction('frontend/element_ready/pxl_post_carousel.default', $body);

        // Counter / pie chart — handler signature is ($scope, $), must pass jQuery
        // as second arg or $(this) inside the waypoint callback is undefined
        elementorFrontend.hooks.doAction('frontend/element_ready/pxl_counter.default', $body, jQuery);
        elementorFrontend.hooks.doAction('frontend/element_ready/pxl_pie_chart.default', $body, jQuery);

        // Client/partner carousel (About page partners section)
        elementorFrontend.hooks.doAction('frontend/element_ready/pxl_client_carousel.default', $body);

        // Tabs-slip scroll section — maiko_triger uses GSAP ScrollTrigger to pin
        // and horizontally scroll the panel stack. Must call with a broad scope
        // so $scope.find('.pxl-tabs-slip1.style-2 ...') finds the widget.
        if ($(window).width() > 767) {
            elementorFrontend.hooks.doAction('frontend/element_ready/pxl_tabs_slip.default', $body);
        }

        // GSAP SplitText — maiko_split_text uses $scope.find('.pxl-split-text')
        // so we pass each widget individually for accurate per-element scoping
        $body.find('.elementor-widget-pxl_heading').each(function () {
            elementorFrontend.hooks.doAction('frontend/element_ready/pxl_heading.default', $(this));
        });
        $body.find('.elementor-widget-pxl_text_editor').each(function () {
            elementorFrontend.hooks.doAction('frontend/element_ready/pxl_text_editor.default', $(this));
        });

        // Elementor entrance animations (.elementor-invisible elements with data-settings)
        // Elementor's core handles these via frontend.min.js, which runs before Vue mounts.
        // We replicate the same logic here for Vue-rendered elements.
        if (elementorFrontend.waypoint) {
            elementorFrontend.waypoint($(document).find('.elementor-invisible'), function () {
                var $el = $(this);
                var settings = $el.data('settings') || {};
                var animation = settings.animation || 'fadeInUp';
                var delay = settings.animation_delay || 0;
                setTimeout(function () {
                    $el.removeClass('elementor-invisible').addClass('animated ' + animation);
                }, delay);
            }, { offset: '90%' });
        }
    }

    // ── 4. WOW.js scroll-reveal (.wow elements) ──────────────────────────────
    if (typeof WOW !== 'undefined') {
        new WOW({ animateClass: 'animated', offset: 100 }).init();
    }

    // ── 5. Mobile menu ────────────────────────────────────────────────────────
    // theme.js binds these handlers inside $(document).ready, which fires
    // before Vue mounts, so the elements don't exist yet and nothing is bound.
    // Rebind here using a namespace so we never double-bind on SPA navigations.

    // Append toggle arrow to items that have sub-menus (guard against duplicates)
    $('#pxl-header-mobile .pxl-header-menu li.menu-item-has-children').each(function () {
        if (!$(this).children('.pxl-menu-toggle').length) {
            $(this).append('<span class="pxl-menu-toggle"></span>');
        }
    });

    // Sub-menu accordion toggle
    $(document).off('click.pxlmobile', '.pxl-menu-toggle').on('click.pxlmobile', '.pxl-menu-toggle', function () {
        if ($(this).hasClass('active')) {
            $(this).closest('ul').find('.pxl-menu-toggle.active').toggleClass('active');
            $(this).closest('ul').find('.sub-menu.active').toggleClass('active').slideToggle();
        } else {
            $(this).closest('ul').find('.pxl-menu-toggle.active').toggleClass('active');
            $(this).closest('ul').find('.sub-menu.active').toggleClass('active').slideToggle();
            $(this).toggleClass('active');
            $(this).parent().find('> .sub-menu').toggleClass('active');
            $(this).parent().find('> .sub-menu').slideToggle();
        }
    });

    // Hamburger button → open drawer
    $(document).off('click.pxlmobile', '#pxl-nav-mobile').on('click.pxlmobile', '#pxl-nav-mobile', function () {
        $(this).toggleClass('active');
        $('body').toggleClass('body-overflow');
        $('.pxl-header-menu').toggleClass('active');
    });

    // Close button / backdrop → close drawer
    $(document).off('click.pxlmobile', '.pxl-menu-close, .pxl-header-menu-backdrop')
               .on('click.pxlmobile', '.pxl-menu-close, .pxl-header-menu-backdrop', function () {
        $(this).closest('.pxl-header-main').find('.pxl-header-menu').removeClass('active');
        $('#pxl-nav-mobile').removeClass('active');
        $('body').removeClass('body-overflow');
    });
});
</script>
