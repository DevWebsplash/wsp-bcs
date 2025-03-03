<?php
/**
 * Single Product functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

add_filter ('woocommerce_short_description', 'appendQuoteBtnToDescription', 10);

function appendQuoteBtnToDescription($description) {
  global $product;

  // Ensure the global variable $product is set and is an object
  if (!is_object($product)) {
    error_log('[' . date('d-M-Y H:i:s T') . '] Error: $product is not an object in woo-single-product.php.');
    return $description; // Return original description instead of recursively calling
  }

  // Now it is safe to use $product methods
  $product_id = $product->get_id();

  // Перевіряємо, чи це не варіація продукту
  if (has_term('brake-caliper-paint-kits', 'product_cat') && is_single($product->get_id())) {
    $base_url = get_site_url();
    $buttonText = '<div class="btn-wrapper"><a href="' . $base_url . '/get-quote/" class="btn btn-8 btn-quote" target="_blank" rel="noopener"><span class="text">Don’t want to paint your own brakes?<small>Get a price from us here.</small></span></a></div>';

    return $description . $buttonText;
  }

  return $description;
}
