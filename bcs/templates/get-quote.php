<?php
/*
Template Name: Get Quote
*/
get_header();
?>
<div class="cn">
  <header class="section-heading section-heading--gaps-lg">
    <h1 class="title h1"><?php the_title(); ?></h1>
    <div class="subtitle"><p>Browse our selection of high-quality brake calipers.</p></div>
  </header>
  <div class="form--relative">
    <?php
    the_content();
    include get_template_directory() . '/includes/partials/form-thank-you.php'; ?>
    </div>
</div>
<?php get_footer(); ?>
