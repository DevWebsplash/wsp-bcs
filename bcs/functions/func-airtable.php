<?php
/**
 * Airtable Sync Functions
 *
 * Syncs only the title from Airtable to WordPress.
 */

// Recommended: Store sensitive data in environment variables or constants
// Define constants in `wp-config.php`
// define('AIRTABLE_PAT', 'your_airtable_pat');
// define('AIRTABLE_BASE_ID', 'your_base_id');

// Replace with your actual token, base ID, and table name
$pat       = 'patkpWz5coirjheoV.a8dc92e7f906af8d8ad3fa06671fa176cbe48662930c73f9cae52f1c1aea8aab'; // Airtable Personal Access Token
$baseId    = 'appu3QXHr7ai2NLwi'; // Airtable Base ID
$tableName = 'tblXbISQ9nRhz0YfJ'; // Airtable Table Name
//$tableName = urlencode('Vehicle List Incl. Variant');

$postType  = 'vehicle'; // WordPress Post Type
$logOption = 'bcs_plugin_error_log'; // Option name for storing error logs
$logHistoryOption = 'bcs_plugin_error_history';
// Define a new option for test notices
$logNoticeOption = 'bcs_plugin_test_notice';


/**
 * Create an admin page to display error logs
 */
add_action('admin_menu', 'bcs_plugin_create_menu');
function bcs_plugin_create_menu() {
  $pageTitle = 'Airtable Error Logs';
  $menuTitle = 'Airtable Logs';
  $menuSlug  = 'bcs_airtable_logs';
  add_menu_page(
      $pageTitle,
      $menuTitle,
      'manage_options',
      $menuSlug,
      'bcs_plugin_logs_page'
  );
}

/**
 * Display the error logs on the admin page
 */
// Add a button in bcs_plugin_logs_page
function bcs_plugin_logs_page() {
  global $logOption, $logHistoryOption, $logNoticeOption;

  echo '<h2>Current Airtable Error Logs</h2>';
  $currentError = get_option($logOption, array());
  if (!empty($currentError)) {
    echo '<div class="error" style="max-height: 500px; overflow: auto; max-width: 100%"><p>' . implode("\n", $currentError) . '</p></div>';
  } else {
    echo '<div class="updated"><p>No current error.</p></div>';
  }

  echo '<h2>Test Notices</h2>';
  $testNotice = get_option($logNoticeOption, array());
  if (!empty($testNotice)) {
    echo '<div class="update-nag notice notice-warning" style="max-height: 500px; overflow: auto; max-width: 100%"><p>' . implode("\n", $testNotice) . '</p></div>';
  } else {
    echo '<p>No test notices.</p>';
  }

  // Button form
  echo '<form method="post" action="">';
  wp_nonce_field('airtable_test_nonce', 'airtable_test_nonce_field');
  submit_button('Test Airtable Connection');
  echo '</form>';

  // Clear Logs form
  echo '<form method="post" style="display:inline;">';
  wp_nonce_field('clear_log_nonce_key', 'clear_log_nonce_field');
  submit_button('Clear Logs', 'secondary');
  echo '</form>';

  echo '<h2>History of Airtable Error Logs</h2>';
  $history = get_option($logHistoryOption, array());
  if (!empty($history)) {
    echo '<div class="error" style="max-height: 500px; overflow: auto; max-width: 100%"><pre>' . implode("\n", $history) . '</pre></div>';
  } else {
    echo '<p>No error history.</p>';
  }
}

// Process the form submission
add_action('admin_init', 'bcs_plugin_handle_test_button');
function bcs_plugin_handle_test_button() {
  global $pat, $baseId, $tableName;

  if (isset($_POST['airtable_test_nonce_field']) && wp_verify_nonce($_POST['airtable_test_nonce_field'], 'airtable_test_nonce')) {
    // Replace with your actual endpoint and header
    $endpoint = "https://api.airtable.com/v0/{$baseId}/{$tableName}";
    $headers = array(
        'Authorization' => 'Bearer ' . $pat,
        'Content-Type'  => 'application/json'
    );
    $response = wp_remote_get($endpoint, array('headers' => $headers));

    // Log the raw response object
    // log_airtable_error('Raw response: ' . print_r($response, true));

    if (is_wp_error($response)) {
      log_airtable_error('Error: ' . $response->get_error_message());
    } else {
      $body = wp_remote_retrieve_body($response);
      log_airtable_notice('Test response: ' . print_r($body, true));
    }
    // Redirect back to logs page
    wp_redirect(admin_url('admin.php?page=bcs_airtable_logs'));
    exit;
  }
}

// Handle the "Clear Logs" button submission
add_action('admin_init', 'bcs_plugin_handle_clear_logs');
function bcs_plugin_handle_clear_logs() {
  global $logOption;
  if (isset($_POST['clear_log_nonce_field']) &&
      wp_verify_nonce($_POST['clear_log_nonce_field'], 'clear_log_nonce_key')) {
    update_option($logOption, array());
    wp_redirect(admin_url('admin.php?page=bcs_airtable_logs'));
    exit;
  }
}

/**
 * Log errors in WordPress options
 *
 * @param string $message The error message to log
 */
function log_airtable_error($message) {
  global $logOption, $logHistoryOption;
  // Save only the current/most recent error
  update_option($logOption, array(date('Y-m-d H:i:s') . ' - ' . $message));

  // Append the same entry to the history
  $history = get_option($logHistoryOption, array());
  $history[] = date('Y-m-d H:i:s') . ' - ' . $message;
  update_option($logHistoryOption, $history);
}

/**
 * Log test notices in WordPress options
 *
 * @param string $message The test notice message to log
 */
function log_airtable_notice($message) {
  global $logNoticeOption;
  // Save the test notice
  update_option($logNoticeOption, array(date('Y-m-d H:i:s') . ' - ' . $message));
}








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

/**
 * Sync data from WordPress to Airtable
 *
 * @param int $post_id The ID of the post being saved
 */
//function sync_wp_to_airtable($post_id) {
//    global $pat, $baseId, $tableName, $postType;
//    if (get_post_type($post_id) !== $postType) {
//        return;
//    }
//
//    $airtable_id = get_post_meta($post_id, 'airtable_id', true);
//    if (!$airtable_id) {
//        return;
//    }
//
//    $fields = array(
//        'Make'  => get_post_meta($post_id, 'make', true),
//        'Model' => get_post_meta($post_id, 'model', true),
//        'Year'  => get_post_meta($post_id, 'year', true),
//    );
//
//    $endpoint = "https://api.airtable.com/v0/{$baseId}/{$tableName}/" . $airtable_id;
//    $response = wp_remote_request($endpoint, array(
//        'method'  => 'PATCH',
//        'headers' => array(
//            'Authorization' => 'Bearer ' . $pat,
//            'Content-Type'  => 'application/json'
//        ),
//        'body'    => json_encode(array('fields' => $fields))
//    ));
//
//    if (is_wp_error($response)) {
//        log_airtable_error('Error updating data to Airtable: ' . $response->get_error_message());
//    }
//}
//
//add_action('save_post_vehicle', 'sync_wp_to_airtable');

