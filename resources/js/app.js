// 1. Import default Laravel + Alpine
import "./bootstrap";

import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

// 2. Import Swiper CSS
import "swiper/css";
import "swiper/css/effect-coverflow";
import "swiper/css/pagination";

// 3. Import Swiper JS
import Swiper from "swiper/bundle";

// 4. Jalankan Swiper setelah DOM siap
document.addEventListener("DOMContentLoaded", () => {
    new Swiper(".swiper", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        spaceBetween: 50,
        slidesPerView: 2, // << ini penting
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        coverflowEffect: {
            rotate: 0,
            stretch: 0,
            depth: 100,
            modifier: 2.5,
            slideShadows: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
});
