<?php
function js_variables ()
  {
    global $wp_query;

    $variables = array(
      'ajax_url' => admin_url ('admin-ajax.php'),
//      'posts'        => json_encode( $wp_query->query_vars ), // everything about your loop is here
      'current_page' => get_query_var ('paged') ? get_query_var ('paged') : 1,
      'max_page' => $wp_query->max_num_pages
    );
    echo '<script type="text/javascript">window.wp_data = ' . json_encode ($variables) . ';</script>';
}

  add_action ('wp_head', 'js_variables');
add_action ('wp_ajax_model_fetch', 'model_fetch');
add_action ('wp_ajax_nopriv_model_fetch', 'model_fetch');
function model_fetch () {
	$result = array();
                  $models = get_terms( 'make', array(  'child_of' => $_POST[ 'make' ] ) );
                  foreach ( $models as $model ) {

	                  ?>
                          <option data-model="<?php echo $model->term_id; ?>" value="<?php echo $model->slug; ?>" ><?php echo $model->name; ?></option>
	                  <?php
	                  $result[] = [
		                  'slug' => $model->slug,
		                  'id' => $model->term_id,
		                  'label' => $model->name,
	                  ];
                  }
	echo json_encode ($result);
	die();
	}



add_action ('wp_ajax_trim_fetch', 'trim_fetch');
add_action ('wp_ajax_nopriv_trim_fetch', 'trim_fetch');
function trim_fetch () {
	$result = array();
	$the_query = new WP_Query(
		array(
			'posts_per_page' => -1,
			'post_type' => 'vehicle',
			'post_status' => 'publish',
			'tax_query' => array (
				array (
					'taxonomy' => 'make',
					'field' => 'term_id',
					'terms' => $_POST[ 'model' ],
				),
			),
		)
	);


	if ($the_query->have_posts ()) :
		while ($the_query->have_posts ()): $the_query->the_post ();
			$post = get_post(get_the_ID ());
			$slug = $post->post_name;
			$result[] = [
				'id' => get_the_ID (),
				'label' => get_the_title (),
				'link' => get_the_permalink (),
			];
			?>
		<?php endwhile;
		wp_reset_postdata ();
	endif;

	echo json_encode ($result);
	die();
}


