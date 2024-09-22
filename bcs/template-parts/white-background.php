<?php
/*
Template Name: White Background | Secondary

*/
get_header();
?>
<div class="cn">
  <header class="section-heading section-heading--gaps-lg">
    <h1 class="title h1"><?php the_title(); ?></h1>
    <div class="subtitle"><p>Browse our selection of high-quality brake calipers.</p></div>
  </header>
  <?php the_content(); ?>
</div>

<script>
  jQuery(document).ready(function($) {
    // Initially hide the brake painting and color palette fields
    $('p:contains("Which brakes need painting?")').hide();
    $('p:contains("Which color palette do you need?")').hide();
    $('p:contains("Custom color")').hide();

    // Show/hide fields based on service selection
    $('input[name="brake_service[]"]').change(function() {
      var paintingSelected = $('input[name="brake_service[]"]:checked').val();

      if (paintingSelected === 'Painting Service Only' || paintingSelected === 'Both') {
        $('p:contains("Which brakes need painting?")').show();
        $('p:contains("Which color palette do you need?")').show();
      } else {
        $('p:contains("Which brakes need painting?")').hide();
        $('p:contains("Which color palette do you need?")').hide();
      }
    });

    // Show/hide the custom color input based on the color palette selection
    $('input[name="color_palette"]').change(function() {
      if ($('input[name="color_palette"]:checked').val() === 'Custom color') {
        $('p:contains("Custom color")').show();
      } else {
        $('p:contains("Custom color")').hide();
      }
    });
  });
</script>

<script>
  jQuery(document).ready(function($) {
    // Function to update the active step in the sidebar
    function updateSidebarStep(step) {
      $('.form-steps .step').removeClass('active');
      $('.form-steps .step-' + step).addClass('active');
    }

    // Function to show the form step based on navigation
    function showStep(step) {
      $('.form-step').hide();
      $('.form-step-' + step).show();
      updateSidebarStep(step);
    }

    // Next button click event
    $('.next-btn').click(function() {
      var nextStep = $(this).data('next-step');
      showStep(nextStep);
    });

    // Previous button click event
    $('.prev-btn').click(function() {
      var prevStep = $(this).data('prev-step');
      showStep(prevStep);
    });

    // Initialize to step 1
    showStep(1);
  });
</script>

<script>
  jQuery(document).ready(function($) {
    // On change of the "Make" dropdown
    $('#vehicle-make').on('change', function() {
      var makeId = $(this).val();

      // Clear and disable the "Model" and "Trim" dropdowns
      $('#vehicle-model').html('<option value="">Select Model</option>').prop('disabled', true);
      $('#vehicle-trim').html('<option value="">Select Trim</option>').prop('disabled', true);

      if (makeId !== '') {
        // AJAX request to get the models based on the selected make
        $.ajax({
          url: window.wp_data.ajax_url,  // WordPress AJAX handler
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

    // On change of the "Model" dropdown
    $('#vehicle-model').on('change', function() {
      var modelId = $(this).val();

      // Clear and disable the "Trim" dropdown
      $('#vehicle-trim').html('<option value="">Select Trim</option>').prop('disabled', true);

      if (modelId !== '') {
        // AJAX request to get the trims based on the selected model
        $.ajax({
          url: ajaxurl,
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
<?php get_footer(); ?>
