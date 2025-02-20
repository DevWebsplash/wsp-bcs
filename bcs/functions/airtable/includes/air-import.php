<?php
function bcs_plugin_get_airtable_data() {
	global $pat, $baseId, $tableName;

	$endpoint = "https://api.airtable.com/v0/{$baseId}/{$tableName}";
	$response = wp_remote_get($endpoint, array(
		'headers' => array(
			'Authorization' => 'Bearer ' . $pat,
			'Content-Type'  => 'application/json'
		)
	));

	if (is_wp_error($response)) {
		return '<p>Error fetching data from Airtable: ' . esc_html($response->get_error_message()) . '</p>';
	}

	$body = wp_remote_retrieve_body($response);
	$data = json_decode($body, true);

	if (!empty($data['records'])) {
		$output = '<h3>Fetched Vehicles</h3>';
		$output .= '<table><tr><th>#</th><th>Make</th><th>Model</th><th>Trim</th><th>Status</th></tr>';
		$counter = 1;

		$created = false; // Флаг для створення лише одного запису

		foreach ($data['records'] as $record) {
			$fields = $record['fields'];

			if (!empty($fields['Make']) && !empty($fields['Model']) && !empty($fields['Trim'])) {
				$trim_name = sanitize_text_field($fields['Trim']);
				$make_name = sanitize_text_field($fields['Make']);
				$model_name = sanitize_text_field($fields['Model']);
				$status = '<span style="color: blue;">Skipped</span>'; // За замовчуванням запис пропущено

				// Якщо ще не створювали запис, додаємо його у CPT `vehicle`
				if (!$created) {
					$existing_post = get_page_by_title($trim_name, OBJECT, 'vehicle');

					if (!$existing_post) {
						// 1️⃣ Створюємо батьківську категорію `make`
						$make_term = term_exists($make_name, 'make'); // Перевіряємо, чи є такий make
						if (!$make_term) {
							$make_term = wp_insert_term($make_name, 'make'); // Створюємо make
							if (!is_wp_error($make_term)) {
								$make_term_id = $make_term['term_id'];
							}
						} else {
							$make_term_id = is_array($make_term) ? $make_term['term_id'] : $make_term;
						}

						// 2️⃣ Створюємо дочірню категорію `model` у таксономії `make`
						$model_term = term_exists($model_name, 'make'); // Перевіряємо, чи є такий model
						if (!$model_term) {
							$model_term = wp_insert_term($model_name, 'make', array(
								'parent' => intval($make_term_id) // Встановлюємо Make як батьківську категорію
							));
							if (!is_wp_error($model_term)) {
								$model_term_id = $model_term['term_id'];
							}
						} else {
							$model_term_id = is_array($model_term) ? $model_term['term_id'] : $model_term;
						}

						// 3️⃣ Створюємо запис у CPT `vehicle`
						$post_id = wp_insert_post(array(
							'post_title'  => $trim_name,
							'post_type'   => 'vehicle',
							'post_status' => 'publish'
						));

						// 4️⃣ Прив'язуємо таксономію `make` (батьківська) і `model` (дочірня)
						if (!is_wp_error($post_id)) {
							wp_set_object_terms($post_id, array(intval($make_term_id), intval($model_term_id)), 'make');

							$status = '<span style="color: green;">✔ Created</span>';
						} else {
							$status = '<span style="color: red;">✘ Error</span>';
						}
					} else {
						$status = '<span style="color: blue;">Already Exists</span>';
					}

					$created = true; // Встановлюємо флаг, що 1 запис вже створено
				}

				// Додаємо всі записи у таблицю (але створюємо лише 1)
				$output .= '<tr><td>' . $counter++ . '</td><td>' . esc_html($make_name) . '</td><td>' . esc_html($model_name) . '</td><td>' . esc_html($trim_name) . '</td><td>' . $status . '</td></tr>';
			}
		}

		$output .= '</table>';
		return $output;
	}

	return '<p>No records found.</p>';
}
