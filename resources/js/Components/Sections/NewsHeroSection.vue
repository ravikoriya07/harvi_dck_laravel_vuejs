<template>
    <!-- Inner-page hero — same treatment as Jobs / Contact / Disclaimer -->
    <section class="news-hero">
        <img
            class="news-hero-photo"
            src="/assets/images/JOB-70-of-155-scaled-1920x1280.avif"
            alt=""
            fetchpriority="high"
            loading="eager"
            decoding="async"
        />
        <div class="news-hero-overlay"></div>
        <div class="container">
            <div class="news-hero-content">
                <h1 class="news-hero-title">
                    <span class="news-hero-title-line">Latest</span>
                    <span class="news-hero-title-line">News</span>
                </h1>
                <p class="news-hero-sub">Project updates and stories from DCK Construction on LinkedIn and Instagram</p>
                <nav class="news-breadcrumb" aria-label="Breadcrumb">
                    <AppLink href="/" class="news-breadcrumb-link">Home</AppLink>
                    <span class="news-breadcrumb-sep">/</span>
                    <span class="news-breadcrumb-current">News</span>
                </nav>
            </div>
        </div>
    </section>
</template>

<script setup>
import AppLink from '@/Components/AppLink.vue';
</script>

<style scoped>
.news-hero {
    position: relative;
    min-height: clamp(380px, 52vh, 580px);
    padding: 60px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    overflow: hidden;
}

.news-hero .container {
    width: 100%;
    max-width: 100%;
}

.news-hero-photo {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    z-index: 0;
}

.news-hero-overlay {
    position: absolute;
    inset: 0;
    z-index: 1;
    pointer-events: none;
    background:
        linear-gradient(180deg, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0.15) 40%, rgba(0, 0, 0, 0.45) 100%),
        radial-gradient(ellipse 70% 60% at 50% 50%, rgba(0, 0, 0, 0.45) 0%, transparent 70%);
}

.news-hero-content {
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 14px;
    width: 100%;
}

.news-hero-title {
    font-size: 75px;
    font-weight: 700;
    color: #fff;
    margin: 0;
    letter-spacing: -0.02em;
    line-height: 1.12;
    opacity: 0;
    animation: news-hero-title-in 0.9s cubic-bezier(0.22, 1, 0.36, 1) 0.15s forwards;
}

.news-hero-title-line {
    display: block;
    text-shadow:
        0 2px 24px rgba(0, 0, 0, 0.45),
        0 1px 2px rgba(0, 0, 0, 0.35);
}

.news-hero-title-line + .news-hero-title-line {
    margin-top: 0.08em;
}

@keyframes news-hero-title-in {
    from {
        opacity: 0;
        transform: translateY(18px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.news-hero-sub {
    font-size: 17px;
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
    max-width: 560px;
    line-height: 1.55;
    text-shadow: 0 1px 12px rgba(0, 0, 0, 0.35);
}

.news-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    margin-top: 4px;
}

.news-breadcrumb-link {
    color: rgba(255, 255, 255, 0.65);
    text-decoration: none;
    transition: color 0.2s;
}

.news-breadcrumb-link:hover { color: #fff; }

.news-breadcrumb-sep { color: rgba(255, 255, 255, 0.4); }

.news-breadcrumb-current { color: rgba(255, 255, 255, 0.9); font-weight: 500; }

@media (prefers-reduced-motion: reduce) {
    .news-hero-title {
        opacity: 1;
        transform: none;
        animation: none;
    }
}

@media (max-width: 1200px) {
    .news-hero-title { font-size: 65px; }
}

@media (max-width: 1024px) {
    .news-hero {
        min-height: clamp(320px, 48vh, 500px);
    }

    .news-hero-title { font-size: 54px; }
}

@media (max-width: 768px) {
    .news-hero {
        min-height: clamp(280px, 45vh, 400px);
        padding: 40px 16px;
    }

    .news-hero-title { font-size: 34px; }
    .news-hero-sub   { font-size: 15px; }
}
</style>
