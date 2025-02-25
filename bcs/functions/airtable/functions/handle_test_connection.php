<?php

if (!defined ('ABSPATH')) {
  exit;
}

add_action ('admin_post_bcs_test_connection', 'bcs_handle_test_connection');
function bcs_handle_test_connection() {
  if (!isset($_POST['bcs_test_nonce']) || !wp_verify_nonce($_POST['bcs_test_nonce'], 'bcs_test_action')) {
    wp_die('Invalid nonce');
  }

  if (!isset($_POST['test_table']) || empty($_POST['test_table'])) {
    wp_die('Please select a table to test');
  }

  global $pat, $baseId;
  $test_table = sanitize_text_field($_POST['test_table']);

  // Get table name from key
  global $tables;
  $table_name = array_search($test_table, $tables) ?: $test_table;

  $airtable_api_url = "https://api.airtable.com/v0/{$baseId}/{$test_table}";

  $args = array(
      'headers' => array(
          'Authorization' => 'Bearer ' . $pat,
          'Content-Type'  => 'application/json'
      ),
      'timeout' => 10,
  );

  $response = wp_remote_get($airtable_api_url, $args);

  if (is_wp_error($response)) {
    $error_message = $response->get_error_message();
    bcs_log_event('Airtable connection failed: ' . $error_message, $table_name);
    wp_redirect(admin_url('admin.php?page=bcs-airtable-sync&status=failed'));
    exit;
  }

  $code = wp_remote_retrieve_response_code($response);
  if ($code == 200) {
    bcs_log_event('Airtable connection successful.', $table_name);
    wp_redirect(admin_url('admin.php?page=bcs-airtable-sync&status=success'));
    exit;
  } else {
    $body = wp_remote_retrieve_body($response);
    bcs_log_event('Airtable connection failed: HTTP code ' . $code . ' Response: ' . $body, $table_name);
    wp_redirect(admin_url('admin.php?page=bcs-airtable-sync&status=failed'));
    exit;
  }
}
