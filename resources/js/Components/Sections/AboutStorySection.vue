<template>
    <!-- Story: staff photo + two counters (left), text + "Our Services" button (right) -->
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-751b7a4a elementor-section-stretched elementor-section-boxed pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none"
        data-settings='{"stretch_section":"section-stretched"}'>
        <div class="elementor-container elementor-column-gap-extended">

            <!-- Left: staff photo + counters -->
            <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-34e107ac pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                <div class="elementor-widget-wrap elementor-element-populated">

                    <!-- Staff photo -->
                    <div class="elementor-element elementor-element-1aa439a3 elementor-widget elementor-widget-pxl_image">
                        <div class="elementor-widget-container">
                            <div class="pxl-image-single df pxl-disable-parallax-sm pxl-parallax-scroll-over"
                                 data-wow-delay="ms">
                                <div class="pxl-item--inner" data-wow-delay="120ms" data-parallax='{"y":80}'>
                                    <div class="pxl-item--image df" data-wow-delay="ms">
                                        <img decoding="async" width="1702" height="1993"
                                             src="/assets/images/STAFF-37-of-61-scaled-e1760215326296.avif"
                                             class="no-lazyload attachment-full"
                                             alt="DCK Staff" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Counter: Since 2008 -->
                    <div class="elementor-element elementor-element-77a9d98a elementor-widget__width-auto elementor-absolute elementor-widget elementor-widget-pxl_counter"
                         data-settings='{"_position":"absolute"}'>
                        <div class="elementor-widget-container">
                            <div class="pxl-counter pxl-counter5 wow rollIn default" data-wow-delay="200ms">
                                <div class="pxl-counter--inner">
                                    <div class="pxl-counter--holder">
                                        <div class="pxl-counter--title title-inline-w">Since</div>
                                        <div class="pxl-counter--number">
                                            <span class="pxl-counter--prefix el-empty"></span>
                                            <span class="pxl-counter--value effect-default"
                                                  data-duration="2000"
                                                  data-startnumber="1"
                                                  data-endnumber="2008"
                                                  data-to-value="2008"
                                                  data-delimiter="">1</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Counter: 17 Years of Experience -->
                    <div class="elementor-element elementor-element-537ec651 elementor-widget__width-auto elementor-absolute elementor-widget elementor-widget-pxl_counter"
                         data-settings='{"_position":"absolute"}'>
                        <div class="elementor-widget-container">
                            <div class="pxl-counter pxl-counter5 wow rollIn default" data-wow-delay="200ms">
                                <div class="pxl-counter--inner">
                                    <div class="pxl-counter--holder">
                                        <div class="pxl-counter--title title-inline-w">Years of Experience</div>
                                        <div class="pxl-counter--number">
                                            <span class="pxl-counter--prefix el-empty"></span>
                                            <span class="pxl-counter--value effect-default"
                                                  data-duration="2000"
                                                  data-startnumber="1"
                                                  data-endnumber="17"
                                                  data-to-value="17"
                                                  data-delimiter="">1</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right: text + button -->
            <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-47e3fb70 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                <div class="elementor-widget-wrap elementor-element-populated">

                    <!-- Description text -->
                    <div class="elementor-element elementor-element-59abc4fa elementor-widget elementor-widget-pxl_text_editor">
                        <div class="elementor-widget-container">
                            <div class="pxl-text-editor pxl-split-text split-lines-transform">
                                <div class="pxl-item--inner">
                                    <p>Established in 2008, we have vast experience of delivering high-quality construction projects in several specialist sectors. Key to our success is building strong client partnerships and our ability to work quickly, safely and efficiently in challenging environments, including working in social housing, schools, hospitals and other public buildings, whilst they are occupied and fully operational.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Our Services button -->
                    <div class="elementor-element elementor-element-66d5463f elementor-widget elementor-widget-pxl_button">
                        <div class="elementor-widget-container">
                            <div class="pxl-button pxl-atc-link wow skewIn">
                                <AppLink href="/services"
                                   class="btn pxl-icon-active btn-default wow skewIn inline pxl-icon--left">
                                    <span class="btn-icon-left">
                                        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" x="0px" y="0px"
                                             viewBox="0 0 1230.3 556.2"
                                             style="enable-background:new 0 0 1230.3 556.2;"
                                             xml:space="preserve">
                                            <g>
                                                <polyline style="fill:none;stroke:#FFFFFF;stroke-width:55;stroke-miterlimit:10;"
                                                          points="983.5,91.5 1165.3,279.2 983.5,464.7"></polyline>
                                                <line style="fill:none;stroke:#FFFFFF;stroke-width:55;stroke-miterlimit:10;"
                                                      x1="1165.3" y1="279.2" x2="22.7" y2="279.2"></line>
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="pxl--btn-text" data-text="Our Services">Our Services</span>
                                </AppLink>
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
</script>
