<?php
/**
 * Style functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

/**
 * Enqueue theme styles.
 */
function wp_theme_styles() {

	/**
	 * Set a script handle prefix based on theme name.
	 * Note that this should be the same as the `themePrefix` var set in your Gulpfile.js.
	 */
	$theme_handle_prefix = 'bcs';

	wp_enqueue_style( $theme_handle_prefix . '-styles', get_template_directory_uri() . '/assets/css/' . $theme_handle_prefix .'.min.css', array(), '2.0.0', 'all' );
	wp_enqueue_style( 'woocommerce-custom', get_template_directory_uri() . '/assets/css/woocommerce-custom.min.css', array(), '1.0.0', 'all' );
}
add_action( 'wp_enqueue_scripts', 'wp_theme_styles' );


