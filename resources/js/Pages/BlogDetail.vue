<template>
    <Head :title="pageTitle" />
    <MainLayout>
        <div id="pxl-main-content" class="elementor elementor-blog-detail">
            <BlogDetailSection :slug="slug" />
        </div>
    </MainLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import BlogDetailSection from '@/Components/Sections/BlogDetailSection.vue';

const props = defineProps({
    slug: {
        type: String,
        default: '',
    },
    title: {
        type: String,
        default: '',
    },
});

const pageTitle = computed(() => {
    if (props.title) return props.title;
    if (!props.slug) return 'Blog Detail';
    return props.slug
        .split('-')
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
});
</script>
