<?php
/*
Template Name: Get Quote
*/
get_header();
?>
<a class="popup-modal open-popup-keep-vehicle hidden" href="#popup-keep-vehicle">Open modal</a>
<div id="popup-keep-vehicle" class="popup-dialog popup-box mfp-fade mfp-hide">
  <div class="content popup-box__content">
    <div class="heading">
      <div class="h2 align-center">Is this your vehicle?</div>
    </div>
    <div class="content-inner">
      <p class="js-get__make"><b>Make:</b> </p>
      <p class="js-get__model"><b>Model:</b> </p>
      <p class="js-get__trim"><b>Trim:</b> </p>
      <p class="align-center description" style="margin-top: 20px;">We use this information to personalize your experience.</p>
      <div class="btn-group">
        <button class="btn btn-2 btn--reset">Reset</button>
        <button class="btn btn-1 btn-keep-vehicle btn--save">Yes</button>
<!--        <button class="btn btn-1 btn-keep-vehicle">I will enter the data myself</button>-->
      </div>
    </div>
  </div>
</div>

<div class="cn page__get-quote">
  <header class="section-heading section-heading--gaps-lg">
    <h1 class="title h1"><?php the_title(); ?></h1>
    <div class="subtitle"><p>Browse our selection of high-quality brake calipers.</p></div>

    <div class="process-line">
      <div class="process-line__item active">
          <div class="process-line__icon">
            <svg width="110" height="110" viewBox="0 0 110 110" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M22.9167 96.2502C20.3958 96.2502 18.2386 95.3534 16.445 93.5597C14.6514 91.7661 13.7531 89.6074 13.75 87.0835V22.9168C13.75 20.396 14.6483 18.2388 16.445 16.4452C18.2417 14.6516 20.3989 13.7532 22.9167 13.7502H42.1667C43.1597 11.0002 44.8219 8.78488 47.1533 7.10433C49.4847 5.42377 52.1003 4.5835 55 4.5835C57.8997 4.5835 60.5168 5.42377 62.8513 7.10433C65.1857 8.78488 66.8464 11.0002 67.8333 13.7502H87.0833C89.6042 13.7502 91.7629 14.6485 93.5596 16.4452C95.3563 18.2418 96.2531 20.3991 96.25 22.9168V87.0835C96.25 89.6043 95.3532 91.7631 93.5596 93.5597C91.766 95.3564 89.6072 96.2532 87.0833 96.2502H22.9167ZM22.9167 87.0835H87.0833V22.9168H22.9167V87.0835ZM32.0833 77.9168H64.1667V68.7502H32.0833V77.9168ZM32.0833 59.5835H77.9167V50.4168H32.0833V59.5835ZM32.0833 41.2502H77.9167V32.0835H32.0833V41.2502ZM55 19.4793C55.9931 19.4793 56.815 19.1539 57.4658 18.5031C58.1167 17.8522 58.4406 17.0318 58.4375 16.0418C58.4344 15.0518 58.109 14.2314 57.4613 13.5806C56.8135 12.9297 55.9931 12.6043 55 12.6043C54.0069 12.6043 53.1865 12.9297 52.5388 13.5806C51.891 14.2314 51.5656 15.0518 51.5625 16.0418C51.5594 17.0318 51.8849 17.8538 52.5388 18.5077C53.1926 19.1616 54.0131 19.4854 55 19.4793Z" fill="black"/>
            </svg>
          </div>
          <div class="process-line__text">Get Refurb Price</div>
      </div>
      <div class="process-line__spacer"></div>
      <div class="process-line__item">
        <div class="process-line__icon">
          <svg width="110" height="110" viewBox="0 0 110 110" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M50.4167 99.5728V57.6353L13.75 36.4373V73.2186C13.75 74.8991 14.1518 76.4269 14.9554 77.8019C15.759 79.1769 16.885 80.2846 18.3333 81.1248L50.4167 99.5728ZM59.5833 99.5728L91.6667 81.1248C93.1181 80.2846 94.2456 79.1769 95.0492 77.8019C95.8528 76.4269 96.253 74.8991 96.25 73.2186V36.4373L59.5833 57.6353V99.5728ZM77.8021 36.5519L91.3229 28.6457L59.5833 10.4269C58.1319 9.58664 56.6042 9.1665 55 9.1665C53.3958 9.1665 51.8681 9.58664 50.4167 10.4269L41.3646 15.5832L77.8021 36.5519ZM55 49.729L68.6354 41.9373L32.3125 20.854L18.5625 28.7603L55 49.729Z" fill="black"/>
          </svg>
        </div>
        <div class="process-line__text">BCS collects calipers from customer</div>
      </div>
      <div class="process-line__spacer"></div>
      <div class="process-line__item">
        <div class="process-line__icon">
          <svg width="110" height="110" viewBox="0 0 110 110" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M24.429 14.9964C27.2887 13.9766 30.3791 13.7893 33.3411 14.4563C36.3031 15.1233 39.015 16.6171 41.1616 18.7642C43.3082 20.9113 44.8015 23.6235 45.4678 26.5857C46.1341 29.5478 45.9461 32.6382 44.9256 35.4977L94.6319 85.2039L84.9061 94.9298L35.1998 45.2235C32.3396 46.2439 29.2485 46.4314 26.2859 45.7644C23.3233 45.0973 20.6109 43.603 18.464 41.4551C16.3172 39.3073 14.8241 36.5943 14.1583 33.6314C13.4926 30.6685 13.6815 27.5775 14.7031 24.7177L24.9515 34.9706C26.2481 36.2229 27.9847 36.9159 29.7874 36.9002C31.59 36.8846 33.3143 36.1615 34.589 34.8869C35.8637 33.6122 36.5867 31.8878 36.6024 30.0852C36.618 28.2826 35.9251 26.546 34.6727 25.2494L24.429 14.9964ZM71.9444 23.6269L86.5286 15.5235L93.0094 22.0089L84.9061 36.5931L76.8027 38.211L67.0861 47.9323L60.6006 41.4514L70.3219 31.7302L71.9444 23.6269ZM39.5356 59.276L49.2569 69.0019L26.5694 91.6894C25.3183 92.9287 23.6393 93.6408 21.8787 93.6786C20.1181 93.7165 18.4101 93.0773 17.1069 91.8928C15.8037 90.7084 15.0047 89.069 14.8747 87.3128C14.7447 85.5565 15.2936 83.8174 16.4081 82.4539L16.8527 81.9635L39.5356 59.276Z" fill="black"/>
          </svg>
        </div>
        <div class="process-line__text">Working on it</div>
      </div>
      <div class="process-line__spacer"></div>
      <div class="process-line__item">
        <div class="process-line__icon">
          <svg width="110" height="110" viewBox="0 0 110 110" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M80.4377 55.0002L64.1668 38.7293L70.6981 32.3127L80.4377 42.0522L99.9168 22.5731L106.334 29.1043L80.4377 55.0002ZM41.2502 55.0002C36.2085 55.0002 31.8925 53.205 28.3023 49.6147C24.712 46.0245 22.9168 41.7085 22.9168 36.6668C22.9168 31.6252 24.712 27.3092 28.3023 23.7189C31.8925 20.1286 36.2085 18.3335 41.2502 18.3335C46.2918 18.3335 50.6078 20.1286 54.1981 23.7189C57.7884 27.3092 59.5835 31.6252 59.5835 36.6668C59.5835 41.7085 57.7884 46.0245 54.1981 49.6147C50.6078 53.205 46.2918 55.0002 41.2502 55.0002ZM4.5835 91.6668V78.8335C4.5835 76.2363 5.25266 73.8499 6.591 71.6743C7.92933 69.4988 9.70461 67.8365 11.9168 66.6877C16.6529 64.3196 21.4654 62.5443 26.3543 61.3618C31.2432 60.1793 36.2085 59.5865 41.2502 59.5835C46.2918 59.5804 51.2571 60.1732 56.146 61.3618C61.0349 62.5504 65.8474 64.3257 70.5835 66.6877C72.7988 67.8335 74.5756 69.4957 75.9139 71.6743C77.2523 73.8529 77.9199 76.2393 77.9168 78.8335V91.6668H4.5835Z" fill="black"/>
          </svg>
        </div>
        <div class="process-line__text">BCS Ships back to customer</div>
      </div>
    </div>
  </header>
<!--  <div class="form--relative">-->
  <div class="">
    <?php
    the_content();
    include get_template_directory() . '/includes/partials/form-thank-you.php'; ?>
  </div>
</div>
<?php get_footer(); ?>
