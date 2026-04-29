<template>
    <!-- Counter (left) + Heading (right) -->
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-e3e892f elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl_parallax_bg_img_noise-none pxl-bg-color-none pxl-section-overlay-none">
        <div class="elementor-container elementor-column-gap-extended">

            <!-- Left: animated counter "15+" -->
            <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-94fe381 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                <div class="elementor-widget-wrap elementor-element-populated">
                    <div class="elementor-element elementor-element-4d04d3b elementor-widget elementor-widget-pxl_counter">
                        <div class="elementor-widget-container">
                            <div class="pxl-counter pxl-counter1">
                                <div class="pxl-counter--inner">
                                    <div class="pxl-counter--holder">
                                        <div class="pxl-counter--number">
                                            <span class="pxl-counter--prefix el-empty"></span>
                                            <span class="pxl-counter--value effect-default ft-gt"
                                                  data-duration="2000"
                                                  data-startnumber="1"
                                                  data-endnumber="15"
                                                  data-to-value="15"
                                                  data-delimiter="">1</span>
                                            <span class="pxl-counter--suffix ft-gt">+</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: "Associations and Accreditations." heading -->
            <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-fbfa517 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                <div class="elementor-widget-wrap elementor-element-populated">
                    <div class="elementor-element elementor-element-0949ec9 elementor-widget__width-initial elementor-widget elementor-widget-pxl_heading">
                        <div class="elementor-widget-container">
                            <div class="pxl-heading px-sub-title-default style-default-style">
                                <div class="pxl-heading--inner">
                                    <h3 class="pxl-item--title pxl-split-text style-default highlight-default split-in-rotate">
                                        Associations and Accreditations.
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Divider + logos carousel -->
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-a068c03 elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl_parallax_bg_img_noise-none pxl-bg-color-none pxl-section-overlay-none">
        <div class="elementor-container elementor-column-gap-extended">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-8ea1b64 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                <div class="elementor-widget-wrap elementor-element-populated">

                    <div class="elementor-element elementor-element-640b1df elementor-widget elementor-widget-pxl_divider">
                        <div class="elementor-widget-container">
                            <div class="pxl-divider horizontal animated normal">
                                <div class="pxl-divider-separator"></div>
                            </div>
                        </div>
                    </div>

                    <div class="elementor-element elementor-element-3eb9aad elementor-widget__width-initial elementor-widget elementor-widget-pxl_client_carousel">
                        <div class="elementor-widget-container">
                            <div class="pxl-swiper-slider pxl-client-carousel pxl-client-carousel1 pxl-swiper-arrow-show style-2" data-arrow="">
                                <div class="pxl-carousel-inner">
                                    <div class="pxl-swiper-container" dir="ltr"
                                         data-settings='{"slide_direction":"horizontal","slide_percolumn":1,"slide_mode":"slide","slides_to_show":5,"slides_to_show_xxl":5,"slides_to_show_lg":4,"slides_to_show_md":3,"slides_to_show_sm":2,"slides_to_show_xs":2,"slides_to_scroll":1,"arrow":false,"pagination":false,"pagination_type":"fraction","autoplay":true,"pause_on_hover":false,"pause_on_interaction":true,"delay":2500,"loop":true,"speed":500}'>
                                        <div class="pxl-swiper-wrapper">
                                            <div v-for="cert in certifications" :key="cert.src" class="pxl-swiper-slide">
                                                <div class="pxl-item--inner wow fadeInRight">
                                                    <a>
                                                        <img loading="lazy" decoding="async"
                                                             :src="cert.src"
                                                             class="no-lazyload attachment-full"
                                                             :alt="cert.alt" />
                                                        <img loading="lazy" decoding="async"
                                                             :src="cert.src"
                                                             class="no-lazyload attachment-full"
                                                             :alt="cert.alt" />
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
const certifications = [
    { src: '/assets/images/thumbnail_45001-SSIP-e1758120151217_17_11zon.jpg',                     alt: 'SSIP 45001' },
    { src: '/assets/images/thumbnail_Cyber-Essentials-Plus-Logo-web-removebg-preview_6_11zon.jpg', alt: 'Cyber Essentials Plus' },
    { src: '/assets/images/thumbnail_Fensa_16_11zon.jpg',                                          alt: 'FENSA' },
    { src: '/assets/images/thumbnail_Forefront_UKAS_15_11zon.jpg',                                alt: 'Forefront UKAS' },
    { src: '/assets/images/thumbnail_Gold_RGB_5_11zon.jpg',                                        alt: 'Gold' },
    { src: '/assets/images/thumbnail_SSIP_Member_4_11zon.jpg',                                    alt: 'SSIP Member' },
    { src: '/assets/images/thumbnail_thermoguard-logo-removebg-preview_3_11zon.jpg',              alt: 'Thermoguard' },
    { src: '/assets/images/thumbnail_UKAS-Q-Mark-FDI-FDM-FSI-Colour-black-UKAS_14_11zon.jpg',    alt: 'UKAS Q Mark' },
    { src: '/assets/images/thumbnail_xElite-Badge.png.pagespeed.ic_.2BAm9hdid-.png',              alt: 'Elite Badge' },
    { src: '/assets/images/thumbnail_LW_logo_employer_rgb-removebg-preview_1_11zon.jpg',          alt: 'Living Wage Employer' },
];
</script>
