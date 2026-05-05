<template>
    <Head :title="post.title || 'Blog Detail'" />
    <MainLayout>
        <div id="pxl-main-content" class="elementor elementor-blog-detail">
            <BlogDetailSection :post="post" :categories="categories" />
        </div>
    </MainLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import BlogDetailSection from '@/Components/Sections/BlogDetailSection.vue';

defineProps({
    post: {
        type: Object,
        default: () => ({}),
    },
    categories: {
        type: Array,
        default: () => [],
    },
});
</script>
