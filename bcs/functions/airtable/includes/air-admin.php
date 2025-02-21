<?php
/**
 * Admin page for Airtable error logs
 *
 * @package BCS Plugin
 */

if (!defined('ABSPATH')) {
  exit;
}


add_action('admin_menu', 'bcs_plugin_create_menu');
add_action('admin_menu', 'bcs_plugin_create_submenu');

// Process the form submission
add_action('admin_init', 'bcs_plugin_handle_test_button');
// Handle the "Clear Logs" button submission
add_action('admin_init', 'bcs_plugin_handle_clear_logs');

//require_once __DIR__ . '/includes/air-import.php';

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


function bcs_plugin_create_submenu() {
  add_submenu_page(
      'bcs_airtable_logs', // Parent slug
      'Airtable Data', // Page title
      'Airtable Data', // Menu title
      'manage_options', // Capability
      'bcs_airtable_data', // Menu slug
      'bcs_plugin_display_airtable_data_page' // Callback function
  );
}


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





function bcs_plugin_handle_clear_logs() {
	global $logOption;
	if (isset($_POST['clear_log_nonce_field']) &&
	    wp_verify_nonce($_POST['clear_log_nonce_field'], 'clear_log_nonce_key')) {
		update_option($logOption, array());
		wp_redirect(admin_url('admin.php?page=bcs_airtable_logs'));
		exit;
	}
}


function log_airtable_error($message) {
	global $logOption, $logHistoryOption;
	// Save only the current/most recent error
	update_option($logOption, array(date('Y-m-d H:i:s') . ' - ' . $message));

	// Append the same entry to the history
	$history = get_option($logHistoryOption, array());
	$history[] = date('Y-m-d H:i:s') . ' - ' . $message;
	update_option($logHistoryOption, $history);
}


function log_airtable_notice($message) {
	global $logNoticeOption;
	// Save the test notice
	update_option($logNoticeOption, array(date('Y-m-d H:i:s') . ' - ' . $message));
}




