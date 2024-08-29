jQuery(function($) {
    'use strict';

    //header
    $('.toggle-menu').on('click', function () {
        $(this).toggleClass('active');
        $('.header__nav').slideToggle(300);
    });
    $('.main-menu .icon').on('click', function () {
        $(this).closest('li').toggleClass('active');
        $(this).next('ul').slideToggle(300);
    });

    //accordeon
    $('.acc-head').on('click', function () {
        $(this).closest('.acc-item').toggleClass('active').find('.acc-body').slideToggle(300);
    });

    //select
    $('.custom-select select').SumoSelect({
        search: true,
        searchText: 'Enter here...',
        forceCustomRendering: true
    });

    //slider
    const swiper1 = new Swiper('.testimonials-slider', {
        slidesPerView: 1,
        spaceBetween: 35,
        navigation: {
            prevEl: '.swiper-button-prev',
            nextEl: '.swiper-button-next',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
            },
            991: {
                slidesPerView: 3,
            },
        },
    });
});
