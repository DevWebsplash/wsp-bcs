<?php
// 🔹 Функція отримання даних із Airtable (з підтримкою офсету)
function bcs_plugin_get_airtable_data($offset = '') {
	global $pat, $baseId, $tableName;

	$endpoint = "https://api.airtable.com/v0/{$baseId}/{$tableName}?pageSize=100";
	if (!empty($offset)) {
		$endpoint .= "&offset={$offset}";
	}

	$response = wp_remote_get($endpoint, array(
		'headers' => array(
			'Authorization' => 'Bearer ' . $pat,
			'Content-Type'  => 'application/json'
		)
	));

	if (is_wp_error($response)) {
		return json_encode(['error' => 'Error fetching data from Airtable: ' . esc_html($response->get_error_message())]);
	}

	$body = wp_remote_retrieve_body($response);
	$data = json_decode($body, true);

	if (empty($data['records'])) {
		return json_encode(['message' => 'No records found.']);
	}

	return json_encode([
		'html' => bcs_plugin_process_airtable_data($data['records']),
		'next_offset' => isset($data['offset']) ? $data['offset'] : ''
	]);
}

// 🔹 Функція обробки та імпорту одного запису
function bcs_plugin_process_airtable_data($records) {
	if (empty($records)) {
		return '<p>No new records to process.</p>';
	}

	$output = '';
	$created = false; // Створюємо лише один запис

	foreach ($records as $record) {
		$fields = $record['fields'];

		if (!empty($fields['Make']) && !empty($fields['Model']) && !empty($fields['Trim'])) {
			$trim_name = sanitize_text_field($fields['Trim']);
			$make_name = sanitize_text_field($fields['Make']);
			$model_name = sanitize_text_field($fields['Model']);
			$status = '<span style="color: blue;">Skipped</span>';

			if (!$created) {
				$existing_post = get_page_by_title($trim_name, OBJECT, 'vehicle');

				if (!$existing_post) {
					// Додаємо Make (батьківська категорія)
					$make_term = term_exists($make_name, 'make');
					if (!$make_term) {
						$make_term = wp_insert_term($make_name, 'make');
						if (!is_wp_error($make_term)) {
							$make_term_id = $make_term['term_id'];
						}
					} else {
						$make_term_id = is_array($make_term) ? $make_term['term_id'] : $make_term;
					}

					// Додаємо Model (дочірня категорія Make)
					$model_term = term_exists($model_name, 'make');
					if (!$model_term) {
						$model_term = wp_insert_term($model_name, 'make', array(
							'parent' => intval($make_term_id)
						));
						if (!is_wp_error($model_term)) {
							$model_term_id = $model_term['term_id'];
						}
					} else {
						$model_term_id = is_array($model_term) ? $model_term['term_id'] : $model_term;
					}

					// Створюємо запис у CPT `vehicle`
					$post_id = wp_insert_post(array(
						'post_title'  => $trim_name,
						'post_type'   => 'vehicle',
						'post_status' => 'publish'
					));

					if (!is_wp_error($post_id)) {
						wp_set_object_terms($post_id, array(intval($make_term_id), intval($model_term_id)), 'make');
						$status = '<span style="color: green;">✔ Created</span>';
					} else {
						$status = '<span style="color: red;">✘ Error</span>';
					}
				} else {
					$status = '<span style="color: blue;">Already Exists</span>';
				}

				$created = true;
			}

			$output .= '<tr><td>' . esc_html($make_name) . '</td><td>' . esc_html($model_name) . '</td><td>' . esc_html($trim_name) . '</td><td>' . $status . '</td></tr>';
		}
	}

	return $output;
}

// 🔹 AJAX для кнопки "Load More Vehicles"
add_action('wp_ajax_fetch_airtable_data', function() {
	$offset = isset($_POST['offset']) ? sanitize_text_field($_POST['offset']) : '';
	echo bcs_plugin_get_airtable_data($offset);
	wp_die();
});

// 🔹 Форма з кнопками Fetch і Load More
function bcs_plugin_display_airtable_data_page() {
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
      document.getElementById("fetchAirtableData").addEventListener("click", function() {
          fetchAirtableData('');
      });

      document.getElementById("loadMoreVehicles").addEventListener("click", function() {
          let nextOffset = this.getAttribute("data-offset");
          fetchAirtableData(nextOffset);
      });

      function fetchAirtableData(offset) {
          let formData = new FormData();
          formData.append('action', 'fetch_airtable_data');
          formData.append('offset', offset);

          fetch(ajaxurl, {
              method: 'POST',
              body: formData
          })
              .then(response => response.json())
              .then(data => {
                  if (data.html) {
                      document.getElementById("airtableTable").innerHTML += data.html;
                  }
                  if (data.next_offset) {
                      let loadMoreBtn = document.getElementById("loadMoreVehicles");
                      loadMoreBtn.setAttribute("data-offset", data.next_offset);
                      loadMoreBtn.style.display = "block";
                  } else {
                      document.getElementById("loadMoreVehicles").style.display = "none";
                  }
              })
              .catch(error => console.error('Error:', error));
      }
	</script>
	<?php
}

// 🔹 Додаємо сторінку в адмінку
add_action('admin_menu', function() {
	add_submenu_page('tools.php', 'Airtable Data Import', 'Airtable Data Import', 'manage_options', 'airtable-data-import', 'bcs_plugin_display_airtable_data_page');
});
