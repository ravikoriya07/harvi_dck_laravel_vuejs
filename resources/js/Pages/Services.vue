<template>
    <Head title="Services" />
    <MainLayout>
        <div id="pxl-main-content" class="elementor elementor-5160">
            <ServicesHeroSection />
            <ServicesListSection :services="services" />
        </div>
    </MainLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import ServicesHeroSection from '@/Components/Sections/ServicesHeroSection.vue';
import ServicesListSection from '@/Components/Sections/ServicesListSection.vue';

defineProps({
    services: {
        type: Array,
        default: () => [],
    },
});
</script>
