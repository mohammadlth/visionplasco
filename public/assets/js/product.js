
var routeMap = [];

$(document).ready(function () {

    new Swiper('.swiper-product-single', {
        spaceBetween: 20,
        slidesPerView: 1,
        loop: false,
        effect: "cards",
        grabCursor: true,
        dir: 'rtl',
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },


    });

    new Swiper('.swiper-products-similar', {
        spaceBetween: 20,
        slidesPerView: 5,
        loop: false,
        dir: 'rtl',
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            100: {
                slidesPerView: 1,
                spaceBetween: 10,
            },
            800: {
                slidesPerView: 2,
                spaceBetween: 12,
            },
            900: {
                slidesPerView: 2,
                spaceBetween: 13,
            },
            1000: {
                slidesPerView: 3,
                spaceBetween: 15,
            },
            1500: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            2500: {
                slidesPerView: 3,
                spaceBetween: 20,
            }
        },
    })

})
