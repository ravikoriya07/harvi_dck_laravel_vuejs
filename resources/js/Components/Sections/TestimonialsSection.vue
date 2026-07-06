<template>
    <!-- Testimonials section -->
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-26226f7 elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl_parallax_bg_img_noise-none pxl-bg-color-none pxl-section-overlay-none">
        <div class="elementor-container elementor-column-gap-extended">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-16c41bb pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                <div class="elementor-widget-wrap elementor-element-populated">

                    <!-- Divider -->
                    <div class="elementor-element elementor-element-8f72f10 elementor-widget elementor-widget-pxl_divider">
                        <div class="elementor-widget-container">
                            <div class="pxl-divider horizontal animated normal">
                                <div class="pxl-divider-separator"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Heading -->
                    <div class="elementor-element elementor-element-d699a92 elementor-widget elementor-widget-pxl_heading">
                        <div class="elementor-widget-container">
                            <div class="pxl-heading px-sub-title-default style-default-style">
                                <div class="pxl-heading--inner">
                                    <h1 class="pxl-item--title pxl-split-text style-default highlight-default split-in-right">
                                        Testimonials
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonials carousel -->
                    <div class="elementor-element elementor-element-6f3f2a2 elementor-widget elementor-widget-pxl_testimonial_carousel">
                        <div class="elementor-widget-container">
                            <div class="pxl-swiper-slider pxl-testimonial-carousel pxl-testimonial-carousel3 df">
                                <div class="pxl-carousel-inner">
                                    <div class="pxl-swiper-container" dir="ltr"
                                         data-settings='{"slide_direction":"horizontal","slide_percolumn":1,"slide_mode":"slide","center_slide":"true","slides_to_show":1,"slides_to_show_xxl":1,"slides_to_show_lg":1,"slides_to_show_md":1,"slides_to_show_sm":1,"slides_to_show_xs":1,"slides_to_scroll":1,"arrow":true,"pagination":true,"pagination_type":"bullets","autoplay":true,"pause_on_hover":false,"pause_on_interaction":true,"delay":10000,"loop":true,"speed":500}'>
                                        <div class="pxl-swiper-wrapper">
                                            <div v-for="testimonial in testimonials" :key="testimonial.author" class="pxl-swiper-slide">
                                                <div class="pxl-item--inner">
                                                    <div class="pxl-item--desc">{{ testimonial.text }}</div>
                                                    <h3 class="pxl-item--title">{{ testimonial.author }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pxl-swiper-bottom pxl-flex-middle">
                                    <div class="pxl-swiper-dots style-1"></div>
                                    <div class="pxl-swiper-arrow-wrap style-1">
                                        <div class="pxl-swiper-arrow pxl-swiper-arrow-prev">
                                            <i class="fas fa-angle-left rtl-icon"></i>
                                        </div>
                                        <div class="pxl-swiper-arrow pxl-swiper-arrow-next">
                                            <i class="fas fa-angle-right rtl-icon"></i>
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

    <!-- Full-width interior image strip between testimonials and contact -->
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-f4fdb44 elementor-section-height-min-height elementor-section-stretched pxl-section-overflow-hidden pxl-bg-prx-effect-mask-parallax elementor-section-boxed elementor-section-height-default elementor-section-items-middle pxl-row-scroll-none pxl-zoom-point-false pxl-section-fix-none pxl_parallax_bg_img_noise-none pxl-bg-color-none pxl-section-overlay-none">
        <div class="mask-parallax">
            <div class="pxl-section-bg-parallax mask-parallax" data-parallax='{"y":-100}'></div>
        </div>
        <div class="elementor-container elementor-column-gap-default">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-73fbfcf pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                <div class="elementor-widget-wrap"></div>
            </div>
        </div>
    </section>
</template>

<script setup>
const testimonials = [
    {
        text: 'DCK Construction has provided exceptional support on our aids and adaptations programme, delivering high-quality accessibility improvements for our residents. Their team demonstrates great sensitivity when working in occupied homes, ensuring comfort, dignity and clear communication throughout. DCK\'s workmanship, reliability, and respectful approach make them a trusted partner for Harrow.',
        author: 'London Borough of Harrow',
    },
    {
        text: 'DCK Construction has consistently completed void refurbishments to a high standard, enabling us to re-let properties quickly and efficiently. Their proactive project management, quality finishes, and commitment to maintaining programme deadlines have been invaluable. DCK continues to be a dependable partner in supporting Southwark\'s housing objectives.',
        author: 'London Borough of Southwark',
    },
    {
        text: 'DCK Construction has shown exceptional performance across our voids programme, delivering quality refurbishments while maintaining strong communication with our teams. They work efficiently, safely and with clear attention to detail, helping us return homes to residents in excellent condition. DCK\'s professionalism and reliability make them a key contractor for Haringey Council.',
        author: 'London Borough of Haringey',
    },
    {
        text: 'DCK Construction has demonstrated strong expertise in delivering compliant fire safety works across Camden properties. Their team works to the highest safety standards, with thorough documentation, clear coordination and high-quality workmanship. DCK\'s commitment to resident safety, regulatory compliance and professional delivery makes them a trusted partner for Camden.',
        author: 'London Borough of Camden',
    },
];
</script>
