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
  // Portfolio rules (highest priority)
  add_rewrite_rule('^portfolio/?$', 'index.php?post_type=portfolio', 'top');
  add_rewrite_rule('^portfolio/([^/]+)/?$', 'index.php?post_type=portfolio&name=$matches[1]', 'top');

  // Product rules (second priority)
  add_rewrite_rule('^product/?$', 'index.php?post_type=product', 'top');
  add_rewrite_rule('^product/([^/]+)/?$', 'index.php?post_type=product&name=$matches[1]', 'top');

  // Product category rules (third priority)
  add_rewrite_rule('^products/([^/]+)/?$', 'index.php?product_cat=$matches[1]', 'top');
  add_rewrite_rule('^products/([^/]+)/page/([0-9]{1,})/?$', 'index.php?product_cat=$matches[1]&paged=$matches[2]', 'top');

  // Vehicle archive
  add_rewrite_rule('^vehicle/?$', 'index.php?post_type=vehicle', 'top');

  // Location taxonomy rules
  add_rewrite_rule('^location/([^/]+)/?$', 'index.php?taxonomy=location&term=$matches[1]', 'top');

  // Make hierarchy rules - MUST BE LAST as they catch everything else
  add_rewrite_rule('^([^/]+)/?$', 'index.php?taxonomy=make&term=$matches[1]', 'top');
  add_rewrite_rule('^([^/]+)/([^/]+)/?$', 'index.php?taxonomy=make&term=$matches[2]', 'top');
  add_rewrite_rule('^([^/]+)/([^/]+)/([^/]+)/?$', 'index.php?post_type=vehicle&name=$matches[3]', 'top');
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
  if (get_transient('portfolio_rules_flushed') !== 'yes') {
    //flush_rewrite_rules();
    update_option('permalink_structure', get_option('permalink_structure'));
    set_transient('portfolio_rules_flushed', 'yes', 5600); // 1 hour
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





function debug_product_category_404() {
  global $wp, $wp_query, $wp_rewrite;

  // Only run on 404 pages with "products" in the URL
  if (is_404() && strpos($_SERVER['REQUEST_URI'], '/products/') !== false) {
    // Start logging
    error_log('[' . date('d-M-Y H:i:s T') . '] Debugging 404 for: ' . $_SERVER['REQUEST_URI']);

    // Log current query vars
    error_log('[' . date('d-M-Y H:i:s T') . '] WP Query vars: ' . print_r($wp_query->query_vars, true));

    // Check if the product category exists
    $slug = basename(rtrim($_SERVER['REQUEST_URI'], '/'));
    $term = get_term_by('slug', $slug, 'product_cat');
    error_log('[' . date('d-M-Y H:i:s T') . '] Product category exists: ' . ($term ? 'yes' : 'no'));
    if ($term) {
      error_log('[' . date('d-M-Y H:i:s T') . '] Category info: ' . print_r($term, true));
    }

    // Log the rewrite rules that might match
    $matched_rules = array();
    foreach ($wp_rewrite->rules as $rule => $query) {
      if (strpos($query, 'product_cat') !== false) {
        $matched_rules[$rule] = $query;
      }
    }
    error_log('[' . date('d-M-Y H:i:s T') . '] Product category rewrite rules: ' . print_r($matched_rules, true));
  }
}
add_action('template_redirect', 'debug_product_category_404', 1);

function log_trim_result($trim_data, $context = '') {
  $log_level = 'DEBUG'; // Can be ERROR, WARNING, INFO, DEBUG
  error_log("[" . date('d-M-Y H:i:s T') . "] [$log_level] [$context] Trim fetch: " .
      (count($trim_data) > 0 ? count($trim_data) . " results" : "No results"));

  // Only log detailed data when specifically debugging this feature
  if (defined('WP_DEBUG_TRIM') && WP_DEBUG_TRIM) {
    error_log("[" . date('d-M-Y H:i:s T') . "] [$log_level] [$context] Data: " .
        json_encode(array_slice($trim_data, 0, 3), JSON_PRETTY_PRINT));
  }
}


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
