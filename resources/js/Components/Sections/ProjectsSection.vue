<template>
    <!-- Projects heading + divider -->
    <div ref="projectsRoot">
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-66518a7 elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl_parallax_bg_img_noise-none pxl-bg-color-none pxl-section-overlay-none">
        <div class="elementor-container elementor-column-gap-extended">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-444fd2f pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                <div class="elementor-widget-wrap elementor-element-populated">

                    <!-- Two-col: heading left, arrow right -->
                    <section
                        class="elementor-section elementor-inner-section elementor-element elementor-element-323e4a9 elementor-section-boxed elementor-section-height-default elementor-section-height-default pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl_parallax_bg_img_noise-none pxl-bg-color-none pxl-section-overlay-none"
                        id="projects">
                        <div class="elementor-container elementor-column-gap-no">

                            <!-- Left: heading + description -->
                            <div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-3246a09 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                                <div class="elementor-widget-wrap elementor-element-populated">
                                    <div class="elementor-element elementor-element-0c4d8f8 elementor-widget elementor-widget-pxl_heading">
                                        <div class="elementor-widget-container">
                                            <div class="pxl-heading px-sub-title-default style-default-style">
                                                <div class="pxl-heading--inner">
                                                    <h1 class="pxl-item--title pxl-split-text style-default highlight-default split-in-right">
                                                        Our Projects
                                                    </h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-7abf891 elementor-widget elementor-widget-pxl_text_editor">
                                        <div class="elementor-widget-container">
                                            <div class="pxl-text-editor pxl-split-text split-lines-transform">
                                                <div class="pxl-item--inner">
                                                    <p><strong>Our Projects Speak for Themselves</strong><br />From
                                                        single-property renovations to large-scale improvements,
                                                        our work reflects commitment, craftsmanship, and the promise to deliver
                                                        exactly what we say we will.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: arrow link -->
                            <div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-0bbfeb9 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                                <div class="elementor-widget-wrap elementor-element-populated">
                                    <div class="elementor-element elementor-element-f6f3f40 elementor-widget__width-auto elementor-invisible elementor-widget elementor-widget-pxl_icon"
                                         data-settings='{"_animation":"bounce"}'>
                                        <div class="elementor-widget-container">
                                            <div class="pxl-icon-list pxl-icon1 style-box-paralax">
                                                <AppLink class="elementor-repeater-item-3fce7e8" href="/projects">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" height="512" viewBox="0 0 24 24" width="512">
                                                        <path d="m16.0039 9.414-8.60699 8.607-1.414-1.414 8.60599-8.607h-7.58499v-2h10.99999v11h-2z" fill="rgb(0,0,0)"></path>
                                                    </svg>
                                                </AppLink>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>

                    <!-- Divider -->
                    <div class="elementor-element elementor-element-11b7342 elementor-widget elementor-widget-pxl_divider">
                        <div class="elementor-widget-container">
                            <div class="pxl-divider horizontal animated normal">
                                <div class="pxl-divider-separator"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio carousel -->
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-0b58c60 elementor-section-stretched elementor-section-boxed home-projects-carousel-section elementor-section-height-default elementor-section-height-default pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl_parallax_bg_img_noise-none pxl-bg-color-none pxl-section-overlay-none">
        <div class="elementor-container elementor-column-gap-no">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-55f6511 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                <div class="elementor-widget-wrap elementor-element-populated">

                    <div class="elementor-element elementor-element-48f5864 post-layout-portfolio-5 elementor-widget elementor-widget-pxl_post_carousel">
                        <div class="elementor-widget-container">
                            <div class="pxl-swiper-slider pxl-portfolio-carousel pxl-portfolio-carousel5 pxl-portfolio-style1">
                                <div class="pxl-carousel-inner">
                                    <div class="pxl-swiper-container" dir="ltr"
                                         data-settings='{"slide_direction":"horizontal","slide_percolumn":1,"slide_percolumnfill":1,"slide_mode":"slide","center_slide":false,"slides_to_show":2,"slides_to_show_xxl":2,"slides_to_show_lg":2,"slides_to_show_md":1,"slides_to_show_sm":1,"slides_to_show_xs":1,"slides_to_scroll":1,"slides_gutter":30,"arrow":true,"pagination":true,"pagination_type":"progressbar","autoplay":true,"pause_on_hover":true,"pause_on_interaction":true,"delay":5000,"loop":true,"speed":700,"center":false}'>
                                        <div class="pxl-swiper-wrapper">
                                            <div v-for="project in projects" :key="project.href" class="pxl-swiper-slide" data-filter="">
                                                <div class="pxl-post--inner">
                                                    <div class="pxl-post--holder">
                                                        <h5 class="pxl-post--title">
                                                            <AppLink :href="project.href">{{ project.title }}</AppLink>
                                                        </h5>
                                                        <div class="btn-readmore">
                                                            <AppLink class="btn btn-default" :href="project.href">
                                                                <span class="pxl--btn-text">Read More</span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 753.2 476.2" style="enable-background:new 0 0 753.2 476.2;" xml:space="preserve">
                                                                    <polygon points="622.6,107.5 601.4,128.7 695.8,223.1 277,223.1 277,253.1 695.8,253.1 601.4,347.5 622.6,368.7 753.2,238.1" />
                                                                    <rect y="223.1" width="283.9" height="30" />
                                                                </svg>
                                                            </AppLink>
                                                        </div>
                                                    </div>
                                                    <div class="pxl-post--featured">
                                                        <AppLink :href="project.href">
                                                            <img loading="lazy" decoding="async"
                                                                 :src="project.image"
                                                                 class="attachment-full"
                                                                 :alt="project.title" />
                                                        </AppLink>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Nav: aligned with carousel track (same container gutter) -->
        <div class="elementor-container elementor-column-gap-no">
            <div class="projects-carousel-nav">
                <div class="wrap-arrow">
                    <div class="pxl-swiper-arrow pxl-swiper-arrow-prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" viewBox="0 0 1230.3 556.2" aria-hidden="true">
                            <g><polyline style="fill:none;stroke:#000000;stroke-width:55;stroke-miterlimit:10;" points="983.5,91.5 1165.3,279.2 983.5,464.7"/><line style="fill:none;stroke:#000000;stroke-width:55;stroke-miterlimit:10;" x1="1165.3" y1="279.2" x2="22.7" y2="279.2"/></g>
                        </svg>
                    </div>
                    <div class="pxl-swiper-dots pxl-swiper-pagination-progressbar"></div>
                    <div class="pxl-swiper-arrow pxl-swiper-arrow-next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" viewBox="0 0 1230.3 556.2" aria-hidden="true">
                            <g><polyline style="fill:none;stroke:#000000;stroke-width:55;stroke-miterlimit:10;" points="983.5,91.5 1165.3,279.2 983.5,464.7"/><line style="fill:none;stroke:#000000;stroke-width:55;stroke-miterlimit:10;" x1="1165.3" y1="279.2" x2="22.7" y2="279.2"/></g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
</template>

<script setup>
import { nextTick, onMounted, useTemplateRef } from 'vue';
import AppLink from '@/Components/AppLink.vue';
import { reinitWidgetsInScope } from '@/composables/themeEffects';

const projectsRoot = useTemplateRef('projectsRoot');

defineProps({
    projects: {
        type: Array,
        default: () => [],
    },
});

function rebindProjectsCarouselNav(root) {
    const slider = root?.querySelector('.home-projects-carousel-section .pxl-swiper-container');

    if (! slider?.swiper) {
        return false;
    }

    const nav = root.querySelector('.home-projects-carousel-section .projects-carousel-nav');

    if (! nav) {
        return false;
    }

    const prev = nav.querySelector('.pxl-swiper-arrow-prev');
    const next = nav.querySelector('.pxl-swiper-arrow-next');
    const dots = nav.querySelector('.pxl-swiper-dots');
    const swiper = slider.swiper;

    if (prev && next) {
        swiper.params.navigation.prevEl = prev;
        swiper.params.navigation.nextEl = next;
        swiper.navigation.destroy();
        swiper.navigation.init();
        swiper.navigation.update();
    }

    if (dots) {
        swiper.params.pagination.el = dots;
        swiper.params.pagination.type = 'progressbar';

        if (swiper.pagination) {
            swiper.pagination.destroy();
        }

        swiper.pagination.init();
        swiper.pagination.render();
        swiper.pagination.update();
    }

    const settingsRaw = slider.getAttribute('data-settings');

    if (settingsRaw) {
        try {
            const settings = JSON.parse(settingsRaw);
            const gutter = Number(settings.slides_gutter);

            if (! Number.isNaN(gutter) && gutter >= 0) {
                swiper.params.spaceBetween = gutter;
                swiper.update();
            }
        } catch {
            // keep theme defaults
        }
    }

    return true;
}

function scheduleProjectsCarouselNavRebind(root) {
    const attempt = (triesLeft) => {
        if (rebindProjectsCarouselNav(root) || triesLeft <= 0) {
            return;
        }

        setTimeout(() => attempt(triesLeft - 1), 100);
    };

    attempt(15);
}

onMounted(() => {
    nextTick(() => {
        const bootstrap = () => {
            if (! projectsRoot.value) {
                return false;
            }

            const ready = reinitWidgetsInScope(projectsRoot.value);

            if (ready) {
                scheduleProjectsCarouselNavRebind(projectsRoot.value);
            }

            return ready;
        };

        if (bootstrap()) {
            return;
        }

        const retry = setInterval(() => {
            if (bootstrap()) {
                clearInterval(retry);
            }
        }, 200);

        setTimeout(() => clearInterval(retry), 8000);
    });
});
</script>
