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

    // Load the "Make" dropdown when the form is rendered
    function loadVehicleMakes() {
      $.ajax({
        url: window.wp_data.ajax_url,
        type: 'POST',
        data: {
          action: 'get_vehicle_makes' // Custom action to get the makes
        },
        success: function(response) {
          $('select[data-make]').html(response); // Populate the "Make" dropdown
          $('select[data-make]').sumo.reload(); // Reload the SumoSelect plugin
        }
      });
    }

    // Trigger the initial load of the makes after the form is rendered
    loadVehicleMakes();

    // Initialize to step 1
    showStep(1);
  });

</script>
<?php get_footer(); ?>
