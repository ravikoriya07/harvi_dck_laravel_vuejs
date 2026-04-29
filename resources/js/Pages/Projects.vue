<template>
    <Head title="Projects" />
    <MainLayout>
        <div id="pxl-main-content" class="elementor elementor-26730">
            <ProjectsGridPageSection />
        </div>
    </MainLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import ProjectsGridPageSection from '@/Components/Sections/ProjectsGridPageSection.vue';
</script>
