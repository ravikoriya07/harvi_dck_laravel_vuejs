<template>
    <!-- Three parallax staff photos shown as floating cards -->
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-d5a9a96 elementor-section-stretched elementor-section-boxed pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none"
        style="margin-top: -140px; margin-bottom: 0;">

        <div class="elementor-container elementor-column-gap-extended">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-1fbfd70 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no" data-element_type="column">
                <div class="elementor-widget-wrap elementor-element-populated">

                    <div v-for="img in images" :key="img.src"
                         :class="['elementor-element', img.elId, 'elementor-widget__width-auto', 'elementor-widget-laptop__width-initial', 'elementor-widget', 'elementor-widget-pxl_image']">
                        <div class="elementor-widget-container">
                            <div class="pxl-image-single df pxl-disable-parallax-sm pxl-parallax-scroll-over wow skewInBottom"
                                 :data-wow-delay="img.delay">
                                <div class="pxl-item--inner" data-wow-delay="120ms" data-parallax='{"y":80}'>
                                    <div class="pxl-item--image df" :data-wow-delay="img.delay">
                                        <img decoding="async"
                                             :src="img.src"
                                             :width="img.w"
                                             :height="img.h"
                                             class="no-lazyload attachment-full"
                                             alt="DCK team" />
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
const images = [
    { src: '/assets/images/About-us_13_11zon.avif',               w: 1066, h: 1600, delay: '200ms', elId: 'elementor-element-926d570' },
    { src: '/assets/images/STAFF-41-of-61-1-scaled_9_11zon.avif', w: 1596, h: 2560, delay: '400ms', elId: 'elementor-element-be6c009' },
    { src: '/assets/images/STAFF-59-of-61-scaled_8_11zon.avif',   w: 2560, h: 1707, delay: '600ms', elId: 'elementor-element-46a4bb7' },
];
</script>
