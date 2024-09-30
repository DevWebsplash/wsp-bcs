jQuery(function ($) {
  'use strict';

  if (!document.querySelector('.quote-form')) {
    return false;
  }

  // Function to update the active step in the sidebar
  const updateSidebarStep = (step) => {
    console.log(`Updating sidebar to step ${step}`);
    $('.form-steps .step').removeClass('active');
    $(`.form-steps .step-${step}`).addClass('active');
  };

  // Function to show the form step based on navigation
  const showStep = (step) => {
    $('.form-step').hide();
    $(`.form-step-${step}`).show();
    updateSidebarStep(step);
  };

  // Function to validate required fields in the current step
  const validateStep = (step) => {
    console.log(`Validating step ${step}`);
    let isValid = true;
    const $currentStep = $(`.form-step-${step}`);

    // Find all required fields in the current step that are visible and not in inactive groups
    $currentStep.find('[aria-required="true"]').each(function () {
      const $group = $(this).closest('[data-class="wpcf7cf_group"]');
      if ($group.length === 0 || $group.is(':visible')) {
        console.log(`Validating field: ${$(this).attr('name')}, value: ${$(this).val()}`);
        if (!$(this).val()) {
          isValid = false;
          $(this).addClass('wpcf7-not-valid');
          $(this).closest('.wpcf7-form-control-wrap').find('.wpcf7-not-valid-tip').remove(); // Remove existing error message
          $(this).closest('.wpcf7-form-control-wrap').append('<span class="wpcf7-not-valid-tip">This field is required.</span>');
        } else {
          $(this).removeClass('wpcf7-not-valid');
          $(this).closest('.wpcf7-form-control-wrap').find('.wpcf7-not-valid-tip').remove();
        }
      }
    });

    // Enable or disable the next button based on validation
    console.log(`Step ${step} is valid: ${isValid}`);
    $currentStep.find('.next-btn').prop('disabled', !isValid);

    return isValid;
  };

  // Reintroduce the function to validate on input change
  $(document).on('input change', '[aria-required="true"]', function() {
    const $currentStep = $(this).closest('.form-step');
    const step = $currentStep.data('step');
    console.log(`Field changed in step ${step}`);
    validateStep(step);
  });

  // Next button click event
  $('.next-btn').on('click', function () {
    const nextStep = $(this).data('next-step');
    const currentStep = nextStep - 1;
    console.log(`Next button clicked, current step: ${currentStep}, next step: ${nextStep}`);

    if (validateStep(currentStep)) {
      showStep(nextStep);
    }
  });

  // Previous button click event
  $('.prev-btn').click(function () {
    const prevStep = $(this).data('prev-step');
    showStep(prevStep);
  });

  // Initialize to step 1
  showStep(1);
});
