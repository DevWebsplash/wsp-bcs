<?php
/**
 * Airtable Sync Functions
 *
 * Syncs only the title from Airtable to WordPress.
 */

// Airtable API credentials (Рекомендується винести в wp-config.php)
$pat       = 'patE6bSNpJeISiotB'; // Airtable API Key
$baseId    = 'appu3QXHr7ai2NLwi'; // Airtable Base ID
$tableName = 'Vehicle List Incl. Variant'; // Airtable Table Name
$postType  = 'vehicle';  // WordPress Post Type

/**
 * Функція синхронізації тайтлу з Airtable у WordPress
 */
function sync_airtable_title_to_wp() {
	global $pat, $baseId, $tableName, $postType;

	$endpoint = "https://api.airtable.com/v0/{$baseId}/{$tableName}";
	$response = wp_remote_get($endpoint, array(
		'headers' => array('Authorization' => 'Bearer ' . $pat)
	));

	// Виведення респонсу у лог або на екран (тимчасово)
	error_log("Airtable API Response: " . print_r($response, true));

	if (is_wp_error($response)) {
		error_log('Error fetching data from Airtable: ' . $response->get_error_message());
		return;
	}

	$body = wp_remote_retrieve_body($response);
	$data = json_decode($body, true);

	// Виведення API-відповіді в браузер (тимчасово)
// Логування респонсу у debug.log замість виводу на екран
	error_log("Airtable API Response: " . print_r($data, true));
	if (!empty($data['records'])) {
		foreach ($data['records'] as $record) {
			$fields = $record['fields'];
			$post_id = get_post_id_by_meta('airtable_id', $record['id']);

			if ($post_id && !empty($fields['Make']) && !empty($fields['Model'])) {
				// Оновлення тільки тайтлу
				wp_update_post(array(
					'ID'         => $post_id,
					'post_title' => $fields['Make'] . ' ' . $fields['Model'],
				));
			}
		}
	}
}
add_action('admin_init', 'sync_airtable_title_to_wp'); // Запуск через адмінку для тестування

/**
 * Отримує ID поста у WordPress за значенням мета-поля
 */
function get_post_id_by_meta($meta_key, $meta_value) {
	global $wpdb;
	return $wpdb->get_var($wpdb->prepare(
		"SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = %s",
		$meta_key, $meta_value
	));
}

add_action('admin_init', function() {
	if (isset($_GET['run_airtable_sync'])) {
		sync_airtable_title_to_wp();
		echo "<h3>Airtable Sync Completed!</h3>";
		exit;
	}
});
