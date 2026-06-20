<template>
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-795d9e8 elementor-section-stretched elementor-section-full_width elementor-section-height-default pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl_parallax_bg_img_noise-none pxl-full-content-with-space-none pxl-bg-color-none pxl-section-overlay-none">
        <div class="elementor-container elementor-column-gap-no">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-9009579 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no"
                 data-settings='{"background_background":"classic"}'>
                <div class="elementor-widget-wrap elementor-element-populated">
                    <div class="elementor-background-overlay"></div>

                    <!-- Heading -->
                    <div class="elementor-element elementor-element-baf74d1 elementor-widget elementor-widget-pxl_heading">
                        <div class="elementor-widget-container">
                            <div class="pxl-heading px-sub-title-default style-default-style">
                                <div class="pxl-heading--inner">
                                    <h1 class="pxl-item--title pxl-split-text style-default highlight-default split-in-right">
                                        DCK Construction
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Staff photo -->
                    <div class="elementor-element elementor-element-3d7cd7b elementor-widget elementor-widget-pxl_image">
                        <div class="elementor-widget-container">
                            <div class="pxl-image-single df pxl-disable-parallax-sm pxl-hide-sr-lg">
                                <div class="pxl-item--inner" data-wow-delay="120ms">
                                    <div class="pxl-item--image df">
                                        <img loading="lazy" decoding="async"
                                             width="2350" height="1003"
                                             src="/assets/images/STAFF-52-of-61-scaled-e1750700599226_11_11zon.avif"
                                             class="no-lazyload attachment-full"
                                             alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Team members row 1 -->
                    <section
                        class="elementor-section elementor-inner-section elementor-element elementor-element-4be14c5 elementor-section-boxed elementor-section-height-default elementor-section-height-default pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl_parallax_bg_img_noise-none pxl-bg-color-none pxl-section-overlay-none elementor-invisible"
                        data-settings='{"animation":"fadeInUp"}'>
                        <div class="elementor-container elementor-column-gap-no">
                            <div v-for="member in teamRow1" :key="member.colId"
                                 :class="'elementor-column elementor-col-20 elementor-inner-column elementor-element elementor-element-' + member.colId + ' pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no'">
                                <div class="elementor-widget-wrap elementor-element-populated">
                                    <div :class="'elementor-element elementor-element-' + member.linkId + ' elementor-widget elementor-widget-pxl_link'">
                                        <div class="elementor-widget-container">
                                            <div class="pxl-link-wrap">
                                                <h3 class="pxl-widget-title pxl-empty"></h3>
                                                <ul class="pxl-link pxl-link-l1 style-line-text type-vertical">
                                                    <li class="pxl-item--link">
                                                        <a><span class="text">{{ member.name }}</span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div :class="'elementor-element elementor-element-' + member.headingId + ' elementor-widget elementor-widget-pxl_heading'">
                                        <div class="elementor-widget-container">
                                            <div class="pxl-heading px-sub-title-default style-default-style">
                                                <div class="pxl-heading--inner">
                                                    <h3 class="pxl-item--title style-default highlight-default">{{ member.role }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Team members row 2 -->
                    <section
                        class="elementor-section elementor-inner-section elementor-element elementor-element-3132db9 elementor-section-boxed elementor-section-height-default elementor-section-height-default pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl_parallax_bg_img_noise-none pxl-bg-color-none pxl-section-overlay-none elementor-invisible"
                        data-settings='{"animation":"fadeInUp"}'>
                        <div class="elementor-container elementor-column-gap-no">
                            <div v-for="member in teamRow2" :key="member.colId"
                                 :class="'elementor-column elementor-col-20 elementor-inner-column elementor-element elementor-element-' + member.colId + ' pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no'">
                                <div class="elementor-widget-wrap elementor-element-populated">
                                    <div :class="'elementor-element elementor-element-' + member.linkId + ' elementor-widget elementor-widget-pxl_link'">
                                        <div class="elementor-widget-container">
                                            <div class="pxl-link-wrap">
                                                <h3 class="pxl-widget-title pxl-empty"></h3>
                                                <ul class="pxl-link pxl-link-l1 style-line-text type-vertical">
                                                    <li class="pxl-item--link">
                                                        <a><span class="text">{{ member.name }}</span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div :class="'elementor-element elementor-element-' + member.headingId + ' elementor-widget elementor-widget-pxl_heading'">
                                        <div class="elementor-widget-container">
                                            <div class="pxl-heading px-sub-title-default style-default-style">
                                                <div class="pxl-heading--inner">
                                                    <h3 class="pxl-item--title style-default highlight-default">{{ member.role }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Team members row 3 -->
                    <section
                        class="elementor-section elementor-inner-section elementor-element elementor-element-f191afb elementor-section-boxed elementor-section-height-default elementor-section-height-default pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl_parallax_bg_img_noise-none pxl-bg-color-none pxl-section-overlay-none elementor-invisible"
                        data-settings='{"animation":"fadeInUp"}'>
                        <div class="elementor-container elementor-column-gap-no">
                            <div v-for="member in teamRow3" :key="member.colId"
                                 :class="'elementor-column elementor-col-20 elementor-inner-column elementor-element elementor-element-' + member.colId + ' pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no'">
                                <div class="elementor-widget-wrap elementor-element-populated">
                                    <div :class="'elementor-element elementor-element-' + member.linkId + ' elementor-widget elementor-widget-pxl_link'">
                                        <div class="elementor-widget-container">
                                            <div class="pxl-link-wrap">
                                                <h3 class="pxl-widget-title pxl-empty"></h3>
                                                <ul class="pxl-link pxl-link-l1 style-line-text type-vertical">
                                                    <li class="pxl-item--link">
                                                        <a><span class="text">{{ member.name }}</span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div :class="'elementor-element elementor-element-' + member.headingId + ' elementor-widget elementor-widget-pxl_heading'">
                                        <div class="elementor-widget-container">
                                            <div class="pxl-heading px-sub-title-default style-default-style">
                                                <div class="pxl-heading--inner">
                                                    <h3 class="pxl-item--title style-default highlight-default">{{ member.role }}</h3>
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
const teamRow1 = [
    { colId: '5ddafbe', linkId: '3aae69a', headingId: '5aa4e8c', name: 'Rustam Isayev',      role: 'CEO DCK Construction' },
    { colId: '3038470', linkId: '3de333b', headingId: '4dde8d9', name: 'Iurii Sama',          role: 'Division Manager' },
    { colId: 'daefa21', linkId: '7ae855e', headingId: '79680f1', name: 'Tom Sessions',         role: 'Managing Quantity Surveyor' },
    { colId: '9614eb0', linkId: '2ff753a', headingId: '0409df2', name: 'Iurii Torchynovich',  role: 'Senior Quantity Surveyor' },
    { colId: '35a5332', linkId: 'b3bce4b', headingId: 'abe5f14', name: 'Ruslan Bizans',        role: 'Senior Site Manager' },
];

const teamRow2 = [
    { colId: 'd984925', linkId: '9a23a7c', headingId: '50dab77', name: 'Mr Anvarjon Umarov', role: 'Contracts Manager' },
    { colId: 'e4dbf4d', linkId: '4b01730', headingId: 'b6829c0', name: 'Oleksandr Morozov',  role: 'Project Manager' },
    { colId: 'f388354', linkId: '6440256', headingId: '8b13439', name: 'Omar Khalid',          role: 'Social Value Manager' },
    { colId: '78f1b20', linkId: '1e1e10b', headingId: 'f06c120', name: 'Natalia Sama',         role: 'Office Administrator' },
    { colId: '541099b', linkId: 'a37a750', headingId: '84e2884', name: 'Janis Bizans',          role: 'Site Manager' },
];

const teamRow3 = [
    { colId: '81c2d0a', linkId: '5fa7565', headingId: '6d39fd6', name: 'Artem Ivliiev',    role: 'Resident Liaison Officer' },
    { colId: '872b936', linkId: '368115b', headingId: '7215d18', name: 'Josh Newman',        role: 'Site Manager' },
    { colId: 'f59b476', linkId: 'd01fd4a', headingId: 'c0f195c', name: 'Matthew Anam',      role: 'Assistant Quantity Surveyor' },
    { colId: '27dce66', linkId: '3dafe9b', headingId: '2782427', name: 'Dmytro Biienko',    role: 'Quantity Surveyor' },
    { colId: '186f705', linkId: '0f3d065', headingId: '8b594d3', name: 'Vladimir Bozianu',  role: 'Site Manager' },
];
</script>
