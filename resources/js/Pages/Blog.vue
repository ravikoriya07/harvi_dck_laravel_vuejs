<template>
    <Head title="Blog" />
    <MainLayout>
        <div id="pxl-main-content" class="elementor elementor-blog">
            <BlogArchiveSection :posts="posts" :categories="categories" />
        </div>
    </MainLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import BlogArchiveSection from '@/Components/Sections/BlogArchiveSection.vue';

defineProps({
    posts: {
        type: Object,
        default: () => ({ data: [], links: [], meta: {} }),
    },
    categories: {
        type: Array,
        default: () => [],
    },
});
</script>
