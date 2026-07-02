<template>
    <!-- Partners: "Our Partners" heading + bordered logo grid (reference layout) -->
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-5a68fd6b elementor-section-stretched elementor-section-boxed pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none"
        data-settings='{"stretch_section":"section-stretched"}'>
        <div class="elementor-container elementor-column-gap-extended">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-7a90725b pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                <div class="elementor-widget-wrap elementor-element-populated">

                    <div class="elementor-element elementor-element-746c73cf elementor-widget elementor-widget-pxl_heading">
                        <div class="elementor-widget-container">
                            <div class="pxl-heading px-sub-title-default style-default-style">
                                <div class="pxl-heading--inner">
                                    <h3 class="pxl-item--title pxl-split-text style-default highlight-default split-in-right">
                                        Our Partners
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="elementor-element elementor-element-5ddc7d3f elementor-widget elementor-widget-pxl_client_carousel">
                        <div class="elementor-widget-container">
                            <div class="pxl-client-carousel1 style-1 about-partners-grid">
                                <div class="about-partners-grid__row">
                                    <div
                                        v-for="(partner, index) in partners"
                                        :key="partner.name"
                                        class="about-partners-grid__cell"
                                        :class="{ 'is-first': index === 0 }">
                                        <div class="pxl-item--inner">
                                            <AppLink :href="partner.href || '#'">
                                                <img
                                                    loading="lazy"
                                                    decoding="async"
                                                    :src="partner.imageBw"
                                                    class="no-lazyload attachment-full"
                                                    :alt="partner.name" />
                                                <img
                                                    loading="lazy"
                                                    decoding="async"
                                                    :src="partner.imageColor"
                                                    class="no-lazyload attachment-full"
                                                    :alt="partner.name" />
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
    </section>
</template>

<script setup>
import AppLink from '@/Components/AppLink.vue';

const partners = [
    {
        name: 'Paritet',
        href: 'https://paritet.uk/',
        imageBw: '/assets/images/Paritet_logo-removebg-preview-1.avif',
        imageColor: '/assets/images/Paritet_logo-removebg-preview.avif',
    },
    {
        name: 'Hazfix',
        href: '#',
        imageBw: '/assets/images/logo-transparent-png-1-scaled.avif',
        imageColor: '/assets/images/logo-transparent-png-scaled-e1760627393297.avif',
    },
    {
        name: 'Stypix',
        href: '#',
        imageBw: '/assets/images/Stypix_bw.avif',
        imageColor: '/assets/images/Stypix.avif',
    },
];
</script>
