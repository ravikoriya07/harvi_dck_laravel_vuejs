<template>
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-ac7f8dc elementor-section-stretched elementor-section-full_width elementor-section-height-default pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none"
        data-settings='{"stretch_section":"section-stretched","background_background":"classic"}'>

        <!-- Floating parallax wireframe image (desktop only) -->
        <div class="pxl-section-effect-images">
            <img decoding="async"
                data-parallax-value=""
                data-parallax='{"x":100}'
                class="pxl-item--image elementor-repeater-item-355d72f pxl-parallax-scroll pxl-hide-sr-md pxl-hide-sr-sm"
                src="/assets/images/home-1-01.webp"
                alt=""
                style="top:250px; right:110px;" />
        </div>

        <div class="elementor-container elementor-column-gap-extended">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-9b35fc2 pxl-column-none pxl-column-overflow-hidden-no">
                <div class="elementor-widget-wrap elementor-element-populated">

                    <!-- ── Heading block ── -->
                    <section class="elementor-section elementor-inner-section elementor-element elementor-element-68c70cb elementor-section-boxed pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none">
                        <div class="elementor-container elementor-column-gap-no">
                            <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-0213dde pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                                <div class="elementor-widget-wrap elementor-element-populated">

                                    <div class="elementor-element elementor-element-4cdf204 elementor-widget elementor-widget-pxl_heading">
                                        <div class="elementor-widget-container">
                                            <div class="pxl-heading px-sub-title-default style-default-style">
                                                <div class="pxl-heading--inner">
                                                    <h3 class="pxl-item--title pxl-split-text style-default highlight-default split-in-right">
                                                        Welcome to DCK
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="elementor-element elementor-element-03e0189 elementor-widget__width-auto elementor-widget elementor-widget-pxl_text_editor">
                                        <div class="elementor-widget-container">
                                            <div class="pxl-text-editor">
                                                <div class="pxl-item--inner">
                                                    <p>Established in 2008, DCK Construction is a trusted Tier 1 multi-trade building contractor with a strong reputation for quality and reliability.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- ── Building background image section ── -->
                    <section class="elementor-section elementor-inner-section elementor-element elementor-element-5844082 elementor-section-height-min-height pxl-section-overflow-hidden elementor-section-boxed pxl-row-scroll-none pxl-zoom-point-false pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none elementor-invisible"
                             data-settings='{"animation":"fadeInUp"}'>
                        <div class="elementor-container elementor-column-gap-no">
                            <!-- Column with background slideshow image -->
                            <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-e695b57 pxl-column-none pxl-column-overflow-hidden-no"
                                 data-settings='{"background_background":"slideshow"}'>
                                <div class="elementor-widget-wrap elementor-element-populated">
                                    <!-- Static replacement for Elementor background slideshow -->
                                    <div class="elementor-background-slideshow">
                                        <div class="elementor-background-slideshow__slide">
                                            <div class="elementor-background-slideshow__slide__image"
                                                 style="background-image: url('/assets/images/bg-2_H-e1760689052181_1_11zon.jpg'); background-size: cover; background-position: center center; position: absolute; top:0; left:0; width:100%; height:100%;"></div>
                                        </div>
                                    </div>
                                    <div class="elementor-background-overlay"></div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- ── Clients / Mission / Vision dark bar ── -->
                    <section class="elementor-section elementor-inner-section elementor-element elementor-element-e53b0ab elementor-section-full_width elementor-section-height-default pxl-row-scroll-none pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none">
                        <div class="elementor-container elementor-column-gap-no">
                            <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-9189f72 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                                <div class="elementor-widget-wrap elementor-element-populated">
                                    <div class="elementor-background-overlay"></div>

                                    <div class="elementor-element elementor-widget elementor-widget-pxl_text_carousel">
                                        <div class="elementor-widget-container">
                                            <div class="pxl-swiper-slider pxl-text-carousel pxl-text-carousel3">
                                                <div class="pxl-carousel-inner">
                                                    <div class="pxl-swiper-container" dir="ltr"
                                                         data-settings='{"slide_direction":"horizontal","slide_percolumn":1,"slide_mode":"slide","slides_to_show":3,"slides_to_show_xxl":3,"slides_to_show_lg":3,"slides_to_show_md":2,"slides_to_show_sm":2,"slides_to_show_xs":1,"slides_to_scroll":1,"arrow":false,"pagination":false,"autoplay":false,"loop":false,"speed":500}'>
                                                        <div class="pxl-swiper-wrapper">
                                                            <div v-for="card in carouselCards" :key="card.title" class="pxl-swiper-slide">
                                                                <div class="pxl-item--inner wow fadeInRight">
                                                                    <h3 class="pxl-item--title el-empty">{{ card.title }}</h3>
                                                                    <div class="pxl-item--desc el-empty">{{ card.desc }}</div>
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

                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
const carouselCards = [
    {
        title: 'Our clients',
        desc: 'Our clients are the driving force behind everything we do. We are committed to exceeding expectations and delivering premium-quality, distinctive spaces that reflect their vision and lifestyle.',
    },
    {
        title: 'Our mission',
        desc: 'Our mission is simple — to turn your ideas into reality. From concept to completion, we focus on understanding your needs, translating them into practical solutions, and building with precision and care.',
    },
    {
        title: 'Our vision',
        desc: 'We envision creating spaces that inspire, bring people together, and remain in perfect harmony with their surroundings — now and for generations to come.',
    },
];
</script>
