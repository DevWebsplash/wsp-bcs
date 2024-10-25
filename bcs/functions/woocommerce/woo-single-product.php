<?php
/**
 * Single Product functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

add_filter ('woocommerce_short_description', 'appendQuoteBtnToDescription', 10);

function appendQuoteBtnToDescription ($description)
{
  global $product;

  // Перевіряємо, чи це не варіація продукту
  if (has_term ('brake-caliper-paint-kits', 'product_cat') && is_single ($product->get_id ())) {
    $base_url = get_site_url ();
    $buttonText = '<div class="btn-wrapper"><a href="' . $base_url . '/get-quote/" class="btn btn-8 btn-quote" target="_blank" rel="noopener"><span class="text">Don’t want to paint your own brakes?<small>Get a price from us here.</small></span></a></div>';

    return $description . $buttonText;
  }

  return $description;
}
