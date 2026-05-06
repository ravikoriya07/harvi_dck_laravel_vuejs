<template>
    <Head :title="project.title + ' — Projects'" />
    <MainLayout>
        <div id="pxl-main-content" class="elementor pxl-project-detail">

            <!-- ── 1. TITLE + CATEGORIES ─────────────────────────────────────────── -->
            <section
                class="elementor-section elementor-top-section elementor-section-stretched elementor-section-boxed pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none pd-hero-section">
                <div class="elementor-container elementor-column-gap-no">

                    <!-- Left: project title (67%) -->
                    <div class="elementor-column elementor-top-column pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no pd-hero-left">
                        <div class="elementor-widget-wrap elementor-element-populated">
                            <div class="elementor-element elementor-widget elementor-widget-pxl_heading">
                                <div class="elementor-widget-container pd-title-wrap">
                                    <div class="pxl-heading px-sub-title-default style-default-style">
                                        <div class="pxl-heading--inner">
                                            <h6 class="pd-hero-title pxl-item--title pxl-split-text style-default highlight-default split-in-right">
                                                {{ project.title }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: categories (33%, bottom-aligned) -->
                    <div class="elementor-column elementor-top-column pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no pd-hero-right">
                        <div class="elementor-widget-wrap elementor-element-populated pd-cats-wrap">
                            <div class="elementor-element elementor-widget elementor-widget-pxl_post_categories">
                                <div class="elementor-widget-container">
                                    <ul class="pxl-portfolio-categories">
                                        <li v-for="cat in categories" :key="cat">{{ cat }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- ── 2. PROPERTIES BAR ─────────────────────────────────────────────── -->
            <section class="pd-props-section">
                <div class="pd-props-bar">
                    <div v-if="project.category" class="pd-prop-item">
                        <span class="pd-prop-label">Project Type</span>
                        <span class="pd-prop-value">{{ project.category }}</span>
                    </div>
                    <div v-if="project.value" class="pd-prop-item">
                        <span class="pd-prop-label">Value</span>
                        <span class="pd-prop-value">{{ project.value }}</span>
                    </div>
                    <div v-if="project.date" class="pd-prop-item">
                        <span class="pd-prop-label">Date</span>
                        <span class="pd-prop-value">{{ project.date }}</span>
                    </div>
                    <div v-if="project.status" class="pd-prop-item">
                        <span class="pd-prop-label">Status</span>
                        <span class="pd-prop-value">{{ project.status }}</span>
                    </div>
                    <div v-if="project.client" class="pd-prop-item pd-prop-client">
                        <span class="pd-prop-label">Client</span>
                        <span class="pd-prop-value">{{ project.client }}</span>
                    </div>
                </div>
            </section>

            <!-- ── 3. GALLERY CAROUSEL ───────────────────────────────────────────── -->
            <div v-if="galleryImages.length" class="pd-gallery-wrap" ref="galleryWrap">
                <div class="swiper pd-gallery-swiper">
                    <div class="swiper-wrapper">
                        <div v-for="(img, i) in galleryImages" :key="i" class="swiper-slide">
                            <figure class="pd-gallery-figure">
                                <img loading="lazy" decoding="async"
                                    :src="img"
                                    :alt="project.title"
                                    class="pd-gallery-img" />
                            </figure>
                        </div>
                    </div>
                    <!-- Arrows (inside the slide) -->
                    <div class="pd-gallery-btn pd-gallery-prev" ref="prevBtn">
                        <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 2 6.6 3.4l5.6 5.6H-4v2h16.2l-5.6 5.6L8 18l8-8z" fill="currentColor"
                                transform="rotate(180,10,10)" />
                        </svg>
                    </div>
                    <div class="pd-gallery-btn pd-gallery-next" ref="nextBtn">
                        <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2l-1.4 1.4 5.6 5.6H0v2h16.2l-5.6 5.6L12 18l8-8z" fill="currentColor" />
                        </svg>
                    </div>
                    <!-- Dots -->
                    <div class="pd-gallery-pagination" ref="paginationEl"></div>
                </div>
            </div>

            <!-- ── 4. SCOPE + DESCRIPTION ────────────────────────────────────────── -->
            <section
                class="elementor-section elementor-top-section elementor-section-full_width elementor-section-stretched pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none">
                <div class="elementor-container elementor-column-gap-no">
                    <div class="elementor-column elementor-col-100 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                        <div class="elementor-widget-wrap elementor-element-populated">

                            <!-- Top divider -->
                            <div class="elementor-element elementor-widget elementor-widget-pxl_divider">
                                <div class="elementor-widget-container">
                                    <div class="pxl-divider horizontal animated slow">
                                        <div class="pxl-divider-separator"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Scope label -->
                            <section v-if="project.scope"
                                class="elementor-section elementor-inner-section elementor-section-boxed pxl-row-scroll-none pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none">
                                <div class="elementor-container elementor-column-gap-extended">
                                    <div class="elementor-column elementor-col-100 elementor-inner-column pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-widget elementor-widget-pxl_heading">
                                                <div class="elementor-widget-container">
                                                    <div class="pxl-heading px-sub-title-default style-default-style">
                                                        <div class="pxl-heading--inner">
                                                            <h6 class="pxl-item--title pxl-split-text style-default highlight-default split-lines-rotation-x">
                                                                Scope
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Scope text -->
                            <section v-if="project.scope"
                                class="elementor-section elementor-inner-section elementor-section-boxed pxl-row-scroll-none pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none">
                                <div class="elementor-container elementor-column-gap-extended">
                                    <div class="elementor-column elementor-col-100 elementor-inner-column pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-widget elementor-widget-pxl_heading">
                                                <div class="elementor-widget-container">
                                                    <div class="pxl-heading px-sub-title-default style-default-style">
                                                        <div class="pxl-heading--inner">
                                                            <h3 class="pxl-item--title pxl-split-text style-default highlight-default split-lines-rotation-x">
                                                                {{ project.scope }}
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Divider -->
                            <div class="elementor-element elementor-widget elementor-widget-pxl_divider">
                                <div class="elementor-widget-container">
                                    <div class="pxl-divider horizontal animated reversal slow">
                                        <div class="pxl-divider-separator"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Project description (HTML) -->
                            <section v-if="project.description"
                                class="elementor-section elementor-inner-section elementor-section-boxed pxl-row-scroll-none pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none">
                                <div class="elementor-container elementor-column-gap-extended">
                                    <div class="elementor-column elementor-col-100 elementor-inner-column pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-widget elementor-widget-pxl_text_editor">
                                                <div class="elementor-widget-container">
                                                    <div class="pxl-text-editor pxl-split-text split-lines-transform">
                                                        <div class="pxl-item--inner">
                                                            <div class="scr_content fl-wrap" v-html="project.description"></div>
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

            <!-- ── 5. PREV / NEXT NAVIGATION ────────────────────────────────────── -->
            <section
                class="elementor-section elementor-top-section elementor-section-stretched elementor-section-boxed pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none pd-nav-section">
                <div class="elementor-container elementor-column-gap-extended">
                    <div class="elementor-column elementor-col-100 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                        <div class="elementor-widget-wrap elementor-element-populated">
                            <div class="elementor-element elementor-widget elementor-widget-pxl_post_navigation">
                                <div class="elementor-widget-container">
                                    <div class="pxl-post-navigation">

                                        <!-- Previous project -->
                                        <div class="pxl--item item--prev pxl-navigation-btn--wrap pxl-navigation--prev"
                                            :class="{ 'pxl--item--hidden': !prevProject }">
                                            <template v-if="prevProject">
                                                <AppLink class="pxl-icon-link pxl-arrow--prev" :href="prevProject.href">
                                                    <span class="pxl-item-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 20 20" height="512" viewBox="0 0 20 20" width="512">
                                                            <path d="m12 2-1.4 1.4 5.6 5.6h-16.2v2h16.2l-5.6 5.6 1.4 1.4 8-8z" fill="rgb(0,0,0)" />
                                                        </svg>
                                                    </span>
                                                    PREVIOUS PROJECT
                                                </AppLink>
                                                <div class="prev-post-title">
                                                    <h3>{{ prevProject.title }}</h3>
                                                </div>
                                            </template>
                                        </div>

                                        <!-- Grid icon -->
                                        <div class="pxl--item pxl--item-grid">
                                            <AppLink href="/projects">
                                                <span class="bl bl1"></span>
                                                <span class="bl bl2"></span>
                                                <span class="bl bl3"></span>
                                                <span class="bl bl4"></span>
                                            </AppLink>
                                        </div>

                                        <!-- Next project -->
                                        <div class="pxl--item item--next pxl-navigation-btn--wrap pxl-navigation--next"
                                            :class="{ 'pxl--item--hidden': !nextProject }">
                                            <template v-if="nextProject">
                                                <AppLink class="pxl-icon-link pxl-arrow--next" :href="nextProject.href">
                                                    NEXT PROJECT
                                                    <span class="pxl-item-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 20 20" height="512" viewBox="0 0 20 20" width="512">
                                                            <path d="m12 2-1.4 1.4 5.6 5.6h-16.2v2h16.2l-5.6 5.6 1.4 1.4 8-8z" fill="rgb(0,0,0)" />
                                                        </svg>
                                                    </span>
                                                </AppLink>
                                                <div class="next-post-title">
                                                    <h3>{{ nextProject.title }}</h3>
                                                </div>
                                            </template>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </MainLayout>
</template>

<script setup>
import { computed, ref, onMounted, onUnmounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import AppLink from '@/Components/AppLink.vue';

const props = defineProps({
    project:     { type: Object, required: true },
    prevProject: { type: Object, default: null },
    nextProject: { type: Object, default: null },
});

const categories = computed(() =>
    (props.project.category ?? '')
        .split(',')
        .map((c) => c.trim())
        .filter(Boolean)
);

const galleryImages = computed(() => props.project.gallery ?? []);

// ── Gallery Swiper ────────────────────────────────────────────────────────────
const galleryWrap = ref(null);
const prevBtn     = ref(null);
const nextBtn     = ref(null);
const paginationEl = ref(null);
let swiperInstance = null;

onMounted(() => {
    if (!galleryImages.value.length || !galleryWrap.value) return;
    if (typeof window.Swiper === 'undefined') return;

    const el = galleryWrap.value.querySelector('.pd-gallery-swiper');
    swiperInstance = new window.Swiper(el, {
        loop: galleryImages.value.length > 1,
        speed: 500,
        autoplay: galleryImages.value.length > 1
            ? { delay: 5000, disableOnInteraction: false, pauseOnMouseEnter: true }
            : false,
        navigation: {
            prevEl: prevBtn.value,
            nextEl: nextBtn.value,
        },
        pagination: {
            el: paginationEl.value,
            clickable: true,
            bulletClass: 'pd-dot',
            bulletActiveClass: 'pd-dot--active',
        },
    });
});

onUnmounted(() => {
    swiperInstance?.destroy(true, true);
    swiperInstance = null;
});
</script>

<style scoped>
/* ── Hero section ────────────────────────────────────────────────────────────── */
.pd-hero-section {
    padding-top: 120px !important;
    padding-bottom: 0 !important;
}

/* Left column 67% */
.pd-hero-left {
    width: 66.709% !important;
    max-width: 66.709% !important;
}

/* Right column 33%, categories aligned to bottom-right */
.pd-hero-right {
    width: 33.291% !important;
    max-width: 33.291% !important;
}

.pd-cats-wrap {
    justify-content: flex-end !important;
    align-content: flex-end !important;
    align-items: flex-end !important;
}

/* Title widget container left padding + max-width */
.pd-title-wrap {
    padding-left: 50px;
    padding-right: 30px;
}

/* Title typography — matches reference: 48px / weight 500 / tight leading */
.pd-hero-title {
    font-size: 48px !important;
    font-weight: 500 !important;
    line-height: 1em !important;
    letter-spacing: -0.9px !important;
    word-spacing: 2px !important;
    margin-bottom: 0 !important;
}

/* ── Properties bar ──────────────────────────────────────────────────────────── */
.pd-props-section {
    position: relative;
    left: 50%;
    width: 100vw;
    transform: translateX(-50%);
    margin-top: 50px;
    margin-bottom: 0;
}

.pd-props-bar {
    display: flex;
    flex-wrap: nowrap;
    align-items: flex-start;
    background-color: #F1F2EB;
    padding: 41px 110px 43px 110px;
    gap: 0;
}

.pd-prop-item {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    padding-right: 20px;
}

/* Client column gets more flex weight (mirrors original 40% vs 15% each) */
.pd-prop-client {
    flex: 2;
    padding-right: 0;
}

.pd-prop-label {
    display: block;
    font-size: 13px;
    font-weight: 400;
    text-transform: uppercase;
    letter-spacing: 1.3px;
    line-height: 30px;
}

.pd-prop-value {
    display: block;
    font-size: 20px;
    font-weight: 400;
    line-height: 30px;
    margin: 0;
}

/* ── Gallery carousel ────────────────────────────────────────────────────────── */
.pd-gallery-wrap {
    position: relative;
    left: 50%;
    width: 100vw;
    transform: translateX(-50%);
    overflow: hidden;
    line-height: 0;
}

.pd-gallery-figure {
    margin: 0;
    line-height: 0;
    display: block;
}

.pd-gallery-img {
    width: 100%;
    height: 600px;
    object-fit: cover;
    display: block;
}

/* Prev / Next arrow buttons */
.pd-gallery-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    width: 52px;
    height: 52px;
    background: rgba(255, 255, 255, 0.85);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.2s;
}

.pd-gallery-btn:hover {
    background: rgba(255, 255, 255, 1);
}

.pd-gallery-btn svg {
    width: 18px;
    height: 18px;
    color: #111;
}

.pd-gallery-prev {
    left: 20px;
}

.pd-gallery-next {
    right: 20px;
}

/* Dots pagination */
.pd-gallery-pagination {
    position: absolute;
    bottom: 16px;
    left: 0;
    right: 0;
    z-index: 10;
    display: flex;
    justify-content: center;
    gap: 8px;
}

/* Bullet styles (scoped deep via :deep for dynamically inserted elements) */
:deep(.pd-dot) {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    cursor: pointer;
    transition: background 0.2s;
    display: inline-block;
}

:deep(.pd-dot--active) {
    background: #fff;
}

/* ── Navigation section ──────────────────────────────────────────────────────── */
.pd-nav-section {
    padding-top: 29px;
    padding-bottom: 60px;
}

.pxl--item--hidden {
    visibility: hidden;
}

/* ── Responsive ──────────────────────────────────────────────────────────────── */
@media (max-width: 1366px) {
    .pd-props-bar {
        padding: 40px 15px;
    }
}

@media (max-width: 1024px) {
    .pd-hero-section {
        padding-top: 50px !important;
    }

    .pd-props-section {
        margin-top: 30px;
    }

    .pd-gallery-img {
        height: 480px;
    }
}

@media (max-width: 880px) {
    .pd-hero-title {
        font-size: 38px !important;
    }
}

@media (max-width: 767px) {
    .pd-hero-left,
    .pd-hero-right {
        width: 100% !important;
        max-width: 100% !important;
    }

    .pd-hero-title {
        font-size: 34px !important;
    }

    .pd-title-wrap {
        padding-left: 0;
        padding-right: 0;
    }

    .pd-cats-wrap {
        justify-content: flex-start !important;
        align-items: flex-start !important;
        align-content: flex-start !important;
        margin-top: -10px !important;
    }

    .pd-props-bar {
        flex-wrap: wrap;
        gap: 20px 0;
    }

    .pd-prop-item {
        flex: 0 0 33.333%;
        padding-right: 12px;
    }

    .pd-prop-client {
        flex: 0 0 33.333%;
    }

    .pd-gallery-img {
        height: 320px;
    }

    .pd-gallery-btn {
        width: 40px;
        height: 40px;
    }
}

@media (max-width: 575px) {
    .pd-hero-section {
        padding-top: 30px !important;
    }

    .pd-hero-title {
        font-size: 28px !important;
    }

    .pd-props-bar {
        padding: 20px;
        gap: 16px 0;
    }

    .pd-prop-item {
        flex: 0 0 50%;
        padding-right: 10px;
    }

    .pd-prop-client {
        flex: 0 0 50%;
    }

    .pd-gallery-img {
        height: 240px;
    }
}
</style>
