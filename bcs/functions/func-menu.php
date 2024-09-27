<?php
/**
 * Menu functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

/**
 * Register nav menus
 */
function gulp_wp_register_menus() {
	register_nav_menus(
		array(
			'primary' => __( 'Primary' ),
			'footer_first' => __( 'Footer first' ),
			'footer_second' => __( 'Footer second' ),
		)
	);
}
add_action( 'init', 'gulp_wp_register_menus' );
