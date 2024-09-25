<?php
function js_variables($wp_query) {
  $variables = array(
      'ajax_url' => admin_url ('admin-ajax.php'),
      'current_page' => get_query_var ('paged') ? get_query_var ('paged') : 1,
//      'max_page' => $wp_query->max_num_pages
  );

    $json = json_encode($variables);
    if (json_last_error() !== JSON_ERROR_NONE) {
      error_log('JSON encoding error: ' . json_last_error_msg());
  } else {
    echo '<script type="text/javascript">window.wp_data = ' . $json . ';</script>';
}
}
add_action ('wp_head', 'js_variables');


// Function to get "Make" options for dropdown
function get_vehicle_makes() {
	$makes = get_terms(array(
			'taxonomy' => 'make',
			'hide_empty' => false,
			'parent' => 0, // Get only top-level "Make" terms
	));


	$result = array_map(function($makes) {
		return [
				'slug' => $makes->slug,
				'id' => $makes->term_id,
				'label' => $makes->name,
		];
	}, $makes);
//    wp_send_json_success($result);
	echo json_encode($result);
	wp_die();
}
add_action('wp_ajax_get_vehicle_makes', 'get_vehicle_makes');
add_action('wp_ajax_nopriv_get_vehicle_makes', 'get_vehicle_makes');

function model_fetch() {
  $make_id = intval($_POST['make']);
  if (!$make_id) {
    wp_send_json_error('Invalid make ID');
  }

  $models = get_terms('make', array('child_of' => $make_id));
  if (is_wp_error($models)) {
    wp_send_json_error('Error fetching models');
  }

  $result = array_map(function($model) {
    return [
        'slug' => $model->slug,
        'id' => $model->term_id,
        'label' => $model->name,
    ];
  }, $models);

  //  wp_send_json_success($result);
  echo json_encode($result);
  wp_die();
}
add_action('wp_ajax_model_fetch', 'model_fetch');
add_action('wp_ajax_nopriv_model_fetch', 'model_fetch');

function trim_fetch() {
  $model_id = intval($_POST['model']);
  if (!$model_id) {
    wp_send_json_error('Invalid model ID');
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
  if ($the_query->have_posts()) {
    while ($the_query->have_posts()) {
      $the_query->the_post();
      $result[] = [
          'id' => get_the_ID(),
          'label' => get_the_title(),
          'link' => get_the_permalink(),
      ];
    }
    wp_reset_postdata();
  }

//  wp_send_json_success($result);
  echo json_encode($result);
  wp_die();
}
add_action('wp_ajax_trim_fetch', 'trim_fetch');
add_action('wp_ajax_nopriv_trim_fetch', 'trim_fetch');




function ajax_fetch () { ?>
	<script type="text/javascript" id="jax-fetch">
		document.addEventListener('DOMContentLoaded', function() {
			const filterItems = document.querySelectorAll('.portfolio-cat-filter div');

			filterItems.forEach(item => {
				item.addEventListener('click', function() {
					const category = this.getAttribute('data-category');
					const ajaxUrl = window.wp_data.ajax_url;

					fetch(ajaxUrl, {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
						},
						body: new URLSearchParams({
							action: 'get_portfolio',
							category: category,
							paged: 1
						})
					})
					.then(response => response.json())
					.then(data => {
        if (data.success) {
          document.querySelector('.portfolio__list').innerHTML = data.data.html;
        } else {
          console.error('Error:', data.data);
        }
					})
					.catch(error => console.error('Error:', error));
				});
			});
		});
	</script>
<?php }
add_action ('wp_footer', 'ajax_fetch');

// Function to handle AJAX request for fetching "Trim" posts based on selected "Make" and "Model" terms
function get_portfolio() {
  $make     = $_POST['make'] ? $_POST['make'] : '';
  $paged    = $_POST['paged'] ? $_POST['paged'] : 1;
  $category = $_POST['category'] ? $_POST['category'] : '';
	$args     = array(
		'post_type'      => 'portfolio',
		'posts_per_page' => 9,
		'post_status'    => 'publish',
		'paged'          => $paged,
		'meta_query'     => array(
			'relation' => 'AND',

		),
		'tax_query'      => array(
			'relation' => 'AND',

		),
	);
	if (!empty($make)) {
		$args['tax_query'][] = array(
			'taxonomy' => 'make',
			'terms' => $make
		);
	}
    if (!empty($category)) {
		$args['tax_query'][] = array(
			'taxonomy' => 'portfolio_category',
			'terms' => $category
		);
	}




	$return_html = '';
	$return_pagination = '';

	$portfolio    = new WP_Query( $args );

  if ($portfolio->have_posts()) {
		$return_html = return_post_html($portfolio);


		// Pagination
		$count = 0;
		$p     = $portfolio->max_num_pages;
		$p_count = $portfolio->found_posts;
		$next_page = $paged + 1;
		$prev_page = $paged - 1;

		$next_content = 'Next <i class="arrow_pag"></i>';
		$prev_content = '<i class="arrow_pag"></i> Previous ';
		if ( $p != 1 ) {
			while ( $p > $count ) {
				$count ++;
				if ( $count == 1 & $paged != 1 ) {
					if ( $paged < 4 ) {
						if ( $paged == 2 ) {
							$return_pagination .= '<li class="pagination__item prev" data-target-page="' . $prev_page . '"><div class="pagination__link">'. $prev_content .'</div></li>';
						} else {
							$return_pagination .= '<li class="pagination__item prev" data-target-page="' . $prev_page . '"><div class="pagination__link">'. $prev_content .'</div></li><li class="pagination__item " data-target-page="1"><div class="pagination__link">1</div></li>';
						}
					} else {
						$return_pagination .= '<li class="pagination__item prev" data-target-page="' . $prev_page . '"><div class="pagination__link">'. $prev_content .'</div></li><li class="pagination__item " data-target-page="1"><div class="pagination__link">1</div></li><li><span>...</span></li>';
					}
				}
				if ( $count == $paged ) {
					$return_pagination .= '<li class="pagination__item active" data-target-page="' . $count . '"><div class="pagination__link">' . $count . '</div></li>';
				} elseif ( $count == $paged + 1 ) {
					$return_pagination .= '<li class="pagination__item " data-target-page="' . $count . '"><div class="pagination__link">' . $count . '</div></li>';
					if ( $paged + 1 == $p ) {
						$return_pagination .= '<li class="pagination__item next" data-target-page="' . $next_page . '"><div class="pagination__link">' . $next_content . '</div></li>';
					}
				} elseif ( $count == $paged + 2 ) {
					$return_pagination .= '<li class="pagination__item " data-target-page="' . $count . '"><div class="pagination__link">' . $count . '</div></li> ';
					if ( $paged + 2 != $p ) {
						$return_pagination .= '<li><span>...</span></li>';
					} else {
						$return_pagination .= '<li class="pagination__item next" data-target-page="' . $next_page . '"><div class="pagination__link">' . $next_content . '</li>';
					}
				} elseif ( $count == $paged - 1 ) {
					$return_pagination .= '<li class="pagination__item " data-target-page="' . $count . '"><div class="pagination__link">' . $count . '</div></li>';
				} elseif ( $count == $p ) {
					$return_pagination .= '<li class="pagination__item " data-target-page="' . $count . '"><div class="pagination__link">' . $count . '</div></li>';
					$return_pagination .= '<li class="pagination__item next" data-target-page="' . $next_page . '"><div class="pagination__link">' . $next_content . '</div></li>';
				}
			}
		}

		$return_html .= '<div class="btn-wrap"><div class="pagination" data-page="'. $paged .'"><ul>'. $return_pagination .'</ul></div></div><div class="count__posts visually-hidden" data-post-count="' . $p_count . '"></div></div>';

  } else {
		// If no content, include the "No posts found" template.
		$return_html .= '<h6 class="no-results">No results were found for your request</h6><div class="count__posts visually-hidden" data-post-count="0"></div></div>';
  }

	wp_reset_postdata();

  // Return the HTML and pagination as JSON
  wp_send_json_success(array('html' => $return_html));
}
add_action('wp_ajax_get_portfolio', 'get_portfolio');
add_action('wp_ajax_nopriv_get_portfolio', 'get_portfolio');

function return_post_html($portfolio) {
  $return_html = '';
  while ($portfolio->have_posts()) {
		$portfolio->the_post ();
		$post_id = get_the_ID ();
		$permalink = get_permalink ();
		$title = get_the_title ();
		$preview_description = get_field ('preview_description');

		$image_repeater = get_field ('overview_image');
    $image_url = !empty($image_repeater['url']) ? esc_url($image_repeater['url']) : get_template_directory_uri() . '/assets/images/Portfolio_Placeholder.webp';

    $return_html .= '<div class="portfolio__item">';
    $return_html .= '<a href="' . $permalink . '" class="portfolio__image">';
    $return_html .= '<img src="' . $image_url . '" loading="lazy" alt="' . esc_attr($image_repeater['alt'] ?? 'Placeholder Image') . '">';
    $return_html .= '</a>';
    $return_html .= '<div class="portfolio__content">';
		$terms = wp_get_object_terms ($post_id, 'portfolio_category', array('orderby' => 'term_id', 'order' => 'ASC'));
    if (!empty($terms)) {
			foreach ($terms as $term) {
				$return_html .= ' <div class="tag">' . $term->name . '</div>';
			}
    }
		$return_html .= '<div class="model">' . $title . '</div>';
		$return_html .= '<div class="info">' . $preview_description . '</div>';
    $return_html .= '<a href="' . $permalink . '" class="btn btn-2">View</a>';
    $return_html .= '</div></div>';
  }
	return $return_html;
}

?>



