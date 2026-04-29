<template>
    <Head title="About Us" />
    <MainLayout>
        <div id="pxl-main-content" class="elementor elementor-26444">
            <AboutHeroSection />
            <AboutQuoteSection />
            <AboutStorySection />
            <AboutApproachSection />
            <AboutCEOSection />
            <AboutTeamGridSection />
            <AboutPartnersSection />
            <AboutParallaxSection />
        </div>
    </MainLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import AboutHeroSection from '@/Components/Sections/AboutHeroSection.vue';
import AboutQuoteSection from '@/Components/Sections/AboutQuoteSection.vue';
import AboutStorySection from '@/Components/Sections/AboutStorySection.vue';
import AboutApproachSection from '@/Components/Sections/AboutApproachSection.vue';
import AboutCEOSection from '@/Components/Sections/AboutCEOSection.vue';
import AboutTeamGridSection from '@/Components/Sections/AboutTeamGridSection.vue';
import AboutPartnersSection from '@/Components/Sections/AboutPartnersSection.vue';
import AboutParallaxSection from '@/Components/Sections/AboutParallaxSection.vue';
</script>
