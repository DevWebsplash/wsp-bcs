<?php
/**
 * Global functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

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


