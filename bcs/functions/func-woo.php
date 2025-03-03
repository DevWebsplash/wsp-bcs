<?php
/**
 * Woocommerce functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

add_action( 'after_setup_theme', 'woocommerce_support' );

require_once 'woocommerce/woo-global.php';
require_once 'woocommerce/woo-cart.php';
require_once 'woocommerce/woo-checkout.php';
require_once 'woocommerce/woo-single-product.php';
