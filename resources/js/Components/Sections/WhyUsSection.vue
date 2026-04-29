<template>
    <!-- Dark background "Why Us" section -->
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-c862404 elementor-section-stretched pxl-section-overflow-hidden elementor-section-boxed pxl-row-scroll-none pxl-zoom-point-false pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none">

        <!-- Decorative parallax vector image -->
        <div class="pxl-section-effect-images">
            <img decoding="async"
                 data-parallax-value=""
                 data-parallax='{"x":80}'
                 class="pxl-item--image elementor-repeater-item-fce42b0 pxl-parallax-scroll pxl-hide-sr-md pxl-hide-sr-sm"
                 src="/assets/images/home1-vector.webp"
                 alt="" />
        </div>

        <div class="elementor-container elementor-column-gap-extended">

            <!-- Left: main text -->
            <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-fd33f0f pxl-column-none pxl-column-zoom-no pxl-border-column-anm"
                 data-element_type="column">
                <div class="elementor-widget-wrap elementor-element-populated">
                    <div class="pxl-border-animated num-1">
                        <div class="pxl-border-anm br h-100 bw-yes" style="--bd-width: 0 1px 0 0; border-style:solid; border-color:#FFFFFF26;"></div>
                    </div>

                    <div class="elementor-element elementor-widget elementor-widget-pxl_text_editor">
                        <div class="elementor-widget-container">
                            <div class="pxl-text-editor pxl-split-text split-lines-transform">
                                <div class="pxl-item--inner">
                                    <p>We may be a small team, but we deliver big results.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="elementor-element elementor-widget elementor-widget-pxl_text_editor">
                        <div class="elementor-widget-container">
                            <div class="pxl-text-editor pxl-split-text split-lines-transform">
                                <div class="pxl-item--inner">
                                    <p>Our focus is on building strong, lasting relationships by providing a full range of reliable, high-quality construction services.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: feature list + counters -->
            <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-02c251c pxl-column-none pxl-column-zoom-no"
                 data-element_type="column">
                <div class="elementor-widget-wrap elementor-element-populated">

                    <!-- Feature list -->
                    <div class="elementor-element elementor-element-e57fae9 elementor-widget elementor-widget-pxl_list">
                        <div class="elementor-widget-container">
                            <div class="pxl-list pxl-list1 style-dot type-vertical">
                                <div v-for="feature in features" :key="feature" class="pxl--item">
                                    <div class="pxl-item-content">
                                        <label class="pxl-empty"></label>
                                        {{ feature }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats counters -->
                    <section class="elementor-section elementor-inner-section elementor-element elementor-element-417f310 elementor-section-boxed pxl-row-scroll-none pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-border-section-anm">
                        <div class="pxl-border-animated num-1">
                            <div class="pxl-border-anm bt w-100" style="border-width:1px 0 0 0; border-style:solid; border-color:#FFFFFF26;"></div>
                        </div>
                        <div class="elementor-container elementor-column-gap-no">
                            <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-9e6a806 pxl-column-none pxl-column-zoom-no"
                                 data-element_type="column">
                                <div class="elementor-widget-wrap elementor-element-populated">

                                    <!-- 17 years -->
                                    <div class="elementor-element elementor-element-d5c065c elementor-widget__width-initial elementor-widget-mobile_extra__width-inherit elementor-widget-widescreen__width-initial elementor-widget elementor-widget-pxl_counter">
                                        <div class="elementor-widget-container">
                                            <div class="pxl-counter pxl-counter2">
                                                <div class="pxl-counter--inner">
                                                    <div class="pxl-counter--holder">
                                                        <div class="pxl-counter--number">
                                                            <span class="pxl-counter--prefix ft-gt el-empty"></span>
                                                            <span class="pxl-counter--value effect-default ft-gt"
                                                                  data-duration="2000"
                                                                  data-startnumber="1"
                                                                  data-endnumber="17"
                                                                  data-to-value="17"
                                                                  data-delimiter="">1</span>
                                                        </div>
                                                        <div class="pxl-counter--title title-inline-w">Years on the market</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 100+ customers -->
                                    <div class="elementor-element elementor-element-c5d9749 elementor-widget__width-initial elementor-widget-mobile_extra__width-inherit elementor-widget-widescreen__width-initial elementor-widget elementor-widget-pxl_counter">
                                        <div class="elementor-widget-container">
                                            <div class="pxl-counter pxl-counter2">
                                                <div class="pxl-counter--inner">
                                                    <div class="pxl-counter--holder">
                                                        <div class="pxl-counter--number">
                                                            <span class="pxl-counter--prefix ft-gt el-empty"></span>
                                                            <span class="pxl-counter--value effect-default ft-gt"
                                                                  data-duration="2000"
                                                                  data-startnumber="1"
                                                                  data-endnumber="100"
                                                                  data-to-value="100"
                                                                  data-delimiter=".">1</span>
                                                            <span class="pxl-counter--suffix ft-gt">+</span>
                                                        </div>
                                                        <div class="pxl-counter--title title-inline-w">customers work and are satisfied</div>
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
const features = [
    'On Time, Every Time — streamlined planning, design, and build process for timely delivery',
    'Trusted Experts — our skilled tradespeople are among the best in the industry',
    'Always Available — we\'re ready to support your project 24/7',
    'Modern Tools — equipped with the latest technology, software, and resources',
    'Proven Experience — over 10 years of serving communities and building with care',
];
</script>
