<?php
/**
 * Global functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */


// WooCommerce Support
add_action('after_setup_theme', 'woocommerce_support');
function woocommerce_support() {
  add_theme_support('woocommerce');
//  add_theme_support('wc-product-gallery-zoom');
  add_theme_support('wc-product-gallery-lightbox');
  add_theme_support('wc-product-gallery-slider');
}


function custom_sidebars() {
  register_sidebar( array(
      'name'          => __( 'Shop Sidebar', 'textdomain' ),
      'id'            => 'shop-sidebar', // This ID should match what you're checking with `is_active_sidebar()`
      'description'   => __( 'Widgets in this area will be shown on the shop pages.', 'textdomain' ),
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
  ) );
}
add_action( 'widgets_init', 'custom_sidebars' );

// Remove default WooCommerce wrappers
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// Add custom WooCommerce wrappers
function woo_custom_wrapper_start() {
  $sidebar = get_sidebar();
  $has_sidebar = is_active_sidebar( 'shop-sidebar' );
//  var_dump ($has_sidebar, $sidebar);
  if ( $has_sidebar ) {
    echo '<div class="cn cn-sidebar"><div id="primary" class="content-area"><main id="main" class="site-main" role="main">';
  } else {
    echo '<div class="cn"><div id="primary" class="content-area"><main id="main" class="site-main" role="main">';
  }
}

function woo_custom_wrapper_end() {
  $sidebar = get_sidebar();
  $has_sidebar = is_active_sidebar( 'shop-sidebar' );

  // Closing content-area, container, and my-custom-wrapper divs.
  if ( $has_sidebar ) {
    echo '</main></div>';
    echo $sidebar;
    echo '</div>';
  } else {
    echo '</main></div></div>';
  }
}

add_action( 'woocommerce_before_main_content', 'woo_custom_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'woo_custom_wrapper_end', 10 );


