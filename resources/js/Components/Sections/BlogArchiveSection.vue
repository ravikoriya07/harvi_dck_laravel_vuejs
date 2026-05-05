<template>
    <div class="container">
        <div class="row pxl-content-wrap pxl-has-sidebar pxl-sidebar-right">
            <div id="pxl-content-area" class="pxl-content-area pxl-content-blog col-12 col-lg-8">
                <main id="pxl-content-main">
                    <article
                        v-for="post in posts.data"
                        :key="post.slug"
                        class="pxl-archive-post post type-post status-publish format-video has-post-thumbnail hentry category-youtube post_format-post-format-video">
                        <div class="content-inner-post">
                            <div class="post-featured">
                                <div class="format-wrap">
                                    <div class="pxl-item--image">
                                        <AppLink :href="post.href">
                                            <img
                                                width="810"
                                                height="385"
                                                class="attachment-maiko-large size-maiko-large wp-post-image"
                                                :src="post.image_url"
                                                :alt="post.title"
                                                decoding="async" />
                                        </AppLink>
                                        <div v-if="post.video_url" class="pxl-video-popup">
                                            <div class="content-inner">
                                                <a class="video-play-button pxl-action-popup" :href="post.video_url">
                                                    <i class="fas fa-play"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="post-content">
                                <h2 class="post-title">
                                    <AppLink :href="post.href" :title="post.title">
                                        {{ post.title }}
                                    </AppLink>
                                </h2>
                                <div class="pxl-divider"></div>
                                <div v-if="post.excerpt" class="post-excerpt">
                                    <p>{{ post.excerpt }}</p>
                                </div>
                                <div class="post-bottom">
                                    <div class="post-metas">
                                        <div class="meta-inner">
                                            <span class="post-author">
                                                <span class="icon-post"><i class="fas fa-user"></i></span>
                                                <span>By <a href="#" rel="author">{{ post.author }}</a></span>
                                            </span>
                                            <span class="post-category">
                                                <span class="icon-post"><i class="fas fa-tag"></i></span>
                                                <span><a href="#" rel="tag">{{ post.category }}</a></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="post-btn-wrap">
                                        <AppLink class="btn-more" :href="post.href">
                                            <span>find out more</span>
                                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 743.03 261.28">
                                                <line class="cls-1" x1="723.09" y1="130.59" y2="130.59" />
                                                <line class="cls-1" x1="723.09" y1="130.59" y2="130.59" />
                                                <path class="cls-2" d="M612.2,117.9" transform="translate(-21.64 -107.51)" />
                                                <path class="cls-3" d="M612.2,117.9" transform="translate(-21.64 -107.51)" />
                                                <path class="cls-1" d="M511.18,175.42" transform="translate(-21.64 -107.51)" />
                                                <path class="cls-1" d="M383.19,308.63" transform="translate(-21.64 -107.51)" />
                                                <polyline class="cls-1" points="600.63 9.92 723.09 131.89 600.63 251.25" />
                                            </svg>
                                        </AppLink>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>

                    <div v-if="posts.data && posts.data.length === 0" class="pxl-no-posts">
                        <p>No blog posts found.</p>
                    </div>

                    <div v-if="posts.links && posts.links.length > 3" class="pxl-pagination-wrap">
                        <nav class="pxl-pagination">
                            <template v-for="link in posts.links" :key="link.label">
                                <AppLink
                                    v-if="link.url"
                                    :href="link.url"
                                    class="page-numbers"
                                    :class="{ current: link.active }"
                                    v-html="link.label" />
                                <span
                                    v-else
                                    class="page-numbers dots"
                                    v-html="link.label" />
                            </template>
                        </nav>
                    </div>
                </main>
            </div>

            <div id="pxl-sidebar-area" class="pxl-sidebar-area pxl-sidebar-blog col-12 col-lg-4">
                <div class="pxl-sidebar-sticky">
                    <section id="pxl_elementor_box-3" class="widget widget_pxl_elementor_box">
                        <div class="elementor elementor-455">
                            <section class="elementor-section elementor-top-section elementor-element elementor-element-903e2ae elementor-section-boxed elementor-section-height-default elementor-section-height-default pxl-row-scroll-none pxl-zoom-point-false pxl-section-overflow-visible pxl-section-fix-none pxl_parallax_bg_img_noise-none pxl-bg-color-none pxl-section-overlay-none">
                                <div class="elementor-container elementor-column-gap-default">
                                    <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-a354939 pxl-column-none pxl-column-overflow-hidden-no pxl-column-zoom-no">
                                        <div class="elementor-widget-wrap elementor-element-populated">
                                            <div class="elementor-element elementor-element-2e43bc4 elementor-widget elementor-widget-pxl_image">
                                                <div class="elementor-widget-container">
                                                    <div class="pxl-image-single df pxl-disable-parallax-sm">
                                                        <div class="pxl-item--inner">
                                                            <div class="pxl-item--image df">
                                                                <img
                                                                    width="1627"
                                                                    height="1626"
                                                                    src="/assets/images/cropped_circle_image-2.png"
                                                                    class="no-lazyload attachment-full"
                                                                    alt="Ramil Veliiev" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-c8171b6 elementor-widget elementor-widget-pxl_heading">
                                                <div class="elementor-widget-container">
                                                    <div class="pxl-heading px-sub-title-default style-default-style">
                                                        <div class="pxl-heading--inner">
                                                            <h6 class="pxl-item--title style-default highlight-default">Ramil Veliiev</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="elementor-element elementor-element-fc6ddbc elementor-widget elementor-widget-pxl_text_editor">
                                                <div class="elementor-widget-container">
                                                    <div class="pxl-text-editor">
                                                        <div class="pxl-item--inner">
                                                            <p>DCK Construction Editor Post Blog</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </section>

                    <section id="categories-2" class="widget widget_categories">
                        <h2 class="widget-title"><span>Categories</span></h2>
                        <div class="widget-content">
                            <ul>
                                <li
                                    v-for="cat in categories"
                                    :key="cat.category"
                                    class="cat-item">
                                    <a href="#">{{ cat.category }}</a>
                                </li>
                            </ul>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import AppLink from '@/Components/AppLink.vue';

defineProps({
    posts: {
        type: Object,
        default: () => ({ data: [], links: [], meta: {} }),
    },
    categories: {
        type: Array,
        default: () => [],
    },
});
</script>
