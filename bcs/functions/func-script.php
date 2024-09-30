<?php
/**
 * Script functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

/**
 * Enqueue theme scripts
 */
function gulp_wp_theme_scripts() {

	/**
	 * Set a script handle prefix based on theme name.
	 * Note that this should be the same as the `themePrefix` var set in your Gulpfile.js.
	 */
	$theme_handle_prefix = 'bcs';

	/**
	 * Enqueue common scripts.
	 */
//  wp_enqueue_script( 'locomotive', 'https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1/dist/locomotive-scroll.min.js', array('jquery' ), '1.0', true );

  /**
   * Pages with carousel.
   */
//  if (is_page_template(array('templates/knowledge.php', 'journal.php'))) {
//    wp_enqueue_script( 'slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery' ), '1.0', true );
//  }

  wp_enqueue_script( $theme_handle_prefix . '-scripts', get_template_directory_uri() . '/assets/js/' .
      $theme_handle_prefix . '.min.js', array( 'jquery' ), '1.0.17', true );

  wp_enqueue_script('ajax-fetch', get_template_directory_uri() .
      '/assets/js/ajax-fetch.js', array('jquery'), '1.0.9', true);
  wp_enqueue_script('get-quote', get_template_directory_uri() .
      '/assets/js/get-quote-form.js', array('jquery'), '1.0.25', true);
}
add_action( 'wp_enqueue_scripts', 'gulp_wp_theme_scripts' );



