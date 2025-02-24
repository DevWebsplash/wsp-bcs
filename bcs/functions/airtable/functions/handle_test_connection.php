<?php

if (!defined('ABSPATH')) {
  exit;
}

add_action( 'admin_post_bcs_test_connection', 'bcs_handle_test_connection' );
function bcs_handle_test_connection () {
  if (isset($_POST[ 'bcs_test_nonce' ]) && wp_verify_nonce ($_POST[ 'bcs_test_nonce' ], 'bcs_test_action')) {
    global $pat, $baseId, $tableName;  // ці змінні повинні бути визначені у файлі air-connections.php

    // Назва таблиці для тестування (змініть за потребою)
    $test_table = $tableName;
    $airtable_api_url = "https://api.airtable.com/v0/{$baseId}/{$test_table}";

    // Підготовка аргументів запиту з авторизацією
    $args = array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $pat,
        ),
        'timeout' => 10,
    );

    // Виконуємо запит до Airtable
    $response = wp_remote_get ($airtable_api_url, $args);

    if (is_wp_error ($response)) {
      $error_message = $response->get_error_message ();
      bcs_log_event ('Airtable connection failed: ' . $error_message);
      wp_redirect (admin_url ('admin.php?page=bcs-airtable-sync&status=failed'));
      exit;
    } else {
      $code = wp_remote_retrieve_response_code ($response);
      if ($code == 200) {
        bcs_log_event ('Airtable connection successful.');
        wp_redirect (admin_url ('admin.php?page=bcs-airtable-sync&status=success'));
        exit;
      } else {
        $body = wp_remote_retrieve_body ($response);
        bcs_log_event ('Airtable connection failed: HTTP code ' . $code . ' Response: ' . $body);
        wp_redirect (admin_url ('admin.php?page=bcs-airtable-sync&status=failed'));
        exit;
      }
    }
  }
}
