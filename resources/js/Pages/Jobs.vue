<template>
    <Head title="Current Jobs" />
    <MainLayout>
        <div id="pxl-main-content" class="elementor elementor-jobs">

            <!-- Page Hero Banner -->
            <section class="jobs-hero">
                <img
                    class="jobs-hero-photo"
                    src="/assets/images/bg-2_H-e1760689052181_1_11zon.avif"
                    alt=""
                    fetchpriority="high"
                    loading="eager"
                    decoding="async"
                />
                <div class="jobs-hero-overlay"></div>
                <div class="container">
                    <div class="jobs-hero-content">
                        <h1 class="jobs-hero-title">
                            <span class="jobs-hero-title-line">Current</span>
                            <span class="jobs-hero-title-line">Jobs</span>
                        </h1>
                        <p class="jobs-hero-sub">Join our team — explore the latest opportunities at DCK Construction</p>
                        <nav class="jobs-breadcrumb" aria-label="Breadcrumb">
                            <AppLink href="/" class="jobs-breadcrumb-link">Home</AppLink>
                            <span class="jobs-breadcrumb-sep">/</span>
                            <span class="jobs-breadcrumb-current">Current Jobs</span>
                        </nav>
                    </div>
                </div>
            </section>

            <!-- Listing + Filters -->
            <JobsListingSection
                :pagination="jobs"
                :categories="categories"
                :filters="filters"
            />

        </div>
    </MainLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import AppLink from '@/Components/AppLink.vue';
import JobsListingSection from '@/Components/Sections/JobsListingSection.vue';

defineProps({
    jobs:       { type: Object, required: true },
    categories: { type: Array,  default: () => [] },
    filters:    { type: Object, default: () => ({}) },
});
</script>

<style scoped>
/* ── Hero ──────────────────────────────────────────────────────────────── */
.jobs-hero {
    position: relative;
    min-height: clamp(380px, 52vh, 580px);
    padding: 60px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    overflow: hidden;
}

.jobs-hero .container {
    width: 100%;
    max-width: 100%;
}

.jobs-hero-photo {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    z-index: 0;
}

.jobs-hero-overlay {
    position: absolute;
    inset: 0;
    z-index: 1;
    pointer-events: none;
    background:
        linear-gradient(180deg, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0.15) 40%, rgba(0, 0, 0, 0.45) 100%),
        radial-gradient(ellipse 70% 60% at 50% 50%, rgba(0, 0, 0, 0.45) 0%, transparent 70%);
}

.jobs-hero-content {
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 14px;
    width: 100%;
}

.jobs-hero-title {
    font-size: 75px;
    font-weight: 700;
    color: #fff;
    margin: 0;
    letter-spacing: -0.02em;
    line-height: 1.12;
    opacity: 0;
    animation: jobs-hero-title-in 0.9s cubic-bezier(0.22, 1, 0.36, 1) 0.15s forwards;
}

.jobs-hero-title-line {
    display: block;
    text-shadow:
        0 2px 24px rgba(0, 0, 0, 0.45),
        0 1px 2px rgba(0, 0, 0, 0.35);
}

.jobs-hero-title-line + .jobs-hero-title-line {
    margin-top: 0.08em;
}

@keyframes jobs-hero-title-in {
    from {
        opacity: 0;
        transform: translateY(18px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.jobs-hero-sub {
    font-size: 17px;
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
    max-width: 520px;
    line-height: 1.55;
    text-shadow: 0 1px 12px rgba(0, 0, 0, 0.35);
}

/* Breadcrumb */
.jobs-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    margin-top: 4px;
}

.jobs-breadcrumb-link {
    color: rgba(255,255,255,0.65);
    text-decoration: none;
    transition: color 0.2s;
}

.jobs-breadcrumb-link:hover { color: #fff; }

.jobs-breadcrumb-sep { color: rgba(255,255,255,0.4); }

.jobs-breadcrumb-current { color: rgba(255,255,255,0.9); font-weight: 500; }

/* ── Responsive ────────────────────────────────────────────────────────── */
@media (prefers-reduced-motion: reduce) {
    .jobs-hero-title {
        opacity: 1;
        transform: none;
        animation: none;
    }
}

@media (max-width: 1200px) {
    .jobs-hero-title { font-size: 65px; }
}

@media (max-width: 1024px) {
    .jobs-hero {
        min-height: clamp(320px, 48vh, 500px);
    }

    .jobs-hero-title { font-size: 54px; }
}

@media (max-width: 768px) {
    .jobs-hero {
        min-height: clamp(280px, 45vh, 400px);
        padding: 40px 16px;
    }

    .jobs-hero-title { font-size: 34px; }
    .jobs-hero-sub    { font-size: 15px; }
}
</style>
