<template>
    <div id="pxl-wapper" class="pxl-wapper">
        <AppHeader />
        <div id="pxl-main">
            <slot />
        </div>
        <AppFooter />
    </div>
</template>

<script setup>
import { onMounted, watch } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import AppHeader from '@/Components/AppHeader.vue';
import AppFooter from '@/Components/AppFooter.vue';
import { ensurePageStyles } from '@/composables/pageAssets';
import {
    bindMobileMenuHandlers,
    observeDynamicSections,
    resetThemePageState,
    scheduleThemeEffects,
} from '@/composables/themeEffects';

const page = usePage();

async function applyPageAssets() {
    await ensurePageStyles(page.component);
    scheduleThemeEffects({ hideLoader: true });
}

watch(() => page.component, () => {
    void applyPageAssets();
});

onMounted(() => {
    bindMobileMenuHandlers();
    observeDynamicSections();
    void applyPageAssets();
});

router.on('start', () => {
    resetThemePageState();
});

router.on('finish', () => {
    void applyPageAssets();
});
</script>
