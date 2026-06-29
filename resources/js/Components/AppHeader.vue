<template>
    <header id="pxl-header-elementor" class="is-sticky pxl-header-show">

        <!-- ── Home: transparent (overlays hero). Inner pages: solid black (px-header--default). ── -->
            <div :class="['pxl-header-elementor-main', isHomePage ? 'px-header--transparent' : 'px-header--default']">
                <div class="pxl-header-content">
                    <div class="elementor elementor-15">
                        <section class="elementor-section elementor-top-section elementor-element elementor-element-6514195 elementor-section-stretched elementor-section-boxed pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none">
                                    <div class="elementor-container elementor-column-gap-extended">
                                        <!-- Logo column -->
                                        <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-20eecb0 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no" data-element_type="column">
                                            <div class="elementor-widget-wrap elementor-element-populated">
                                                <div class="elementor-element elementor-element-e9f5301 elementor-widget elementor-widget-pxl_logo">
                                                    <div class="elementor-widget-container">
                                                        <div class="pxl-logo">
                                                            <Link href="/"><img fetchpriority="high" src="/assets/images/dck-logo-1.avif" alt="DCK Construction" /></Link>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Desktop Nav column -->
                                        <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-de87c60 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no" data-element_type="column">
                                            <div class="elementor-widget-wrap elementor-element-populated">
                                                <div class="elementor-element elementor-element-396e816 elementor-widget__width-auto elementor-widget elementor-widget-pxl_menu">
                                                    <div class="elementor-widget-container">
                                                        <div class="pxl-nav-menu pxl-nav-menu1 pxl-mega-full-width pxl-nav-horizontal fr-style-box show-effect-slideup sub-style-default">
                                                            <div class="menu-menu-main-home-container">
                                                                <ul class="pxl-menu-primary clearfix">
                                                                    <li v-for="item in navItems" :key="item.label"
                                                                        :class="['menu-item', item.active ? 'current-menu-item current_page_item' : '']">
                                                                        <AppLink :href="item.href"><span class="pxl-menu-item-text">{{ item.label }}</span></AppLink>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="pxl-divider-move"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                    </div>
                </div>
            </div>

            <!-- ── White sticky header (shown on scroll) ── -->
            <div class="pxl-header-elementor-sticky pxl-onepage-sticky pxl-sticky-stt">
                <div class="pxl-header-content">
                    <div class="elementor elementor-9365">
                        <section class="elementor-section elementor-top-section elementor-element elementor-element-6514195 elementor-section-stretched elementor-section-boxed pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none" style="background-color:#FFFFFF; box-shadow:0px 0px 10px 0px rgba(0,0,0,0.05);">
                                    <div class="elementor-container elementor-column-gap-extended" style="max-width:1852px;">
                                        <!-- Sticky Logo column -->
                                        <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-20eecb0 pxl-column-none" style="padding:0 15px;" data-element_type="column">
                                            <div class="elementor-widget-wrap elementor-element-populated">
                                                <div class="elementor-element elementor-element-e9f5301 elementor-widget elementor-widget-pxl_logo">
                                                    <div class="elementor-widget-container">
                                                        <div class="pxl-logo">
                                                            <Link href="/"><img src="/assets/images/dck-logo-1.avif" alt="DCK Construction" style="max-height:41px;" /></Link>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Sticky Nav column -->
                                        <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-de87c60 pxl-column-none" data-element_type="column">
                                            <div class="elementor-widget-wrap elementor-element-populated" style="justify-content:flex-end;">
                                                <div class="elementor-element elementor-element-396e816 elementor-widget__width-auto elementor-widget elementor-widget-pxl_menu">
                                                    <div class="elementor-widget-container">
                                                        <div class="pxl-nav-menu pxl-nav-menu1 pxl-mega-full-width pxl-nav-horizontal fr-style-box show-effect-slideup sub-style-default">
                                                            <div class="menu-menu-main-home-container">
                                                                <ul class="pxl-menu-primary clearfix">
                                                                    <li v-for="item in navItems" :key="'sticky-' + item.label"
                                                                        :class="['menu-item', item.active ? 'current-menu-item' : '']">
                                                                        <AppLink :href="item.href"><span class="pxl-menu-item-text">{{ item.label }}</span></AppLink>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="pxl-divider-move"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        </section>
                    </div>
                </div>
            </div>

        <!-- ── Mobile header (shared) ── -->
        <div id="pxl-header-mobile" class="style-light">
            <div id="pxl-header-main" class="pxl-header-main">
                <div class="container">
                    <div class="row">
                        <div class="pxl-header-mobile-default">
                            <div class="pxl-header-branding">
                                <Link href="/"><img src="/assets/images/dck-logo-1.avif" alt="DCK Construction Ltd" /></Link>
                            </div>
                            <div id="pxl-nav-mobile">
                                <div class="pxl-nav-mobile-button pxl-anchor-divider pxl-cursor--cta">
                                    <span class="pxl-icon-line pxl-icon-line1"></span>
                                    <span class="pxl-icon-line pxl-icon-line2"></span>
                                    <span class="pxl-icon-line pxl-icon-line3"></span>
                                </div>
                            </div>
                        </div>
                        <div class="pxl-header-menu">
                            <div class="pxl-header-menu-scroll">
                                <div class="pxl-menu-close pxl-hide-xl pxl-close"></div>
                                <div class="pxl-logo-mobile pxl-hide-xl">
                                    <Link href="/"><img src="/assets/images/favicon/favicon-1.png" alt="DCK Construction Ltd" /></Link>
                                </div>
                                <div class="pxl-header-mobile-search pxl-hide-xl"></div>
                                <nav class="pxl-header-nav">
                                    <ul class="pxl-menu-primary clearfix">
                                        <li v-for="item in navItems" :key="'mobile-' + item.label"
                                            :class="['menu-item', item.active ? 'current-menu-item' : '']">
                                            <AppLink :href="item.href"><span class="pxl-menu-item-text">{{ item.label }}</span></AppLink>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="pxl-header-menu-backdrop"></div>
                    </div>
                </div>
            </div>
        </div>

    </header>
</template>

<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import AppLink from '@/Components/AppLink.vue';

const page = usePage();

const currentPath = computed(() => {
    const u = (page.url || '/').split('?')[0] || '/';
    if (u === '/' || u === '') return '/';
    return u.replace(/\/$/, '') || '/';
});

const isHomePage = computed(() => currentPath.value === '/');

function itemIsActive(item) {
    const p = currentPath.value;
    if (item.href === '/') return p === '/';
    if (item.href?.startsWith('/')) {
        return p === item.href || p.startsWith(item.href + '/');
    }
    return false;
}

const navItems = computed(() => {
    const base = [
        { label: 'Home', href: '/' },
        { label: 'About US', href: '/about' },
        { label: 'Services', href: '/services' },
        { label: 'Projects', href: '/projects' },
        { label: 'Contact Us', href: '/contact' },
        { label: 'Blog', href: '/blog' },
        { label: 'Current Jobs', href: '/jobs' },
    ];
    return base.map((item) => ({ ...item, active: itemIsActive(item) }));
});
</script>
