<?php get_header();
/* Template Name: Home */
?>

  <section class="b-hero align-center text-center">
    <div class="cn cn--lg">
      <h1 class="b-hero__title"><?php the_field( 'header_title1' ); ?></h1>
      <p><?php the_field( 'header_subtitle1' ); ?></p>
      <a class="btn btn-white" href="<?php the_field( 'header_button_link1' ); ?>"><?php the_field( 'header_button_title1' ); ?></a>
    </div>
  </section>


<?php get_footer(); ?>
