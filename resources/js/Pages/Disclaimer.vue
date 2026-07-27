<template>
    <Head title="Disclaimer" />
    <MainLayout>
        <div id="pxl-main-content" class="elementor elementor-26442">
            <DisclaimerHeroSection />
            <DisclaimerContentSection />
        </div>
    </MainLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import DisclaimerHeroSection from '@/Components/Sections/DisclaimerHeroSection.vue';
import DisclaimerContentSection from '@/Components/Sections/DisclaimerContentSection.vue';
</script>
