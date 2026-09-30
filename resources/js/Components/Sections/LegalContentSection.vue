<template>
    <!-- Legal page body: "Last updated" line, intro, "On this page" contents list and numbered sections -->
    <div class="legal-page">
        <article class="legal-page__inner">
            <p v-if="page.last_updated" class="legal-page__updated">
                Last updated: <time :datetime="page.last_updated_iso">{{ page.last_updated }}</time>
            </p>

            <div v-if="page.intro" class="legal-page__intro legal-page__prose" v-html="page.intro"></div>

            <nav v-if="sections.length > 1" class="legal-page__toc" aria-labelledby="legal-page-toc-title">
                <h2 id="legal-page-toc-title" class="legal-page__toc-title">On this page</h2>
                <ol class="legal-page__toc-list">
                    <li v-for="(section, index) in sections" :key="section.id">
                        <a :href="`${page.path}#${section.id}`" class="legal-page__toc-link" @click="onTocClick($event, section.id)">
                            <span class="legal-page__toc-num">{{ index + 1 }}.</span>
                            <span>{{ section.heading }}</span>
                        </a>
                    </li>
                </ol>
            </nav>

            <section
                v-for="(section, index) in sections"
                :id="section.id"
                :key="section.id"
                class="legal-page__section"
                tabindex="-1"
            >
                <h2 class="legal-page__heading">
                    <span class="legal-page__heading-num">{{ index + 1 }}.</span>
                    {{ section.heading }}
                </h2>
                <div class="legal-page__prose" v-html="section.body"></div>
            </section>
        </article>
    </div>
</template>

<script setup>
import { computed, onMounted } from 'vue';

const props = defineProps({
    page: { type: Object, required: true },
});

const sections = computed(() => props.page.sections ?? []);

function scrollToSection(id, smooth = true) {
    const target = document.getElementById(id);

    if (!target) {
        return;
    }

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    target.scrollIntoView({ behavior: smooth && !reduceMotion ? 'smooth' : 'auto', block: 'start' });
    target.focus({ preventScroll: true });
}

/**
 * Hrefs are "/path#id" rather than "#id" so theme.js's global a[href^="#"] handler (which ignores
 * the header offset) never binds to them; we scroll here and respect scroll-margin-top instead.
 */
function onTocClick(event, id) {
    if (event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
        return;
    }

    if (!document.getElementById(id)) {
        return;
    }

    event.preventDefault();
    window.history.replaceState(window.history.state, '', `#${id}`);
    scrollToSection(id);
}

onMounted(() => {
    // Section ids are ASCII slugs, so the raw hash can be compared directly.
    const hashId = window.location.hash.slice(1);

    if (hashId && sections.value.some((section) => section.id === hashId)) {
        requestAnimationFrame(() => scrollToSection(hashId, false));
    }
});
</script>

<style scoped>
.legal-page {
    --legal-ink: #121c27;
    --legal-text: #333;
    --legal-muted: #6b6b6b;
    --legal-rule: #e6e6e6;

    font-family: 'Founders Grotesk', sans-serif;
    color: var(--legal-text);
}

.legal-page__inner {
    max-width: 960px;
    margin: 0 auto;
    padding: 64px 40px 96px;
    box-sizing: border-box;
}

.legal-page__updated {
    margin: 0 0 28px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--legal-rule);
    font-size: 16px;
    color: var(--legal-muted);
}

.legal-page__intro :deep(p) {
    font-size: 21px;
    line-height: 1.6;
    color: #111;
}

/* ── "On this page" contents ─────────────────────────────────────────── */
.legal-page__toc {
    margin: 36px 0 8px;
    padding: 28px 32px;
    border: 1px solid var(--legal-rule);
    border-radius: 4px;
    background: #f7f7f7;
}

.legal-page__toc-title {
    margin: 0 0 16px;
    font-family: inherit;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.4;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--legal-muted);
}

.legal-page__toc-list {
    margin: 0;
    padding: 0;
    list-style: none;
    columns: 2;
    column-gap: 40px;
}

.legal-page__toc-list li {
    margin: 0;
    break-inside: avoid;
}

.legal-page__toc-link {
    display: flex;
    gap: 8px;
    padding: 5px 0;
    font-size: 17px;
    line-height: 1.4;
    color: var(--legal-ink);
    text-decoration: none;
}

.legal-page__toc-link:hover span:last-child,
.legal-page__toc-link:focus-visible span:last-child {
    text-decoration: underline;
    text-underline-offset: 3px;
}

.legal-page__toc-num {
    flex: 0 0 auto;
    min-width: 24px;
    color: var(--legal-muted);
    font-variant-numeric: tabular-nums;
}

/* ── Sections ────────────────────────────────────────────────────────── */
/* Clears theme.js's fixed header, which slides in when scrolling up (~122px desktop, 80px mobile). */
.legal-page__section {
    padding-top: 44px;
    scroll-margin-top: 140px;
}

.legal-page__section:focus {
    outline: none;
}

.legal-page__heading {
    display: flex;
    gap: 12px;
    margin: 0 0 16px;
    font-family: inherit;
    font-size: 30px;
    font-weight: 600;
    line-height: 1.25;
    color: var(--legal-ink);
}

.legal-page__heading-num {
    flex: 0 0 auto;
    color: var(--legal-muted);
    font-variant-numeric: tabular-nums;
}

/* ── Rich text from the admin editor ─────────────────────────────────── */
.legal-page__prose :deep(p) {
    margin: 0 0 16px;
    font-size: 18px;
    line-height: 1.7;
}

.legal-page__prose > :deep(:last-child) {
    margin-bottom: 0;
}

.legal-page__prose :deep(h3) {
    margin: 28px 0 10px;
    font-family: inherit;
    font-size: 21px;
    font-weight: 600;
    line-height: 1.35;
    color: var(--legal-ink);
}

.legal-page__prose :deep(ul),
.legal-page__prose :deep(ol) {
    margin: 0 0 16px;
    padding-left: 24px;
}

/* maiko-style.css sets `ul li { list-style: inside }`, which drops <li><p> text below its bullet. */
.legal-page__prose :deep(ul > li) {
    list-style: disc outside;
}

.legal-page__prose :deep(ol > li) {
    list-style: decimal outside;
}

.legal-page__prose :deep(li) {
    margin: 0 0 8px;
    padding-left: 4px;
    font-size: 18px;
    line-height: 1.7;
}

.legal-page__prose :deep(li > p) {
    margin: 0;
}

.legal-page__prose :deep(li::marker) {
    color: var(--legal-muted);
}

.legal-page__prose :deep(strong) {
    font-weight: 600;
    color: #111;
}

.legal-page__prose :deep(a) {
    color: var(--legal-ink);
    text-decoration: underline;
    text-underline-offset: 3px;
    text-decoration-thickness: 1px;
    overflow-wrap: anywhere;
}

.legal-page__prose :deep(a:hover) {
    text-decoration-thickness: 2px;
}

.legal-page__prose :deep(blockquote) {
    margin: 0 0 16px;
    padding: 4px 0 4px 18px;
    border-left: 3px solid var(--legal-ink);
    color: #444;
}

/* ── Tablet / mobile ─────────────────────────────────────────────────── */
@media (max-width: 1024px) {
    .legal-page__inner {
        padding: 48px 28px 72px;
    }
}

@media (max-width: 767px) {
    .legal-page__inner {
        padding: 32px 20px 56px;
    }

    .legal-page__intro :deep(p) {
        font-size: 19px;
    }

    .legal-page__toc {
        padding: 22px 20px;
    }

    .legal-page__toc-list {
        columns: 1;
    }

    .legal-page__section {
        padding-top: 36px;
        scroll-margin-top: 64px;
    }

    .legal-page__heading {
        gap: 8px;
        font-size: 24px;
    }

    .legal-page__prose :deep(p),
    .legal-page__prose :deep(li) {
        font-size: 17px;
    }
}

@media print {
    .legal-page__toc {
        display: none;
    }

    .legal-page__inner {
        padding: 0;
    }
}
</style>
