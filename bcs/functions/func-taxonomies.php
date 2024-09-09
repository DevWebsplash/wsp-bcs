<?php
/**
 * Custom Post Type vehicle functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
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
      'rewrite' => array( 'with_front' => false,'hierarchical' => true),
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
function custom_rewrite_rules() {
  // Register custom rewrite rules for each post type

  add_rewrite_rule('^product/make/(.+)/?', 'index.php?post_type=product&make=$matches[1]', 'top');
  add_rewrite_rule('^vehicle/make/(.+)/?', 'index.php?post_type=vehicle&make=$matches[1]', 'top');
  add_rewrite_rule('^portfolio/make/(.+)/?', 'index.php?post_type=portfolio&make=$matches[1]', 'top');
}
add_action('init', 'custom_rewrite_rules');
function custom_query_vars($query_vars) {
  $query_vars[] = 'make';
  return $query_vars;
}
add_filter('query_vars', 'custom_query_vars');

function custom_pre_get_posts($query) {
  if (!is_admin() && $query->is_main_query()) {
    if ($query->get('post_type') && $query->get('make')) {
      $taxonomy = 'make';
      $term = get_term_by('slug', $query->get('make'), $taxonomy);
      if ($term) {
        $query->set('tax_query', array(
            array(
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => $term->slug,
            ),
        ));
      }
    }
  }
}
add_action('pre_get_posts', 'custom_pre_get_posts');
