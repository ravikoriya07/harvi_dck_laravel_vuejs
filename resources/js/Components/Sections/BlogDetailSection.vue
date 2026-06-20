<template>
    <div class="container">
        <div class="top-metas">
            <div class="metas-left">
                <h2 class="pxl-item--title">{{ post.title }}</h2>
                <div class="post-metas">
                    <div class="meta-inner align-items-center">
                        <span class="post-author align-items-center">
                            <span class="icon-post"><i class="fas fa-user"></i></span>
                            <span>By {{ post.author }}</span>
                        </span>
                        <span class="pxl-item--date">
                            <span class="icon-post"><i class="fas fa-calendar"></i></span>
                            {{ post.published_at }}
                        </span>
                        <span class="post-category align-items-center">
                            <span class="icon-post"><i class="fas fa-tag"></i></span>
                            <a href="#" rel="tag">{{ post.category }}</a>
                        </span>
                        <span class="post-comments align-items-center">
                            <span class="icon-post"><i class="fas fa-comment"></i></span>
                            <a href="#comments"><span>No Comments</span></a>
                        </span>
                    </div>
                </div>
            </div>
            <div v-if="post.video_url" class="pxl-icon-postformat">
                <div class="format-wrap">
                    <div class="link-icon">
                        <div class="pxl-video-popup">
                            <div class="content-inner">
                                <a class="video-play-button pxl-action-popup" :href="post.video_url">
                                    <i class="fas fa-play"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row pxl-content-wrap pxl-has-sidebar pxl-sidebar-right">
            <div id="pxl-content-area" class="pxl-content-area pxl-content-post col-12 col-lg-8">
                <main id="pxl-content-main">
                    <article class="pxl-single-post post type-post status-publish format-video has-post-thumbnail hentry category-youtube post_format-post-format-video">
                        <div class="single-post-inner has-post-thumbnail">
                            <div v-if="post.image_url" class="post-image post-featured">
                                <img :src="post.image_url" :alt="post.title" width="810" height="385" />
                            </div>
                            <div class="post-content">
                                <div class="content-inner clearfix">
                                    <div v-if="post.content" v-html="post.content"></div>
                                    <p v-else-if="post.excerpt">{{ post.excerpt }}</p>
                                </div>
                                <div class="navigation page-links clearfix empty-none"></div>
                            </div>
                            <div class="pxl-el-divider"></div>
                            <div class="post-tags-share d-flex">
                                <div class="post-tags-wrap"></div>
                                <div class="post-share-wrap">
                                    <div class="post-shares align-items-center">
                                        <span class="label"><i class="fas fa-share-alt"></i> Share</span>
                                        <div class="social-share">
                                            <div class="social">
                                                <a class="pxl-icon" title="Facebook" target="_blank" rel="noopener noreferrer" :href="shareUrls.facebook">
                                                    <i class="fab fa-facebook-f"></i>
                                                </a>
                                                <a class="pxl-icon" title="Twitter" target="_blank" rel="noopener noreferrer" :href="shareUrls.twitter">
                                                    <span class="fab fa-twitter"></span>
                                                </a>
                                                <a class="pxl-icon" title="LinkedIn" target="_blank" rel="noopener noreferrer" :href="shareUrls.linkedin">
                                                    <i class="fab fa-linkedin-in"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pxl-el-divider"></div>
                        </div>
                    </article>

                    <div id="comments" class="comments-area">
                        <div id="respond" class="comment-respond">
                            <h3 id="reply-title" class="comment-reply-title">Leave A Comment</h3>
                            <form class="comment-form" @submit.prevent>
                                <div class="row">
                                    <div class="col-12 notice-f">
                                        Your email address will not be published. Required fields are marked *
                                    </div>
                                    <div class="cm-divider comment-form-author col-lg-6 col-md-6 col-sm-12">
                                        <input type="text" placeholder="*Your Name" />
                                        <div class="ip-divider"></div>
                                    </div>
                                    <div class="cm-divider comment-form-email col-lg-6 col-md-6 col-sm-12">
                                        <input type="text" placeholder="*Your Email" />
                                        <div class="ip-divider"></div>
                                    </div>
                                    <p class="comment-form-cookies-consent">
                                        <input id="blog-comment-cookies-consent" type="checkbox" value="yes" />
                                        <label for="blog-comment-cookies-consent">
                                            Save my name, email, and website in this browser for the next time I comment.
                                        </label>
                                    </p>
                                    <div class="cm-divider comment-form-comment">
                                        <textarea cols="45" rows="8" placeholder="Write comment..." aria-required="true"></textarea>
                                        <div class="ip-divider"></div>
                                    </div>
                                    <p class="form-submit">
                                        <button type="submit" class="btn-submit">Post Comment</button>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </main>
            </div>

            <div id="pxl-sidebar-area" class="pxl-sidebar-area pxl-sidebar-post col-12 col-lg-4">
                <div class="pxl-sidebar-sticky">
                    <section class="widget widget_pxl_elementor_box">
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
                                                                    src="/assets/images/cropped_circle_image-2.avif"
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

                    <section class="widget widget_categories">
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
import { computed } from 'vue';

const props = defineProps({
    post: {
        type: Object,
        default: () => ({}),
    },
    categories: {
        type: Array,
        default: () => [],
    },
});

const shareUrls = computed(() => {
    const pageUrl = encodeURIComponent(`https://thedck.com/blog/${props.post.slug || ''}`);
    const text = encodeURIComponent(props.post.title || '');
    return {
        facebook: `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`,
        twitter: `https://twitter.com/intent/tweet?url=${pageUrl}&text=${text}`,
        linkedin: `https://www.linkedin.com/sharing/share-offsite/?url=${pageUrl}`,
    };
});
</script>
