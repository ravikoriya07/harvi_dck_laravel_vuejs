<template>
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-7f0c737 elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl_parallax_bg_img_noise-none pxl-bg-color-none pxl-section-overlay-none">
        <div class="elementor-container elementor-column-gap-extended">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-5993be0 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                <div class="elementor-widget-wrap elementor-element-populated">

                    <!-- Heading -->
                    <div class="elementor-element elementor-element-a9ff6fe elementor-widget__width-initial elementor-widget elementor-widget-pxl_heading">
                        <div class="elementor-widget-container">
                            <div class="pxl-heading px-sub-title-default style-default-style">
                                <div class="pxl-heading--inner">
                                    <h1 class="pxl-item--title pxl-split-text style-default highlight-default split-in-rotate">
                                        Our Partners
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="elementor-element elementor-element-2e914ba elementor-widget elementor-widget-pxl_divider">
                        <div class="elementor-widget-container">
                            <div class="pxl-divider horizontal animated normal">
                                <div class="pxl-divider-separator"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Partners carousel -->
                    <div class="elementor-element elementor-element-84f8f1e elementor-widget__width-initial elementor-widget elementor-widget-pxl_client_carousel">
                        <div class="elementor-widget-container">
                            <div class="pxl-swiper-slider pxl-client-carousel pxl-client-carousel1 pxl-swiper-arrow-show style-2" data-arrow="">
                                <div class="pxl-carousel-inner">
                                    <div class="pxl-swiper-container" dir="ltr"
                                         data-settings='{"slide_direction":"horizontal","slide_percolumn":1,"slide_mode":"slide","slides_to_show":3,"slides_to_show_xxl":3,"slides_to_show_lg":3,"slides_to_show_md":3,"slides_to_show_sm":2,"slides_to_show_xs":1,"slides_to_scroll":1,"arrow":false,"pagination":false,"pagination_type":"bullets","autoplay":false,"pause_on_hover":false,"pause_on_interaction":true,"delay":3000,"loop":true,"speed":500}'>
                                        <div class="pxl-swiper-wrapper">
                                            <div v-for="partner in partners" :key="partner.src" class="pxl-swiper-slide">
                                                <div class="pxl-item--inner wow fadeInRight">
                                                    <a>
                                                        <img loading="lazy" decoding="async"
                                                             :src="partner.src"
                                                             class="no-lazyload attachment-full"
                                                             :alt="partner.alt" />
                                                        <img loading="lazy" decoding="async"
                                                             :src="partner.src"
                                                             class="no-lazyload attachment-full"
                                                             :alt="partner.alt" />
                                                    </a>
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
    </section>
</template>

<script setup>
const partners = [
    { src: '/assets/images/Paritet_logo-removebg-preview.avif',          alt: 'Paritet' },
    { src: '/assets/images/logo-transparent-png-scaled-e1760627393297.avif', alt: 'Partner' },
    { src: '/assets/images/Stypix.avif',                                  alt: 'Stypix' },
];
</script>
