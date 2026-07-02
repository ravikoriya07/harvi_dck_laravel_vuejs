<template>
    <!-- Procurement Work Stages heading (cream background) -->
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-dc8c063 elementor-section-stretched elementor-section-full_width pxl-row-scroll-none pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none">
        <div class="elementor-container elementor-column-gap-extended">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-6d1874f pxl-column-overflow-hidden-yes pxl-column-none pxl-column-zoom-no"
                 data-element_type="column">
                <div class="elementor-widget-wrap elementor-element-populated">

                    <!-- Heading + description row -->
                    <section class="elementor-section elementor-inner-section elementor-element elementor-element-c210c2e elementor-section-full_width pxl-row-scroll-none pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none">
                        <div class="elementor-container elementor-column-gap-default">

                            <div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-33db4ab pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no"
                                 data-element_type="column">
                                <div class="elementor-widget-wrap elementor-element-populated">
                                    <div class="elementor-element elementor-element-4161331 elementor-widget elementor-widget-pxl_heading">
                                        <div class="elementor-widget-container">
                                            <div class="pxl-heading px-sub-title-default style-default-style">
                                                <div class="pxl-heading--inner">
                                                    <h3 class="pxl-item--title style-default highlight-default">
                                                        Procurement Work Stages
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-7cc0de9 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no"
                                 data-element_type="column">
                                <div class="elementor-widget-wrap elementor-element-populated">
                                    <div class="elementor-element elementor-element-d3fc072 elementor-widget elementor-widget-pxl_text_editor">
                                        <div class="elementor-widget-container">
                                            <div class="pxl-text-editor">
                                                <div class="pxl-item--inner">
                                                    <p>We follow clear principles and carefully manage every stage before moving a project into construction.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>

                    <!-- Pagination counter row -->
                    <section class="elementor-section elementor-inner-section elementor-element elementor-element-297316e elementor-section-full_width pxl-row-scroll-none pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none">
                        <div class="elementor-container elementor-column-gap-default">
                            <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-83d24b8 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no"
                                 data-element_type="column">
                                <div class="elementor-widget-wrap elementor-element-populated">
                                    <div class="elementor-element elementor-element-5dd681a elementor-widget__width-auto elementor-widget elementor-widget-pxl_pagination_carousel">
                                        <div class="elementor-widget-container">
                                            <div class="pxl-pagination-carousel"></div>
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

    <!-- Tab slider section (full height) -->
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-5009efb elementor-section-height-min-height elementor-section-items-stretch elementor-section-full_width elementor-section-stretched elementor-section-height-default pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none">
        <div class="elementor-container elementor-column-gap-no">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-5744277 pxl-column-overflow-hidden-yes pxl-column-none pxl-column-zoom-no"
                 data-element_type="column">
                <div class="elementor-widget-wrap elementor-element-populated">

                    <div class="elementor-element elementor-element-f2b4d29 elementor-widget elementor-widget-pxl_tabs_slip">
                        <div class="elementor-widget-container">
            <div class="pxl-tabs-slip pxl-tabs-slip1 style-2">
                <div class="pxl-tabs--content">
                                    <nav class="anchor-nav" role="navigation">
                                        <a href="#tab-item-0" class="anchor">1</a>
                                        <a href="#tab-item-1" class="anchor">2</a>
                                        <a href="#tab-item-2" class="anchor">3</a>
                                    </nav>

                                    <div v-for="(tab, i) in tabs" :key="i"
                                         :id="'tab-item-' + i"
                                         :class="'pxl-item--content pxl-item--content-' + (i + 1)">
                                        <!-- .elementor wrapper: activates scoped CSS for each template
                                             (elementor-10689/10728/10729) including pxl-column-bg-parallax image,
                                             right-column padding, typography sizes, etc. -->
                                        <div :class="['elementor', tab.elementorClass]">
                                        <section
                                            class="elementor-section elementor-top-section elementor-element elementor-element-b90c713 elementor-section-full_width pxl-section-overflow-hidden elementor-section-height-full elementor-section-items-stretch elementor-section-height-default pxl-row-scroll-none pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none">
                                            <div class="pxl-section-effect-images">
                                                <img decoding="async" data-parallax-value="" data-parallax="[]"
                                                     class="pxl-item--image elementor-repeater-item-4e2b0c1 slide-right-to-left pxl-hide-sr-md pxl-hide-sr-sm"
                                                     :src="tab.bgImage" alt="" />
                                            </div>
                                            <div class="elementor-container elementor-column-gap-no">
                                                <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-fe1041d pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no"
                                                     data-element_type="column">
                                                    <div class="elementor-widget-wrap elementor-element-populated">
                                                        <div class="pxl-column-bg-parallax"
                                                             data-parallax="[]"
                                                             :style="{
                                                                 backgroundImage: `url('${tab.image}')`,
                                                                 backgroundPosition: 'center center',
                                                                 backgroundSize: 'cover',
                                                             }"></div>
                                                        <div class="elementor-element elementor-widget elementor-widget-pxl_image elementor-hidden-desktop elementor-hidden-laptop elementor-hidden-tablet_extra elementor-hidden-tablet elementor-hidden-mobile_extra">
                                                            <div class="elementor-widget-container">
                                                                <div class="pxl-image-single df pxl-disable-parallax-sm pxl-hide-sr-lg">
                                                                    <div class="pxl-item--inner" data-wow-delay="120ms">
                                                                        <div class="pxl-item--image df">
                                                                            <img loading="lazy" decoding="async" :src="tab.image" class="no-lazyload attachment-full" alt="" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-d20be2b pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no pxl-border-column-anm"
                                                     data-element_type="column">
                                                    <div class="elementor-widget-wrap elementor-element-populated">
                                                        <div class="pxl-border-animated num-3">
                                                            <div class="pxl-border-anm bt w-100 bw-yes" style="--bd-width: 1px 0 0 0; border-style: solid; border-color: #11111126;"></div>
                                                            <div class="pxl-border-anm br h-100 bw-yes" style="--bd-width: 0 1px 0 0; border-style: solid; border-color: #11111126;"></div>
                                                            <div class="pxl-border-anm bb w-100 bw-yes" style="--bd-width: 0 0 1px 0; border-style: solid; border-color: #11111126;"></div>
                                                            <div class="pxl-border-anm bl h-100 bw-no" style="--bd-width: 0 0 0 0px; border-style: solid; border-color: #11111126;"></div>
                                                        </div>
                                                        <div class="elementor-element elementor-widget elementor-widget-pxl_heading">
                                                            <div class="elementor-widget-container">
                                                                <div class="pxl-heading px-sub-title-dot-2 style-default-style">
                                                                    <div class="pxl-heading--inner">
                                                                        <div class="pxl-item--subtitle px-sub-title-dot-2">
                                                                            <span class="pxl-item--subtext">Our Approach</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="elementor-element elementor-widget elementor-widget-pxl_heading">
                                                            <div class="elementor-widget-container">
                                                                <div class="pxl-heading px-sub-title-dot-2 style-default-style">
                                                                    <div class="pxl-heading--inner">
                                                                        <h3 class="pxl-item--title style-default highlight-default">
                                                                            {{ tab.title }}
                                                                        </h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="elementor-element elementor-widget elementor-widget-pxl_text_editor">
                                                            <div class="elementor-widget-container">
                                                                <div class="pxl-text-editor">
                                                                    <div class="pxl-item--inner">
                                                                        <p>{{ tab.desc }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="elementor-element elementor-widget elementor-widget-pxl_button">
                                                            <div class="elementor-widget-container">
                                                                <div class="pxl-button pxl-atc-link wow skewInRight" data-wow-delay="300ms">
                                                                    <AppLink href="/about" class="btn pxl-icon-active btn-default wow skewInRight inline pxl-icon--left" data-wow-delay="300ms">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Layer_1" x="0px" y="0px" viewBox="0 0 1230.3 556.2" style="enable-background:new 0 0 1230.3 556.2; width:37px;" xml:space="preserve">
                                                                            <g><polyline style="fill:none;stroke:#FFFFFF;stroke-width:55;stroke-miterlimit:10;" points="983.5,91.5 1165.3,279.2 983.5,464.7"/><line style="fill:none;stroke:#FFFFFF;stroke-width:55;stroke-miterlimit:10;" x1="1165.3" y1="279.2" x2="22.7" y2="279.2"/></g>
                                                                        </svg>
                                                                        <span class="pxl--btn-text" data-text="Learn More">Learn More</span>
                                                                    </AppLink>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        </div><!-- /.elementor -->
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

const tabs = [
    {
        elementorClass: 'elementor-10689',
        title: 'Reliable Delivery',
        desc: 'We take pride in delivering every project safely, on time and to the highest standard. With directly employed teams and a hands-on management approach, we maintain full control over quality, efficiency and client satisfaction.',
        image: '/assets/images/work4.avif',
        bgImage: '/assets/images/home1-appro1.avif',
    },
    {
        elementorClass: 'elementor-10728',
        title: 'Working with People',
        desc: 'Our experience in occupied properties has taught us the value of communication, care and respect. We work closely with residents, clients and partners to ensure every project runs smoothly with minimal disruption.',
        image: '/assets/images/work7.avif',
        bgImage: '/assets/images/home-1-01.avif',
    },
    {
        elementorClass: 'elementor-10729',
        title: 'Safety & Compliance First',
        desc: 'Health, safety and compliance are at the core of everything we do. From fire safety works to complex refurbishments, our processes meet the highest industry standards and regulatory requirements.',
        image: '/assets/images/work8.avif',
        bgImage: '/assets/images/home-3-s3-3.avif',
    },
];
</script>
