<template>
    <!-- Full-width team photo parallax section -->
    <section
        ref="sectionRef"
        class="elementor-section elementor-top-section elementor-element elementor-element-6bc8ad73 elementor-section-full_width elementor-section-height-min-height elementor-section-stretched pxl-section-overflow-hidden pxl_parallax_bg_img_noise-on pxl-bg-prx-effect-pinned-zoom-clipped elementor-section-height-default elementor-section-items-middle pxl-row-scroll-none pxl-zoom-point-false pxl-section-fix-none pxl-full-content-with-space-none pxl-bg-color-none pxl-section-overlay-none"
        data-settings='{"stretch_section":"section-stretched","pxl_parallax_bg_effect_other":"pinned-zoom-clipped"}'>
        <div class="clipped-bg-pinned">
            <div class="clipped-bg">
                <div
                    ref="parallaxLayerRef"
                    class="pxl-section-bg-parallax pinned-zoom-clipped"
                    data-parallax="[]"></div>
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
const parallaxLayerRef = ref(null);
let gsapTimeline = null;
let initCancelled = false;
let layoutRefreshTimer = null;

const INITIAL_INSET = '20%';
const INITIAL_SCALE = 0.86;

/**
 * Timeline fractions (must sum to 1). Mapped to scroll between start/end below.
 * Expand must span most of the approach phase so full width is not reached while
 * the section is only partially visible (reference: full width when centered/active).
 */
const SCRUB_EXPAND = 0.5;
const SCRUB_HOLD_FULL = 0.28;
const SCRUB_SHRINK = 0.22;

const toDomNode = (value) => {
    if (!value) return null;
    if (value instanceof Node) return value;
    if (Array.isArray(value) && value[0] instanceof Node) return value[0];
    if (typeof value === 'object' && value[0] instanceof Node) return value[0];
    return null;
};

const killSectionTriggers = (sectionEl, ScrollTrigger) => {
    if (!sectionEl || !ScrollTrigger?.getAll) return;
    ScrollTrigger.getAll().forEach((trigger) => {
        const triggerNode = toDomNode(trigger?.vars?.trigger);
        if (triggerNode && (triggerNode === sectionEl || sectionEl.contains(triggerNode))) {
            // revert=true: removes the pin spacer and reverts the element position
            trigger.kill(true);
        }
    });
};

onMounted(async () => {
    await nextTick();

    // Child components mount before MainLayout. MainLayout's onMounted runs
    // maiko_parallax_bg() which attaches ScrollTrigger + pin on this section
    // after this hook returns — so any kill/setup here would be overwritten.
    // Queue init after the current synchronous mount flush so we replace the
    // theme triggers with our scrub timeline.
    queueMicrotask(() => {
        requestAnimationFrame(() => {
            if (initCancelled) return;

            const sectionEl = sectionRef.value;
            const parallaxEl = parallaxLayerRef.value;
            if (!sectionEl || !parallaxEl || typeof window === 'undefined') return;

            const gsap = window.gsap;
            const ScrollTrigger = window.ScrollTrigger;
            if (!gsap || !ScrollTrigger) return;

            // Kill theme ScrollTriggers with revert=true to restore pinned layout
            killSectionTriggers(sectionEl, ScrollTrigger);

            // Animate the inner parallax layer only. Theme puts clip+scale on `.clipped-bg`; combining that with
            // GSAP transforms caused drift mid-scroll while footer/layout reflow made it look correct sometimes.
            gsap.killTweensOf(parallaxEl);
            gsap.set(parallaxEl, { clearProps: 'all' });

            gsap.set(parallaxEl, {
                clipPath: `inset(0% ${INITIAL_INSET} 0% ${INITIAL_INSET})`,
                scale: INITIAL_SCALE,
                transformOrigin: '50% 50%',
            });

            const fullClip = { clipPath: 'inset(0% 0% 0% 0%)', scale: 1 };
            const smallClip = {
                clipPath: `inset(0% ${INITIAL_INSET} 0% ${INITIAL_INSET})`,
                scale: INITIAL_SCALE,
            };

            // Scroll span: first pixel of section enters bottom of viewport → section finishes leaving at top.
            // Timeline ~0 → ~0.5 = gradual widen while bringing section into view (full width ~ viewport-centered).
            // Middle = hold full while section reads “active”; tail = narrow again on exit (both directions scrub smoothly).
            gsapTimeline = gsap.timeline({
                scrollTrigger: {
                    trigger: sectionEl,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: 1,
                    invalidateOnRefresh: true,
                },
            });

            gsapTimeline
                .to(parallaxEl, { ...fullClip, ease: 'none', duration: SCRUB_EXPAND })
                .to(parallaxEl, { ...fullClip, ease: 'none', duration: SCRUB_HOLD_FULL })
                .to(parallaxEl, { ...smallClip, ease: 'none', duration: SCRUB_SHRINK });

            ScrollTrigger.refresh();

            // theme.js applies footer fixed margin after ~600ms — refresh ST so scrub math matches final layout.
            if (layoutRefreshTimer) clearTimeout(layoutRefreshTimer);
            layoutRefreshTimer = window.setTimeout(() => {
                layoutRefreshTimer = null;
                if (!initCancelled && window.ScrollTrigger) {
                    window.ScrollTrigger.refresh();
                }
            }, 700);
        });
    });
});

onBeforeUnmount(() => {
    initCancelled = true;
    if (layoutRefreshTimer) {
        clearTimeout(layoutRefreshTimer);
        layoutRefreshTimer = null;
    }
    if (gsapTimeline) {
        gsapTimeline.scrollTrigger?.kill();
        gsapTimeline.kill();
        gsapTimeline = null;
    }
});
</script>

<style scoped>
.clipped-bg-pinned {
    inset: 0;
}
/* Neutralize theme clip/scale on wrapper — GSAP drives clip+scale on `.pxl-section-bg-parallax` instead. */
.clipped-bg {
    clip-path: none !important;
    -webkit-clip-path: none !important;
    transform: none !important;
    -webkit-transform: none !important;
}
.pxl-section-bg-parallax {
    transform-origin: center center;
}
</style>
