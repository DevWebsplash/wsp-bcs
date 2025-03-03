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
//		'has_archive' => 'vehicle',
    'has_archive' => true,
		'rewrite' => array('slug' => 'vehicle', 'with_front' => false),
		'supports' => array('title', 'editor', 'custom-fields'),
    'menu_icon' => 'dashicons-car',
    'menu_position' => 10,
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
//		'has_archive' => 'portfolio',
    'has_archive' => true,
		'rewrite' => array('slug' => 'portfolio', 'with_front' => false),
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
    'menu_icon' => 'dashicons-portfolio',
    'menu_position' => 10,
	);
	register_post_type('portfolio', $args);
}
add_action('init', 'register_portfolio_cpt');


function custom_rewrite_rules() {
  // Portfolio rules stay first (highest priority)
  add_rewrite_rule('^portfolio/?$', 'index.php?post_type=portfolio', 'top');
  add_rewrite_rule('^portfolio/([^/]+)/?$', 'index.php?post_type=portfolio&name=$matches[1]', 'top');

  add_rewrite_rule('^product/?$', 'index.php?post_type=product', 'top');
  add_rewrite_rule('^product/([^/]+)/?$', 'index.php?post_type=product&name=$matches[1]', 'top');

  // Make hierarchy
  add_rewrite_rule('^([^/]+)/?$', 'index.php?taxonomy=make&term=$matches[1]', 'top');
  add_rewrite_rule('^([^/]+)/([^/]+)/?$', 'index.php?taxonomy=make&term=$matches[2]', 'top');

  // Vehicle post
  add_rewrite_rule('^([^/]+)/([^/]+)/([^/]+)/?$', 'index.php?post_type=vehicle&name=$matches[3]', 'top');

  add_rewrite_rule('^vehicle/?$', 'index.php?post_type=vehicle', 'top');

  // Location taxonomy rules
  add_rewrite_rule('^location/([^/]+)/?$', 'index.php?taxonomy=location&term=$matches[1]', 'top');
}
add_action('init', 'custom_rewrite_rules');


/**
 * Register Make Taxonomy
 */
function register_make_taxonomy() {
	$args = array(
		'label' => 'Make',
		'rewrite' => array('slug' => '', 'with_front' => false, 'hierarchical' => true),
		'hierarchical' => true,
	);
	register_taxonomy('make', array('vehicle', 'portfolio', 'product'), $args);
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


function check_and_flush_rewrite_rules() {
  // Use a transient to avoid flushing on every page load
  if (get_transient('portfolio_rules_flushed') !== 'yes') {
    flush_rewrite_rules();
    set_transient('portfolio_rules_flushed', 'yes', 120);
  }
}
add_action('init', 'check_and_flush_rewrite_rules', 99);



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
//function flush_rewrite_rules_on_activation() {
//	flush_rewrite_rules();
//}
//register_activation_hook(__FILE__, 'flush_rewrite_rules_on_activation');

//function flush_rules_after_update() {
//  flush_rewrite_rules();
//}
//register_activation_hook(__FILE__, 'flush_rules_after_update');



//function check_post_type_settings() {
//  if (current_user_can('administrator') && isset($_GET['check_cpt'])) {
//    $portfolio_settings = get_post_type_object('portfolio');
//    echo '<pre>';
//    print_r($portfolio_settings);
//    echo '</pre>';
//    exit;
//  }
//}
//add_action('init', 'check_post_type_settings', 999);
//
//function debug_portfolio_query() {
//  if (is_404() && strpos($_SERVER['REQUEST_URI'], '/portfolio/') !== false) {
//    global $wp_query, $wp_rewrite;
//
//    // Log requested URL and matching patterns
//    error_log('404 Portfolio URL: ' . $_SERVER['REQUEST_URI']);
//    error_log('WP Query vars: ' . print_r($wp_query->query_vars, true));
//    error_log('Post type: ' . get_query_var('post_type'));
//    error_log('Name: ' . get_query_var('name'));
//
//    // Check if post exists with that slug
//    $slug = basename(rtrim($_SERVER['REQUEST_URI'], '/'));
//    $post = get_page_by_path($slug, OBJECT, 'portfolio');
//    error_log('Post exists check: ' . ($post ? 'Yes, ID: '.$post->ID : 'No'));
//  }
//}
//add_action('wp', 'debug_portfolio_query');
//
//
//function print_matched_rewrite_rule() {
//  global $wp, $wp_rewrite;
//
//  if (isset($_GET['debug_matched_rule'])) {
//    $matched_rule = $wp->matched_rule;
//    $matched_query = $wp->matched_query;
//
//    echo '<pre>';
//    echo "Requested URL: " . $wp->request . "\n";
//    echo "Matched Rule: " . $matched_rule . "\n";
//    echo "Matched Query: " . $matched_query . "\n";
//    print_r($wp_rewrite->rules);
//    echo '</pre>';
//    exit;
//  }
//}
//add_action('wp', 'print_matched_rewrite_rule');
//
//function disable_custom_rewrites() {
//  if (isset($_GET['no_custom_rules'])) {
//    remove_all_actions('generate_rewrite_rules');
//  }
//}
//add_action('init', 'disable_custom_rewrites', 1);


//function check_portfolio_registration() {
//  add_action('init', function() {
//    error_log('Portfolio post type exists: ' . (post_type_exists('portfolio') ? 'yes' : 'no'));
//    error_log('Portfolio post type settings: ' . print_r(get_post_type_object('portfolio'), true));
//  }, 999);
//}
//check_portfolio_registration();
//











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
