jQuery(function ($) {
  'use strict';

  $(document).ready(function () {
    // Constants
    const FORM_SELECTOR = '.quote-form';
    const STEP_SELECTOR_PREFIX = '.form-step-';
    const ERROR_SUMMARY_SELECTOR = '.error-summary';
    const NEXT_BTN_SELECTOR = '.next-btn';
    const PREV_BTN_SELECTOR = '.prev-btn';
    const REQUIRED_FIELD_SELECTOR = '[aria-required="true"]';
    const BRAKE_SERVICE_SELECTOR = '[data-name="brake_service"] input[type="checkbox"]';
    const WPCF7_FORM_CONTROL_WRAP = '.wpcf7-form-control-wrap';
    const WPCF7_NOT_VALID_CLASS = 'wpcf7-not-valid';
    const WPCF7_NOT_VALID_TIP_CLASS = 'wpcf7-not-valid-tip';

    if (!document.querySelector(FORM_SELECTOR)) {
      return;
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
      currentStep = step;

      // Additional logic for step 2
      if (step === 2) {
        updateServiceGroupsVisibility();
      }

      // Additional logic for step 3
      if (step === 3) {
        updateFieldStyles();
      }

      // Validate the current step when it's shown
      validateStep(step);
    };

    // Function to get error description from hidden inputs
    const getErrorDescription = (fieldName) => {
      // Replace hyphens with underscores to match the error description input names
      const sanitizedFieldName = fieldName.replace(/-/g, '_');
      return $(`input[name="error_description_${sanitizedFieldName}"]`).val() || 'This field is required.';
    };

    // Function to display error message under the field
    const displayFieldError = ($field, message) => {
      let $errorContainer = $field.closest('.form-item, .custom-select, .wpcf7-form-control-wrap');
      if (!$errorContainer.length) {
        $errorContainer = $field.parent();
      }

      $errorContainer.find(`.${WPCF7_NOT_VALID_TIP_CLASS}`).remove();
      if ($errorContainer.length) {
        $errorContainer.append(`<span class="${WPCF7_NOT_VALID_TIP_CLASS}">${message}</span>`);
      } else {
        $field.after(`<span class="${WPCF7_NOT_VALID_TIP_CLASS}">${message}</span>`);
      }
    };

    // Function to remove field error message
    const removeFieldError = ($field) => {
      let $errorContainer = $field.closest('.form-item, .custom-select, .wpcf7-form-control-wrap');
      if (!$errorContainer.length) {
        $errorContainer = $field.parent();
      }
      $errorContainer.find(`.${WPCF7_NOT_VALID_TIP_CLASS}`).remove();
    };

    // Function to validate individual field
    const validateField = ($field, invalidFields) => {
      let isValid = true;
      const fieldName = $field.attr('name');

      if (!fieldName) {
        console.error('Field name is undefined for field:', $field);
        return false;
      }

      const errorDescription = getErrorDescription(fieldName);

      if ($field.is(':radio')) {
        if (!$(`[name="${fieldName}"]:checked`).length) {
          isValid = false;
          displayFieldError($field, errorDescription);
          invalidFields.push(fieldName);
        } else {
          removeFieldError($field);
        }
      } else if ($field.is('select')) {
        if (!$field.val()) {
          isValid = false;
          $field.addClass(WPCF7_NOT_VALID_CLASS);
          displayFieldError($field, errorDescription);
          invalidFields.push(fieldName);
        } else {
          $field.removeClass(WPCF7_NOT_VALID_CLASS);
          removeFieldError($field);
        }
      } else if ($field.is(':checkbox')) {
        if (!$(`[name="${fieldName}"]:checked`).length) {
          isValid = false;
          displayFieldError($field, errorDescription);
          invalidFields.push(fieldName);
        } else {
          removeFieldError($field);
        }
      } else {
        if (!$field.val()) {
          isValid = false;
          $field.addClass(WPCF7_NOT_VALID_CLASS);
          displayFieldError($field, errorDescription);
          invalidFields.push(fieldName);
        } else {
          $field.removeClass(WPCF7_NOT_VALID_CLASS);
          removeFieldError($field);
        }
      }

      return isValid;
    };

    // Function to display error summary
    const displayErrorSummary = ($errorSummary, invalidFields) => {
      const uniqueErrorFields = [...new Set(invalidFields)]; // Remove duplicates
      const errorList = uniqueErrorFields.map((field) => {
        const errorDescription = getErrorDescription(field);
        return `<li>${errorDescription}</li>`;
      }).join('');
      $errorSummary.html(`<ul>${errorList}</ul>`).show();
    };

    const validateStep = (step) => {
      let isValid = true;
      const $currentStep = $(`${STEP_SELECTOR_PREFIX}${step}`);
      const invalidFields = [];

      // Clear previous error summary
      const $errorSummary = $currentStep.find(ERROR_SUMMARY_SELECTOR);
      $errorSummary.html('').hide();

      if (step === 1) {
        // Validate fields on step 1
        const fieldsToValidate = ['make', 'model', 'trim', 'engine'];

        fieldsToValidate.forEach((fieldName) => {
          let $field;
          if (fieldName === 'engine') {
            // For the engine field, select the actual select element
            $field = $currentStep.find(`select[name="${fieldName}"]`);
          } else {
            // For make, model, trim, select the hidden inputs
            $field = $currentStep.find(`input[name="${fieldName}"]`);
          }

          if ($field.length) {
            const fieldValid = validateField($field, invalidFields);
            if (!fieldValid) {
              isValid = false;
            }
          } else {
            console.error(`Field ${fieldName} not found on step ${step}`);
          }
        });
      } else {
        // Existing validation logic for other steps
        $currentStep.find(REQUIRED_FIELD_SELECTOR).each(function () {
          const $field = $(this);
          const $group = $field.closest('.form-group');

          // Skip validation for fields in hidden groups or hidden fields
          if (($group.length && !$group.is(':visible')) || !$field.is(':visible')) {
            return;
          }

          // Validate the field
          const fieldValid = validateField($field, invalidFields);
          if (!fieldValid) {
            isValid = false;
          }
        });

        // Additional validation for step 2
        if (step === 2) {
          // Validate brake_service checkboxes
          const $brakeServiceCheckboxes = $currentStep.find(BRAKE_SERVICE_SELECTOR);
          const isBrakeServiceChecked = $brakeServiceCheckboxes.is(':checked');
          if (!isBrakeServiceChecked) {
            isValid = false;
            const fieldName = 'brake_service';
            displayFieldError($brakeServiceCheckboxes.first(), getErrorDescription(fieldName));
            invalidFields.push(fieldName);
          } else {
            removeFieldError($brakeServiceCheckboxes.first());
          }

          // Validate fields in groups if they are visible
          const groupFieldsToValidate = ['brake_paint', 'color_palette', 'custom_color'];
          groupFieldsToValidate.forEach((field) => {
            const $field = $currentStep.find(`[name="${field}"][aria-required="true"]`);
            if ($field.length) {
              const fieldValid = validateField($field, invalidFields);
              if (!fieldValid) {
                isValid = false;
              }
            }
          });
        }
      }

      // Display error messages in error-summary
      if (!isValid && invalidFields.length > 0) {
        displayErrorSummary($errorSummary, invalidFields);
      }

      $currentStep.find(NEXT_BTN_SELECTOR).prop('disabled', !isValid).toggleClass('disabled', !isValid);

      return {isValid, invalidFields};
    };

    // Function to update service groups visibility
    const updateServiceGroupsVisibility = () => {
      const $functionalRefurbishment = $('[data-name="brake_service"] input[value="Functional Refurbishment"]');
      const $paintingService = $('[data-name="brake_service"] input[value="Painting Service"]');

      if ($functionalRefurbishment.is(':checked')) {
        $('#group-brake_paint').show();
        // Set aria-required on fields in the group
        $('#group-brake_paint').find('select[name="brake_paint"]').attr('aria-required', 'true');
      } else {
        $('#group-brake_paint').hide();
        // Clear values and remove aria-required
        $('#group-brake_paint').find('select[name="brake_paint"]')
            .removeAttr('aria-required')
            .val('')
            .removeClass(WPCF7_NOT_VALID_CLASS);
        $('#group-brake_paint')
            .find(`.${WPCF7_NOT_VALID_TIP_CLASS}`)
            .remove();
      }

      if ($paintingService.is(':checked')) {
        $('#group-color_palette').show();
        // Set aria-required on fields in the group
        $('#group-color_palette').find('[name="color_palette"]').attr('aria-required', 'true');
      } else {
        $('#group-color_palette').hide();
        // Clear values and remove aria-required
        $('#group-color_palette').find('[name="color_palette"]')
            .removeAttr('aria-required')
            .prop('checked', false)
            .removeClass(WPCF7_NOT_VALID_CLASS);
        $('#group-color_palette')
            .find(`.${WPCF7_NOT_VALID_TIP_CLASS}`)
            .remove();
      }
    };

    // Function to update field styles on step 3
    const updateFieldStyles = () => {
      $('.form-step-3').find('input, select, textarea').each(function () {
        const $field = $(this);
        if ($field.val()) {
          $field.closest('.form-item').addClass('filled');
        } else {
          $field.closest('.form-item').removeClass('filled');
        }
      });
    };

    // Next button click event
    $(document).on('click', NEXT_BTN_SELECTOR, function (event) {
      const nextStep = $(this).data('next-step');
      const currentStep = nextStep - 1;
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
    $(document).on('click', PREV_BTN_SELECTOR, function () {
      const prevStep = $(this).data('prev-step');
      showStep(prevStep);
    });

    // Update selectors for hidden fields
    const $makeSelect = $('.data-make');
    const $modelSelect = $('.data-model');
    const $trimSelect = $('.data-trim');

    const $hiddenMake = $('#make');
    const $hiddenModel = $('#model');
    const $hiddenTrim = $('#trim');

    $makeSelect.on('change', function () {
      const selectedValue = $(this).val();
      $hiddenMake.val('');
      $hiddenModel.val('');
      $hiddenTrim.val('');
      $hiddenMake.val(selectedValue);
      validateStep(1); // Re-validate step 1
    });

    $modelSelect.on('change', function () {
      const selectedValue = $(this).val();
      $hiddenModel.val('');
      $hiddenTrim.val('');
      $hiddenModel.val(selectedValue);
      validateStep(1); // Re-validate step 1
    });

    $trimSelect.on('change', function () {
      const selectedValue = $(this).val();
      $hiddenTrim.val('');
      $hiddenTrim.val(selectedValue);
      validateStep(1); // Re-validate step 1
    });

    // Event listener for brake_service checkboxes
    $(document).on('change', BRAKE_SERVICE_SELECTOR, function () {
      updateServiceGroupsVisibility();
      validateStep(2);
    });

    // Use event delegation for validation events
    $('.form-content').on('input change', REQUIRED_FIELD_SELECTOR + ', [name="color_palette"]', function () {
      const $currentStep = $(this).closest('.form-step');
      const step = $currentStep.data('step');
      validateStep(step);
    });

    // Initialize to step 1
    showStep(1);
    updateFieldStyles();
    updateServiceGroupsVisibility();
  });
});
