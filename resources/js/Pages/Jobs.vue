<template>
    <Head title="Current Jobs" />
    <MainLayout>
        <div id="pxl-main-content" class="elementor elementor-jobs">

            <!-- Page Hero Banner -->
            <section class="jobs-hero">
                <div class="jobs-hero-overlay"></div>
                <div class="container">
                    <div class="jobs-hero-content">
                        <h1 class="jobs-hero-title">Current Jobs</h1>
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
    background: #0d1b2a url('/assets/images/bg-page-header.jpg') center/cover no-repeat;
    padding: 80px 0 70px;
    text-align: center;
    overflow: hidden;
}

.jobs-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(13,27,42,0.82) 0%, rgba(19,85,165,0.72) 100%);
}

.jobs-hero-content {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}

.jobs-hero-title {
    font-size: 44px;
    font-weight: 800;
    color: #fff;
    margin: 0;
    letter-spacing: -0.01em;
    line-height: 1.15;
}

.jobs-hero-sub {
    font-size: 17px;
    color: rgba(255,255,255,0.75);
    margin: 0;
    max-width: 480px;
    line-height: 1.55;
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
@media (max-width: 768px) {
    .jobs-hero        { padding: 60px 0 52px; }
    .jobs-hero-title  { font-size: 32px; }
    .jobs-hero-sub    { font-size: 15px; }
}

@media (max-width: 480px) {
    .jobs-hero-title { font-size: 26px; }
}
</style>
