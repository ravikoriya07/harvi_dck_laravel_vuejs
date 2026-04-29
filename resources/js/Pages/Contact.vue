<template>
    <Head title="Contact Us" />
    <MainLayout>
        <div id="pxl-main-content" class="elementor elementor-1306">
            <ContactHeroSection />
            <ContactOfficesSection />
            <ContactMapSection />
        </div>
    </MainLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import ContactHeroSection from '@/Components/Sections/ContactHeroSection.vue';
import ContactOfficesSection from '@/Components/Sections/ContactOfficesSection.vue';
import ContactMapSection from '@/Components/Sections/ContactMapSection.vue';
</script>
