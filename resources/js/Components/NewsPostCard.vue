<template>
    <!-- Maiko blog-grid card (.pxl-blog-grid-layout1): image + category badge, date, excerpt, read-more -->
    <article class="pxl-post--inner news-card">
        <div class="pxl-post--featured news-card__media">
            <a
                class="news-card__media-link"
                :href="post.permalink"
                target="_blank"
                rel="noopener noreferrer"
                tabindex="-1"
                aria-hidden="true">
                <img
                    v-if="showImage"
                    class="no-lazyload"
                    :src="post.image_url"
                    :alt="post.image_alt"
                    :loading="eager ? 'eager' : 'lazy'"
                    :fetchpriority="eager ? 'high' : 'auto'"
                    decoding="async"
                    @error="imageFailed = true" />
                <span v-else class="news-card__placeholder">
                    <i :class="platformIcon" aria-hidden="true"></i>
                </span>
            </a>

            <span v-if="typeIcon" class="news-card__type" aria-hidden="true">
                <i :class="typeIcon"></i>
            </span>

            <div class="pxl-post--category">
                <a :href="post.permalink" target="_blank" rel="noopener noreferrer" tabindex="-1" aria-hidden="true">
                    <i :class="platformIcon" aria-hidden="true"></i>{{ post.platform_label }}
                </a>
            </div>
        </div>

        <div class="pxl-post--holder news-card__body">
            <div class="pxl-post--meta news-card__meta">
                <time class="post-date" :datetime="post.published_at">{{ post.published_label }}</time>
            </div>

            <p v-if="post.caption" class="pxl-post--content news-card__caption">{{ post.caption }}</p>

            <div class="news-card__footer">
                <a class="btn--readmore news-card__cta" :href="post.permalink" target="_blank" rel="noopener noreferrer">
                    <span>View on {{ post.platform_label }}</span>
                    <span class="screen-reader-text">(opens in a new tab)</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="17" height="17" aria-hidden="true">
                        <path d="m12 2-1.4 1.4 5.6 5.6h-16.2v2h16.2l-5.6 5.6 1.4 1.4 8-8z" fill="currentColor" />
                    </svg>
                </a>
            </div>
        </div>
    </article>
</template>

<script setup>
import { computed, ref, watch } from 'vue';

const props = defineProps({
    post: { type: Object, required: true },
    eager: { type: Boolean, default: false },
});

const PLATFORM_ICONS = {
    linkedin: 'fab fa-linkedin-in',
    instagram: 'fab fa-instagram',
};

const TYPE_ICONS = {
    video: 'fas fa-play',
    carousel: 'fas fa-clone',
};

// Remote fallback URLs can expire — swap to the themed placeholder instead of a broken image
const imageFailed = ref(false);

watch(() => props.post.image_url, () => {
    imageFailed.value = false;
});

const showImage = computed(() => Boolean(props.post.image_url) && ! imageFailed.value);
const platformIcon = computed(() => PLATFORM_ICONS[props.post.platform] ?? 'fas fa-newspaper');
const typeIcon = computed(() => (showImage.value ? TYPE_ICONS[props.post.media_type] ?? null : null));
</script>

<style scoped>
.news-card {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.news-card__media {
    aspect-ratio: 1 / 1;
    background-color: #f1f2eb;
}

.news-card__media-link {
    display: block;
    width: 100%;
    height: 100%;
}

.news-card__media img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
}

.news-card:hover .news-card__media img {
    transform: scale(1.04);
}

.news-card__placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    font-size: 64px;
    color: rgba(17, 17, 17, 0.22);
}

.news-card__type {
    position: absolute;
    top: 17px;
    right: 17px;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background-color: #fff;
    color: #111;
    font-size: 13px;
    pointer-events: none;
}

.news-card .pxl-post--category a i {
    margin-right: 8px;
}

.news-card__body {
    display: flex;
    flex-direction: column;
    flex: 1 1 auto;
}

.news-card__meta {
    margin-top: 24px;
}

.news-card__caption {
    margin: 0;
    white-space: pre-line;
    overflow-wrap: anywhere;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.news-card__footer {
    margin-top: auto;
}

/* Theme capitalises every word; keep platform names as written */
.news-card .news-card__footer a.btn--readmore {
    text-transform: none;
}

.news-card .news-card__footer a.btn--readmore:hover {
    color: #3e68ff;
}

@media (max-width: 767px) {
    .news-card__meta {
        margin-top: 20px;
    }
}
</style>
