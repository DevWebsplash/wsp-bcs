<?php
/**
 * Footer template
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */
?>

<!--STICKY CALLBACK-->
<div class="sticky-callback">
  <div class="btn-callback">
    <img src="<?php echo get_template_directory_uri (); ?>/assets/images/icons/icon-11.svg" alt="Open modal">
    <img src="<?php echo get_template_directory_uri (); ?>/assets/images/icons/close-01.svg" alt="Close modal">
  </div>

  <div class="tooltip">Need A quick response? We’re here to help</div>

  <div class="form">
    <div class="form__head">
      <div class="icon"><img src="<?php echo get_template_directory_uri (); ?>/assets/images/icons/icon-11.svg" alt=""></div>
      <div>Get a callback</div>
    </div>
    <div class="form__body">
      <div class="text">Leave your contact information at this form and we’ll contact you to help you as soon as possible</div>
      <?php echo do_shortcode('[contact-form-7 id="f193e7f" title="Get a callback"]') ?>
    </div>
    <?php include get_template_directory() . '/includes/partials/form-thank-you.php'; ?>
  </div>
</div>

<a href="#top" class="to-top">
  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/chevron-down-3.svg" alt="To top button">
</a>
</main>

<?php if (!is_page_template (array('templates/get-quote.php'))) { ?>
  <footer class="footer">
    <div class="cn">
      <div class="footer__main">
        <div class="footer__info">
          <div class="title"><?php echo get_field ('footer_info_title', 'option'); ?></div>
          <?php echo get_field ('footer_info', 'option'); ?>
        </div>
        <nav class="footer__nav">
          <?php
          wp_nav_menu (array(
              'theme_location' => 'footer_first',
              'container' => false,
          )); ?>
          <?php
          wp_nav_menu (array(
              'theme_location' => 'footer_second',
              'container' => false,
          )); ?>
        </nav>
        <div class="footer__actions">
          <?php if (have_rows ('footer_actions', 'option')): ?>
            <?php while (have_rows ('footer_actions', 'option')) : the_row (); ?>
              <?php $image_repeater = get_sub_field ('icon'); ?>
              <a href="<?php echo get_sub_field ('link'); ?>" class="item">
                <span class="icon"><img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>" loading="lazy" alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>"></span>
                <span><?php echo get_sub_field ('title'); ?></span>
                <span class="arrow"><img src="<?php echo get_template_directory_uri (); ?>/assets/images/icons/chevron-right.svg" loading="lazy" alt=""></span>
              </a>
            <?php endwhile; ?>
          <?php endif; ?>
        </div>
      </div>

      <div class="footer__bottom">
        <div class="links">
          <?php if (have_rows ('footer_bottom_links', 'option')): ?>
            <?php while (have_rows ('footer_bottom_links', 'option')) : the_row (); ?>
              <?php
              $link = get_sub_field ('link');
              if ($link):
                $link_url = $link[ 'url' ];
                $link_title = $link[ 'title' ];
                $link_target = $link[ 'target' ] ? $link[ 'target' ] : '_self';
                ?>
                <a href="<?php echo esc_url ($link_url); ?>"<?php echo esc_attr ($link_target); ?>><?php echo esc_html ($link_title); ?></a>
              <?php endif; ?>
            <?php endwhile; ?>
          <?php endif; ?>
        </div>
        <div class="copyright"><?php echo get_field ('copyright', 'option'); ?></div>
      </div>
    </div>
  </footer>
<?php } ?>
</div>

<!--<div class="reset-vehicle">-->
<!--  <div class="reset-vehicle-btn btn btn-4">Reset cache</div>-->
<!--</div>-->

<?php wp_footer (); ?>

</body>
</html>
