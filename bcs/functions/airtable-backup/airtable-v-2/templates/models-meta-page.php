<?php
/**
 * Сторінка Models Meta Page
 * Відображає результати імпорту даних з Airtable.
 */

// Забороняємо прямий доступ
if (!defined ('ABSPATH')) {
  exit;
}

function bcs_fetch_airtable_data_callback () {
  if (!check_ajax_referer ('fetch_airtable_data', 'nonce', false)) {
    wp_send_json_error (['message' => 'Invalid security token']);
    return;
  }

    $offset = isset($_POST['offset']) ? sanitize_text_field($_POST['offset']) : '';

    try {
    $result = bcs_plugin_get_airtable_data ($offset);
    $data = json_decode ($result, true);

    if (json_last_error () !== JSON_ERROR_NONE) {
      wp_send_json_error (['message' => 'Invalid response format']);
      return;
    }

        if (!isset($data['html'])) {
            wp_send_json_error(['message' => 'No data received']);
            return;
        }

    wp_send_json_success ($data);

  } catch (Exception $e) {
    wp_send_json_error (['message' => $e->getMessage ()]);
  }
}

add_action ('wp_ajax_fetch_airtable_data', 'bcs_fetch_airtable_data_callback');

// Initialize AJAX data
$ajax_nonce = wp_create_nonce ('fetch_airtable_data');
?>
<h2>Airtable Data Import</h2>
<button id="fetchAirtableData" class="button button-primary">Fetch from Airtable</button>
<div id="responseMessage" style="margin: 10px 0;"></div>
<table id="airtableTable" class="widefat" cellspacing="0">
  <thead>
  <tr>
    <th>Make</th>
    <th>Model</th>
    <th>Trim</th>
    <th>Status</th>
  </tr>
  </thead>
  <tbody></tbody>
</table>
<button id="loadMoreVehicles" class="button" style="display:none; margin-top: 10px;">Load More Vehicles</button>

<script>
  // Define the AJAX parameters
  const bcsAjax = {
    ajaxurl: '<?php echo admin_url ('admin-ajax.php'); ?>',
    nonce: '<?php echo wp_create_nonce('fetch_airtable_data'); ?>'
  };

  // Show message function
  function showMessage(message, isError = false) {
    const messageDiv = document.getElementById('responseMessage');
    messageDiv.innerHTML = message;
    messageDiv.style.color = isError ? 'red' : 'green';
  }

  function fetchAirtableData(offset = '') {
    // Show loading state
    document.getElementById('fetchAirtableData').disabled = true;
    showMessage('Loading data...');

    const formData = new FormData();
    formData.append('action', 'fetch_airtable_data');
    formData.append('nonce', bcsAjax.nonce);
    formData.append('offset', offset);

    fetch(bcsAjax.ajaxurl, {
      method: 'POST',
      credentials: 'same-origin',
        body: formData
    })
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.json();
        })
        .then(response => {
          if (!response.success) {
            throw new Error(response.data.message || 'Unknown error occurred');
          }

        const tbody = document.querySelector('#airtableTable tbody');
          if (response.data && response.data.html) {
            tbody.insertAdjacentHTML('beforeend', response.data.html);
            showMessage('Data loaded successfully!');
          }

        const loadMoreBtn = document.getElementById('loadMoreVehicles');
          if (response.data && response.data.next_offset) {
            loadMoreBtn.setAttribute('data-offset', response.data.next_offset);
            loadMoreBtn.style.display = 'block';
          } else {
            loadMoreBtn.style.display = 'none';
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showMessage(error.message, true);
        })
        .finally(() => {
          document.getElementById('fetchAirtableData').disabled = false;
        });
  }

  // Event Listeners
  document.getElementById('fetchAirtableData').addEventListener('click', () => fetchAirtableData());

  document.getElementById('loadMoreVehicles').addEventListener('click', function () {
    const nextOffset = this.getAttribute('data-offset');
    if (nextOffset) {
      fetchAirtableData(nextOffset);
    }
  });
</script>
