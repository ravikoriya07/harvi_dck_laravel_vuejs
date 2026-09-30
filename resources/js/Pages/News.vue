<template>
    <Head title="News">
        <meta
            head-key="description"
            name="description"
            content="The latest news from DCK Construction — project updates, milestones and community work, straight from our LinkedIn and Instagram." />
    </Head>
    <MainLayout>
        <div id="pxl-main-content" class="elementor elementor-news">
            <NewsHeroSection />
            <NewsFeedSection :pagination="posts" :profiles="profiles" :unavailable="unavailable" />
        </div>
    </MainLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import NewsHeroSection from '@/Components/Sections/NewsHeroSection.vue';
import NewsFeedSection from '@/Components/Sections/NewsFeedSection.vue';

defineProps({
    posts: {
        type: Object,
        default: () => ({ data: [], links: [], total: 0, last_page: 1 }),
    },
    profiles: {
        type: Object,
        default: () => ({}),
    },
    unavailable: {
        type: Boolean,
        default: false,
    },
});
</script>
