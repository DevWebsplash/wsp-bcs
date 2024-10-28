<?php
/**
 * Script functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  BCS
 */

/**
 * Enqueue theme scripts
 */
function gulp_wp_theme_scripts() {
	$theme_handle_prefix = 'bcs';

  wp_enqueue_script( $theme_handle_prefix . '-scripts', get_template_directory_uri() . '/assets/js/' .
      $theme_handle_prefix . '.min.js', array( 'jquery' ), '1.0.51', true );

  wp_enqueue_script('ajax-fetch', get_template_directory_uri() .
      '/assets/js/ajax-fetch.js', array('jquery'), '1.0.65', true);
  wp_enqueue_script('get-quote', get_template_directory_uri() .
      '/assets/js/get-quote-form.js', array('jquery'), '1.0.97', true);
}
add_action( 'wp_enqueue_scripts', 'gulp_wp_theme_scripts' );



