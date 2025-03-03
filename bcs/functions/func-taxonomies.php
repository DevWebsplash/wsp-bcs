<?php
/**
 * BCS Custom Post Types and Taxonomies Manager
 *
 * Оптимізована версія на основі рекомендацій для:
 * - Покращення логування
 * - Оптимізації продуктивності
 * - Обробки помилок та структуризації коду
 *
 * @package BCS
 */

namespace BCS;

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Захист від прямого доступу
}

/**
 * Class CPTManager
 *
 * Реєструє Custom Post Types.
 */
class CPTManager {
  public function __construct() {
    add_action( 'init', [ $this, 'register_vehicle_cpt' ], 8 );
    add_action( 'init', [ $this, 'register_portfolio_cpt' ], 8 );
  }

  public function register_vehicle_cpt() {
    $args = [
        'label'         => 'Vehicle',
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'vehicle', 'with_front' => false ],
        'supports'      => [ 'title', 'editor', 'custom-fields' ],
        'menu_icon'     => 'dashicons-car',
        'menu_position' => 10,
    ];
    register_post_type( 'vehicle', $args );
  }

  public function register_portfolio_cpt() {
    $args = [
        'label'         => 'Portfolio',
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'portfolio', 'with_front' => false ],
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'menu_icon'     => 'dashicons-portfolio',
        'menu_position' => 10,
    ];
    register_post_type( 'portfolio', $args );
  }
}

/**
 * Class RewriteManager
 *
 * Реєструє rewrite-правила та оновлює permalink‑структуру.
 */
class RewriteManager {
  public function __construct() {
    add_action( 'init', [ $this, 'add_custom_rewrite_rules' ], 10 );
    add_action( 'init', [ $this, 'check_and_flush_rewrite_rules' ], 99 );
    add_filter( 'post_type_link', [ $this, 'vehicle_permalink_structure' ], 10, 2 );
    add_action( 'template_redirect', [ $this, 'debug_product_category_404' ], 1 );
  }

  public function add_custom_rewrite_rules() {
    // Правила для Portfolio (найвищий пріоритет)
    add_rewrite_rule( '^portfolio/?$', 'index.php?post_type=portfolio', 'top' );
    add_rewrite_rule( '^portfolio/([^/]+)/?$', 'index.php?post_type=portfolio&name=$matches[1]', 'top' );

    // Правила для Product
    add_rewrite_rule( '^product/?$', 'index.php?post_type=product', 'top' );
    add_rewrite_rule( '^product/([^/]+)/?$', 'index.php?post_type=product&name=$matches[1]', 'top' );

    // Правила для Product Category
    add_rewrite_rule( '^products/([^/]+)/?$', 'index.php?product_cat=$matches[1]', 'top' );
    add_rewrite_rule( '^products/([^/]+)/page/([0-9]{1,})/?$', 'index.php?product_cat=$matches[1]&paged=$matches[2]', 'top' );

    // Архів для Vehicle
    add_rewrite_rule( '^vehicle/?$', 'index.php?post_type=vehicle', 'top' );

    // Правила для Location Taxonomy
    add_rewrite_rule( '^location/([^/]+)/?$', 'index.php?taxonomy=location&term=$matches[1]', 'top' );

    // Правила для ієрархії Make - мають бути останні, оскільки охоплюють інші випадки
    add_rewrite_rule( '^([^/]+)/?$', 'index.php?taxonomy=make&term=$matches[1]', 'top' );
    add_rewrite_rule( '^([^/]+)/([^/]+)/?$', 'index.php?taxonomy=make&term=$matches[2]', 'top' );
    add_rewrite_rule( '^([^/]+)/([^/]+)/([^/]+)/?$', 'index.php?post_type=vehicle&name=$matches[3]', 'top' );
  }

  public function check_and_flush_rewrite_rules() {
    if ( get_transient( 'portfolio_rules_flushed' ) !== 'yes' ) {
      // Оновлюємо permalink‑структуру для примусової перегенерації правил
      update_option( 'permalink_structure', get_option( 'permalink_structure' ) );
      // Кешуємо оновлення на 24 години
      set_transient( 'portfolio_rules_flushed', 'yes', 86400 );
    }
  }

  public function vehicle_permalink_structure( $post_link, $post ) {
    if ( 'vehicle' === get_post_type( $post ) ) {
      $terms = get_the_terms( $post->ID, 'make' );
      if ( $terms && ! is_wp_error( $terms ) ) {
        $hierarchy = [];
        foreach ( $terms as $term ) {
          $hierarchy[ $term->term_id ] = $term;
        }
        usort( $hierarchy, function( $a, $b ) {
          return $a->parent - $b->parent;
        } );
        $make_slug       = isset( $hierarchy[0] ) ? $hierarchy[0]->slug : 'no-make';
        $make_child_slug = isset( $hierarchy[1] ) ? $hierarchy[1]->slug : '';
        return home_url( "/{$make_slug}/" . ( ! empty( $make_child_slug ) ? "{$make_child_slug}/" : '' ) . "{$post->post_name}/" );
      }
    }
    return $post_link;
  }

  public function debug_product_category_404() {
    global $wp, $wp_query, $wp_rewrite;

    if ( is_404() && strpos( $_SERVER['REQUEST_URI'], '/products/' ) !== false ) {
      $log_time = date( 'd-M-Y H:i:s T' );
      error_log( "[{$log_time}] Debugging 404 for: " . $_SERVER['REQUEST_URI'] );
      error_log( "[{$log_time}] WP Query vars: " . print_r( $wp_query->query_vars, true ) );

      $slug = basename( rtrim( $_SERVER['REQUEST_URI'], '/' ) );
      $term = get_term_by( 'slug', $slug, 'product_cat' );
      error_log( "[{$log_time}] Product category exists: " . ( $term ? 'yes' : 'no' ) );
      if ( $term ) {
        error_log( "[{$log_time}] Category info: " . print_r( $term, true ) );
      }

      $matched_rules = [];
      foreach ( $wp_rewrite->rules as $rule => $query ) {
        if ( strpos( $query, 'product_cat' ) !== false ) {
          $matched_rules[ $rule ] = $query;
        }
      }
      error_log( "[{$log_time}] Product category rewrite rules: " . print_r( $matched_rules, true ) );
    }
  }
}

/**
 * Class TaxonomyManager
 *
 * Реєструє таксономії та змінює посилання для таксономії Make.
 */
class TaxonomyManager {
  public function __construct() {
    add_action( 'init', [ $this, 'register_make_taxonomy' ] );
    add_action( 'init', [ $this, 'register_location_taxonomy' ] );
    add_filter( 'term_link', [ $this, 'make_term_link' ], 10, 3 );
  }

  public function register_make_taxonomy() {
    $args = [
        'label'        => 'Make',
        'rewrite'      => [ 'slug' => '', 'with_front' => false, 'hierarchical' => true ],
        'hierarchical' => true,
    ];
    register_taxonomy( 'make', [ 'vehicle', 'portfolio', 'product' ], $args );
  }

  public function register_location_taxonomy() {
    $labels = [
        'name'          => 'Locations',
        'singular_name' => 'Location',
        'search_items'  => 'Search Locations',
        'all_items'     => 'All Locations',
        'parent_item'   => 'Parent Location',
        'parent_item_colon' => 'Parent Location:',
        'edit_item'     => 'Edit Location',
        'update_item'   => 'Update Location',
        'add_new_item'  => 'Add New Location',
        'new_item_name' => 'New Location Name',
        'menu_name'     => 'Locations',
    ];

    $args = [
        'labels'             => $labels,
        'hierarchical'       => true,
        'public'             => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'show_tagcloud'      => true,
        'show_in_quick_edit' => true,
        'show_admin_column'  => true,
        'rewrite'            => [ 'slug' => 'location', 'with_front' => false ],
        'has_archive'        => true,
    ];

    register_taxonomy( 'location', [ 'portfolio' ], $args );
  }

  public function make_term_link( $url, $term, $taxonomy ) {
    if ( 'make' === $taxonomy ) {
      $parent = get_term( $term->parent, 'make' );
      if ( $parent && ! is_wp_error( $parent ) ) {
        $url = home_url( "/" . $parent->slug . "/" . $term->slug . "/" );
      } else {
        $url = home_url( "/" . $term->slug . "/" );
      }
    }
    return $url;
  }
}

/**
 * Class LogManager
 *
 * Забезпечує розширене логування для налагодження.
 */
class LogManager {
  /**
   * Логування результатів операцій trim.
   *
   * @param array  $trim_data Дані trim.
   * @param string $context   Контекст логування.
   */
  public static function log_trim_result( $trim_data, $context = '' ) {
    $log_level = 'DEBUG';
    $log_time  = date( 'd-M-Y H:i:s T' );
    error_log( "[{$log_time}] [{$log_level}] [{$context}] Trim fetch: " . ( count( $trim_data ) > 0 ? count( $trim_data ) . " results" : "No results" ) );

    if ( defined( 'WP_DEBUG_TRIM' ) && constant('WP_DEBUG_TRIM') ) {
      error_log( "[{$log_time}] [{$log_level}] [{$context}] Data: " . json_encode( array_slice( $trim_data, 0, 3 ), JSON_PRETTY_PRINT ) );
    }
  }

  /**
   * Розширене логування із зазначенням контексту, рівня та ідентифікатора запиту.
   *
   * @param string $message Повідомлення для логування.
   * @param array  $data    Додаткові дані.
   * @param string $level   Рівень логування (наприклад, INFO, DEBUG, ERROR).
   */
  public static function enhanced_logging( $message, $data = [], $level = 'INFO' ) {
    if ( ! defined( 'WP_DEBUG' ) || ! constant('WP_DEBUG') ) {
      return;
    }

    $request_id = isset( $_SERVER['HTTP_X_REQUEST_ID'] ) ? $_SERVER['HTTP_X_REQUEST_ID'] : uniqid( 'req-' );
    $log_time   = date( 'd-M-Y H:i:s T' );
    $log_entry  = sprintf(
        "[{$log_time}] [%s] [%s] %s %s",
        strtoupper( $level ),
        $request_id,
        $message,
        ! empty( $data ) ? json_encode( $data, JSON_PARTIAL_OUTPUT_ON_ERROR ) : ''
    );
    error_log( $log_entry );
  }
}

// Ініціалізація менеджерів
new CPTManager();
new RewriteManager();
new TaxonomyManager();
