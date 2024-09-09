<?php
/**
 * Admin functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

/**
 * Credit in admin footer
 */
//function gulp_wp_admin_footer() {
//	echo 'Developed by <a href="http://author.com" target="_blank" rel="noreferrer noopener">Author Name</a>';
//}
//add_filter( 'admin_footer_text', 'gulp_wp_admin_footer' );


/**
 * Change default greeting
 */
function gulp_wp_greeting( $wp_admin_bar ) {
	$user_id = get_current_user_id();
	$current_user = wp_get_current_user();
	$profile_url = get_edit_profile_url( $user_id );

	if ( 0 !== $user_id ) {
		$avatar = get_avatar( $user_id, 28 );
		$howdy = sprintf( __( 'Hi, %1$s' ), $current_user->display_name );
		$class = empty( $avatar ) ? '' : 'with-avatar';

		$wp_admin_bar->add_menu(array(
			'id' => 'my-account',
			'parent' => 'top-secondary',
			'title' => $howdy . $avatar,
			'href' => $profile_url,
			'meta' => array(
				'class' => $class,
			),
		));
	}
}
add_action( 'admin_bar_menu', 'gulp_wp_greeting', 11 );

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
}


function woocommerce_support() {
  add_theme_support( 'woocommerce' );
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

