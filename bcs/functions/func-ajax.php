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


function ajax_fetch () { ?>
<script>

</script>
<script type="text/javascript" id="jax-fetch">
jQuery(function ($) {
  'use strict';

  const isVehiclePage = window.location.pathname.includes('/vehicle/');
  document.addEventListener('DOMContentLoaded', function() {
    if (!document.querySelector('.vehicles-search')) {
      return false;
    }

    window.addEventListener('popstate', function(event) {
      if (isVehiclePage) {
        window.location.reload();
      }
    });
  });

  const baseUrl = `${window.location.origin}/staging/vehicle/`;

  const makeSelect = $('select[data-make]');
  const modelSelect = $('select[data-model]').prop('disabled', true);
  const trimSelect = $('select[data-trim]').prop('disabled', true);
  const searchButton = $('.vehicles-search .btn-group .btn.btn-1');

  const debounce = (func, wait = 100) => {
    let timeout;
    return function (...args) {
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(this, args), wait);
    };
  };

  function getUrlSegments() {
    const path = window.location.pathname;
    const segments = path.split('/').filter(segment => segment);
    return {
      make: segments[2] || null,
      model: segments[3] || null
    };
  }

  function setModelFromUrl() {
    const urlSegments = getUrlSegments();
    if (urlSegments && urlSegments.model) {
      modelSelect.val(urlSegments.model).trigger('change');
    }
  }

  const updateSelectStates = () => {
    const isMakeSelected = makeSelect.find('option:selected').data('make') !== undefined;
    const isModelSelected = modelSelect.find('option:selected').data('model') !== undefined;

    modelSelect.prop('disabled', !isMakeSelected);
    trimSelect.prop('disabled', !isMakeSelected || !isModelSelected);
  };

  const updateSelects = (select, options, dataName) => {
    const optionsHtml = options.map(option =>
        `<option data-${dataName}="${option[dataName === 'link' ? 'link' : 'id']}" value="${option.slug}">${option.label}</option>`
    ).join('');

    requestAnimationFrame(() => {
    select.empty().append('<option value="">Select</option>').append(optionsHtml).prop('disabled', false);
    select[0].sumo.reload();
    });
  };

  const handleMakeChange = async function () {
    const makeId = $(this).find(':selected').data('make');
    const makeSlug = $(this).val();

    if (!makeId) {
      modelSelect.prop('disabled', true).empty().append('<option value="">Select Model</option>');
      trimSelect.prop('disabled', true).empty().append('<option value="">Select Trim</option>');

      searchButton.attr('href', baseUrl);
      updateSelectStates();
      return;
    }

    modelSelect.prop('disabled', false).empty().append('<option value="">Select</option>');
    modelSelect[0].sumo.reload();
    trimSelect.prop('disabled', true).empty().append('<option value="">Select Trim</option>');
    trimSelect[0].sumo.reload();


    searchButton.attr('href', `${baseUrl}${makeSlug}/`);
    if (isVehiclePage) {
      window.history.pushState({}, '', `${baseUrl}${makeSlug}/`);
    }

    try {
      const response = await $.post(window.wp_data.ajax_url, { action: 'model_fetch', make: makeId });
      const models = JSON.parse(response);
      updateSelects(modelSelect, models, 'model');
      modelSelect.prop('disabled', false);
      updateSelectStates();
    } catch (error) {
      console.error('Error fetching models:', error);
    }
  };

  const handleModelChange = async function () {
    const modelId = $(this).find(':selected').data('model');
    const modelSlug = $(this).val();
    const makeSlug = makeSelect.val();

    if (!modelId) {
      trimSelect.prop('disabled', true).empty().append('<option value="">Select Trim</option>');
      searchButton.attr('href', `${baseUrl}${makeSlug}/`);
      updateSelectStates();
      return;
    }

    searchButton.attr('href', `${baseUrl}${makeSlug}/${modelSlug}/`);
    if (isVehiclePage) {
        window.history.pushState({}, '', `${baseUrl}${makeSlug}/${modelSlug}/`);
    }

    try {
      const response = await $.post(window.wp_data.ajax_url, { action: 'trim_fetch', model: modelId });
      const trims = JSON.parse(response);
      updateSelects(trimSelect, trims, 'link');
      trimSelect.prop('disabled', false);
      updateSelectStates();
    } catch (error) {
      console.error('Error fetching trims:', error);
    }
  };

  const handleTrimChange = function () {
    const trimLink = $(this).find(':selected').data('link');
    const makeSlug = makeSelect.val();
    const modelSlug = modelSelect.val();

    searchButton.attr('href', trimLink || `${baseUrl}${makeSlug}/${modelSlug}/`);
    if (isVehiclePage) {
        window.history.pushState({}, '', trimLink || `${baseUrl}${makeSlug}/${modelSlug}/`);
    }
    updateSelectStates();
  };

  makeSelect.on('change', debounce(handleMakeChange, 100));
  modelSelect.on('change', debounce(handleModelChange, 100));
  trimSelect.on('change', debounce(handleTrimChange, 100));

  setModelFromUrl();
  updateSelectStates();
});
</script>
<?php }
add_action ('wp_footer', 'ajax_fetch');

function model_fetch() {
  $make_id = intval($_POST['make']);
  if (!$make_id) {
    wp_send_json_error('Invalid make ID');
  }

  $models = get_terms('make', array('child_of' => $make_id));
  $result = array_map(function($model) {
    return [
        'slug' => $model->slug,
        'id' => $model->term_id,
        'label' => $model->name,
    ];
  }, $models);

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

  echo json_encode($result);
  wp_die();
}
add_action('wp_ajax_trim_fetch', 'trim_fetch');
add_action('wp_ajax_nopriv_trim_fetch', 'trim_fetch');









// Function to get all 'Make' terms
// Function to generate the "Make" dropdown and handle AJAX for dynamic "Model" and "Trim"
function vehicle_form_shortcode() {
  ob_start(); // Buffer the output

  // "Make" dropdown
  echo '<h3>Step 1: Car Details</h3>';
  echo '<label>Select Make *</label>';
  echo '<select id="vehicle-make" name="vehicle_make">';
  echo get_vehicle_make_options(); // Generates the options for "Make"
  echo '</select><br>';

  // "Model" dropdown (initially disabled)
  echo '<label>Select Model *</label>';
  echo '<select id="vehicle-model" name="vehicle_model" disabled>';
  echo '<option value="">Select Model</option>';
  echo '</select><br>';

  // "Trim" dropdown (initially disabled)
  echo '<label>Select Trim *</label>';
  echo '<select id="vehicle-trim" name="vehicle_trim" disabled>';
  echo '<option value="">Select Trim</option>';
  echo '</select><br>';

  // Include necessary JavaScript to handle AJAX calls
  ?>
  <script>
    jQuery(document).ready(function($) {
      // When "Make" is changed, load "Model" dropdown
      $('#vehicle-make').on('change', function() {
        var makeId = $(this).val();

        // Clear and disable the "Model" and "Trim" dropdowns
        $('#vehicle-model').html('<option value="">Select Model</option>').prop('disabled', true);
        $('#vehicle-trim').html('<option value="">Select Trim</option>').prop('disabled', true);

        if (makeId !== '') {
          // AJAX request to get the models based on the selected make
          $.ajax({
            url: window.wp_data.ajax_url,
            type: 'POST',
            data: {
              action: 'get_vehicle_models_or_trims',
              parent_term_id: makeId
            },
            success: function(response) {
              $('#vehicle-model').html(response).prop('disabled', false); // Enable and populate model dropdown
            }
          });
        }
      });

      // When "Model" is changed, load "Trim" dropdown
      $('#vehicle-model').on('change', function() {
        var modelId = $(this).val();

        // Clear and disable the "Trim" dropdown
        $('#vehicle-trim').html('<option value="">Select Trim</option>').prop('disabled', true);

        if (modelId !== '') {
          // AJAX request to get the trims based on the selected model
          $.ajax({
            url: window.wp_data.ajax_url,
            type: 'POST',
            data: {
              action: 'get_vehicle_models_or_trims',
              parent_term_id: modelId
            },
            success: function(response) {
              $('#vehicle-trim').html(response).prop('disabled', false); // Enable and populate trim dropdown
            }
          });
        }
      });
    });
  </script>
  <?php

  return ob_get_clean(); // Return the buffered output
}
add_shortcode('vehicle_form', 'vehicle_form_shortcode');

// Function to handle AJAX requests for models and trims based on parent term
function get_vehicle_models_or_trims() {
  if (isset($_POST['parent_term_id'])) {
    $parent_id = intval($_POST['parent_term_id']);

    // Get child terms (Models or Trims) based on parent
    $terms = get_terms(array(
        'taxonomy' => 'make',
        'hide_empty' => false,
        'parent' => $parent_id,
    ));

    if (!empty($terms)) {
      foreach ($terms as $term) {
        echo '<option value="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</option>';
      }
    } else {
      echo '<option value="">No terms available</option>';
    }
  }

  wp_die(); // Stop further execution
}
add_action('wp_ajax_get_vehicle_models_or_trims', 'get_vehicle_models_or_trims');
add_action('wp_ajax_nopriv_get_vehicle_models_or_trims', 'get_vehicle_models_or_trims');
?>



