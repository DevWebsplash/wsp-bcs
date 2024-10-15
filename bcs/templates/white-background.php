<?php
/*
Template Name: White Background | Secondary

*/
get_header();
?>
<div class="cn">
  <header class="section-heading section-heading--gaps-lg">
    <h1 class="title h1"><?php the_title(); ?></h1>
    <?php if ( is_page( 99 ) ) {
//      echo '<div class="subtitle"><p>We`ll respond within 1 business hour, usually within 20 minutes. Feel free to upload images/video to assist with your enquiry using the upload tool below.</p></div>';
    } else {
      echo '<div class="subtitle"><p>Browse our selection of high-quality brake calipers.</p></div>';
    } ?>
  </header>
  <?php if ( is_page( 147959 ) ) {
    echo '<div class="form--relative">';
    the_content();
    include get_template_directory() . '/includes/partials/form-thank-you.php';
    echo '</div>';
  } else {
    the_content();
  } ?>
</div>
<?php get_footer(); ?>
