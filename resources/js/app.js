import './bootstrap';
import Swiper from 'swiper';
import { Navigation, Autoplay } from 'swiper/modules';

// Initialize product sliders
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.product-slider').forEach((el, index) => {
        const swiperEl = el.querySelector('.swiper');
        const prevEl = el.querySelector('.swiper-button-prev');
        const nextEl = el.querySelector('.swiper-button-next');
        const paginationEl = el.querySelector('.swiper-pagination');

        new Swiper(swiperEl, {
            modules: [Navigation, Autoplay],
            slidesPerView: 1,
            spaceBetween: 16,
            navigation: {
                prevEl: prevEl,
                nextEl: nextEl,
            },
            pagination: {
                el: paginationEl,
                clickable: true,
            },
            autoplay: {
                delay: 4000,
                disableOnInteraction: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                },
            },
        });
    });
});