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
                                        :key="service.href"
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

defineProps({
    services: {
        type: Array,
        default: () => [],
    },
});
</script>
