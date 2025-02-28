<?php
/**
 * Custom Post Type vehicle functions
 */

/**
 * Register Custom Post Type vehicle
 */
function register_vehicle_cpt() {
	$args = array(
		'label' => 'Vehicle',
		'public' => true,
		'has_archive' => 'vehicle',
		'rewrite' => array('slug' => 'vehicle', 'with_front' => false),
		'supports' => array('title', 'editor', 'custom-fields'),
	);
	register_post_type('vehicle', $args);
}
add_action('init', 'register_vehicle_cpt');

/**
 * Register Custom Post Type Portfolio
 */
function register_portfolio_cpt() {
	$args = array(
		'label' => 'Portfolio',
		'public' => true,
		'has_archive' => 'portfolio',
		'rewrite' => array('slug' => 'portfolio', 'with_front' => false),
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
	);
	register_post_type('portfolio', $args);
}
add_action('init', 'register_portfolio_cpt');

/**
 * Register Make Taxonomy
 */
function register_make_taxonomy() {
	$args = array(
		'label' => 'Make',
		'rewrite' => array('slug' => '', 'with_front' => false, 'hierarchical' => true),
		'hierarchical' => true,
	);
	register_taxonomy('make', array('vehicle'), $args);
}
add_action('init', 'register_make_taxonomy');

/**
 * Rewrite URL structure for the taxonomy Make
 */
function make_term_link($url, $term, $taxonomy) {
	if ($taxonomy === 'make') {
		$parent = get_term($term->parent, 'make');
		if ($parent && !is_wp_error($parent)) {
			$url = home_url("/" . $parent->slug . "/" . $term->slug . "/");
		} else {
			$url = home_url("/" . $term->slug . "/");
		}
	}
	return $url;
}
add_filter('term_link', 'make_term_link', 10, 3);

/**
 * Custom rewrite rules for Vehicle and Portfolio
 */
function custom_rewrite_rules() {
	// Make hierarchy
	add_rewrite_rule('^([^/]+)/?$', 'index.php?taxonomy=make&term=$matches[1]', 'top');
	add_rewrite_rule('^([^/]+)/([^/]+)/?$', 'index.php?taxonomy=make&term=$matches[2]', 'top');

	// Vehicle post
	add_rewrite_rule('^([^/]+)/([^/]+)/([^/]+)/?$', 'index.php?post_type=vehicle&name=$matches[3]', 'top');

	add_rewrite_rule('^vehicle/?$', 'index.php?post_type=vehicle', 'top');
}
add_action('init', 'custom_rewrite_rules');

/**
 * Custom permalink structure for Vehicle
 */
function vehicle_permalink_structure($post_link, $post) {
	if ('vehicle' === get_post_type($post)) {
		$terms = get_the_terms($post->ID, 'make');
		if ($terms && !is_wp_error($terms)) {
			$hierarchy = array();
			foreach ($terms as $term) {
				$hierarchy[$term->term_id] = $term;
			}
			usort($hierarchy, function ($a, $b) {
				return $a->parent - $b->parent;
			});
			$make_slug = isset($hierarchy[0]) ? $hierarchy[0]->slug : 'no-make';
			$make_child_slug = isset($hierarchy[1]) ? $hierarchy[1]->slug : '';
			return home_url("/{$make_slug}/" . (!empty($make_child_slug) ? "{$make_child_slug}/" : '') . "{$post->post_name}/");
		}
	}
	return $post_link;
}
add_filter('post_type_link', 'vehicle_permalink_structure', 10, 2);



/**
 * Flush rewrite rules on activation
 */
function flush_rewrite_rules_on_activation() {
	flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'flush_rewrite_rules_on_activation');


function register_location_taxonomy() {
	$labels = array(
		'name' => 'Locations',
		'singular_name' => 'Location',
		'search_items' => 'Search Locations',
		'all_items' => 'All Locations',
		'parent_item' => 'Parent Location',
		'parent_item_colon' => 'Parent Location:',
		'edit_item' => 'Edit Location',
		'update_item' => 'Update Location',
		'add_new_item' => 'Add New Location',
		'new_item_name' => 'New Location Name',
		'menu_name' => 'Locations',
	);

	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
		'show_in_quick_edit' => true,
		'show_admin_column' => true,
		'rewrite' => array(
			'slug' => 'location',
			'with_front' => false,
		),
		'has_archive' => true, // Enable archive for the taxonomy
	);

	// Register the taxonomy for the 'portfolio' post type
	register_taxonomy('location', array('portfolio'), $args);
}
add_action('init', 'register_location_taxonomy');
