<template>
    <section class="news-feed-section">
        <div class="container">

            <!-- Error State (database unavailable — details are logged server-side) -->
            <div v-if="unavailable" class="news-state" role="alert">
                <div class="news-state-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.2">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="7" x2="12" y2="13" />
                        <circle cx="12" cy="16.5" r="0.6" fill="currentColor" />
                    </svg>
                </div>
                <h2 class="news-state-title">News is temporarily unavailable</h2>
                <p class="news-state-text">We couldn't load our latest updates just now. Please try again in a moment.</p>
                <div class="news-state-actions">
                    <button type="button" class="btn btn-default news-state-btn" @click="retry">
                        <span class="pxl--btn-text">Try again</span>
                    </button>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else-if="posts.length === 0" class="news-state" role="status">
                <div class="news-state-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.2">
                        <path d="M4 5h13a1 1 0 0 1 1 1v12a2 2 0 0 0 2 2H6a2 2 0 0 1-2-2V5z" />
                        <path d="M18 9h2v9a2 2 0 0 1-2 2" />
                        <line x1="7" y1="9" x2="15" y2="9" />
                        <line x1="7" y1="13" x2="15" y2="13" />
                        <line x1="7" y1="17" x2="12" y2="17" />
                    </svg>
                </div>
                <h2 class="news-state-title">No news to display yet</h2>
                <p class="news-state-text">
                    Our latest LinkedIn and Instagram updates will appear here. In the meantime, follow DCK Construction.
                </p>
                <div v-if="profileLinks.length" class="news-state-actions">
                    <a
                        v-for="profile in profileLinks"
                        :key="profile.label"
                        class="btn btn-default news-state-btn"
                        :href="profile.href"
                        target="_blank"
                        rel="noopener noreferrer">
                        <i :class="profile.icon" aria-hidden="true"></i>
                        <span class="pxl--btn-text">{{ profile.label }}</span>
                    </a>
                </div>
            </div>

            <!-- Posts -->
            <template v-else>
                <div class="pxl-blog-grid-layout1 news-grid">
                    <div class="row">
                        <div
                            v-for="(post, index) in posts"
                            :key="post.id"
                            class="pxl-grid-item col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                            <NewsPostCard :post="post" :eager="index < 3" />
                        </div>
                    </div>
                </div>

                <!-- Pagination — same structure as Jobs / Blog -->
                <nav v-if="pagination.last_page > 1" class="pxl-pagination-wrap news-pagination" aria-label="News pagination">
                    <div class="pxl-pagination-links">
                        <template v-for="(link, index) in normalizedLinks" :key="index">

                            <!-- Prev arrow -->
                            <template v-if="link.variant === 'prev'">
                                <Link
                                    v-if="link.url"
                                    class="prev page-numbers"
                                    preserve-scroll
                                    :href="link.url"
                                    aria-label="Previous page"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </Link>
                            </template>

                            <!-- Next arrow -->
                            <template v-else-if="link.variant === 'next'">
                                <Link
                                    v-if="link.url"
                                    class="next page-numbers"
                                    preserve-scroll
                                    :href="link.url"
                                    aria-label="Next page"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </Link>
                            </template>

                            <!-- Ellipsis -->
                            <template v-else-if="link.variant === 'ellipsis'">
                                <span class="page-numbers dots" aria-hidden="true">…</span>
                            </template>

                            <!-- Page number -->
                            <template v-else>
                                <Link
                                    v-if="link.url && !link.active"
                                    class="page-numbers"
                                    preserve-scroll
                                    :href="link.url"
                                    :aria-label="'Page ' + link.label"
                                >{{ link.label }}</Link>
                                <span
                                    v-else-if="link.active"
                                    class="page-numbers current"
                                    :aria-label="'Page ' + link.label"
                                    aria-current="page"
                                >{{ link.label }}</span>
                            </template>

                        </template>
                    </div>
                </nav>
            </template>

        </div>
    </section>
</template>

<script setup>
import { computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import NewsPostCard from '@/Components/NewsPostCard.vue';

const props = defineProps({
    pagination: { type: Object, required: true },
    profiles: { type: Object, default: () => ({}) },
    unavailable: { type: Boolean, default: false },
});

const posts = computed(() => props.pagination.data ?? []);

const profileLinks = computed(() => [
    { label: 'Follow on LinkedIn', href: props.profiles.linkedin, icon: 'fab fa-linkedin-in' },
    { label: 'Follow on Instagram', href: props.profiles.instagram, icon: 'fab fa-instagram' },
].filter((profile) => profile.href));

function retry() {
    router.reload({ only: ['posts', 'unavailable'] });
}

// ── Pagination ───────────────────────────────────────────────────────────────
const normalizedLinks = computed(() => {
    const links = props.pagination.links ?? [];
    return links.map((link) => {
        const text = String(link.label)
            .replace(/<[^>]*>/g, '')
            .replace(/&nbsp;/g, ' ')
            .replace(/&laquo;|&raquo;/g, '')
            .trim();
        const lower = text.toLowerCase();
        let variant = 'page';
        if (lower.includes('previous')) variant = 'prev';
        else if (lower.includes('next')) variant = 'next';
        else if (text === '...' || text === '…') variant = 'ellipsis';
        return { ...link, label: text, variant };
    });
});
</script>

<style scoped>
.news-feed-section {
    padding: 90px 0 60px;
}

/* ── Empty / Error State (same treatment as the Projects grid empty state) ─ */
.news-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 320px;
    padding: 24px 24px 60px;
    text-align: center;
}

.news-state-icon {
    width: 88px;
    height: 88px;
    border-radius: 50%;
    background: #f1f2eb;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 24px;
    color: #3e68ff;
}

.news-state-title {
    margin: 0 0 12px;
    font-size: 1.75rem;
    font-weight: 500;
    line-height: 1.2;
    letter-spacing: -0.02em;
    color: #111;
}

.news-state-text {
    margin: 0;
    max-width: 30rem;
    font-size: 1rem;
    line-height: 1.6;
    color: #666;
}

.news-state-actions {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 16px;
    margin-top: 32px;
}

/* Theme .btn-default is styled for dark sections (footer); give it the site's dark fill here */
.news-state .btn.news-state-btn {
    background-color: #111;
    border-color: #111;
    color: #fff;
    gap: 10px;
    /* <button> picks up the theme's uppercase form-button style; match the link buttons */
    font-family: inherit;
    text-transform: none;
    letter-spacing: normal;
}

.news-state .btn.news-state-btn:hover,
.news-state .btn.news-state-btn:focus-visible {
    background-color: #3e68ff;
    border-color: #3e68ff;
    color: #fff;
}

/* ── Pagination: wrap instead of overflowing on narrow screens ─────────── */
.news-pagination .pxl-pagination-links {
    flex-wrap: wrap;
    row-gap: 12px;
    margin-top: 0;
}

@media (max-width: 767px) {
    .news-feed-section {
        padding: 50px 0 40px;
    }

    .news-state-title {
        font-size: 1.5rem;
    }

    .news-pagination .pxl-pagination-links {
        column-gap: 10px;
    }

    .news-pagination .page-numbers {
        width: 44px;
        height: 44px;
    }
}
</style>
