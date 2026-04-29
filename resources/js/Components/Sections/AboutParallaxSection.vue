<template>
    <!-- Full-width team photo parallax section -->
    <section
        ref="sectionRef"
        class="elementor-section elementor-top-section elementor-element elementor-element-6bc8ad73 elementor-section-full_width elementor-section-height-min-height elementor-section-stretched pxl-section-overflow-hidden pxl_parallax_bg_img_noise-on pxl-bg-prx-effect-pinned-zoom-clipped elementor-section-height-default elementor-section-items-middle pxl-row-scroll-none pxl-zoom-point-false pxl-section-fix-none pxl-full-content-with-space-none pxl-bg-color-none pxl-section-overlay-none"
        data-settings='{"stretch_section":"section-stretched","pxl_parallax_bg_effect_other":"pinned-zoom-clipped"}'>
        <div class="clipped-bg-pinned">
            <div class="clipped-bg">
                <div class="pxl-section-bg-parallax pinned-zoom-clipped" data-parallax="[]"></div>
            </div>
        </div>
        <div class="elementor-container elementor-column-gap-no">
            <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-2dbd2f95 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                <div class="elementor-widget-wrap"></div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { nextTick, onBeforeUnmount, onMounted, ref } from 'vue';

const sectionRef = ref(null);
let cleanup = null;

const toDomNode = (value) => {
    if (!value) return null;
    if (value instanceof Node) return value;
    if (Array.isArray(value) && value[0] instanceof Node) return value[0];
    if (typeof value === 'object' && value[0] instanceof Node) return value[0]; // jQuery-like object
    return null;
};

const killSectionTriggers = (sectionEl, scrollTrigger) => {
    if (!sectionEl || !scrollTrigger?.getAll) return;
    scrollTrigger.getAll().forEach((trigger) => {
        const triggerNode = toDomNode(trigger?.vars?.trigger);
        if (triggerNode && sectionEl.contains(triggerNode)) {
            trigger.kill();
        }
    });
};

const initPinnedZoomClipped = () => {
    const sectionEl = sectionRef.value;
    if (!sectionEl || typeof window === 'undefined') return;

    const clippedBg = sectionEl.querySelector('.clipped-bg');
    if (clippedBg) {
        clippedBg.style.clipPath = 'inset(0% 20% 0% 20%)';
        clippedBg.style.transform = 'scale(0.86)';
    }

    const scrollTrigger = window.ScrollTrigger;
    killSectionTriggers(sectionEl, scrollTrigger);

    if (typeof window.maiko_parallax_bg === 'function') {
        window.maiko_parallax_bg();
    }

    cleanup = () => {
        killSectionTriggers(sectionEl, scrollTrigger);
    };
};

onMounted(async () => {
    await nextTick();
    initPinnedZoomClipped();
});

onBeforeUnmount(() => {
    if (typeof cleanup === 'function') cleanup();
});
</script>
