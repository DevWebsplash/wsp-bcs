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

  const makeSelect = $('select.data-make');
  const modelSelect = $('select.data-model').prop('disabled', true);
  const trimSelect = $('select.data-trim').prop('disabled', true);
  const searchButton = $('.vehicles-search .btn-group .btn.btn-1');



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

    modelSelect.prop('disabled', false).empty().append('<option value="">Select Model</option>');
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

    // Save to localStorage
    localStorage.setItem('makeSelect', makeSlug);
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

    // Save to localStorage
    localStorage.setItem('modelSelect', modelSlug);
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

    // Save to localStorage
    localStorage.setItem('trimSelect', trimLink);
  };

  const loadFromLocalStorage = () => {
    const makeSlug = localStorage.getItem('makeSelect');
    const modelSlug = localStorage.getItem('modelSelect');
    const trimLink = localStorage.getItem('trimSelect');
    console.log('Loading from localStorage:', makeSlug, modelSlug, trimLink);

    if (makeSlug) {
      makeSelect.val(makeSlug);
      makeSelect[0].sumo.reload();
      handleMakeChange.call(makeSelect[0]);
    }
    if (modelSlug) {
      modelSelect.val(modelSlug);
      modelSelect[0].sumo.reload();
      handleModelChange.call(modelSelect[0]);
    }
    if (trimLink) {
      trimSelect.val(trimLink);
      trimSelect[0].sumo.reload();
      handleTrimChange.call(trimSelect[0]);
    }
  };

  if (localStorage.getItem('makeSelect') || localStorage.getItem('modelSelect') || localStorage.getItem('trimSelect')) {
    loadFromLocalStorage();
  } else {
    setTimeout(() => {
      handleMakeChange.call(makeSelect[0]);
    }, 50);
  }

  makeSelect.on('change', debounce(handleMakeChange, 100));
  modelSelect.on('change', debounce(handleModelChange, 100));
  trimSelect.on('change', debounce(handleTrimChange, 100));

  setModelFromUrl();
  updateSelectStates();
  // loadFromLocalStorage();

  makeSelect.SumoSelect();
  modelSelect.SumoSelect();
  trimSelect.SumoSelect();
});



const setModelFromUrl = () => {
  const {make, model} = getUrlSegments();
  // console.log('URL Segments:', {make, model}); // Debug log
  if (make) {
    makeSelect.val(make);
    // console.log('Make changed to:', {make}); // Debug log
    makeSelect.trigger('change');
  } else {
    console.error('Make is not defined in URL segments');
  }
  if (model) {
    modelSelect.val(model);
    // console.log('Model changed to:', {model}); // Debug log
    modelSelect.trigger('change');
  } else {
    console.error('Model is not defined in URL segments');
  }
  // console.log('Selected Make:', makeSelect.val()); // Debug log
  // console.log('Selected Model:', modelSelect.val()); // Debug log
};
