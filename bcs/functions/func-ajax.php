<?php
function js_variables($wp_query) {
  $variables = array(
      'ajax_url' => admin_url ('admin-ajax.php'),
      'current_page' => get_query_var ('paged') ? get_query_var ('paged') : 1,
      'max_page' => $wp_query->max_num_pages
  );

    $json = json_encode($variables);
    if (json_last_error() !== JSON_ERROR_NONE) {
        // Handle error
    }
    echo '<script type="text/javascript">window.wp_data = ' . $json . ';</script>';
}
add_action ('wp_head', 'js_variables');


function ajax_fetch ()
{ ?>
<script type="text/javascript" id="jax-fetch">
jQuery(function ($) {
  'use strict';
  console.log('!!!! Ready !!!!');
  const pageUrl = `${window.location.origin}/staging/vehicle/`;

  // Initialize SumoSelect
  $('.custom-select select').SumoSelect({
    search: true,
    searchText: 'Enter here...',
    forceCustomRendering: true
  });

  // Function to get URL segments
  function getUrlSegments() {
    const path = window.location.pathname;
    const segments = path.split('/').filter(segment => segment);
    return {
      make: segments[2] || null,
      model: segments[3] || null
    };
  }

  // Function to set model select based on URL
  function setModelFromUrl() {
    const urlSegments = getUrlSegments();
    if (urlSegments && urlSegments.model) {
      const modelSelect = $('select[data-model]'); // Adjust the selector as needed
      modelSelect.val(urlSegments.model).trigger('change');
    }
  }

  // Disable model and trim selects initially
  const makeSelect = $('select[data-make]');
  const modelSelect = $('select[data-model]').prop('disabled', true);
  const trimSelect = $('select[data-trim]').prop('disabled', true);
  const searchButton = $('.vehicles-search .btn-group .btn.btn-1');

  // Check if an option is selected and enable/disable selects accordingly
  const updateSelectStates = () => {
    const isMakeSelected = makeSelect.find('option:selected').data('make') !== undefined;
    const isModelSelected = modelSelect.find('option:selected').data('model') !== undefined;

    modelSelect.prop('disabled', !isMakeSelected);
    trimSelect.prop('disabled', !isMakeSelected || !isModelSelected);
  };

  const updateSelects = (select, options, dataName) => {
    select.empty().append('<option value="">Select</option>').prop('disabled', false);
    $.each(options, (index, option) => {
      if (dataName == 'link') {
        select.append(`<option data-${dataName}="${option.link}" value="${option.label}">${option.label}</option>`);
        return;
      }
      select.append(`<option data-${dataName}="${option.id}" value="${option.slug}">${option.label}</option>`);
    });
    select[0].sumo.reload();
  };

  const handleMakeChange = function () {
    const makeId = $(this).find(':selected').data('make');
    const makeSlug = $(this).val();

    if (!makeId) {
      modelSelect.prop('disabled', true).empty().append('<option value="">Select Model</option>');
      trimSelect.prop('disabled', true).empty().append('<option value="">Select Trim</option>');

      searchButton.attr('href', pageUrl);
      updateSelectStates();
      return;
    }

    // Reset trim select when make is changed
    trimSelect.prop('disabled', true).empty().append('<option value="">Select Trim</option>');
    trimSelect[0].sumo.reload();


    searchButton.attr('href', `${pageUrl}${makeSlug}/`);
    window.history.pushState({}, '', `${pageUrl}${makeSlug}/`);
    $.post(window.wp_data.ajax_url, { action: 'model_fetch', make: makeId }, (response) => {
      const models = JSON.parse(response);
      updateSelects(modelSelect, models, 'model');
      modelSelect.prop('disabled', false);
      updateSelectStates();
    });
  };

  const handleModelChange = function () {
    const modelId = $(this).find(':selected').data('model');
    const modelSlug = $(this).val();
    const makeSlug = $('select[data-make]').val();

    if (!modelId) {
      trimSelect.prop('disabled', true).empty().append('<option value="">Select Trim</option>');
      searchButton.attr('href', `${pageUrl}${makeSlug}/`);
      updateSelectStates();
      return;
    }

    searchButton.attr('href', `${pageUrl}${makeSlug}/${modelSlug}/`);
    window.history.pushState({}, '', `${pageUrl}${makeSlug}/${modelSlug}/`);
    $.post(window.wp_data.ajax_url, { action: 'trim_fetch', model: modelId }, (response) => {
      const trims = JSON.parse(response);
      updateSelects(trimSelect, trims, 'link');
      trimSelect.prop('disabled', false);
      updateSelectStates();
    });
  };

  const handleTrimChange = function () {
    const trimLink = $(this).find(':selected').data('link');
    const makeSlug = $('select[data-make]').val();
    const modelSlug = $('select[data-model]').val();

    searchButton.attr('href', trimLink || `${pageUrl}${makeSlug}/${modelSlug}/`);
    window.history.pushState({}, '', trimLink || `${pageUrl}${makeSlug}/${modelSlug}/`);
    updateSelectStates();
  };

  // Event bindings
  $('select[data-make]').on('change', handleMakeChange);
  $('select[data-model]').on('change', handleModelChange);
  $('select[data-trim]').on('change', handleTrimChange);

  // Call the function to set selects from URL
  setModelFromUrl();

  // Update select states on page load
  updateSelectStates();
});
</script>
<?php }
add_action ('wp_footer', 'ajax_fetch');

function model_fetch() {
  $models = get_terms('make', array('child_of' => $_POST['make']));
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
  $args = array(
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

?>
