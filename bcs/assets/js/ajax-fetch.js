jQuery(document).ready(async function ($) {
  // Early exit if the page does not contain required elements
  const isQuotePage = document.querySelector('.quote-form');
  const isPortfolioPage = document.querySelector('.s-portfolio');
  const isRelevantPage = document.querySelector('.vehicles-search') || isQuotePage;
  if (!isRelevantPage) return;

  const isVehiclePage = window.location.pathname.includes('/vehicle/');
  const baseUrl = `${window.location.origin}/staging/vehicle/`;

  // Cache jQuery selectors
  const $makeSelect = $('.data-make');
  const $modelSelect = $('.data-model');
  const $trimSelect = $('.data-trim');
  const $searchButton = $('.vehicles-search .btn-group .vehicles-search__btn');
  const $loader = $('.loader');

  // Class to manage vehicle state
  class VehicleState {
    constructor() {
      this.make = null;
      this.model = null;
      this.trim = null;
    }

    loadFromCache(cache) {
      this.make = JSON.parse(cache.get('selectedMake')) || {id: '', slug: ''};
      this.model = JSON.parse(cache.get('selectedModel')) || {id: '', slug: ''};
      this.trim = JSON.parse(cache.get('selectedTrim')) || {id: '', slug: '', link: ''};
      console.debug('Loaded state from cache:', this);
    }

    saveToCache(cache) {
      cache.set('selectedMake', JSON.stringify(this.make));
      cache.set('selectedModel', JSON.stringify(this.model));

      // Only save trim if it has a valid ID
      if (this.trim && this.trim.id) {
        cache.set('selectedTrim', JSON.stringify(this.trim));
      }
    }
  }

  // Class to manage cache
  class Cache {
    get(key) {
      const value = localStorage.getItem(key);
      // console.debug(`Cache get ${key}:`, value);
      return value;
    }

    set(key, value) {
      if (value && value !== '{}') {
        localStorage.setItem(key, value);
        // console.debug(`Cache set ${key}:`, value);
      } else {
        localStorage.removeItem(key);
        // console.debug(`Cache remove ${key}`);
      }
    }
  }

  const vehicleState = new VehicleState();
  const cache = new Cache();

  // Loading state
  const loadingState = {isMakeLoaded: false, isModelLoaded: false, isTrimLoaded: false};

  // Cache data
  let makesCache = JSON.parse(localStorage.getItem('makesCache')) || [];
  let modelsCache = JSON.parse(localStorage.getItem('modelsCache')) || [];

  // Helper functions

  /**
   * Show or hide the loader
   * @param {boolean} show
   */
  const showLoader = (show) => {
    if ($loader.length) {
      $loader.css('display', show ? 'flex' : 'none');
      if (show) {
        $loader.addClass('visible');
      } else {
        $loader.removeClass('visible');
      }
    }
  };

  /**
   * Get URL segments for make and model
   */
  const getUrlSegments = () => {
    const segments = window.location.pathname.split('/').filter(Boolean);
    // console.debug('Extracted URL Segments:', segments);
    return {make: segments[2] || null, model: segments[3] || null};
  };

  /**
   * Update the browser URL segments based on the selected values
   */
  const updateUrlSegments = () => {
    if (!isVehiclePage) return;
    const makeSlug = vehicleState.make?.slug || '';
    const modelSlug = vehicleState.model?.slug || '';
    let newUrl = baseUrl;

    if (makeSlug) newUrl += `${makeSlug}/`;
    if (modelSlug) newUrl += `${modelSlug}/`;

    if (newUrl !== window.location.href) {
      window.history.pushState({}, '', newUrl);
      // console.debug('Updated URL:', newUrl);
    }
  };

  /**
   * Initialize SumoSelect or reload it if already initialized
   * @param {jQuery} $select
   */
  const initializeSumoSelect = ($select) => {
    if ($select[0]?.sumo) $select[0].sumo.reload();
    else $select.SumoSelect({csvDispCount: 3});
  };

  /**
   * Fetch data from server
   * @param {string} action
   * @param {object} params
   * @returns {Promise<Array>}
   */
  const fetchData = async (action, params) => {
    try {
      showLoader(true);
      // console.debug(`Fetching ${action} with params:`, params);
      const response = await fetch(window.wp_data.ajax_url, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
        body: new URLSearchParams({action, ...params}),
      });
      const data = await response.json();
      if (data.error) throw new Error(data.error);

      // Log the data received for trims
      if (action === 'trim_fetch') {
        console.debug('Received trims data:', data);
      }

      return data;
    } catch (error) {
      console.error(`Error fetching ${action}:`, error);
      return [];
    } finally {
      showLoader(false);
    }
  };

  /**
   * Populate a select dropdown with given options
   * @param {jQuery} $select
   * @param {Array} options
   * @param {string} dataName
   */
  const populateDropdown = async ($select, options, dataName) => {
    try {
      if (!Array.isArray(options)) {
        throw new Error(`Expected options to be an array but got: ${typeof options}`);
      }

      // console.debug(`Populating ${dataName} select with options:`, options);

      const capitalizedDataName = dataName.charAt(0).toUpperCase() + dataName.slice(1);
      const optionsHtml = options
          .map((option) => {
            // console.debug(`Option ID for ${dataName}:`, option.id);
            return `<option data-${dataName}="${option.id}" ${
                dataName === 'trim' ? `data-link="${option.link}"` : ''
            } value="${option.slug}">${option.label}</option>`;
          })
          .join('');

      $select.html(`<option value="">Select ${capitalizedDataName}</option>${optionsHtml}`);
      $select.prop('disabled', false);
      initializeSumoSelect($select);
      loadingState[`is${capitalizedDataName}Loaded`] = true;
      // console.debug(`Dropdown ${dataName} populated and enabled.`);

      // After populating, check if vehicleState[dataName] has a slug and re-select it
      if (vehicleState[dataName]?.slug) {
        const matchingOption = $select.find(`option[value="${vehicleState[dataName].slug}"]`);
        if (matchingOption.length) {
          $select.val(vehicleState[dataName].slug);
          initializeSumoSelect($select);

          // Update vehicleState[dataName] with the correct id and link
          vehicleState[dataName] = {
            id: matchingOption.data(dataName) || '',
            slug: matchingOption.val() || '',
            link: matchingOption.data('link') || '',
          };
          vehicleState.saveToCache(cache);

          if (dataName === 'trim') {
            updateSearchButton();
          }

          // If it's the model dropdown, we need to update the state and fetch trims
          if (dataName === 'model') {
            await updateStateAndDropdown('model', vehicleState.model.id, vehicleState.model.slug);
          }
        } else {
          // If the selection is not valid, reset it
          vehicleState[dataName] = {id: '', slug: '', link: ''};
          cache.set(`selected${capitalizedDataName}`, JSON.stringify(vehicleState[dataName]));
        }
      }
    } catch (error) {
      // console.error(`Error populating select ${dataName}:`, error);
    }
  };

  /**
   * Reset a dropdown and optionally reset its state
   * @param {jQuery} $select
   * @param {string} dataName
   * @param {object} options
   */
  const resetDropdown = ($select, dataName, options = {}) => {
    const {resetState = true} = options;
    const capitalizedDataName = dataName.charAt(0).toUpperCase() + dataName.slice(1);

    $select.html(`<option value="">Select ${capitalizedDataName}</option>`);
    $select.prop('disabled', true);
    initializeSumoSelect($select);

    if (resetState) {
      vehicleState[dataName] = {id: '', slug: '', link: ''};
      cache.set(`selected${capitalizedDataName}`, JSON.stringify(vehicleState[dataName]));
    }
  };

  /**
   * Update the search button based on the selected values
   */
  const updateSearchButton = () => {
    const makeSlug = vehicleState.make?.slug || '';
    const modelSlug = vehicleState.model?.slug || '';
    const trimLink = vehicleState.trim?.link || '';
    let url;

    if (vehicleState.trim?.id && trimLink) {
      url = trimLink;
    } else if (makeSlug && modelSlug) {
      url = `${baseUrl}${makeSlug}/${modelSlug}/`;
    } else if (makeSlug) {
      url = `${baseUrl}${makeSlug}/`;
    } else {
      url = baseUrl;
    }

    $searchButton.attr('href', url);
    // console.debug(`Updated search button href to: ${url}`);
  };

  /**
   * Update vehicle state and corresponding dropdowns
   * @param {string} key
   * @param {string} id
   * @param {string} slug
   */
  const updateStateAndDropdown = async (key, id, slug) => {
    vehicleState[key] = {id, slug, link: vehicleState[key]?.link || ''};
    // Only save make and model here to avoid overwriting trim
    if (key === 'make' || key === 'model') {
      cache.set(`selected${key.charAt(0).toUpperCase() + key.slice(1)}`, JSON.stringify(vehicleState[key]));
    }

    // console.debug(`Updated vehicleState:`, vehicleState);

    const capitalizedKey = key.charAt(0).toUpperCase() + key.slice(1);

    if (key === 'make') {
      resetDropdown($modelSelect, 'model', {resetState: false}); // Do not reset vehicleState.model here
      resetDropdown($trimSelect, 'trim', {resetState: false}); // Do not reset vehicleState.trim here
      // Fetch models
      const models = await fetchData('model_fetch', {make: id});
      modelsCache = models;
      localStorage.setItem('modelsCache', JSON.stringify(modelsCache));
      await populateDropdown($modelSelect, modelsCache, 'model');
    } else if (key === 'model') {
      resetDropdown($trimSelect, 'trim', {resetState: false}); // Do not reset vehicleState.trim here
      // Fetch trims
      const trims = await fetchData('trim_fetch', {model: id});
      await populateDropdown($trimSelect, trims, 'trim');
    }

    updateSearchButton();
    updateUrlSegments();
  };

  /**
   * Initialize the selects on page load
   */
  const initialize = async () => {
    // console.debug('Initializing page with cached and URL data...');
    vehicleState.loadFromCache(cache);
    const urlData = getUrlSegments();

    // Update vehicleState based on URL data
    if (urlData.make) {
      vehicleState.make = makesCache.find((make) => make.slug === urlData.make) || vehicleState.make;
    }
    if (urlData.model) {
      vehicleState.model =
          modelsCache.find((model) => model.slug === urlData.model) || vehicleState.model;
    }

    // console.debug(`Initializing with vehicleState:`, vehicleState);

    // Fetch makes if not cached
    if (makesCache.length === 0) {
      makesCache = await fetchData('get_vehicle_makes');
      localStorage.setItem('makesCache', JSON.stringify(makesCache));
    }
    await populateDropdown($makeSelect, makesCache, 'make');

    // Update make selection
    if (vehicleState.make.id) {
      await updateStateAndDropdown('make', vehicleState.make.id, vehicleState.make.slug);
      if(isQuotePage) {
        $('#make').val(vehicleState.make.slug);
      }
      // if(isPortfolioPage) {
      //   $('.selected_vehicle__make-value').html(vehicleState.make.slug);
      // }
    }

    // Update model selection
    if (vehicleState.model.id) {
      await updateStateAndDropdown('model', vehicleState.model.id, vehicleState.model.slug);
      if(isQuotePage) {
        $('#model').val(vehicleState.model.slug);
      }
      // if (isPortfolioPage) {
      //   $('.selected_vehicle__model-value').html(vehicleState.model.slug);
      // }
    }

    initializeSumoSelect($makeSelect);
    initializeSumoSelect($modelSelect);
    initializeSumoSelect($trimSelect);

    // After initializing, ensure trim is selected if it exists
    if (vehicleState.trim && vehicleState.trim.id) {
      const matchingOption = $trimSelect.find(`option[value="${vehicleState.trim.slug}"]`);
      if (matchingOption.length) {
        $trimSelect.val(vehicleState.trim.slug);
        initializeSumoSelect($trimSelect);
        updateSearchButton();
        if(isQuotePage) {
          $('#trim').val(vehicleState.trim.slug);
        }
        // if(isPortfolioPage) {
        //   $('.selected_vehicle__trim-value').html(vehicleState.trim.slug);
        // }
      }
    }

    updateSearchButton();
    updateUrlSegments();
  };

  // Event listeners

  // Clean up existing event listeners
  $makeSelect.off('change');
  $modelSelect.off('change');
  $trimSelect.off('change');

  $makeSelect.on('change', async () => {
    const selectedOption = $makeSelect.find(':selected');
    const selectedMakeId = selectedOption.data('make');
    const selectedMakeSlug = selectedOption.val();
    await updateStateAndDropdown('make', selectedMakeId, selectedMakeSlug);
  });

  $modelSelect.on('change', async () => {
    const selectedOption = $modelSelect.find(':selected');
    const selectedModelId = selectedOption.data('model');
    const selectedModelSlug = selectedOption.val();
    await updateStateAndDropdown('model', selectedModelId, selectedModelSlug);

  });

  $trimSelect.on('change', () => {
    const selectedOption = $trimSelect.find(':selected');
    vehicleState.trim = {
      id: selectedOption.data('trim') || '',
      slug: selectedOption.val() || '',
      link: selectedOption.data('link') || '',
    };
    // Save trim only when it has a valid ID
    if (vehicleState.trim.id) {
      cache.set('selectedTrim', JSON.stringify(vehicleState.trim));
    }

    console.log('Trim selected');
    console.log('isQuotePage', isQuotePage);
    // console.debug(
    //     `Trim selected - ID: ${vehicleState.trim.id}, Slug: ${vehicleState.trim.slug}, Link: ${vehicleState.trim.link}`
    // );
    updateSearchButton();
    updateUrlSegments();
  });

  // Initialize selects on page load
  await initialize();
});
