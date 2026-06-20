<template>
    <section
        id="service"
        class="elementor-section elementor-top-section elementor-element elementor-element-db31e97 elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl_parallax_bg_img_noise-none pxl-bg-color-none pxl-section-overlay-none"
        data-settings='{"stretch_section":"section-stretched"}'>
        <div class="elementor-container elementor-column-gap-extended">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-8b3a6c2 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                <div class="elementor-widget-wrap elementor-element-populated">
                    <div class="elementor-element elementor-element-382c0f2 elementor-widget elementor-widget-pxl_heading">
                        <div class="elementor-widget-container">
                            <div class="pxl-heading px-sub-title-default style-default-style">
                                <div class="pxl-heading--inner">
                                    <h1 class="pxl-item--title pxl-split-text style-default highlight-default split-lines-rotation-x">
                                        Our Services
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="elementor-element elementor-element-d51d63d post-layout-service-list-1 elementor-widget elementor-widget-pxl_post_list">
                        <div class="elementor-widget-container">
                            <div
                                class="pxl-grid pxl-service-list pxl-effect--3d none layout-service-list-1"
                                data-layout-mode="fitRows"
                                data-start-page="1"
                                data-max-pages="1"
                                :data-total="services.length"
                                :data-perpage="services.length"
                                data-next-link="">
                                <div class="pxl-grid-inner pxl-list-inner d-flex-wrap relative row" data-gutter="15">
                                    <div
                                        v-for="(service, index) in services"
                                        :key="service.title"
                                        class="pxl-grid-item col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"
                                        :style="{ zIndex: index + 1 }">
                                        <div class="pxl-post--inner" data-wow-duration="1.2s">
                                            <div class="pxl-holder-content">
                                                <span class="count-pos">{{ String(index + 1).padStart(2, '0') }}.</span>
                                                <div class="pxl-container">
                                                    <div class="pxl-container-left">
                                                        <h3 class="pxl-post--title">
                                                            <AppLink :href="service.href">{{ service.title }}</AppLink>
                                                        </h3>
                                                        <div class="pxl-post--content">{{ service.desc }}</div>
                                                    </div>
                                                    <ul class="multi-text">
                                                        <li class="box-multi">
                                                            <p>
                                                                <AppLink :href="service.href"></AppLink>
                                                            </p>
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 0 20 20" width="20">
                                                                <path d="m12 2-1.4 1.4 5.6 5.6h-16.2v2h16.2l-5.6 5.6 1.4 1.4 8-8z" fill="rgb(0,0,0)" />
                                                            </svg>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="pxl-post--featured">
                                                <img
                                                    loading="lazy"
                                                    decoding="async"
                                                    class="no-lazyload"
                                                    :src="service.image"
                                                    :alt="service.alt"
                                                />
                                                <AppLink :href="service.href"></AppLink>
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
import AppLink from '@/Components/AppLink.vue';

const services = [
    {
        title: 'Structural Works',
        href: '/services/architecture-services',
        desc: 'Structural Works Division delivers reliable, safe, and fully compliant structural solutions for residential, commercial, and public-sector projects.',
        image: '/assets/images/bg-3-795x653.avif',
        alt: 'construction silhouette',
    },
    {
        title: 'Disrepairs / Responsive',
        href: '/services/disrepair',
        desc: 'We provide a comprehensive Disrepair and Responsive Maintenance Service designed to resolve property issues quickly, efficiently, and to the highest standard.',
        image: '/assets/images/image-2-795x475.avif',
        alt: 'image-2',
    },
    {
        title: 'Loft / Extension',
        href: '/services/loft-extension',
        desc: 'We specialise in creating additional living space through expertly designed loft conversions and house extensions.',
        image: '/assets/images/image_1-768x653.avif',
        alt: 'image_1',
    },
    {
        title: 'Roofing Works',
        href: '/services/roofing',
        desc: 'We deliver specialist roofing works, including full roof replacements, structural repairs, and weatherproofing solutions.',
        image: '/assets/images/Gemini_Generated_Image_q882q7q882q7q882-e1762265925894-795x608.avif',
        alt: 'Roofing Works',
    },
    {
        title: 'Aids and Adaptations',
        href: '/services/adaptions',
        desc: 'We provide specialist mobility adaptations, including Level Access Showers, disabled access ramps, and lifting solutions.',
        image: '/assets/images/LAS18-795x653.avif',
        alt: 'LAS18',
    },
    {
        title: 'Fire Safety Works',
        href: '/services/fire-safety',
        desc: 'DCK delivers comprehensive fire safety solutions, including fire door installations, compartmentation works, and fire-stopping measures.',
        image: '/assets/images/JOB-17-of-155-scaled-795x653.avif',
        alt: 'Fire Safety Works',
    },
    {
        title: 'Refurbishment / General Build',
        href: '/services/general-build',
        desc: 'We have vast experience of delivering high-quality construction projects in several specialist sectors with strong client partnerships.',
        image: '/assets/images/image_5-4-795x653.avif',
        alt: 'Refurbishment / General Build',
    },
];
</script>
