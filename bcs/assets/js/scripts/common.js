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
        let $accItem = $(this).closest('.acc-item');
        if (!$accItem.hasClass('active')) {
            console.log('not active');
            $('.acc-item.active .acc-body').slideUp(300).closest('.acc-item').removeClass('active');
            $accItem.addClass('active').find('.acc-body').slideDown(300);
        } else {
            console.log('active');
            $accItem.removeClass('active').find('.acc-body').slideUp(300);
        }
    });

    // Toggles 'hover' class on '.form-item--label' when input is focused or has a value.
    $('.form-item--label .wpcf7-form-control').on('focus blur', function (e) {
        if (e.type === 'focus' || $(this).val().length > 0) {
            $(this).closest('.form-item--label').addClass('hover');
        } else {
            $(this).closest('.form-item--label').removeClass('hover');
        }
    });
    const updateFieldStyles = () => {
        if (!document.querySelector('.quote-form')) {
            return;
        }
        $('form.wpcf7-form').find('input, select, textarea').each(function () {
            const $field = $(this);
            if ($field.val()) {
                $field.closest('.form-item').addClass('filled');
            } else {
                $field.closest('.form-item').removeClass('filled');
            }
        });
    };
    updateFieldStyles();

    document.addEventListener('wpcf7mailsent', function(event) {
        const form = event.target;
        if (form.closest('.sticky-callback')) {
            const formBody = $(form).closest('.form__body');
            const formThanks = formBody.next('.form__thanks');
            formBody.hide();
            formThanks.show();
        }
        if (form.closest('.s-contact__form') || form.closest('.form--relative')) {
            const formBody = form.closest('.wpcf7');
            console.log('form--relative', formBody);
            const formThanks = formBody.next('.form__thanks');
            formBody.hide();
            formThanks.addClass('visible').show();
        }
    }, false);


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

    const swiper3 = new Swiper('.cooperation-slider', {
        slidesPerView: 1,
        spaceBetween: 30,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });

    $('.popup-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
        },
        image: {
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
            titleSrc: function(item) {
                return item.el.attr('title') + ' by Marsel Van Oosten';
            }
        }
    });

    /*
    404 animation
   */
    if (document.body.classList.contains('error404')) {
        console.log('!!!---- 404 ----!!!');
        window.onload = function () {
            document.querySelector('.cont_principal').className = "cont_principal cont_error_active";
        }
    }
});
