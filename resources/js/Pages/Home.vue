<template>
    <Head title="Home">
        <link rel="preload" as="image" href="/assets/images/home-1-01.avif" fetchpriority="high" media="(min-width: 768px)" />
        <link rel="preload" as="image" href="/assets/images/bg-2_H-e1760689052181_1_11zon.avif" fetchpriority="high" />
    </Head>
    <MainLayout>
        <div id="pxl-main-content" class="elementor elementor-18">
            <HeroSection />
            <AboutSection />
            <AboutImagesSection />
            <WhyChooseUsSection />
            <WhyUsSection />
            <ServicesSection :services="services" />
            <ClientsSection />
            <ProjectsSection :projects="projects" />
            <ProcurementSection />
            <TeamSection />
            <PartnersSection />
            <TestimonialsSection />
            <ContactSection />
            <CertificationsSection />
        </div>
    </MainLayout>
</template>

<script setup>
import { defineAsyncComponent } from 'vue';
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import HeroSection from '@/Components/Sections/HeroSection.vue';
import AboutSection from '@/Components/Sections/AboutSection.vue';
import AboutImagesSection from '@/Components/Sections/AboutImagesSection.vue';
import ServicesSection from '@/Components/Sections/ServicesSection.vue';
import ProjectsSection from '@/Components/Sections/ProjectsSection.vue';

defineProps({
    projects: {
        type: Array,
        default: () => [],
    },
    services: {
        type: Array,
        default: () => [],
    },
});

// Carousels must be in the initial bundle so Swiper/theme init runs reliably.
const WhyChooseUsSection = defineAsyncComponent(() => import('@/Components/Sections/WhyChooseUsSection.vue'));
const WhyUsSection = defineAsyncComponent(() => import('@/Components/Sections/WhyUsSection.vue'));
const ClientsSection = defineAsyncComponent(() => import('@/Components/Sections/ClientsSection.vue'));
const ProcurementSection = defineAsyncComponent(() => import('@/Components/Sections/ProcurementSection.vue'));
const TeamSection = defineAsyncComponent(() => import('@/Components/Sections/TeamSection.vue'));
const PartnersSection = defineAsyncComponent(() => import('@/Components/Sections/PartnersSection.vue'));
const TestimonialsSection = defineAsyncComponent(() => import('@/Components/Sections/TestimonialsSection.vue'));
const ContactSection = defineAsyncComponent(() => import('@/Components/Sections/ContactSection.vue'));
const CertificationsSection = defineAsyncComponent(() => import('@/Components/Sections/CertificationsSection.vue'));
</script>
