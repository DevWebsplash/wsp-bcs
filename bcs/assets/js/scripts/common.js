jQuery(function ($) {
  'use strict';

  //anchors scroll
  let anchorOffset = $(window).width() > 992 ? 80 : 40;
  $(function () {
    $('a[href*="#"]:not([href="#"]):not(.open-popup)').on('click', function () {
      if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
        let target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

        if (target.length) {
          $('html, body').animate({
            scrollTop: target.offset().top - anchorOffset
          }, 1000);
          return false;
        }
      }
    });
  });

  // Toggle menu
  $('.toggle-menu').on('click', function () {
    $(this).toggleClass('active');
    $('.header__nav').slideToggle(300);
  });

  // Main menu icon click
  $('.main-menu').on('click', '.icon', function () {
    $(this).closest('li').toggleClass('active');
    $(this).next('ul').slideToggle(300);
  });

  // Accordion
  $('.acc-head').on('click', function () {
    let $accItem = $(this).closest('.acc-item');
    if (!$accItem.hasClass('active')) {
      $('.acc-item.active .acc-body').slideUp(300).closest('.acc-item').removeClass('active');
      $accItem.addClass('active').find('.acc-body').slideDown(300);
    } else {
      $accItem.removeClass('active').find('.acc-body').slideUp(300);
    }
  });

  // Form item label hover
  $('.form-item--label .wpcf7-form-control').on('focus blur', function (e) {
    $(this).closest('.form-item--label').toggleClass('hover', e.type === 'focus' || $(this).val().length > 0);
  });

  // Update field styles
  const updateFieldStyles = () => {
    if (!document.querySelector('.quote-form')) return;
    $('form.wpcf7-form').find('input, select, textarea').each(function () {
      $(this).closest('.form-item').toggleClass('filled', !!$(this).val());
    });
  };
  updateFieldStyles();

  // Form submission success handling
  document.addEventListener('wpcf7mailsent', function (event) {
    const form = event.target;
    if (form.closest('.sticky-callback')) {
      const formBody = $(form).closest('.form__body');
      const formThanks = $(formBody).next('.form__thanks');
      $(formBody).hide();
      $(formThanks).show();
    }
    if (form.closest('.s-contact__form') || form.closest('.form--relative')) {
      const formBody = form.closest('.wpcf7');
      console.log('formBody ', formBody, 'form ', form);
      $(formBody).hide();

      const formThanks = $(formBody).next('.form__thanks');
      console.log('formBody ', formBody, 'formThanks ', formThanks);
      $(formThanks).addClass('visible').show();
    }
  }, false);

  // Custom select
  $('.custom-select select').SumoSelect({
    search: true,
    searchText: 'Enter here...',
    forceCustomRendering: true
  });

  // To top button
  const toTop = $('.to-top');
  if(toTop.length) {
    let lastScrollTop = 0;
    $(window).on('scroll', function () {
      let scrollTop = $(this).scrollTop();
      if (scrollTop > lastScrollTop || !(scrollTop > 100)) {
        toTop.removeClass('show').fadeOut('normal');
      } else {
        toTop.addClass('show').fadeIn('normal');cd
      }
      lastScrollTop = scrollTop;
    });

    toTop.on('click', function () {
      $('html, body').animate({scrollTop: 0}, 800);
      return false;
    });
  }


  // Sticky callback
  const btnCallback = $('.btn-callback');
  const stickyCallback = () => {
    const topOffset = $(window).height() / 2;
    const bottomOffset = $(document).height() - $(window).height() * 2;
    const scrollTop = $(window).scrollTop();

    const isVisible = scrollTop > topOffset && scrollTop < bottomOffset;
    $('.sticky-callback').toggleClass('visible', isVisible);
    if (!isVisible) {
      btnCallback.removeClass('active');
      $('.sticky-callback .form').removeClass('visible');
    }
  };
  $(window).on('scroll', stickyCallback);

  btnCallback.on('click', function () {
    $(this).toggleClass('active');
    $('.sticky-callback .form').toggleClass('visible');
  });

  // Overflow text
  $('.overflow-text-cn').each(function () {
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
      th.find('.overflow-text').css('height', $(this).hasClass('active') ? innerTextHeight + 'px' : textHeight + 'px');
    });
  });

  // Swiper slider initialization
  const initSwiper = (selector, options) => new Swiper(selector, options);

  initSwiper('.testimonials-slider', {
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
      768: {slidesPerView: 2},
      991: {slidesPerView: 3},
    },
  });

  initSwiper('.articles-slider', {
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
      768: {slidesPerView: 2},
      991: {slidesPerView: 3},
    },
  });

  initSwiper('.cooperation-slider', {
    slidesPerView: 1,
    spaceBetween: 30,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
  });

  // Popup gallery
  $('.popup-gallery').magnificPopup({
    delegate: 'a',
    type: 'image',
    tLoading: 'Loading image #%curr%...',
    mainClass: 'mfp-img-mobile',
    gallery: {
      enabled: true,
      navigateByImgClick: true,
      preload: [0, 1]
    },
    image: {
      tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
      titleSrc: function (item) {
        return item.el.attr('title') + ' by Marsel Van Oosten';
      }
    }
  });

  // 404 animation
  if (document.body.classList.contains('error404')) {
    window.onload = function () {
      document.querySelector('.cont_principal').className = "cont_principal cont_error_active";
    };
  }
});
