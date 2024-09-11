<?php
function js_variables () {
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

add_action ('wp_footer', 'ajax_fetch');
function ajax_fetch ()
{ ?>
  <script type="text/javascript" id="jax-fetch">
    jQuery(function($) {
      'use strict';
      console.log('!!!! Ready !!!!');
      const pageUrl = `${window.location.origin}/staging/vehicle/`;


      // Initialize SumoSelect
      $('.custom-select select').SumoSelect({
        search: true,
        searchText: 'Enter here...',
        forceCustomRendering: true
      });

      // Function to extract URL segments and set selects
      const setSelectsFromUrl = () => {
        const pathArray = window.location.pathname.split('/');
        const vehicleIndex = pathArray.indexOf('vehicle');
        if (vehicleIndex !== -1 && pathArray.length > vehicleIndex + 1) {
          const [make, model] = [pathArray[vehicleIndex + 1], pathArray[vehicleIndex + 2] || null];
          if (make) {
            const makeSelect = $('select[data-make]');
            makeSelect.val(make).trigger('change');
            // if (makeSelect[0].sumo) {
            //   makeSelect[0].sumo.reload(); // Reload SumoSelect for make
            // }
            if (model) {
              const modelSelect = $('select[data-model]');
              modelSelect.val(model).trigger('change');
              // if (modelSelect[0].sumo) {
              //   modelSelect[0].sumo.reload(); // Reload SumoSelect for model
              // }
            }
          }
        }
      };



      // Disable model and trim selects initially
      const modelSelect = $('select[data-model]').prop('disabled', true);
      const trimSelect = $('select[data-trim]').prop('disabled', true);
      const searchButton = $('.vehicles-search .btn-group .btn.btn-1');

      const updateSelects = (select, options) => {
        select.empty().append('<option value="">Select</option>').prop('disabled', false);
        $.each(options, (index, option) => {
          select.append(`<option data-id="${option.id}" value="${option.slug}">${option.label}</option>`);
        });
        select[0].sumo.reload();
      };

      const handleMakeChange = function() {
        const makeId = $(this).find(':selected').data('make');
        const makeSlug = $(this).val();

        if (!makeId) {
          modelSelect.prop('disabled', true).empty().append('<option value="">Select Model</option>');
          trimSelect.prop('disabled', true).empty().append('<option value="">Select Trim</option>');
          searchButton.attr('href', pageUrl);
          return;
        }

        searchButton.attr('href', `${pageUrl}${makeSlug}/`);
        $.post(window.wp_data.ajax_url, { action: 'model_fetch', make: makeId }, (response) => {
          const models = JSON.parse(response);
          updateSelects(modelSelect, models);
        });
      };

      const handleModelChange = function() {
        const modelId = $(this).find(':selected').data('model');
        const modelSlug = $(this).val();
        const makeSlug = $('select[data-make]').val();

        if (!modelId) {
          trimSelect.prop('disabled', true).empty().append('<option value="">Select Trim</option>');
          searchButton.attr('href', `${pageUrl}${makeSlug}/`);
          return;
        }

        searchButton.attr('href', `${pageUrl}${makeSlug}/${modelSlug}/`);
        $.post(window.wp_data.ajax_url, { action: 'trim_fetch', model: modelId }, (response) => {
          const trims = JSON.parse(response);
          updateSelects(trimSelect, trims);
        });
      };

      const handleTrimChange = function() {
        const trimLink = $(this).find(':selected').data('link');
        const makeSlug = $('select[data-make]').val();
        const modelSlug = $('select[data-model]').val();

        searchButton.attr('href', trimLink || `${pageUrl}${makeSlug}/${modelSlug}/`);
      };

      // Event bindings
      $('select[data-make]').on('change', handleMakeChange);
      $('select[data-model]').on('change', handleModelChange);
      $('select[data-trim]').on('change', handleTrimChange);

      // Call the function to set selects from URL
      setSelectsFromUrl();
    });
  </script>
<?php }

add_action('wp_ajax_model_fetch', 'model_fetch');
add_action('wp_ajax_nopriv_model_fetch', 'model_fetch');
function model_fetch() {
  $result = array();
  $models = get_terms('make', array('child_of' => $_POST['make']));
  foreach ($models as $model) {
    $result[] = [
        'slug' => $model->slug,
        'id' => $model->term_id,
        'label' => $model->name,
    ];
  }
  echo json_encode($result);
  wp_die();
}

add_action('wp_ajax_trim_fetch', 'trim_fetch');
add_action('wp_ajax_nopriv_trim_fetch', 'trim_fetch');
function trim_fetch() {
  $result = array();
  $the_query = new WP_Query(array(
      'posts_per_page' => -1,
      'post_type' => 'vehicle',
      'post_status' => 'publish',
      'tax_query' => array(
          array(
              'taxonomy' => 'make',
              'field' => 'term_id',
              'terms' => $_POST['model'],
          ),
      ),
  ));

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

  echo json_encode($result);
  wp_die();
}


