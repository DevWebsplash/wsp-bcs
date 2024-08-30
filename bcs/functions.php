<?php
/**
 * Theme functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

require_once 'functions/func-admin.php';
//require_once 'functions/func-debug.php';
require_once 'functions/func-menu.php';
require_once 'functions/func-script.php';
require_once 'functions/func-style.php';
//require_once 'functions/func-ajax.php';

//require_once 'functions/func-plugin-bootload.php';


// Register Custom Post Type vehicle
function register_vehicle_cpt() {
	$labels = array(
		'name' => 'Vehicles',
		'singular_name' => 'Vehicle',
	);

	$args = array(
		'label' => 'Vehicle',
		'public' => true,
		'rewrite' => array('slug' => 'vehicle/%make%', 'with_front' => false),  // Custom permalink structure
		'has_archive' => true,
		'supports' => array('title', 'editor', 'custom-fields'),
	);

	register_post_type('vehicle', $args);
}
add_action('init', 'register_vehicle_cpt');

// Register Custom Taxonomy Make
function register_make_taxonomy() {
	$labels = array(
		'name' => 'make',
		'singular_name' => 'Make',
	);

	$args = array(
		'label' => 'Make',
		'rewrite' => array('slug' => 'make', 'hierarchical' => true),
		'hierarchical' => true,
	);

	register_taxonomy('make',  array( 'portfolio', 'product', 'vehicle' ), $args);
}
add_action('init', 'register_make_taxonomy');

function custom_vehicle_rewrite_rules() {
	add_rewrite_rule(
		'^vehicle/([^/]+)/([^/]+)/([^/]+)/?$',
		'index.php?vehicle=$matches[3]',
		'top'
	);
}
add_action('init', 'custom_vehicle_rewrite_rules');

function vehicle_permalink_structure($post_link, $post) {
	if ('vehicle' === get_post_type($post)) {
		$terms = get_the_terms($post->ID, 'make'); // Get terms for the 'make' taxonomy

		if ($terms && !is_wp_error($terms)) {
			$parent_term = null;
			$child_term = null;

			// Identify parent and child terms
			foreach ($terms as $term) {
				if ($term->parent == 0) {
					$parent_term = $term;
				} else {
					$child_term = $term;
				}
			}

			// Set parent and child terms for the permalink structure
			$make = $parent_term ? $parent_term->slug : 'no-make';
			$child = $child_term ? $child_term->slug : 'no-model';
			$post_link = str_replace('%make%', "$make/$child", $post_link);
		} else {
			// Fallback if no terms are found
			$post_link = str_replace('%make%', 'no-make', $post_link);
		}
	}

	return $post_link;
}
add_filter('post_type_link', 'vehicle_permalink_structure', 10, 2);

function flush_vehicle_rewrite_rules() {
	register_vehicle_cpt();
	register_make_taxonomy();
	flush_rewrite_rules();
}
add_action('init', 'flush_vehicle_rewrite_rules', 20);
