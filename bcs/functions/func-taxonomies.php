<?php
/**
 * Custom Post Type vehicle functions
 */

/**
 * Register Custom Post Type vehicle
 */
// Реєстрація Vehicle CPT
function register_vehicle_cpt() {
	$labels = array(
		'name' => 'Vehicles',
		'singular_name' => 'Vehicle',
	);

	$args = array(
		'label' => 'Vehicle',
		'public' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => 'vehicle', 'with_front' => false),
		'supports' => array('title', 'editor', 'custom-fields'),
	);

	register_post_type('vehicle', $args);
}
add_action('init', 'register_vehicle_cpt');

function add_vehicle_archive_body_class($classes) {
  if (is_post_type_archive('vehicle') || is_singular('vehicle') || (is_tax('make') && is_tax('make', array('vehicle')))) {
    $classes[] = 'vehicle-archive';
  } elseif (is_tax('make')) {
    $queried_object = get_queried_object();
    if ($queried_object && isset($queried_object->taxonomy) && $queried_object->taxonomy === 'make') {
      $post_types = get_taxonomy('make')->object_type;
      if (in_array('vehicle', $post_types)) {
        $classes[] = 'vehicle-archive';
      }
    }
  }
  return $classes;
}
add_filter('body_class', 'add_vehicle_archive_body_class');

// Register Portfolio Custom Post Type
function register_portfolio_cpt() {
	$labels = array(
		'name' => 'Portfolios',
		'singular_name' => 'Portfolio',
	);

	$args = array(
		'label' => 'Portfolio',
		'public' => true,
		'rewrite' => array('slug' => 'portfolio', 'with_front' => false),
		'has_archive' => true,
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
	);

	register_post_type('portfolio', $args);
}
add_action('init', 'register_portfolio_cpt');

// Register Custom Taxonomy Make and associate with multiple post types
function register_make_taxonomy() {
	$labels = array(
		'name' => 'Makes',
		'singular_name' => 'Make',
	);

	$args = array(
		'label' => 'Make',
		'rewrite' => array('slug' => '', 'hierarchical' => true),
		'hierarchical' => true,
	);

	register_taxonomy('make', array('vehicle', 'portfolio', 'product'), $args);
}
add_action('init', 'register_make_taxonomy');

// Видалення /make/ зі структури URL
function remove_make_slug_from_term_link($url, $term, $taxonomy) {
	if ($taxonomy === 'make') {
		$url = str_replace('/make/', '/', $url);
	}
	return $url;
}
add_filter('term_link', 'remove_make_slug_from_term_link', 10, 3);

// Переписані правила
function custom_vehicle_rewrite_rules() {
	// Архів vehicle
	add_rewrite_rule('^vehicle/?$', 'index.php?post_type=vehicle', 'top');

	// Таксономія make (без /make/)
	add_rewrite_rule('^([^/]+)/?$', 'index.php?taxonomy=make&term=$matches[1]', 'top');
	add_rewrite_rule('^([^/]+)/([^/]+)/?$', 'index.php?taxonomy=make&term=$matches[2]&make_parent=$matches[1]', 'top');

	// Окремі vehicle пости (make/make-child/post-name)
	add_rewrite_rule('^([^/]+)/([^/]+)/([^/]+)/?$', 'index.php?post_type=vehicle&name=$matches[3]', 'top');
}
add_action('init', 'custom_vehicle_rewrite_rules');

// Фільтр на URL
function vehicle_permalink_structure($post_link, $post) {
	if ('vehicle' === get_post_type($post) && !empty($post->ID)) {
		$terms = get_the_terms($post->ID, 'make');

		if ($terms && !is_wp_error($terms)) {
			$parent_term = null;
			$child_term = null;

			foreach ($terms as $term) {
				if ($term->parent == 0) {
					$parent_term = $term;
				} else {
					$child_term = $term;
				}
			}

			$make = $parent_term ? $parent_term->slug : 'no-make';
			$child = $child_term ? $child_term->slug : 'no-model';

			return home_url('/' . $make . '/' . $child . '/' . $post->post_name . '/');
		} else {
			return home_url('/no-make/no-model/' . $post->post_name . '/');
		}
	}
	return $post_link;
}
add_filter('post_type_link', 'vehicle_permalink_structure', 10, 2);





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
