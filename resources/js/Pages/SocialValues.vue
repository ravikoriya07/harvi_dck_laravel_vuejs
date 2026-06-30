<template>
    <Head title="Social Values" />
    <MainLayout>
        <div id="pxl-main-content" class="elementor elementor-26730">
            <SocialValuesGridPageSection :pagination="socialValues" />
        </div>
    </MainLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import SocialValuesGridPageSection from '@/Components/Sections/SocialValuesGridPageSection.vue';

defineProps({
    socialValues: {
        type: Object,
        required: true,
    },
});
</script>
