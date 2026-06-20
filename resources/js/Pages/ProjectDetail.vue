<template>
    <Head :title="project.title + ' — Projects'" />
    <MainLayout>
        <!-- Mirrors static HTML: #pxl-main > .container.pd-project-shell > … > article.pxl-portfolio-single -->
        <div class="container pd-project-shell">
            <div class="row">
                <div id="pxl-content-area" class="col-12">
                    <main id="pxl-content-main">
                        <article class="pxl-portfolio-single">
                            <div id="pxl-main-content" class="elementor pxl-project-detail">

            <!-- ── 1. TITLE + CATEGORIES ─────────────────────────────────────────── -->
            <section
                class="elementor-section elementor-top-section elementor-section-boxed pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none pd-hero-section">
                <div class="elementor-container elementor-column-gap-no">

                    <!-- Left: project title (66.709%) -->
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

                    <!-- Right: categories (33.291%, bottom-aligned) -->
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
                <div class="pd-props-max">
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
                </div>
            </section>

            <!-- ── 3. GALLERY CAROUSEL ───────────────────────────────────────────── -->
            <div v-if="galleryImages.length" class="pd-gallery-max">
            <div class="pd-gallery-wrap" ref="galleryWrap">
                <div class="swiper pd-gallery-swiper">
                    <div class="swiper-wrapper">
                        <div v-for="(img, index) in galleryImages" :key="img" class="swiper-slide">
                            <figure class="pd-gallery-figure">
                                <img
                                    :loading="index === 0 ? 'eager' : 'lazy'"
                                    :fetchpriority="index === 0 ? 'high' : 'auto'"
                                    decoding="async"
                                    :src="img"
                                    :alt="project.title"
                                    class="pd-gallery-img" />
                            </figure>
                        </div>
                    </div>
                    <!-- Arrows -->
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
                    <!-- Pagination dots -->
                    <div class="pd-gallery-pagination" ref="paginationEl"></div>
                </div>
            </div>
            </div>

            <!-- ── 4. SCOPE + DESCRIPTION ────────────────────────────────────────── -->
            <!--
              Scope/description omit theme `.pxl-split-text` / GSAP SplitText — those classes set
              autoAlpha:0 until ScrollTrigger fires; Vue-mounted DOM often misses the initial refresh,
              so content stays hidden until resize. Plain markup stays visible on first paint.
            -->
            <section
                class="elementor-section elementor-top-section elementor-section-boxed pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none pd-content-section pd-body-section">
                <div class="elementor-container elementor-column-gap-no">
                    <div class="elementor-column elementor-col-100 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                        <div class="elementor-widget-wrap elementor-element-populated">

                            <div v-if="project.scope" class="pd-scope-block">
                                <h2 class="pd-scope-heading">Scope</h2>
                                <div class="pd-scope-rule" aria-hidden="true" />
                                <p class="pd-scope-summary">{{ project.scope }}</p>
                                <div class="pd-scope-rule" aria-hidden="true" />
                            </div>

                            <!-- Project description -->
                            <section v-if="project.description"
                                class="elementor-section elementor-inner-section elementor-section-boxed pxl-row-scroll-none pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none pd-inner-section pd-desc-section">
                                <div class="elementor-container elementor-column-gap-extended">
                                    <div class="elementor-column elementor-col-100 elementor-inner-column pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-widget elementor-widget-pxl_text_editor">
                                                <div class="elementor-widget-container">
                                                    <div class="pxl-text-editor pd-description-editor">
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
                class="elementor-section elementor-top-section elementor-section-boxed pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none pd-nav-section">
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
                        </article>
                    </main>
                </div>
            </div>
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
const galleryWrap   = ref(null);
const prevBtn       = ref(null);
const nextBtn       = ref(null);
const paginationEl  = ref(null);
let swiperInstance  = null;

onMounted(() => {
    if (!galleryImages.value.length || !galleryWrap.value) return;
    if (typeof window.Swiper === 'undefined') return;

    const el = galleryWrap.value.querySelector('.pd-gallery-swiper');
    const count = galleryImages.value.length;
    swiperInstance = new window.Swiper(el, {
        // Loop requires at least slidesPerView+1 clones on each side; use ≥6 as safe threshold.
        loop: count >= 6,
        speed: 500,
        slidesPerView: 3,
        spaceBetween: 0,
        breakpoints: {
            0:    { slidesPerView: 1 },
            576:  { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        },
        autoplay: count > 1
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
    padding-top: 76px !important;
    padding-bottom: 0 !important;
}

/* Outer shell width comes from `grid.css` + `#pxl-main > .container.pd-project-shell`
   in projects-elementor-generated.css — do not force hero rail wider here. */

/* Left column 66.709% */
.pd-hero-left {
    width: 66.709% !important;
    max-width: 66.709% !important;
}

/* Right column 33.291% — categories aligned to bottom-right */
.pd-hero-right {
    width: 33.291% !important;
    max-width: 33.291% !important;
}

.pd-cats-wrap {
    justify-content: flex-end !important;
    align-content: flex-end !important;
    align-items: flex-end !important;
}

/* Align hero content with meta/gallery rail (global `.pd-hero-left` offset removed for boxed layout) */
.pd-hero-left > .elementor-element-populated {
    margin-left: 0 !important;
}

.pd-title-wrap {
    padding: 0 24px 0 0;
}

/* Category tag — reference: small caps, tracked, muted */
.pxl-portfolio-categories {
    list-style: none;
    margin: 0;
    padding: 0;
}

.pxl-portfolio-categories li {
    font-size: 13px;
    font-weight: 400;
    text-transform: uppercase;
    letter-spacing: 0.14em;
    color: #9c9c9c;
    line-height: 1.4;
}

/* Title typography — matches reference: ~48px / weight 500 */
.pd-hero-title {
    font-size: 48px !important;
    font-weight: 500 !important;
    line-height: 1em !important;
    letter-spacing: -0.9px !important;
    word-spacing: 2px !important;
    margin-bottom: 0 !important;
}

/* ── Properties bar (boxed — width from `.pd-props-max` in theme CSS) ─────────── */
.pd-props-section {
    width: 100%;
    margin-top: 50px;
    margin-bottom: 0;
    box-sizing: border-box;
}

.pd-props-bar {
    display: flex;
    flex-wrap: nowrap;
    align-items: flex-start;
    background-color: #f1f2eb;
    padding: 41px clamp(24px, 6vw, 110px) 43px;
    gap: 0;
}

/* Items 1-4: 15% each */
.pd-prop-item {
    flex: 0 0 15%;
    width: 15%;
    min-width: 0;
    display: flex;
    flex-direction: column;
    padding-right: 2px;
}

/* Client: 40% with left indent matching reference (margin-left: 60px on inner widget) */
.pd-prop-client {
    flex: 0 0 40%;
    width: 40%;
    padding-right: 0;
    padding-left: 60px;
}

.pd-prop-label {
    display: block;
    font-size: 13px;
    font-weight: 400;
    text-transform: uppercase;
    letter-spacing: 1.3px;
    line-height: 30px;
    color: #7a7a7a;
}

.pd-prop-value {
    display: block;
    font-size: 20px;
    font-weight: 400;
    line-height: 30px;
    margin: 0;
    color: #111;
}

/* ── Gallery carousel (inside `.pd-gallery-max` rail) ──────────────────────── */
.pd-gallery-max {
    width: 100%;
    margin-top: 0;
}

.pd-gallery-wrap {
    position: relative;
    width: 100%;
    max-width: 100%;
    margin-left: auto;
    margin-right: auto;
    overflow: hidden;
    line-height: 0;
    box-sizing: border-box;
}

.pd-gallery-figure {
    margin: 0;
    line-height: 0;
    display: block;
}

/* Square images — natural aspect ratio, no fixed height */
.pd-gallery-img {
    width: 100%;
    aspect-ratio: 1;
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

/* ── Content section (scope + description) ───────────────────────────────────── */
.pd-content-section {
    padding-top: 80px;
}

.pd-inner-section {
    margin-top: 0;
}

/* Scope — static markup (reference: large title → rule → uppercase summary → rule) */
.pd-scope-block {
    width: 100%;
    margin: 0;
    padding: 0;
    text-align: left;
}

.pd-scope-heading {
    margin: 0 0 18px;
    padding: 0;
    font-size: clamp(2rem, 4vw, 3.125rem);
    font-weight: 700;
    line-height: 1.12;
    letter-spacing: -0.02em;
    color: #111;
}

.pd-scope-rule {
    display: block;
    width: 100%;
    height: 1px;
    margin: 0;
    background: #d8d8d8;
}

.pd-scope-summary {
    margin: 22px 0;
    padding: 0;
    font-size: clamp(0.875rem, 1.35vw, 1.0625rem);
    font-weight: 600;
    line-height: 1.5;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #111;
}

/* Description block below scope */
.pd-desc-section {
    margin-top: 40px;
    margin-bottom: 0;
}

:deep(.scr_content h3),
:deep(.scr_content h2) {
    font-size: 1.28rem;
    font-weight: 700;
    color: #111;
    margin: 0 0 16px;
    line-height: 1.35;
}

/* Description text line-height */
:deep(.scr_content p),
:deep(.scr_content) {
    line-height: 26px;
    color: #333;
}

/* ── Navigation section ──────────────────────────────────────────────────────── */
.pd-nav-section {
    padding-top: 29px;
    padding-bottom: 101px;
}

.pxl--item--hidden {
    visibility: hidden;
}

/* ── Responsive ──────────────────────────────────────────────────────────────── */
@media (max-width: 1366px) {
    .pd-props-bar {
        padding-top: 40px;
        padding-bottom: 40px;
    }
}

@media (max-width: 1024px) {
    .pd-hero-section {
        padding-top: 50px !important;
    }

    .pd-hero-title {
        font-size: 48px !important;
    }

    .pd-props-section {
        margin-top: 30px;
    }

    .pd-prop-item {
        flex: 0 0 33.333%;
        width: 33.333%;
        margin-bottom: 15px;
    }

    .pd-prop-client {
        flex: 0 0 33.333%;
        width: 33.333%;
        padding-left: 0;
    }

    .pd-props-bar {
        flex-wrap: wrap;
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

    .pd-prop-item,
    .pd-prop-client {
        flex: 0 0 50%;
        width: 50%;
        padding-left: 0;
        padding-right: 10px;
    }

    .pd-gallery-btn {
        width: 40px;
        height: 40px;
    }

    .pd-content-section {
        padding-top: 56px;
    }

    .pd-scope-heading {
        margin-bottom: 14px;
    }

    .pd-scope-summary {
        margin: 18px 0;
        letter-spacing: 0.06em;
    }

    .pd-desc-section {
        margin-top: 32px;
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

    .pd-prop-item,
    .pd-prop-client {
        flex: 0 0 100%;
        width: 100%;
    }
}
</style>
