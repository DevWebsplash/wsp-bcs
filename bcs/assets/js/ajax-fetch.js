jQuery(function ($) {
  'use strict';

  const isVehiclePage = window.location.pathname.includes('/vehicle/');
  document.addEventListener('DOMContentLoaded', function () {
    if (!document.querySelector('.vehicles-search') || !document.querySelector('.quote-form')) {
      return false;
    }

    window.addEventListener('popstate', function (event) {
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

  makeSelect.SumoSelect();
  modelSelect.SumoSelect();
  trimSelect.SumoSelect();

  const debounce = (func, wait = 100) => {
    let timeout;
    return function (...args) {
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(this, args), wait);
    };
  };

  const getUrlSegments = () => {
    const path = window.location.pathname;
    const segments = path.split('/').filter(segment => segment);
    return {
      make: segments[2] || null,
      model: segments[3] || null
    };
  };

  const setModelFromUrl = () => {
    const urlSegments = getUrlSegments();
    if (urlSegments && urlSegments.model) {
      modelSelect.val(urlSegments.model).trigger('change');
    }
  };

  const updateSelectStates = () => {
    const isMakeSelected = makeSelect.find('option:selected').data('make') !== undefined;
    const isModelSelected = modelSelect.find('option:selected').data('model') !== undefined;

    modelSelect.prop('disabled', !isMakeSelected);
    trimSelect.prop('disabled', !isMakeSelected || !isModelSelected);
  };

  const updateSelects = (select, options, dataName) => {
    if (!Array.isArray(options)) {
      console.error('Expected an array but got:', options);
      return;
    }

    const optionsHtml = options.map(option =>
        `<option data-${dataName}="${option[dataName === 'link' ? 'link' : 'id']}" value="${option.slug}">${option.label}</option>`
    ).join('');

    requestAnimationFrame(() => {
      select.empty().append('<option value="">Select</option>').append(optionsHtml).prop('disabled', false);
      select[0].sumo.reload();
    });
  };

  const fetchMakes = async () => {
    const response = await $.post(window.wp_data.ajax_url, {action: 'get_vehicle_makes'});
    return JSON.parse(response);
  };

  const handleMakeChange = async function () {
    const makeId = $(this).find(':selected').data('make');
    const makeSlug = $(this).val();

    if (!makeId) {
      const makes = await fetchMakes();
      updateSelects(makeSelect, makes, 'make');
      modelSelect.prop('disabled', true).empty().append('<option value="">Select Model</option>');
      trimSelect.prop('disabled', true).empty().append('<option value="">Select Trim</option>');
      searchButton.attr('href', baseUrl);

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
      const response = await $.post(window.wp_data.ajax_url, {action: 'model_fetch', make: makeId});
      const models = Object.values(JSON.parse(response)); // Convert object to array
      if (!Array.isArray(models)) {
        console.error('Response is not an array:', models);
        throw new Error('Expected an array but got: ' + JSON.stringify(models));
      }
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
      const response = await $.post(window.wp_data.ajax_url, {action: 'trim_fetch', model: modelId});
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


  if (document.querySelector('.quote-form')) {
    handleMakeChange.call(makeSelect[0]);
  }
  makeSelect.on('change', debounce(handleMakeChange, 100));
  modelSelect.on('change', debounce(handleModelChange, 100));
  trimSelect.on('change', debounce(handleTrimChange, 100));

  setModelFromUrl();
  updateSelectStates();

});
