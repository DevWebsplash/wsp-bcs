<?php
function js_variables ($wp_query)
{
  $variables = array(
      'ajax_url' => admin_url ('admin-ajax.php'),
      'current_page' => get_query_var ('paged') ? get_query_var ('paged') : 1,
//      'max_page' => $wp_query->max_num_pages
  );

  $json = json_encode ($variables);
  if (json_last_error () !== JSON_ERROR_NONE) {
    error_log ('JSON encoding error: ' . json_last_error_msg ());
  } else {
    echo '<script type="text/javascript">window.wp_data = ' . $json . ';</script>';
  }
}

add_action ('wp_head', 'js_variables');

// Function to render the vehicle search form
function render_vehicle_search_form ()
{
  ?>
  <div class="vehicles-search">
    <div class="loader" style="display: none;">Loading...</div>

    <div class="form-row">
      <div class="custom-select">
        <select class="data-make">
          <option value="">Select Make</option>
        </select>
      </div>
      <div class="custom-select">
        <select class="data-model" disabled>
          <option value="">Select Model</option>
        </select>
      </div>
      <div class="custom-select">
        <select class="data-trim" disabled>
          <option value="">Select Trim</option>
        </select>
      </div>
      <div class="btn-group">
        <a href="<?php echo get_bloginfo ('url'); ?>/vehicle/" class="btn btn-1 vehicles-search__btn">Search</a>
      </div>
    </div>
  </div>
  <?php
}

// Function to get "Make" options for dropdown
function get_vehicle_makes ()
{
  $makes = get_terms (array(
      'taxonomy' => 'make',
      'hide_empty' => false,
      'parent' => 0, // Get only top-level "Make" terms
  ));

  $result = array_map (function ($makes) {
    return [
        'slug' => $makes->slug,
        'id' => $makes->term_id,
        'label' => $makes->name,
    ];
  }, $makes);
  echo json_encode ($result);
  wp_die ();
}

add_action ('wp_ajax_get_vehicle_makes', 'get_vehicle_makes');
add_action ('wp_ajax_nopriv_get_vehicle_makes', 'get_vehicle_makes');

function model_fetch ()
{
  $make_id = intval ($_POST[ 'make' ]);
  if (!$make_id) {
    echo json_encode (['error' => 'Invalid make ID ' . $make_id]);
    wp_die ();
  }

  $models = get_terms ('make', array('child_of' => $make_id));
  if (is_wp_error ($models)) {
    wp_send_json_error ('Error fetching models ' . $make_id);
  }

  $result = array_map (function ($model) {
    return [
        'slug' => $model->slug,
        'id' => $model->term_id,
        'label' => $model->name,
    ];
  }, $models);

  //  wp_send_json_success($result);
  echo json_encode ($result);
  wp_die ();
}

add_action ('wp_ajax_model_fetch', 'model_fetch');
add_action ('wp_ajax_nopriv_model_fetch', 'model_fetch');

function trim_fetch ()
{
  $model_id = intval ($_POST[ 'model' ]);
  if (!$model_id) {
    echo json_encode (['error' => 'Invalid model ID']);
    wp_die ();
  }

  $args = array(
      'posts_per_page' => -1,
      'post_type' => 'vehicle',
      'post_status' => 'publish',
      'tax_query' => array(
          array(
              'taxonomy' => 'make',
              'field' => 'term_id',
              'terms' => $model_id,

          ),
      ),
  );
  $the_query = new WP_Query($args);

  $result = array();
  if ($the_query->have_posts ()) {
    while ($the_query->have_posts ()) {
      $the_query->the_post ();
      $result[] = [
          'id' => get_the_ID (),
          'label' => get_the_title (),
          'link' => get_the_permalink (),
          'slug' => get_post_field ('post_name'),
      ];
    }
    wp_reset_postdata ();
  }

  // Debug log
  error_log ('Trim fetch result: ' . print_r ($result, true));

  echo json_encode ($result);
  wp_die ();
}

add_action ('wp_ajax_trim_fetch', 'trim_fetch');
add_action ('wp_ajax_nopriv_trim_fetch', 'trim_fetch');

function ajax_fetch ()
{ ?>
  <script type="text/javascript" id="jax-fetch">
    jQuery(document).ready(function ($) {

      const filterItems = $('.portfolio-cat-filter select');
      const sortSelect = $('.sort-select select');
      const resetButton = $('.js-reset-filtering');

      function fetchPortfolio(page = 1) {
        const selectedCategory = $('select[name="portfolio-cat"]').find('option:selected').data('category') || '';
        const selectedProductUsed = $('select[name="product-used"]').find('option:selected').data('used') || '';
        const selectedCityState = $('select[name="city-state"]').find('option:selected').data('city-state') || '';
        const sortBy = sortSelect.val();

        const ajaxUrl = window.wp_data.ajax_url;

        $.ajax({
          url: ajaxUrl,
          method: 'POST',
          data: {
            action: 'get_portfolio',
            category: selectedCategory,
            product_used: selectedProductUsed,
            city_state: selectedCityState,
            sort_by: sortBy,
            paged: page
          },
          success: function (data) {
            const container = $('.portfolio__list');
            if (data.success) {

              container.html(data.data.html);
              container.append(data.data.pagination);
            } else {
              console.error('Error:', data.data);
            }
          },
          error: function (error) {
            console.error('Error:', error);
          }
        });
      }

      filterItems.on('change', function () {
        fetchPortfolio();
      });

      if (sortSelect.length) {
        sortSelect.on('change', function () {
          fetchPortfolio();
        });
      }

      if (resetButton.length) {
        resetButton.on('click', function () {
          filterItems.prop('selectedIndex', 0);
          if (sortSelect.length) sortSelect.prop('selectedIndex', 0);
          fetchPortfolio();
        });
      }

      $(document).on('click', '.pagination .pagination__item', function (e) {
        e.preventDefault();
        const page = $(this).data('target-page');
        fetchPortfolio(page);

        $('.pagination .pagination__item').removeClass('active');
        $(this).addClass('active');
      });
    });
  </script>
<?php }

add_action ('wp_footer', 'ajax_fetch');

require_once get_template_directory() . '/includes/partials/pagination.php';

/**
 * Обробляє AJAX-запит для отримання портфоліо.
 */
function get_portfolio() {
    // Getting data from POST and sanitizing
    $make = isset($_POST['make']) ? sanitize_text_field($_POST['make']) : '';
    $product_used = isset($_POST['product_used']) ? sanitize_text_field($_POST['product_used']) : '';
    $city_state = isset($_POST['city-state']) ? sanitize_text_field($_POST['city-state']) : '';
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $sort_by = isset($_POST['sort_by']) ? sanitize_text_field($_POST['sort_by']) : 'newest';

  switch ($sort_by) {
    case 'newest':
      $orderby = 'date';
      $order = 'DESC';
      break;
    case 'increase':
      $orderby = 'title';
      $order = 'ASC';
      break;
    case 'reduction':
      $orderby = 'title';
      $order = 'DESC';
      break;
    case 'oldest':
      $orderby = 'date';
      $order = 'ASC';
      break;
    default:
      $orderby = 'date';
      $order = 'DESC';
      break;
  }

  $args = array(
      'post_type' => 'portfolio',
      'posts_per_page' => get_option('posts_per_page'),
      'post_status' => 'publish',
      'paged' => $paged,
      'meta_query' => array(
          'relation' => 'AND',
      ),
      'tax_query' => array(
          'relation' => 'OR',
      ),
      'orderby' => $orderby,
      'order' => $order,
  );

  if (!empty($make)) {
    $args[ 'tax_query' ][] = array(
        'taxonomy' => 'make',
        'terms' => $make,
    );
  }

  if (!empty($category)) {
    $args[ 'tax_query' ][] = array(
        'taxonomy' => 'portfolio_category',
        'terms' => $category,
    );
  }

  if (!empty($product_used)) {
    $args[ 'tax_query' ][] = array(
        'taxonomy' => 'product_used',
        'terms' => $product_used,
    );
  }

  if (!empty($city_state)) {
    $args[ 'tax_query' ][] = array(
        'taxonomy' => 'location',
        'terms' => $city_state,
    );
  }

  $portfolio = new WP_Query($args);

  $return_html = '';

  if ($portfolio->have_posts ()) {
    $return_html = return_post_html ($portfolio);

    ob_start();
    render_pagination($portfolio, $paged);
    $return_pagination = ob_get_clean();

  } else {
    $return_html .= '<h6 class="no-results">No results were found for your request</h6>';
  }

  wp_reset_postdata ();

  // Return the HTML and pagination as JSON
  wp_send_json_success(array('html' => $return_html, 'pagination' => $return_pagination));
}

add_action ('wp_ajax_get_portfolio', 'get_portfolio');
add_action ('wp_ajax_nopriv_get_portfolio', 'get_portfolio');





// Function to return the HTML for each post
function return_post_html ($portfolio)
{
  $return_html = '';
  while ($portfolio->have_posts ()) {
    $portfolio->the_post ();
    $post_id = get_the_ID ();
    $permalink = get_permalink ();
    $title = get_the_title ();
    $preview_description = get_field ('preview_description');

    $image_repeater = get_field ('overview_image');
    $image_url = !empty($image_repeater[ 'url' ]) ? esc_url ($image_repeater[ 'url' ]) : get_template_directory_uri () . '/assets/images/Portfolio_Placeholder.webp';

    $return_html .= '<div class="portfolio__item">';
    $return_html .= '<a href="' . $permalink . '" class="portfolio__image">';
    $return_html .= '<img src="' . $image_url . '" loading="lazy" alt="' . esc_attr ($image_repeater[ 'alt' ] ?? 'Placeholder Image') . '">';
    $return_html .= '</a>';
    $return_html .= '<div class="portfolio__content"><div class="portfolio__tags">';
                        $term_list = wp_get_post_terms ($post->ID, 'portfolio_category', ['fields' => 'all']);
                        // Виводимо назву первинної категорії
                        foreach ($term_list as $term_primary) {
	                        $primary_category = get_post_meta ($post->ID, '_yoast_wpseo_primary_portfolio_category', true);
	                        if ($primary_category == $term_primary->term_id) {
			                        $return_html .= '<div class="tag">' .esc_html ($term_primary->name). '</div>';
		                        break; // Припиняємо цикл після знаходження первинної категорії
	                        }
                        }
    $return_html .= '</div><div class="model" title="' . $title . '">' . $title . '</div>';
    $return_html .= '<div class="info">' . $preview_description . '</div>';
    $return_html .= '</div><div class="btn-wrapper"><a href="' . $permalink . '" class="btn btn-2">View</a></div></div>';
  }
  return $return_html;
}

?>



