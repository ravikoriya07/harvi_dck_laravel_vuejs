<template>
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-0ad4aba elementor-section-stretched elementor-section-boxed pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none">

        <div class="elementor-container elementor-column-gap-extended">
            <div class="elementor-column elementor-col-100 elementor-top-column pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no"
                 id="services">
                <div class="elementor-widget-wrap elementor-element-populated">

                    <!-- Subtitle label -->
                    <div class="elementor-element elementor-element-bef521a elementor-widget elementor-widget-pxl_heading">
                        <div class="elementor-widget-container">
                            <div class="pxl-heading px-sub-title-dot-4 style-default-style">
                                <div class="pxl-heading--inner">
                                    <div class="pxl-item--subtitle pxl-split-text px-sub-title-dot-4 split-lines-rotation-x">
                                        <span class="pxl-item--subtext">CONSTRUCTION &amp; REFURBISHMENT SERVICES</span>
                                    </div>
                                    <h3 class="pxl-item--title style-default highlight-default"></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="elementor-element elementor-element-399f058 elementor-widget elementor-widget-pxl_divider">
                        <div class="elementor-widget-container">
                            <div class="pxl-divider horizontal animated normal">
                                <div class="pxl-divider-separator"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Main heading -->
                    <div class="elementor-element elementor-element-563c96a elementor-widget elementor-widget-pxl_heading">
                        <div class="elementor-widget-container">
                            <div class="pxl-heading px-sub-title-default style-default-style">
                                <div class="pxl-heading--inner">
                                    <h3 class="pxl-item--title pxl-split-text style-default highlight-default split-lines-transform">
                                        Crafting Strong Foundations for the Future
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="elementor-element elementor-element-e4a9834 elementor-widget elementor-widget-pxl_text_editor">
                        <div class="elementor-widget-container">
                            <div class="pxl-text-editor pxl-split-text split-lines-transform">
                                <div class="pxl-item--inner">
                                    <p>At DCK, we offer a complete range of professional construction services, guiding your project from initial concept to final completion with precision and care.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- See more button (offset right on desktop) -->
                    <div class="elementor-element elementor-element-4b5466d elementor-widget elementor-widget-pxl_button">
                        <div class="elementor-widget-container">
                            <div class="pxl-button pxl-atc-link wow skewIn">
                                <AppLink href="/services"
                                   class="btn pxl-icon-active btn-default wow skewIn inline pxl-icon--left">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Layer_1" x="0px" y="0px" viewBox="0 0 1230.3 556.2" style="enable-background:new 0 0 1230.3 556.2; width:37px;" xml:space="preserve">
                                        <g>
                                            <polyline style="fill:none;stroke:#000000;stroke-width:55;stroke-miterlimit:10;" points="983.5,91.5 1165.3,279.2 983.5,464.7"></polyline>
                                            <line style="fill:none;stroke:#000000;stroke-width:55;stroke-miterlimit:10;" x1="1165.3" y1="279.2" x2="22.7" y2="279.2"></line>
                                        </g>
                                    </svg>
                                    <span class="pxl--btn-text" data-text="See More About Us">See More About Us</span>
                                </AppLink>
                            </div>
                        </div>
                    </div>

                    <!-- Services carousel -->
                    <div class="elementor-element post-layout-service-2 elementor-invisible elementor-widget elementor-widget-pxl_post_carousel"
                         data-settings='{"_animation":"fadeInUp"}'>
                        <div class="elementor-widget-container">
                            <div class="pxl-swiper-slider pxl-service-carousel pxl-service-carousel2 pxl-service-style1">
                                <div class="pxl-carousel-inner">
                                    <div class="pxl-swiper-container" dir="ltr"
                                         data-settings='{"slide_direction":"horizontal","slide_percolumn":1,"slide_mode":"slide","slides_to_show":3,"slides_to_show_xxl":3,"slides_to_show_lg":3,"slides_to_show_md":2,"slides_to_show_sm":1,"slides_to_show_xs":1,"slides_to_scroll":1,"slides_gutter":30,"arrow":true,"pagination":true,"pagination_type":"bullets","autoplay":true,"pause_on_hover":true,"pause_on_interaction":true,"delay":5000,"loop":true,"speed":700,"center":true}'>
                                        <div class="pxl-swiper-wrapper">
                                            <div v-for="service in services" :key="service.href" class="pxl-swiper-slide">
                                                <div class="pxl-post--inner">
                                                    <div class="pxl-post--featured">
                                                        <AppLink :href="service.href">
                                                            <img loading="lazy" decoding="async"
                                                                 :src="service.image"
                                                                 class="attachment-full"
                                                                 :alt="service.title" />
                                                        </AppLink>
                                                    </div>
                                                    <div class="wrap-content">
                                                        <h3 class="pxl-post--title">
                                                            <AppLink :href="service.href">{{ service.title }}</AppLink>
                                                        </h3>
                                                        <div class="pxl-post--content">{{ service.desc }}</div>
                                                        <div class="pxl-post--readmore">
                                                            <AppLink class="btn-readmore" :href="service.href">
                                                                <span>find out more</span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 753.2 476.2" style="enable-background:new 0 0 753.2 476.2;" xml:space="preserve">
                                                                    <polygon points="622.6,107.5 601.4,128.7 695.8,223.1 277,223.1 277,253.1 695.8,253.1 601.4,347.5 622.6,368.7 753.2,238.1" />
                                                                    <rect y="223.1" width="283.9" height="30" />
                                                                </svg>
                                                            </AppLink>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pxl-swiper-dots style-1"></div>
                                <div class="pxl-swiper-arrow-wrap style-1">
                                    <div class="pxl-swiper-arrow pxl-swiper-arrow-prev"></div>
                                    <div class="pxl-swiper-arrow pxl-swiper-arrow-next"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import AppLink from '@/Components/AppLink.vue';

defineProps({
    services: {
        type: Array,
        default: () => [],
    },
});
</script>
