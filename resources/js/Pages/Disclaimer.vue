<template>
    <Head title="Disclaimer" />
    <MainLayout>
        <div id="pxl-main-content" class="elementor elementor-26442">
            <LegalHeroSection title="Disclaimer" />
            <DisclaimerContentSection />
        </div>
    </MainLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import LegalHeroSection from '@/Components/Sections/LegalHeroSection.vue';
import DisclaimerContentSection from '@/Components/Sections/DisclaimerContentSection.vue';
</script>
