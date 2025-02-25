<?php
if (!defined('ABSPATH')) {
  exit;
}

add_action('admin_post_bcs_test_connection', 'bcs_handle_test_connection');

function bcs_test_airtable_connection() {
  global $pat, $baseId;

  error_log("Testing Airtable connection...");
  error_log("Base ID: {$baseId}");

  // Спершу перевіряємо доступ до бази
  $url = "https://api.airtable.com/v0/meta/bases/{$baseId}";
  $response = wp_remote_get($url, [
      'headers' => [
          'Authorization' => "Bearer {$pat}",
          'Content-Type' => 'application/json'
      ],
      'timeout' => 30
  ]);

  if (is_wp_error($response)) {
    error_log("Connection test failed: " . $response->get_error_message());
    return false;
  }

  $status_code = wp_remote_retrieve_response_code($response);
  $body = wp_remote_retrieve_body($response);

  error_log("Connection test response code: {$status_code}");
  error_log("Connection test response: {$body}");

  return $status_code === 200;
}
function bcs_add_test_connection_button() {
  ?>
  <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" class="test-connection-form">
    <?php wp_nonce_field('bcs_test_connection', 'test_connection_nonce'); ?>
    <input type="hidden" name="action" value="bcs_test_connection">
    <input type="submit" class="button button-primary" value="Test Airtable Connection">
  </form>
  <?php
}

function bcs_validate_airtable_config() {
  global $pat, $baseId, $tableWordpressTrims;

  $errors = [];

  if (empty($pat)) {
    $errors[] = 'Personal Access Token is not configured';
  }

  if (empty($baseId)) {
    $errors[] = 'Base ID is not configured';
  }

  if (empty($tableWordpressTrims)) {
    $errors[] = 'Table ID is not configured';
  }

  if (!empty($errors)) {
    foreach ($errors as $error) {
      error_log("Airtable config error: {$error}");
    }
    return false;
  }

  return true;
}
