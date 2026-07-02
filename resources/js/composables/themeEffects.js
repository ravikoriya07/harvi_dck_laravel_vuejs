/**
 * Optimized Maiko / Elementor / WOW bootstrap for Inertia + Vue.
 *
 * Performance rules:
 * - Layout bindings (sticky header, parallax scan) run once per page visit.
 * - Widget hooks run only on unprocessed nodes (never re-init Swiper / SplitText).
 * - Async homepage sections trigger a debounced scoped init, not a full page re-scan.
 */

const SPLIT_INIT_ATTR = 'data-pxl-split-init';
const ENTRANCE_BOUND_ATTR = 'data-pxl-entrance-bound';
const LAYOUT_FLAG = 'data-pxl-layout-init';

let wowInstance = null;
let scheduleTimer = null;
let mutationTimer = null;
let scrollRefreshTimer = null;
let domObserver = null;

function legacyScriptsReady() {
    return typeof jQuery !== 'undefined'
        && typeof elementorFrontend !== 'undefined'
        && typeof WOW !== 'undefined'
        && typeof gsap !== 'undefined';
}

function playElementorEntrance($el) {
    const settings = $el.data('settings') || {};
    const animation = settings.animation || settings._animation || 'fadeInUp';
    const delay = Number(settings.animation_delay || settings._animation_delay || 0);

    setTimeout(() => {
        $el.removeClass('elementor-invisible').addClass(`animated ${animation}`);
    }, delay);
}

function isInViewport(el) {
    const rect = el.getBoundingClientRect();

    return rect.top < window.innerHeight * 0.92 && rect.bottom > 0;
}

function bindElementorEntranceAnimations($scope) {
    const $root = $scope?.length ? $scope : jQuery('body');

    $root.find('.elementor-invisible').filter(function () {
        return ! this.hasAttribute(ENTRANCE_BOUND_ATTR);
    }).each(function () {
        const $el = jQuery(this);
        this.setAttribute(ENTRANCE_BOUND_ATTR, '1');

        if (isInViewport(this)) {
            playElementorEntrance($el);
            return;
        }

        if (elementorFrontend.waypoint) {
            elementorFrontend.waypoint($el, function () {
                playElementorEntrance(jQuery(this));
            }, { offset: '90%', triggerOnce: true });
        }
    });
}

function hasUninitializedSwipers($scope) {
    return $scope.find('.pxl-swiper-container').toArray().some((el) => ! el.swiper);
}

function scheduleScrollTriggerRefresh() {
    clearTimeout(scrollRefreshTimer);
    scrollRefreshTimer = setTimeout(() => {
        if (typeof ScrollTrigger !== 'undefined') {
            ScrollTrigger.refresh();
        }
    }, 250);
}

function initWow() {
    if (typeof WOW === 'undefined') {
        return;
    }

    if (! wowInstance) {
        wowInstance = new WOW({ animateClass: 'animated', offset: 100 });
        wowInstance.init();
    } else if (typeof wowInstance.sync === 'function') {
        wowInstance.sync();
    }
}

function initWidgetsInScope($scope) {
    if (! legacyScriptsReady() || ! $scope.length) {
        return;
    }

    const $ = jQuery;

    elementorFrontend.hooks.doAction('frontend/element_ready/global', $scope);

    $scope.find('.pxl-swiper-slider, .pxl-header-mobile-elementor').css('opacity', '1');

    if (hasUninitializedSwipers($scope)) {
        elementorFrontend.hooks.doAction('frontend/element_ready/pxl_post_carousel.default', $scope);
    }

    if ($scope.find('.pxl-counter').length) {
        elementorFrontend.hooks.doAction('frontend/element_ready/pxl_counter.default', $scope, jQuery);
    }

    if ($scope.find('.pxl-pie-chart').length) {
        elementorFrontend.hooks.doAction('frontend/element_ready/pxl_pie_chart.default', $scope, jQuery);
    }

    if ($scope.find('.pxl-client-carousel').length) {
        elementorFrontend.hooks.doAction('frontend/element_ready/pxl_client_carousel.default', $scope);
    }

    if ($(window).width() > 1024 &&
        $scope.find('.pxl-tabs-slip1.style-2, .pxl-tabs-slip.style-1').length > 0) {
        elementorFrontend.hooks.doAction('frontend/element_ready/pxl_tabs_slip.default', $scope);
    }

    $scope.find('.elementor-widget-pxl_heading').each(function () {
        if (this.hasAttribute(SPLIT_INIT_ATTR)) {
            return;
        }

        this.setAttribute(SPLIT_INIT_ATTR, '1');
        elementorFrontend.hooks.doAction('frontend/element_ready/pxl_heading.default', $(this));
    });

    $scope.find('.elementor-widget-pxl_text_editor').each(function () {
        if (this.hasAttribute(SPLIT_INIT_ATTR)) {
            return;
        }

        this.setAttribute(SPLIT_INIT_ATTR, '1');
        elementorFrontend.hooks.doAction('frontend/element_ready/pxl_text_editor.default', $(this));
    });

    bindElementorEntranceAnimations($scope);
    initWow();
    scheduleScrollTriggerRefresh();
}

function runLayoutBindings() {
    if (! legacyScriptsReady()) {
        return false;
    }

    const wrapper = document.getElementById('pxl-wapper');

    if (wrapper?.hasAttribute(LAYOUT_FLAG)) {
        return true;
    }

    const $ = jQuery;

    const themeLayout = [
        'maiko_header_sticky', 'maiko_header_mobile', 'maiko_menu_divider_move',
        'maiko_scroll_to_top', 'maiko_footer_fixed', 'maiko_check_scroll',
        'maiko_submenu_responsive', 'maiko_panel_anchor_toggle',
        'maiko_slider_column_offset', 'maiko_height_ct_grid',
        'maiko_bgr_parallax', 'maiko_fit_to_screen', 'maiko_el_parallax',
        'maiko_backtotop_progess_bar', 'maiko_button_progess_bar',
        'maiko_bgr_hv', 'maiko_zoom_point',
    ];

    themeLayout.forEach((fn) => {
        if (typeof window[fn] === 'function') {
            window[fn]();
        }
    });

    if ($(window).width() > 767 && typeof window.maiko_button_parallax === 'function') {
        window.maiko_button_parallax();
    }

    if (typeof window.maiko_parallax_bg === 'function') {
        window.maiko_parallax_bg();
    }

    $('.pxl-swiper-slider, .pxl-header-mobile-elementor').css('opacity', '1');

    $('#pxl-header-mobile .pxl-header-menu li.menu-item-has-children').each(function () {
        if (! $(this).children('.pxl-menu-toggle').length) {
            $(this).append('<span class="pxl-menu-toggle"></span>');
        }
    });

    wrapper?.setAttribute(LAYOUT_FLAG, '1');
    document.body.classList.add('pxl-effects-ready');

    return true;
}

export function hidePageLoader() {
    document.querySelector('.pxl-loader')?.classList.add('is-loaded');
}

export function resetThemePageState() {
    document.getElementById('pxl-wapper')?.removeAttribute(LAYOUT_FLAG);
    document.body.classList.remove('pxl-effects-ready');
}

export function bootstrapThemeEffects({ hideLoader = true } = {}) {
    if (! legacyScriptsReady()) {
        return false;
    }

    runLayoutBindings();
    initWidgetsInScope(jQuery('body'));

    // Async sections may mount shortly after first paint — re-scan for carousels.
    setTimeout(initPendingWidgetsInMain, 400);
    setTimeout(initPendingWidgetsInMain, 1200);

    if (hideLoader) {
        requestAnimationFrame(() => hidePageLoader());
    }

    return true;
}

/**
 * Wait for legacy scripts, bootstrap once, then hide loader.
 */
export function scheduleThemeEffects({ hideLoader = true, scope = null } = {}) {
    clearTimeout(scheduleTimer);

    scheduleTimer = setTimeout(() => {
        const run = () => {
            if (scope) {
                if (! legacyScriptsReady()) {
                    return false;
                }

                runLayoutBindings();
                initWidgetsInScope(jQuery(scope));
                return true;
            }

            return bootstrapThemeEffects({ hideLoader });
        };

        if (run()) {
            return;
        }

        const retry = setInterval(() => {
            if (run()) {
                clearInterval(retry);
            }
        }, 50);

        window.addEventListener('load', () => {
            run();
            clearInterval(retry);
        }, { once: true });

        setTimeout(() => {
            clearInterval(retry);
            if (hideLoader) {
                hidePageLoader();
            }
        }, 8000);
    }, 16);
}

function destroySwipersInScope($scope) {
    $scope.find('.pxl-swiper-container').each(function () {
        if (this.swiper) {
            this.swiper.destroy(true, true);
        }
    });
}

function clearWidgetInitFlags(scope) {
    if (! scope) {
        return;
    }

    scope.querySelectorAll(`[${SPLIT_INIT_ATTR}]`).forEach((el) => {
        el.removeAttribute(SPLIT_INIT_ATTR);
    });

    scope.querySelectorAll(`[${ENTRANCE_BOUND_ATTR}]`).forEach((el) => {
        el.removeAttribute(ENTRANCE_BOUND_ATTR);
    });
}

/**
 * Re-run Maiko/Elementor widgets inside a DOM subtree (split-text, swipers, entrances).
 */
export function reinitWidgetsInScope(scope) {
    if (! legacyScriptsReady() || ! scope) {
        return false;
    }

    const $scope = jQuery(scope);

    if (! $scope.length) {
        return false;
    }

    clearWidgetInitFlags(scope);
    destroySwipersInScope($scope);
    $scope.find('.pxl-swiper-slider, .pxl-header-mobile-elementor').css('opacity', '1');
    initWidgetsInScope($scope);
    scheduleScrollTriggerRefresh();

    return true;
}

function initPendingWidgetsInMain() {
    if (! legacyScriptsReady()) {
        return;
    }

    const $main = jQuery('#pxl-main');

    if (! $main.length) {
        return;
    }

    $main.find('.pxl-swiper-slider, .pxl-header-mobile-elementor').css('opacity', '1');

    if (hasUninitializedSwipers($main) ||
        $main.find('.elementor-invisible:not([data-pxl-entrance-bound])').length > 0) {
        initWidgetsInScope($main);
    } else {
        bindElementorEntranceAnimations($main);
        initWow();
    }
}

function collectAddedRoots(mutations) {
    const roots = [];

    for (const mutation of mutations) {
        for (const node of mutation.addedNodes) {
            if (node.nodeType !== 1) {
                continue;
            }

            if (node.matches?.('.elementor-section, section, .pxl-swiper-slider, .wow, .pxl-swiper-container') ||
                node.querySelector?.('.elementor-section, .pxl-swiper-slider, .pxl-swiper-container, .wow, .elementor-invisible')) {
                roots.push(node);
            }
        }
    }

    return roots;
}

/**
 * Debounced scoped init when async Vue sections mount (homepage below-fold chunks).
 */
export function observeDynamicSections() {
    const root = document.getElementById('pxl-main');

    if (! root || domObserver) {
        return;
    }

    domObserver = new MutationObserver((mutations) => {
        const addedRoots = collectAddedRoots(mutations);

        if (! addedRoots.length) {
            return;
        }

        clearTimeout(mutationTimer);
        mutationTimer = setTimeout(initPendingWidgetsInMain, 200);
    });

    domObserver.observe(root, { childList: true, subtree: true });
}

export function bindMobileMenuHandlers() {
    if (typeof jQuery === 'undefined') {
        return;
    }

    const $ = jQuery;

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

    $(document).off('click.pxlmobile', '#pxl-nav-mobile').on('click.pxlmobile', '#pxl-nav-mobile', function () {
        $(this).toggleClass('active');
        $('body').toggleClass('body-overflow');
        $('.pxl-header-menu').toggleClass('active');
    });

    $(document).off('click.pxlmobile', '.pxl-menu-close, .pxl-header-menu-backdrop')
        .on('click.pxlmobile', '.pxl-menu-close, .pxl-header-menu-backdrop', function () {
            $(this).closest('.pxl-header-main').find('.pxl-header-menu').removeClass('active');
            $('#pxl-nav-mobile').removeClass('active');
            $('body').removeClass('body-overflow');
        });
}

// Backwards-compatible alias
export function initThemeEffects() {
    return bootstrapThemeEffects({ hideLoader: false });
}
