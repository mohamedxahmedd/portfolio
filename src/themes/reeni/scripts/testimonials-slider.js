/* Testimonials carousel — loaded on demand by theme.js (only the home page needs it). */
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

export function mountTestimonials(refs) {
    return new Swiper(refs.swiper, {
        modules: [Navigation, Pagination, Autoplay],
        slidesPerView: 1,
        spaceBetween: 24,
        loop: true,
        autoplay: { delay: 6000, disableOnInteraction: false },
        pagination: { el: refs.pagination, clickable: true },
        navigation: { prevEl: refs.prev, nextEl: refs.next },
        breakpoints: {
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        },
        speed: 700,
    });
}
