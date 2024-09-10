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
      let pageUrl = window.location.origin + '/staging/vehicle/';
      // Initialize SumoSelect
      // $('.custom-select select').SumoSelect({
      //   search: true,
      //   searchText: 'Enter here...',
      //   forceCustomRendering: true
      // });

      // Disable model and trim selects initially
      $('select[data-model], select[data-trim]').prop('disabled', true);

      // Handle make change
      $('select[data-make]').on('change', function() {
        var makeSlug = $(this).val();
        var makeId = $(this).find(':selected').data('make');
        var modelSelect = $('select[data-model]');
        var trimSelect = $('select[data-trim]');
        var searchButton = $('.vehicles-search .btn-group .btn.btn-1');

        if (!makeId) {
          // Disable model and trim selects if no make is chosen
          modelSelect.prop('disabled', true).empty().append('<option value="">Select Model</option>');
          trimSelect.prop('disabled', true).empty().append('<option value="">Select Trim</option>');
          modelSelect[0].sumo.reload();
          trimSelect[0].sumo.reload();
            searchButton.attr('href', pageUrl);
          return;
        }

        // Reset model and trim selects
        modelSelect.empty().append('<option value="">Select Model</option>');
        trimSelect.empty().append('<option value="">Select Trim</option>');
        trimSelect.prop('disabled', true);
        modelSelect[0].sumo.reload();
        trimSelect[0].sumo.reload();

        // Update search button URL
        searchButton.attr('href', pageUrl + makeSlug + '/');

        $.ajax({
          url: window.wp_data.ajax_url,
          type: 'post',
          data: {
            action: 'model_fetch',
            make: makeId
          },
          success: function(response) {
            var models = JSON.parse(response);
            modelSelect.prop('disabled', false);
            $.each(models, function(index, model) {
              modelSelect.append('<option data-model="' + model.id + '" value="' + model.slug + '">' + model.label + '</option>');
            });
            modelSelect[0].sumo.reload();
          }
        });
      });

      // Handle model change
      $('select[data-model]').on('change', function() {
        var modelSlug = $(this).val();
        var modelId = $(this).find(':selected').data('model');
        var trimSelect = $('select[data-trim]');
        var makeSlug = $('select[data-make]').val();
        var searchButton = $('.vehicles-search .btn-group .btn.btn-1');

        if (!modelId) {
          // Disable trim select if no model is chosen
          trimSelect.prop('disabled', true).empty().append('<option value="">Select Trim</option>');
          trimSelect[0].sumo.reload();
            searchButton.attr('href', pageUrl + makeSlug + '/');
          return;
        }

        // Reset trim select
        trimSelect.empty().append('<option value="">Select Trim</option>');
        trimSelect[0].sumo.reload();

        // Update search button URL
        searchButton.attr('href', pageUrl + makeSlug + '/' + modelSlug + '/');

        $.ajax({
          url: window.wp_data.ajax_url,
          type: 'post',
          data: {
            action: 'trim_fetch',
            model: modelId
          },
          success: function(response) {
            var trims = JSON.parse(response);
            trimSelect.prop('disabled', false);
            $.each(trims, function(index, trim) {
                    trimSelect.append('<option data-link="' + trim.link + '" data-trim="' + trim.id + '" value="' + trim.label + '">' + trim.label + '</option>');
            });
            trimSelect[0].sumo.reload();
          }
        });
      });

      // Handle trim change
      $('select[data-trim]').on('change', function() {
          var trimLink = $(this).find(':selected').data('link');
          var makeSlug = $('select[data-make]').find(':selected').val();
          var modelSlug = $('select[data-model]').find(':selected').val();
          var searchButton = $('.vehicles-search .btn-group .btn.btn-1');

          if (!trimLink) {
              // Update search button URL without trim
              searchButton.attr('href', pageUrl + makeSlug + '/' + modelSlug + '/');
              return;
          }

          // Update search button URL with trim
          searchButton.attr('href', trimLink);
      });

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


