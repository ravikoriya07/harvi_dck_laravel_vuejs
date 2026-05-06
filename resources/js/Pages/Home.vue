<template>
    <Head title="Home" />
    <MainLayout>
        <div id="pxl-main-content" class="elementor elementor-18">
            <HeroSection />
            <AboutSection />
            <AboutImagesSection />
            <WhyChooseUsSection />
            <WhyUsSection />
            <ServicesSection />
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
import { Head } from '@inertiajs/vue3';

defineProps({
    projects: {
        type: Array,
        default: () => [],
    },
});
import MainLayout from '@/Layouts/MainLayout.vue';
import HeroSection from '@/Components/Sections/HeroSection.vue';
import AboutSection from '@/Components/Sections/AboutSection.vue';
import AboutImagesSection from '@/Components/Sections/AboutImagesSection.vue';
import WhyChooseUsSection from '@/Components/Sections/WhyChooseUsSection.vue';
import WhyUsSection from '@/Components/Sections/WhyUsSection.vue';
import ServicesSection from '@/Components/Sections/ServicesSection.vue';
import ClientsSection from '@/Components/Sections/ClientsSection.vue';
import ProjectsSection from '@/Components/Sections/ProjectsSection.vue';
import ProcurementSection from '@/Components/Sections/ProcurementSection.vue';
import TeamSection from '@/Components/Sections/TeamSection.vue';
import PartnersSection from '@/Components/Sections/PartnersSection.vue';
import TestimonialsSection from '@/Components/Sections/TestimonialsSection.vue';
import ContactSection from '@/Components/Sections/ContactSection.vue';
import CertificationsSection from '@/Components/Sections/CertificationsSection.vue';
</script>
