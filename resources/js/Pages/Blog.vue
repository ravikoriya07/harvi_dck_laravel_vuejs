<template>
    <Head title="Blog" />
    <MainLayout>
        <div id="pxl-main-content" class="elementor elementor-blog">
            <BlogArchiveSection />
        </div>
    </MainLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import BlogArchiveSection from '@/Components/Sections/BlogArchiveSection.vue';
</script>
