<?php
/*
Template Name: Contact Us

*/
get_header();
?>
<div class="cn">
  <header class="section-heading section-heading--gaps-lg">
    <h1 class="title h2"><?php the_title(); ?></h1>

<!--    <p>Feel free to upload images/video to assist with your enquiry using the upload tool below.</p>-->
  </header>

</div>
<section class="s-contact">
  <div class="cn">
    <div class="s-contact__inner">
      <div class="s-contact__info">
        <div class="section-heading">
          <h2 class="title h3">Contact Information</h2>

        </div>
        <div class="info">
          <?php echo get_field ('footer_info', 'option'); ?>
        </div>
        <div class="map">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2407.504121676445!2d-1.287096486365831!3d52.885345372043005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4879e8f3ad762499%3A0x3528ea48ee002cb6!2sBrake%20Caliper%20Specialists%20Limited!5e0!3m2!1suk!2sua!4v1728725459556!5m2!1suk!2sua" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
      <div class="s-contact__form">
        <div class="section-heading">
          <h2 class="title h3">Fill free to contact us!</h2>
          <div class="subtitle"><p>We`ll respond within 1 business hour, usually within 20 minutes. </p></div>
        </div>
        <div class="form form--relative">
          <?php the_content(); ?>
          <?php include get_template_directory() . '/includes/partials/form-thank-you.php'; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
