<?php
function bcs_plugin_get_airtable_models_meta_data($offset = '') {
	global $pat, $baseId, $tableModelsMeta;

	$endpoint = "https://api.airtable.com/v0/" . urlencode($baseId) . "/" . urlencode($tableModelsMeta) . "?pageSize=100";
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
		'html' => bcs_plugin_process_airtable_models_meta_data($data['records']),
		'next_offset' => isset($data['offset']) ? $data['offset'] : ''
	]);
}

function bcs_plugin_process_airtable_models_meta_data($records) {
	if (empty($records)) {
		return '<p>No new records to process.</p>';
	}

	$output = '';

	foreach ($records as $record) {
		$fields = $record['fields'];

		if (!empty($fields['title']) && !empty($fields['Descrp']) && !empty($fields['Vehicle Brand Logo'])) {
			$title = sanitize_text_field($fields['title']);
			$description = sanitize_textarea_field($fields['Descrp']);
			$logo = esc_url($fields['Vehicle Brand Logo']);

			// Шукаємо пост по заголовку
			$existing_post = get_page_by_title($title, OBJECT, 'vehicle');

			if ($existing_post) {
				$post_id = $existing_post->ID;

				// Отримуємо поточні значення Flexible Content
				$flexible_content = get_field('flixble_content_vehicle', $post_id);

				if (!$flexible_content || !is_array($flexible_content)) {
					$flexible_content = [];
				}

				// Шукаємо, чи вже є такий лейаут
				$found = false;
				foreach ($flexible_content as &$layout) {
					if ($layout['vehicle_brand_logo'] === $logo) {
						$layout['vehicle_description'] = $description; // Оновлюємо тільки description
						$found = true;
						break;
					}
				}

				if (!$found) {
					// Додаємо новий лейаут
					$flexible_content[] = [
						'acf_fc_layout' => 'technical_data', // Назва лейауту у Flexible Content
						'vehicle_brand_logo' => $logo,
						'vehicle_description' => $description
					];
				}

				// Оновлюємо поле ACF
				update_field('vehicle_flexible_content', $flexible_content, $post_id);

				$status = '<span style="color: green;">✔ Updated</span>';
			} else {
				// Створюємо новий запис у CPT `vehicle`
				$post_id = wp_insert_post(array(
					'post_title'  => $title,
					'post_type'   => 'vehicle',
					'post_status' => 'publish'
				));

				if (!is_wp_error($post_id)) {
					// Додаємо новий Flexible Content Layout
					$flexible_content = [
						[
							'acf_fc_layout' => 'vehicle_layout', // Назва лейауту у Flexible Content
							'vehicle_brand_logo' => $logo,
							'vehicle_description' => $description
						]
					];

					update_field('vehicle_flexible_content', $flexible_content, $post_id);
					$status = '<span style="color: green;">✔ Created</span>';
				} else {
					$status = '<span style="color: red;">✘ Error</span>';
				}
			}

			$output .= '<tr><td>' . esc_html($title) . '</td><td>' . esc_html($description) . '</td><td><img src="' . esc_url($logo) . '" width="50"></td><td>' . $status . '</td></tr>';
		}
	}

	return $output;
}


add_action('wp_ajax_fetch_airtable_models_meta_data', function() {
	$offset = isset($_POST['offset']) ? sanitize_text_field($_POST['offset']) : '';
	echo bcs_plugin_get_airtable_models_meta_data($offset);
	wp_die();
});
function bcs_display_airtable_models_meta_data_page() {
	?>
	<h2>Airtable Models Meta Data Import</h2>
	<button id="fetchAirtableModelsMetaData">Fetch from Airtable</button>
	<table id="airtableModelsMetaTable">
		<tr><th>Title</th><th>Description</th><th>Logo</th><th>Status</th></tr>
	</table>
	<button id="loadMoreModelsMeta" style="display:none;">Load More Vehicles</button>

	<script>
      document.getElementById("fetchAirtableModelsMetaData").addEventListener("click", function() {
          fetchAirtableModelsMetaData('');
      });

      document.getElementById("loadMoreModelsMeta").addEventListener("click", function() {
          let nextOffset = this.getAttribute("data-offset");
          fetchAirtableModelsMetaData(nextOffset);
      });

      function fetchAirtableModelsMetaData(offset) {
          let formData = new FormData();
          formData.append('action', 'fetch_airtable_models_meta_data');
          formData.append('offset', offset);

          fetch(ajaxurl, {
              method: 'POST',
              body: formData
          })
              .then(response => response.json())
              .then(data => {
                  if (data.html) {
                      document.getElementById("airtableModelsMetaTable").innerHTML += data.html;
                  }
                  if (data.next_offset) {
                      let loadMoreBtn = document.getElementById("loadMoreModelsMeta");
                      loadMoreBtn.setAttribute("data-offset", data.next_offset);
                      loadMoreBtn.style.display = "block";
                  } else {
                      document.getElementById("loadMoreModelsMeta").style.display = "none";
                  }
              })
              .catch(error => console.error('Error:', error));
      }
	</script>
	<?php
}



