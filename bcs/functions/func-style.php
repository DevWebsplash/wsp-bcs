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

	wp_enqueue_style( $theme_handle_prefix . '-styles', get_template_directory_uri() .
      '/assets/css/' . $theme_handle_prefix .'.min.css', array(), '1.2.30', 'all' );
//      '/assets/css/' . $theme_handle_prefix .'.min.css', array(), '1.0.46', 'all' );
	wp_enqueue_style( 'woocommerce-custom', get_template_directory_uri() .
      '/assets/css/woocommerce-custom.min.css', array(), '1.0.92', 'all' );
}
add_action( 'wp_enqueue_scripts', 'wp_theme_styles' );


/**
 * Set WooCommerce image dimensions upon theme activation
 */
// Remove each style one by one
add_filter( 'woocommerce_enqueue_styles', 'jk_dequeue_styles' );
function jk_dequeue_styles( $enqueue_styles ) {
  unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
  unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
//  unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
  return $enqueue_styles;
}

// Or just remove them all in one line
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

// Customize ACF components look
function my_custom_acf() {
  echo '
  <style>
    .acf-flexible-content .layout {
      border: 2px solid #8c8f94;
      background: #fff;
      border-radius: 5px;
    }
    .acf-flexible-content .layout .acf-fc-layout-handle {
      background: #c5c5c5;
      color: #444;
      font-weight: bold;
    }
    .acf-flexible-content .layout .acf-fc-layout-order {
      background: #2d2d2d;
      color: #fff;
    }
  </style>
  ';
};
add_action('admin_head', 'my_custom_acf');
