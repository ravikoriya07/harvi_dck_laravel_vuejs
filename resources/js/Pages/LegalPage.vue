<template>
    <Head :title="page.title">
        <meta v-if="page.meta_description" head-key="description" name="description" :content="page.meta_description" />
    </Head>
    <MainLayout>
        <!-- Reuses the Disclaimer page's Elementor scope (.elementor-26442) so all legal pages share one hero. -->
        <div id="pxl-main-content" class="elementor elementor-26442">
            <LegalHeroSection :title="page.title" />
            <LegalContentSection :page="page" />
        </div>
    </MainLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import LegalHeroSection from '@/Components/Sections/LegalHeroSection.vue';
import LegalContentSection from '@/Components/Sections/LegalContentSection.vue';

defineProps({
    page: { type: Object, required: true },
});
</script>
