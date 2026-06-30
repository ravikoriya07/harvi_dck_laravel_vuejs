<template>
    <Head :title="socialValue.title + ' — Social Values'" />
    <MainLayout>
        <!-- Mirrors static HTML: #pxl-main > .container.pd-project-shell > … > article.pxl-portfolio-single -->
        <div class="container pd-project-shell">
            <div class="row">
                <div id="pxl-content-area" class="col-12">
                    <main id="pxl-content-main">
                        <article class="pxl-portfolio-single">
                            <div id="pxl-main-content" class="elementor pxl-social-value-detail">

            <!-- ── 1. HERO ───────────────────────────────────────────────────────── -->
            <section class="pd-hero-section">
                <div class="pd-hero-inner">
                    <AppLink href="/social-values" class="pd-back-link">← All Social Values</AppLink>

                    <ul v-if="categories.length" class="pd-category-list" aria-label="Social value categories">
                        <li v-for="cat in categories" :key="cat" class="pd-category-pill">{{ cat }}</li>
                    </ul>

                    <h1 class="pd-hero-title">{{ socialValue.title }}</h1>
                </div>
            </section>

            <!-- ── 2. META ───────────────────────────────────────────────────────── -->
            <section v-if="hasMetaFields" class="pd-meta-section">
                <div class="pd-meta-card">
                    <dl class="pd-meta-grid">
                        <div v-if="socialValue.category" class="pd-meta-item">
                            <dt class="pd-meta-label">Type</dt>
                            <dd class="pd-meta-value">{{ socialValue.category }}</dd>
                        </div>
                        <div v-if="socialValue.value" class="pd-meta-item">
                            <dt class="pd-meta-label">Value</dt>
                            <dd class="pd-meta-value">{{ socialValue.value }}</dd>
                        </div>
                        <div v-if="socialValue.date" class="pd-meta-item">
                            <dt class="pd-meta-label">Date</dt>
                            <dd class="pd-meta-value">{{ socialValue.date }}</dd>
                        </div>
                        <div v-if="socialValue.status" class="pd-meta-item">
                            <dt class="pd-meta-label">Status</dt>
                            <dd class="pd-meta-value">{{ socialValue.status }}</dd>
                        </div>
                        <div v-if="socialValue.client" class="pd-meta-item">
                            <dt class="pd-meta-label">Client</dt>
                            <dd class="pd-meta-value">{{ socialValue.client }}</dd>
                        </div>
                    </dl>
                </div>
            </section>

            <!-- ── 3. GALLERY CAROUSEL ───────────────────────────────────────────── -->
            <div v-if="galleryImages.length" class="pd-gallery-max pd-gallery-section">
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
                                    :alt="socialValue.title"
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

                            <div v-if="socialValue.scope" class="pd-scope-block">
                                <h2 class="pd-scope-heading">Scope</h2>
                                <div class="pd-scope-rule" aria-hidden="true" />
                                <p class="pd-scope-summary">{{ socialValue.scope }}</p>
                                <div class="pd-scope-rule" aria-hidden="true" />
                            </div>

                            <!-- Project description -->
                            <section v-if="socialValue.description"
                                class="elementor-section elementor-inner-section elementor-section-boxed pxl-row-scroll-none pxl-section-overflow-visible pxl-section-fix-none pxl-bg-color-none pxl-section-overlay-none pd-inner-section pd-desc-section">
                                <div class="elementor-container elementor-column-gap-extended">
                                    <div class="elementor-column elementor-col-100 elementor-inner-column pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-widget elementor-widget-pxl_text_editor">
                                                <div class="elementor-widget-container">
                                                    <div class="pxl-text-editor pd-description-editor">
                                                        <div class="pxl-item--inner">
                                                            <div class="scr_content fl-wrap" v-html="socialValue.description"></div>
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

                                        <!-- Previous -->
                                        <div class="pxl--item item--prev pxl-navigation-btn--wrap pxl-navigation--prev"
                                            :class="{ 'pxl--item--hidden': !prevSocialValue }">
                                            <template v-if="prevSocialValue">
                                                <AppLink class="pxl-icon-link pxl-arrow--prev" :href="prevSocialValue.href">
                                                    <span class="pxl-item-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 20 20" height="512" viewBox="0 0 20 20" width="512">
                                                            <path d="m12 2-1.4 1.4 5.6 5.6h-16.2v2h16.2l-5.6 5.6 1.4 1.4 8-8z" fill="rgb(0,0,0)" />
                                                        </svg>
                                                    </span>
                                                    PREVIOUS
                                                </AppLink>
                                                <div class="prev-post-title">
                                                    <h3>{{ prevSocialValue.title }}</h3>
                                                </div>
                                            </template>
                                        </div>

                                        <!-- Grid icon -->
                                        <div class="pxl--item pxl--item-grid">
                                            <AppLink href="/social-values">
                                                <span class="bl bl1"></span>
                                                <span class="bl bl2"></span>
                                                <span class="bl bl3"></span>
                                                <span class="bl bl4"></span>
                                            </AppLink>
                                        </div>

                                        <!-- Next -->
                                        <div class="pxl--item item--next pxl-navigation-btn--wrap pxl-navigation--next"
                                            :class="{ 'pxl--item--hidden': !nextSocialValue }">
                                            <template v-if="nextSocialValue">
                                                <AppLink class="pxl-icon-link pxl-arrow--next" :href="nextSocialValue.href">
                                                    NEXT
                                                    <span class="pxl-item-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 20 20" height="512" viewBox="0 0 20 20" width="512">
                                                            <path d="m12 2-1.4 1.4 5.6 5.6h-16.2v2h16.2l-5.6 5.6 1.4 1.4 8-8z" fill="rgb(0,0,0)" />
                                                        </svg>
                                                    </span>
                                                </AppLink>
                                                <div class="next-post-title">
                                                    <h3>{{ nextSocialValue.title }}</h3>
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
    socialValue:     { type: Object, required: true },
    prevSocialValue: { type: Object, default: null },
    nextSocialValue: { type: Object, default: null },
});

const categories = computed(() =>
    (props.socialValue.category ?? '')
        .split(',')
        .map((c) => c.trim())
        .filter(Boolean)
);

const galleryImages = computed(() => props.socialValue.gallery ?? []);

const hasMetaFields = computed(() =>
    Boolean(
        props.socialValue.category ||
        props.socialValue.value ||
        props.socialValue.date ||
        props.socialValue.status ||
        props.socialValue.client,
    ),
);

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
/* ── Layout rail (matches projects-elementor-generated.css) ───────────────── */
.pd-hero-inner,
.pd-meta-section,
.pd-gallery-section {
    max-width: var(--pd-meta-gallery-max, 1600px);
    width: 100%;
    margin-left: auto;
    margin-right: auto;
}

/* ── Hero ───────────────────────────────────────────────────────────────────── */
.pd-hero-section {
    padding-top: clamp(40px, 6vw, 72px);
    padding-bottom: 0;
}

.pd-hero-inner {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 16px;
}

.pd-back-link {
    font-size: 14px;
    font-weight: 500;
    color: #3e68ff;
    text-decoration: none;
    letter-spacing: 0.02em;
    transition: opacity 0.2s;
}

.pd-back-link:hover {
    opacity: 0.75;
}

.pd-category-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.pd-category-pill {
    display: inline-block;
    padding: 8px 16px;
    border: 1px solid #d0d0cb;
    border-radius: 19.5px;
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #111;
    line-height: 1.2;
    background: #fff;
}

.pd-hero-title {
    margin: 0;
    max-width: 22em;
    font-size: clamp(1.75rem, 4.5vw, 3rem);
    font-weight: 500;
    line-height: 1.12;
    letter-spacing: -0.02em;
    color: #111;
}

/* ── Meta card ─────────────────────────────────────────────────────────────── */
.pd-meta-section {
    margin-top: clamp(24px, 4vw, 40px);
}

.pd-meta-card {
    background: #f5f4f0;
    border: 1px solid #e3e3dc;
    border-radius: 12px;
    padding: clamp(20px, 3.5vw, 36px) clamp(20px, 4vw, 40px);
}

.pd-meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: clamp(20px, 3vw, 32px) clamp(16px, 2.5vw, 28px);
    margin: 0;
}

.pd-meta-item {
    margin: 0;
    min-width: 0;
}

.pd-meta-label {
    display: block;
    margin: 0 0 6px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: #7a7a7a;
    line-height: 1.4;
}

.pd-meta-value {
    margin: 0;
    font-size: clamp(1rem, 1.6vw, 1.25rem);
    font-weight: 400;
    line-height: 1.4;
    color: #111;
    word-break: break-word;
}

/* ── Gallery ───────────────────────────────────────────────────────────────── */
.pd-gallery-section {
    margin-top: clamp(24px, 4vw, 40px);
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
@media (max-width: 1024px) {
    .pd-hero-title {
        max-width: none;
    }
}

@media (max-width: 767px) {
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
        padding-top: 28px;
    }

    .pd-meta-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
}
</style>
