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
    if (!document.querySelector('.vehicles-search') || !document.querySelector('.quote-form')) {
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
    console.log($(this).find('option').length);
    // if ($(this).find('option').length === 1) {
    //   const response = await $.post(window.wp_data.ajax_url, { action: 'get_vehicle_makes' });
    //   const makes = JSON.parse(response);
    //   updateSelects(makeSelect, makes, 'make');
    // }

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





// Function to get "Make" options for dropdown
function get_vehicle_makes() {
  $makes = get_terms(array(
      'taxonomy' => 'make',
      'hide_empty' => false,
      'parent' => 0, // Get only top-level "Make" terms
  ));

  if (!empty($makes)) {
    foreach ($makes as $make) {
      echo '<option value="' . esc_attr($make->term_id) . '">' . esc_html($make->name) . '</option>';
    }
  } else {
    echo '<option value="">No Makes Available</option>';
  }
  wp_die();
}
add_action('wp_ajax_get_vehicle_makes', 'get_vehicle_makes');
add_action('wp_ajax_nopriv_get_vehicle_makes', 'get_vehicle_makes');

// Function to get child terms (Models and Trims) based on parent term
function get_vehicle_models_or_trims() {
  if (isset($_POST['parent_term_id'])) {
    $parent_id = intval($_POST['parent_term_id']);

    $terms = get_terms(array(
        'taxonomy' => 'make',
        'hide_empty' => false,
        'parent' => $parent_id, // Get child terms based on parent (Make or Model)
    ));

    if (!empty($terms)) {
      foreach ($terms as $term) {
        echo '<option value="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</option>';
      }
    } else {
      echo '<option value="">No terms available</option>';
    }
  }
  wp_die();
}
add_action('wp_ajax_get_vehicle_models_or_trims', 'get_vehicle_models_or_trims');
add_action('wp_ajax_nopriv_get_vehicle_models_or_trims', 'get_vehicle_models_or_trims');

// Function to handle AJAX request for fetching "Trim" posts based on selected "Make" and "Model" terms
function get_vehicle_trims() {
  if (isset($_POST['make_id']) && isset($_POST['model_id'])) {
    $make_id = intval($_POST['make_id']);
    $model_id = intval($_POST['model_id']);

    // Query posts of type "trim" where the selected Make and Model are associated
    $trims = new WP_Query(array(
        'post_type' => 'trim', // Assuming your custom post type is "trim"
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'make',
                'field' => 'term_id',
                'terms' => $make_id,
            ),
            array(
                'taxonomy' => 'make', // Assuming both Make and Model are part of the "make" taxonomy
                'field' => 'term_id',
                'terms' => $model_id,
            ),
        ),
    ));

    if ($trims->have_posts()) {
      while ($trims->have_posts()) {
        $trims->the_post();
        echo '<option value="' . get_the_ID() . '">' . get_the_title() . '</option>';
      }
    } else {
      echo '<option value="">No trims available</option>';
    }
    wp_reset_postdata();
  }

  wp_die(); // End the AJAX request
}
add_action('wp_ajax_get_vehicle_trims', 'get_vehicle_trims');
add_action('wp_ajax_nopriv_get_vehicle_trims', 'get_vehicle_trims');







?>



