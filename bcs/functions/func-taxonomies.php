<?php
/**
 * Custom Post Type vehicle functions
 */

/**
 * Register Custom Post Type vehicle
 */

function register_vehicle_cpt() {
	$labels = array(
		'name' => 'Vehicles',
		'singular_name' => 'Vehicle',
	);

	$args = array(
		'label' => 'Vehicle',
		'public' => true,
		'rewrite' => array('slug' => '/%make%', 'with_front' => false),  // Custom permalink structure

		'has_archive' => 'vehicle',
		'supports' => array('title', 'editor', 'custom-fields'),
	);

	register_post_type('vehicle', $args);
}
add_action('init', 'register_vehicle_cpt');

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
		'rewrite' => array('slug' => '', 'hierarchical' => true),  // Make archive URL will be under /vehicle/
		'hierarchical' => true,
	);

	// Register 'make' taxonomy for 'vehicle', 'portfolio', and 'product' post types
	register_taxonomy('make', array('vehicle', 'portfolio', 'product'), $args);
    }
add_action('init', 'register_make_taxonomy');

// Custom rewrite rules for vehicle
function custom_vehicle_rewrite_rules() {
	// Add rewrite rule for single vehicle posts
	add_rewrite_rule(
		'^([^/]+)/([^/]+)/([^/]+)/?$',
		'index.php?post_type=vehicle&make=$matches[1]&vehicle=$matches[3]',
		'top'
	);

	// Add rewrite rule for make taxonomy archives
	add_rewrite_rule(
		'^([^/]+)/([^/]+)/?$',
		'index.php?make=$matches[2]',
		'top'
	);
      }
add_action('init', 'custom_vehicle_rewrite_rules');

// Adjust the vehicle post type permalinks
function vehicle_permalink_structure($post_link, $post) {
	if ('vehicle' === get_post_type($post)) {
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

			// Update permalink structure
			$post_link = str_replace('%make%', "$make/$child", $post_link);
		} else {
			$post_link = str_replace('%make%', 'no-make', $post_link);
		}
    }

	return $post_link;
  }
add_filter('post_type_link', 'vehicle_permalink_structure', 10, 2);

// Flush rewrite rules after registration
function flush_vehicle_rewrite_rules() {
	register_vehicle_cpt();
	register_make_taxonomy();
	flush_rewrite_rules(); // Ensure that WordPress updates the rewrite rules
}
add_action('init', 'flush_vehicle_rewrite_rules', 20);


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
