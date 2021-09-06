

document.addEventListener("DOMContentLoaded", function () {
    // createProduct();

    var swiper = new Swiper(".swiper-products", {
        slidesPerView: 1,
        spaceBetween: 0,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {

            480: {
                slidesPerView: 2,
                spaceBetween: 5,
            },
            600: {
                slidesPerView: 2,
                spaceBetween: 5,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 5,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 40,
            },
            1366: {
                slidesPerView: 4,
                spaceBetween: 50,
            },
        },
    });
});

