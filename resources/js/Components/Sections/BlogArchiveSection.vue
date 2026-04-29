<template>
    <div class="container">
        <div class="row pxl-content-wrap pxl-has-sidebar pxl-sidebar-right">
            <div id="pxl-content-area" class="pxl-content-area pxl-content-blog col-12 col-lg-8">
                <main id="pxl-content-main">
                    <article
                        v-for="post in posts"
                        :key="post.href"
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
                                                :src="post.image"
                                                :alt="post.title"
                                                decoding="async" />
                                        </AppLink>
                                        <div class="pxl-video-popup">
                                            <div class="content-inner">
                                                <a class="video-play-button pxl-action-popup" :href="post.videoUrl">
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
                                <div class="post-excerpt"></div>
                                <div class="post-bottom">
                                    <div class="post-metas">
                                        <div class="meta-inner">
                                            <span class="post-author">
                                                <span class="icon-post"><i class="fas fa-user"></i></span>
                                                <span>By <a href="#" title="Posts by Ramil Veliiev" rel="author">Ramil Veliiev</a></span>
                                            </span>
                                            <span class="post-category">
                                                <span class="icon-post"><i class="fas fa-tag"></i></span>
                                                <span><a href="#" rel="tag">YouTube</a></span>
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
                                                    <div class="pxl-image-single df pxl-disable-parallax-sm pxl-hide-sr-lg">
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
                                <li class="cat-item cat-item-1"><a href="#">YouTube</a></li>
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

const posts = [
    {
        title: 'Conversation with the CEO | DCK Construction',
        href: '/blog/conversation-with-the-ceo-dck-construction',
        image: '/assets/images/Screenshot-2026-02-10-083321-810x385.png',
        videoUrl: 'https://www.youtube.com/watch?v=YHdujsohPMs',
    },
    {
        title: 'DCK Construction: Newham Voids Works Overview',
        href: '/blog/dck-construction-newham-voids-works-overview',
        image: '/assets/images/Screenshot-2026-02-10-082902-810x385.png',
        videoUrl: 'https://www.youtube.com/watch?v=N5nPA0qzZBY',
    },
    {
        title: 'DCK Construction Working with Camden Council | Fire Door Installation',
        href: '/blog/dck-construction-working-with-camden-council-fire-door-installation',
        image: '/assets/images/Screenshot-2026-01-06-161416-810x385.png',
        videoUrl: 'https://www.youtube.com/watch?v=iIU15suqnR0',
    },
    {
        title: 'Kitchen & Bathroom Renewal Programme - Delivering Quality Upgrades for Haringey Homes',
        href: '/blog/kitchen-bathroom-renewal-programme-delivering-quality-upgrades-for-haringey-homes',
        image: '/assets/images/Screenshot-2026-01-06-161032-810x385.png',
        videoUrl: 'https://www.youtube.com/watch?v=GJm6oqf9_bE',
    },
];
</script>
