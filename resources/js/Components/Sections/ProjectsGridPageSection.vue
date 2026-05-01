<template>
    <div class="elementor-element elementor-element-0da32ca e-flex e-con-boxed e-con e-parent">
        <div class="e-con-inner">
            <div class="elementor-element elementor-element-70b37a9 pxl-post-layout-portfolio-1 elementor-widget elementor-widget-pxl_post_grid">
                <div class="elementor-widget-container">
                    <div
                        class="pxl-grid pxl-post-list pxl-portfolio-grid pxl-portfolio-grid-layout1 pxl-portfolio-style1 df pxl-effect--3d none"
                        :data-start-page="pagination.current_page"
                        :data-max-pages="pagination.last_page"
                        :data-total="pagination.total"
                        :data-perpage="pagination.per_page"
                        :data-next-link="pagination.next_page_url ?? ''"
                        data-layout="fitRows">
                        <div class="pxl-grid-inner pxl-grid-masonry row" data-gutter="15">
                            <div
                                v-for="project in projects"
                                :key="project.href"
                                class="pxl-grid-item col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="pxl-post--inner" data-wow-duration="1.2s">
                                    <div class="pxl-post--featured">
                                        <AppLink :href="project.href">
                                            <img
                                                loading="lazy"
                                                decoding="async"
                                                class="no-lazyload"
                                                :src="project.image"
                                                :alt="project.title"
                                            />
                                        </AppLink>
                                        <div class="pxl-post-content-hide">
                                            <div class="pxl-post-content-top">
                                                <div class="pxl-post--content"></div>
                                            </div>
                                            <AppLink class="btn-readmore" :href="project.href">
                                                <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" enable-background="new 0 0 20 20" height="17" viewBox="0 0 20 20" width="21">
                                                    <path d="m12 2-1.4 1.4 5.6 5.6h-16.2v2h16.2l-5.6 5.6 1.4 1.4 8-8z" fill="#fff" />
                                                </svg>
                                            </AppLink>
                                        </div>
                                        <AppLink class="pxl-item--overlay" :href="project.href"></AppLink>
                                    </div>

                                    <div class="pxl-post--holder">
                                        <div class="pxl-post--category">
                                            <a href="#">{{ project.category }}</a>
                                        </div>
                                        <h5 class="pxl-post--title">
                                            <AppLink :href="project.href">{{ project.title }}</AppLink>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="pagination.last_page > 1"
                        class="navigation page-links pxl-projects-pagination-nav"
                        aria-label="Projects pagination">
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

const projects = computed(() => props.pagination.data ?? []);

/** Laravel labels prev/next as long text; theme CSS uses fixed 36×36 tiles — classify for compact « » controls */
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
