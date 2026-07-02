import { onMounted, onUnmounted, ref } from 'vue';

const SWIPER_BREAKPOINTS = {
    0: { slidesPerView: 1, spaceBetween: 12 },
    576: { slidesPerView: 2, spaceBetween: 16 },
    1024: { slidesPerView: 3, spaceBetween: 20 },
};

export function useDetailGallerySwiper(galleryImages) {
    const galleryWrap = ref(null);
    const prevBtn = ref(null);
    const nextBtn = ref(null);
    const paginationEl = ref(null);
    let swiperInstance = null;

    onMounted(() => {
        if (!galleryImages.value.length || !galleryWrap.value) {
            return;
        }

        if (typeof window.Swiper === 'undefined') {
            return;
        }

        const el = galleryWrap.value.querySelector('.pd-gallery-swiper');
        const count = galleryImages.value.length;

        swiperInstance = new window.Swiper(el, {
            loop: count >= 6,
            speed: 500,
            slidesPerView: 1,
            spaceBetween: 12,
            slidesPerGroup: 1,
            watchOverflow: true,
            breakpoints: SWIPER_BREAKPOINTS,
            autoplay: count > 1
                ? { delay: 5000, disableOnInteraction: false, pauseOnMouseEnter: true }
                : false,
            navigation: {
                prevEl: prevBtn.value,
                nextEl: nextBtn.value,
            },
            pagination: count > 1 && paginationEl.value
                ? {
                    el: paginationEl.value,
                    clickable: true,
                    bulletClass: 'pd-dot',
                    bulletActiveClass: 'pd-dot--active',
                }
                : undefined,
        });
    });

    onUnmounted(() => {
        swiperInstance?.destroy(true, true);
        swiperInstance = null;
    });

    return { galleryWrap, prevBtn, nextBtn, paginationEl };
}
