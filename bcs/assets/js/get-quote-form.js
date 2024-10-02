jQuery(function ($) {
  'use strict';

  $(document).ready(function () {
    if (!document.querySelector('.quote-form')) {
      return false;
    }

    let currentStep = 1;

    const updateSidebarStep = (step) => {
      $('.form-steps .step').removeClass('active');
      $(`.form-steps .step-${step}`).addClass('active');
    };

    const showStep = (step) => {
      $('.form-step').hide();
      $(`.form-step-${step}`).show();
      updateSidebarStep(step);
      currentStep = step; // Update currentStep
    };

    const validateStep = (step) => {
      let isValid = true;
      const $currentStep = $(`.form-step-${step}`);
      const invalidFields = [];

      $currentStep.find('[aria-required="true"]').each(function () {
        const $group = $(this).closest('[data-class="wpcf7cf_group"]');
        if ($group.length === 0 || $group.is(':visible')) {
          console.log(`Validating field: ${$(this).attr('name')}, value: ${$(this).val()}`);
          if (!$(this).val()) {
            isValid = false;
            $(this).addClass('wpcf7-not-valid');
            $(this).closest('.wpcf7-form-control-wrap').find('.wpcf7-not-valid-tip').remove();
            $(this).closest('.wpcf7-form-control-wrap').append('<span class="wpcf7-not-valid-tip">This field is required.</span>');
            $(this).next('.error-message').text('This field is required.').show();
            invalidFields.push($(this).attr('name') || $(this).attr('placeholder'));
          } else {
            $(this).removeClass('wpcf7-not-valid');
            $(this).closest('.wpcf7-form-control-wrap').find('.wpcf7-not-valid-tip').remove();
            $(this).next('.error-message').hide();
          }
        }
      });

      // Check if at least one checkbox is checked in brake_service
      if (step === 2) {
        const $brakeServiceCheckboxes = $currentStep.find('[data-name="brake_service"] input[type="checkbox"]');
        const isBrakeServiceChecked = $brakeServiceCheckboxes.is(':checked');
        if (!isBrakeServiceChecked) {
          isValid = false;
          $brakeServiceCheckboxes.closest('.wpcf7-form-control-wrap').find('.wpcf7-not-valid-tip').remove();
          $brakeServiceCheckboxes.closest('.wpcf7-form-control-wrap').append('<span class="wpcf7-not-valid-tip">At least one option must be selected.</span>');
          invalidFields.push('Brake Service');
        } else {
          $brakeServiceCheckboxes.closest('.wpcf7-form-control-wrap').find('.wpcf7-not-valid-tip').remove();
        }

        // Validate custom_color field if it is visible
        const $customColorField = $currentStep.find('[data-name="custom_color"] input');
        if ($customColorField.is(':visible') && !$customColorField.val()) {
          isValid = false;
          $customColorField.addClass('wpcf7-not-valid');
          $customColorField.closest('.wpcf7-form-control-wrap').find('.wpcf7-not-valid-tip').remove();
          $customColorField.closest('.wpcf7-form-control-wrap').append('<span class="wpcf7-not-valid-tip">This field is required.</span>');
          invalidFields.push('Custom Color');
        } else {
          $customColorField.removeClass('wpcf7-not-valid');
          $customColorField.closest('.wpcf7-form-control-wrap').find('.wpcf7-not-valid-tip').remove();
        }
      }

      $currentStep.find('.next-btn').prop('disabled', !isValid).toggleClass('disabled', !isValid);

      return {isValid, invalidFields};
    };

    const getInvalidFields = (step) => {
      const {invalidFields} = validateStep(step);
      return invalidFields;
    };


    $(document).on('input change', '[aria-required="true"], [data-name="brake_service"] input[type="checkbox"]', function () {
      const $currentStep = $(this).closest('.form-step');
      const step = $currentStep.data('step');
      console.log(`Field changed in step ${step}`);
      console.log(`Field val ` + $(this).val());
      validateStep(step);
    });

    // Next button click event
    $(document).on('click', '.next-btn', function (event) {

      const nextStep = $(this).data('next-step');
      const currentStep = nextStep - 1;
      console.log(`Next button clicked, current step: ${currentStep}, next step: ${nextStep}`);
      if ($(this).hasClass('disabled') || $(this).prop('disabled')) {
        // Prevent default action and trigger validation to show error messages
        event.preventDefault();
        validateStep(currentStep);
        return false;
      } else {
        showStep(nextStep);
      }
    });


    // Previous button click event
    $(document).on('click', '.prev-btn', function () {
      const prevStep = $(this).data('prev-step');
      showStep(prevStep);
    });

    const form = $('.wpcf7-form');

    form.on('submit', function (event) {
      event.preventDefault(); // Prevent the default form submission

      const {isValid, invalidFields} = validateStep(currentStep);

      if (!isValid) {
        const errorMessage = `Step ${currentStep} has invalid fields: ${invalidFields.join(', ')}`;
        $('.wpcf7-response-output').text(errorMessage).show();
      } else {
        $('.wpcf7-response-output').hide();
        this.submit(); // Submit the form if valid
      }
    });

    $(document).on('wpcf7invalid', '.wpcf7-form', function (event) {
      console.log('Form submission failed');
      console.log(event.detail.apiResponse); // Log the form response
    });

    // Initialize to step 1
    showStep(1);
  });
});
