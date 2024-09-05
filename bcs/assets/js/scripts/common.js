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

    //callback button
    const btnCallback = $('.btn-callback');
    const stickyCallback = () => {
        let topOffset = ($(window).height())/2;
        let bottomOffset = $(document).height() - ($(window).height())*2;

        if ($(window).scrollTop() > topOffset && $(window).scrollTop() < bottomOffset) {
            $('.sticky-callback').addClass('visible');
        } else {
            $('.sticky-callback').removeClass('visible');
        }
    }

    stickyCallback();
    $(window).scroll(stickyCallback);

    btnCallback.on('click', function() {
        $(this).toggleClass('active');
        $('.sticky-callback .form').toggleClass('visible');
    });

    //overflow text
    $('.overflow-text-cn').each(function() {
        let th = $(this);
        let btn = th.find('.btn');
        let textHeight = th.find('.overflow-text').height();
        let innerTextHeight = th.find('.text').height();

        if (textHeight >= innerTextHeight) {
            th.find('.overflow-text').css('height', innerTextHeight + 'px');
            btn.hide();
        }

        btn.on('click', function () {
            $(this).toggleClass('active');

            if ($(this).hasClass('active')) {
                th.find('.overflow-text').css('height', innerTextHeight + 'px');
            } else {
                th.find('.overflow-text').css('height', textHeight + 'px');
            }
        });
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

    const swiper2 = new Swiper('.articles-slider', {
        slidesPerView: 1,
        spaceBetween: 30,
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
