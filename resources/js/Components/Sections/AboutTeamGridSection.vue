<template>
    <!-- Team grid: DCK staff members grouped by department -->
    <section
        class="elementor-section elementor-top-section elementor-element elementor-element-3b0a10c0 elementor-section-stretched elementor-section-boxed pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none"
        data-settings='{"stretch_section":"section-stretched"}'>
        <div class="elementor-container elementor-column-gap-extended">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-70730caf pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                <div class="elementor-widget-wrap elementor-element-populated">

                    <div class="elementor-element elementor-element-52953d08 elementor-widget-widescreen__width-initial elementor-widget elementor-widget-pxl_team_grid">
                        <div class="elementor-widget-container">
                            <div class="pxl-grid pxl-team-grid pxl-team-grid1 pxl-team-layout1 pxl-effect--3d style-1"
                                 data-layout="fitRows">
                                <div class="pxl-grid-filter normal style-1">
                                    <div class="pxl--filter-inner">
                                        <span class="filter-item active" data-filter="*">All</span>
                                    </div>
                                </div>

                                <div v-for="group in teamGroups" :key="group.name"
                                     class="pxl-team-department-group">
                                    <div class="pxl-team-department-heading">
                                        <div class="pxl-heading px-sub-title-default style-default-style">
                                            <div class="pxl-heading--inner">
                                                <h3 class="pxl-item--title style-default highlight-default">
                                                    {{ group.name }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pxl-grid-inner pxl-grid-masonry row" data-gutter="15">
                                        <div v-for="member in group.members" :key="member.name"
                                             class="pxl-grid-item col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                                            <div class="pxl-item--inner wow skewIn">
                                                <div class="pxl-effect--direction">
                                                    <div class="pxl-item--image">
                                                        <a>
                                                            <img decoding="async"
                                                                 :src="member.image"
                                                                 class="no-lazyload attachment-full"
                                                                 :alt="member.name" />
                                                        </a>
                                                    </div>
                                                    <div class="pxl-item--holder pxl-effect--content">
                                                        <div class="pxl-item--meta pxl-flex-grow">
                                                            <h3 class="pxl-item--title">
                                                                <a>{{ member.name }}</a>
                                                            </h3>
                                                            <div class="pxl-item--position">{{ member.position }}</div>
                                                            <div v-if="member.description" class="pxl-item--desc">{{ member.description }}</div>
                                                            <div v-else class="pxl-item--desc"></div>
                                                            <div class="pxl-item--social"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grid-sizer col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12"></div>
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
defineProps({
    teamGroups: {
        type: Array,
        default: () => [],
    },
});
</script>
