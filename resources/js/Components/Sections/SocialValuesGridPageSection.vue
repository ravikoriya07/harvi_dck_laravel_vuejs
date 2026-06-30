<template>
    <div class="elementor-element elementor-element-0da32ca e-flex e-con-boxed e-con e-parent">
        <div class="e-con-inner">
            <div class="elementor-element elementor-element-70b37a9 pxl-post-layout-portfolio-1 elementor-widget elementor-widget-pxl_post_grid">
                <div class="elementor-widget-container">
                    <div
                        v-if="!isEmpty"
                        class="pxl-grid pxl-post-list pxl-portfolio-grid pxl-portfolio-grid-layout1 pxl-portfolio-style1 df pxl-effect--3d none"
                        :data-start-page="pagination.current_page"
                        :data-max-pages="pagination.last_page"
                        :data-total="pagination.total"
                        :data-perpage="pagination.per_page"
                        :data-next-link="pagination.next_page_url ?? ''"
                        data-layout="fitRows">
                        <div class="pxl-grid-inner pxl-grid-masonry row" data-gutter="15">
                            <div
                                v-for="item in items"
                                :key="item.href"
                                class="pxl-grid-item col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="pxl-post--inner" data-wow-duration="1.2s">
                                    <div class="pxl-post--featured">
                                        <AppLink :href="item.href">
                                            <img
                                                loading="lazy"
                                                decoding="async"
                                                class="no-lazyload"
                                                :src="item.image"
                                                :alt="item.title"
                                            />
                                        </AppLink>
                                        <div class="pxl-post-content-hide">
                                            <div class="pxl-post-content-top">
                                                <div class="pxl-post--content"></div>
                                            </div>
                                            <AppLink class="btn-readmore" :href="item.href">
                                                <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" enable-background="new 0 0 20 20" height="17" viewBox="0 0 20 20" width="21">
                                                    <path d="m12 2-1.4 1.4 5.6 5.6h-16.2v2h16.2l-5.6 5.6 1.4 1.4 8-8z" fill="#fff" />
                                                </svg>
                                            </AppLink>
                                        </div>
                                        <AppLink class="pxl-item--overlay" :href="item.href"></AppLink>
                                    </div>

                                    <div class="pxl-post--holder">
                                        <div class="pxl-post--category">
                                            <a href="#">{{ item.category }}</a>
                                        </div>
                                        <h5 class="pxl-post--title">
                                            <AppLink :href="item.href">{{ item.title }}</AppLink>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-else class="pxl-grid-empty" role="status">
                        <div class="pxl-grid-empty-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.2">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                                <line x1="8" y1="7" x2="16" y2="7" />
                                <line x1="8" y1="11" x2="14" y2="11" />
                            </svg>
                        </div>
                        <h2 class="pxl-grid-empty-title">No social values to display</h2>
                        <p class="pxl-grid-empty-text">
                            There are no social value stories available at the moment. Please check back soon.
                        </p>
                    </div>

                    <div
                        v-if="!isEmpty && pagination.last_page > 1"
                        class="navigation page-links pxl-projects-pagination-nav"
                        aria-label="Social Values pagination">
                        <template v-for="(link, index) in normalizedLinks" :key="index">
                            <template v-if="link.variant === 'prev'">
                                <Link
                                    v-if="link.url"
                                    class="post-page-numbers post-page-numbers--compact"
                                    preserve-scroll
                                    :href="link.url"
                                    aria-label="Previous page">«</Link>
                                <span
                                    v-else
                                    class="post-page-numbers post-page-numbers--compact is-disabled"
                                    aria-hidden="true">«</span>
                            </template>
                            <template v-else-if="link.variant === 'next'">
                                <Link
                                    v-if="link.url"
                                    class="post-page-numbers post-page-numbers--compact"
                                    preserve-scroll
                                    :href="link.url"
                                    aria-label="Next page">»</Link>
                                <span
                                    v-else
                                    class="post-page-numbers post-page-numbers--compact is-disabled"
                                    aria-hidden="true">»</span>
                            </template>
                            <template v-else-if="link.variant === 'ellipsis'">
                                <span
                                    class="post-page-numbers post-page-numbers--ellipsis pxl-post-page-numbers--ellipsis"
                                    aria-hidden="true">…</span>
                            </template>
                            <template v-else>
                                <Link
                                    v-if="link.url && !link.active"
                                    class="post-page-numbers"
                                    preserve-scroll
                                    :href="link.url">
                                    <span v-html="link.label"></span>
                                </Link>
                                <span
                                    v-else-if="link.active"
                                    class="post-page-numbers current"
                                    v-html="link.label"></span>
                            </template>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLink from '@/Components/AppLink.vue';

const props = defineProps({
    pagination: {
        type: Object,
        required: true,
    },
});

const items = computed(() => props.pagination.data ?? []);

const isEmpty = computed(() => (props.pagination.total ?? items.value.length) === 0);

const normalizedLinks = computed(() => {
    const links = props.pagination.links ?? [];
    return links.map((link) => {
        const text = String(link.label)
            .replace(/<[^>]*>/g, '')
            .replace(/&nbsp;/g, ' ')
            .trim();
        const lower = text.toLowerCase();

        let variant = 'page';
        if (lower.includes('previous')) {
            variant = 'prev';
        } else if (lower.includes('next')) {
            variant = 'next';
        } else if (text === '...' || text === '…') {
            variant = 'ellipsis';
        }

        return { ...link, variant };
    });
});
</script>

<style scoped>
.pxl-grid-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 320px;
    padding: 64px 24px 80px;
    text-align: center;
}

.pxl-grid-empty-icon {
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

.pxl-grid-empty-title {
    margin: 0 0 12px;
    font-size: 1.75rem;
    font-weight: 500;
    line-height: 1.2;
    letter-spacing: -0.02em;
    color: #111;
}

.pxl-grid-empty-text {
    margin: 0;
    max-width: 28rem;
    font-size: 1rem;
    line-height: 1.6;
    color: #666;
}
</style>
