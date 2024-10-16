<?php
/**
 * CheckOut functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

add_filter( 'the_title', 'woo_title_order_received', 10, 2 );

function woo_title_order_received( $title, $id ) {
  if ( function_exists( 'is_order_received_page' ) &&
      is_order_received_page() && get_the_ID() === $id ) {
    $title = "Thank you for your order! :)";
  }
  return $title;
}

add_filter('woocommerce_thankyou_order_received_text', 'woo_change_order_received_text', 10, 2 );
function woo_change_order_received_text( $str, $order ) {
  $new_str = str_replace('Thank you. ', '', $str) . '';
  return $new_str;
}
