<template>
    <!-- Parallax image strip above clients -->
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-c4ae1c0 elementor-section-height-min-height elementor-section-stretched pxl-section-overflow-hidden pxl-bg-prx-effect-mask-parallax elementor-section-boxed elementor-section-height-default elementor-section-items-middle pxl-row-scroll-none pxl-zoom-point-false pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none">
        <div class="mask-parallax">
            <div class="pxl-section-bg-parallax mask-parallax" data-parallax='{"y":-100}'></div>
        </div>
        <div class="elementor-container elementor-column-gap-default">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-45f2a47 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no"
                 data-element_type="column">
                <div class="elementor-widget-wrap"></div>
            </div>
        </div>
    </section>

    <!-- "Our Clients" heading -->
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-9c81158 elementor-section-stretched elementor-section-boxed elementor-section-height-default pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none">
        <div class="elementor-container elementor-column-gap-extended">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-4321aaf pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no"
                 data-element_type="column">
                <div class="elementor-widget-wrap elementor-element-populated">
                    <div class="elementor-element elementor-element-a4733f1 elementor-widget__width-initial elementor-widget elementor-widget-pxl_heading">
                        <div class="elementor-widget-container">
                            <div class="pxl-heading px-sub-title-default style-default-style">
                                <div class="pxl-heading--inner">
                                    <h1 class="pxl-item--title pxl-split-text style-default highlight-default split-in-rotate">
                                        Our Clients
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Divider + client logos carousel -->
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-ae16f2c elementor-section-stretched elementor-section-boxed elementor-section-height-default pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none">
        <div class="elementor-container elementor-column-gap-extended">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-e1e1b88 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no"
                 data-element_type="column">
                <div class="elementor-widget-wrap elementor-element-populated">

                    <div class="elementor-element elementor-element-c098f11 elementor-widget elementor-widget-pxl_divider">
                        <div class="elementor-widget-container">
                            <div class="pxl-divider horizontal animated normal">
                                <div class="pxl-divider-separator"></div>
                            </div>
                        </div>
                    </div>

                    <div class="elementor-element elementor-element-09c6945 elementor-widget__width-initial elementor-widget elementor-widget-pxl_client_carousel">
                        <div class="elementor-widget-container">
                            <div class="pxl-swiper-slider pxl-client-carousel pxl-client-carousel1 pxl-swiper-arrow-show style-2" data-arrow="">
                                <div class="pxl-carousel-inner">
                                    <div class="pxl-swiper-container" dir="ltr"
                                         data-settings='{"slide_direction":"horizontal","slide_percolumn":1,"slide_mode":"slide","slides_to_show":5,"slides_to_show_xxl":5,"slides_to_show_lg":4,"slides_to_show_md":3,"slides_to_show_sm":2,"slides_to_show_xs":2,"slides_to_scroll":1,"arrow":false,"pagination":false,"pagination_type":"bullets","autoplay":true,"pause_on_hover":false,"pause_on_interaction":true,"delay":2000,"loop":true,"speed":1000}'>
                                        <div class="pxl-swiper-wrapper">
                                            <div v-for="client in clients" :key="client.normal" class="pxl-swiper-slide">
                                                <div class="pxl-item--inner wow fadeInRight">
                                                    <a>
                                                        <img loading="lazy" decoding="async"
                                                             :src="client.color"
                                                             class="no-lazyload attachment-full"
                                                             alt="" />
                                                        <img loading="lazy" decoding="async"
                                                             :src="client.normal"
                                                             class="no-lazyload attachment-full"
                                                             alt="" />
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
const clients = [
    {
        color:  '/assets/images/R-scaled-e1757582678238.avif',
        normal: '/assets/images/1-01833329_22_11zon.avif',
    },
    {
        color:  '/assets/images/hounslowsquare-e1757586426401_21_11zon-removebg-preview.avif',
        normal: '/assets/images/hounslowsquare-e1757586426401_21_11zon-1.avif',
    },
    {
        color:  '/assets/images/southwark_council_logo_thumb_080525-removebg-preview-e1757586556672.avif',
        normal: '/assets/images/southwark_council_logo_thumb_080525-removebg-preview-e1757586556672_20_11zon.avif',
    },
    {
        color:  '/assets/images/o_1172-removebg-preview-e1757586310795.avif',
        normal: '/assets/images/o_1172-removebg-preview-e1757586310795_19_11zon.avif',
    },
    {
        color:  '/assets/images/EQUANS_logotype_RGG-e1757587263463.avif',
        normal: '/assets/images/EQUANS_logotype_RGG-e1757587263463_18_11zon.avif',
    },
    {
        color:  '/assets/images/image-removebg-preview-e1757587302187.avif',
        normal: '/assets/images/image-removebg-preview-e1757587302187_17_11zon.avif',
    },
    {
        color:  '/assets/images/image-removebg-preview.avif',
        normal: '/assets/images/image-removebg-preview_16_11zon.avif',
    },
    {
        color:  '/assets/images/image-removebg-preview-1.avif',
        normal: '/assets/images/image-removebg-preview-1_15_11zon.avif',
    },
];
</script>
