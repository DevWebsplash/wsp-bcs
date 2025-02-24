<?php
/**
 * Admin page for Airtable error logs (інтегровано в тему)
 *
 * @package BCS Plugin
 */

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Регістрація адмін-меню та прив’язка обробників форм
 */
add_action( 'admin_menu', 'bcs_register_admin_menu' );
// Використовуємо admin_post_ для обробки POST-запитів із форм
add_action( 'admin_post_bcs_test_connection', 'bcs_handle_test_connection' );
add_action( 'admin_post_bcs_clear_logs', 'bcs_handle_clear_logs' );
//add_action('admin_init', 'bcs_plugin_handle_test_button');
//add_action('admin_init', 'bcs_plugin_handle_clear_logs');

/**
 * Регіструє сторінки адмін-панелі для модуля.
 */
function bcs_register_admin_menu() {
  // Головна сторінка модуля
  add_menu_page(
      __( 'Airtable Sync', 'bcs' ),
      __( 'Airtable Data', 'bcs' ),
      'manage_options',
      'bcs-airtable-sync',
      'bcs_admin_page_callback',
      'dashicons-cloud',
      6
  );

  // Підменю "Логи"
  add_submenu_page(
      'bcs-airtable-sync',
      __( 'Airtable Logs', 'bcs' ),
      __( 'Airtable Logs', 'bcs' ),
      'manage_options',
      'bcs-airtable-logs',
      'bcs_logs_page_callback'
  );

  // Підменю "Models Meta"
  add_submenu_page(
      'bcs-airtable-sync',
      __( 'Airtable Models Meta', 'bcs' ),
      __( 'Models Meta', 'bcs' ),
      'manage_options',
      'bcs-airtable-models',
//      'bcs_plugin_display_airtable_data_page'
      'bcs_models_page_callback'
  );
}

/**
 * Callback для головної сторінки адмін-панелі модуля.
 */
function bcs_admin_page_callback() {
  include BCS_AIRTABLE_PATH . 'templates/admin-page.php';
}

/**
 * Callback для сторінки логів.
 */
function bcs_logs_page_callback() {
  include BCS_AIRTABLE_PATH . 'templates/logs-page.php';
}

/**
 * Callback для сторінки з моделями.
 */
function bcs_models_page_callback() {
  include BCS_AIRTABLE_PATH . 'templates/models-meta-page.php';
}

/**
 * Обробка запиту для тестування з’єднання з Airtable.
 * Виконується перевірка nonce, спроба підключення до Airtable і запис результату в логи.
 */
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

/**
 * Обробка запиту для очищення логів.
 * Виконується перевірка nonce і, у разі успішної перевірки, файл логів очищається.
 */
function bcs_handle_clear_logs() {
  if ( isset( $_POST['bcs_clear_nonce'] ) && wp_verify_nonce( $_POST['bcs_clear_nonce'], 'bcs_clear_action' ) ) {
    // Очищення логів – у цьому прикладі ми видаляємо вміст файлу логів.
    $log_file = BCS_AIRTABLE_PATH . 'logs.txt';
    if ( file_exists( $log_file ) ) {
        // Очищаємо файл, записуючи порожній рядок
        file_put_contents( $log_file, '' );
        bcs_log_event( 'Logs cleared by user.' );
    }
    wp_redirect( admin_url( 'admin.php?page=bcs-airtable-sync&status=cleared' ) );
    exit;
  }
}

/**
 * Допоміжна функція для запису подій у логи.
 * Записує повідомлення у файл логів (logs.txt), розташований у модулі.
 *
 * @param string $message Повідомлення для запису.
 */
function bcs_log_event( $message ) {
    $log_file = BCS_AIRTABLE_PATH . 'logs.txt';
    $date     = date( 'Y-m-d H:i:s' );
    $log_msg  = "[{$date}] {$message}" . PHP_EOL;
    file_put_contents( $log_file, $log_msg, FILE_APPEND );
}

/**
 * Підключення стилів та скриптів до адмін-панелі.
 * Завантажуємо assets лише на сторінках модуля.
 */
function bcs_admin_enqueue_assets( $hook ) {
  // Завантаження активне лише для наших сторінок:
  // toplevel_page_bcs-airtable-sync, bcs_page_bcs-airtable-logs, bcs_page_bcs-airtable-models
  if ( ! in_array( $hook, array( 'toplevel_page_bcs-airtable-sync', 'bcs_page_bcs-airtable-logs', 'bcs_page_bcs-airtable-models' ) ) ) {
    return;
  }

  wp_enqueue_style( 'bcs-admin-styles', BCS_AIRTABLE_URL . 'assets/css/styles.css', array(), '1.0.0' );
  wp_enqueue_script( 'bcs-admin-scripts', BCS_AIRTABLE_URL . 'assets/js/scripts.js', array( 'jquery' ), '1.0.0', true );
}
add_action( 'admin_enqueue_scripts', 'bcs_admin_enqueue_assets' );





// ...................................................
//
//function bcs_plugin_handle_test_button() {
//    global $pat, $baseId, $tableName;
//
//  if (isset($_POST['airtable_test_nonce_field']) && wp_verify_nonce($_POST['airtable_test_nonce_field'], 'airtable_test_nonce')) {
//        $endpoint = "https://api.airtable.com/v0/{$baseId}/{$tableName}";
//    $headers = array(
//        'Authorization' => 'Bearer ' . $pat,
//        'Content-Type'  => 'application/json'
//    );
//    $response = wp_remote_get($endpoint, array('headers' => $headers));
//
//    if (is_wp_error($response)) {
//      log_airtable_error('Error: ' . $response->get_error_message());
//    } else {
//      $body = wp_remote_retrieve_body($response);
//
//      log_airtable_notice('Test response: ' . print_r($body, true));
//    }
//    wp_redirect(admin_url('admin.php?page=bcs-airtable-logs'));
//    exit;
//  }
//}
//
//function bcs_plugin_handle_clear_logs() {
//	global $logOption;
//	if (isset($_POST['clear_log_nonce_field']) &&
//	    wp_verify_nonce($_POST['clear_log_nonce_field'], 'clear_log_nonce_key')) {
//		update_option($logOption, array());
//		wp_redirect(admin_url('admin.php?page=bcs_airtable_logs'));
//		exit;
//	}
//}
//
//
//
//function bcs_plugin_logs_page() {
//  global $logOption, $logHistoryOption, $logNoticeOption;
//
//  echo '<h2>Current Airtable Error Logs</h2>';
//  $currentError = get_option($logOption, array());
//  if (!empty($currentError)) {
//    echo '<div class="error" style="max-height: 500px; overflow: auto; max-width: 100%"><p>' . implode("\n", $currentError) . '</p></div>';
//  } else {
//    echo '<div class="updated"><p>No current error.</p></div>';
//  }
//
//  echo '<h2>Test Notices</h2>';
//  $testNotice = get_option($logNoticeOption, array());
//  if (!empty($testNotice)) {
//    echo '<div class="update-nag notice notice-warning" style="max-height: 500px; overflow: auto; max-width: 100%"><p>' . implode("\n", $testNotice) . '</p></div>';
//  } else {
//    echo '<p>No test notices.</p>';
//  }
//
//  // Button form
//  echo '<form method="post" action="">';
//  wp_nonce_field('airtable_test_nonce', 'airtable_test_nonce_field');
//  submit_button('Test Airtable Connection');
//  echo '</form>';
//
//  // Clear Logs form
//  echo '<form method="post" style="display:inline;">';
//  wp_nonce_field('clear_log_nonce_key', 'clear_log_nonce_field');
//  submit_button('Clear Logs', 'secondary');
//  echo '</form>';
//
//  echo '<h2>History of Airtable Error Logs</h2>';
//  $history = get_option($logHistoryOption, array());
//  if (!empty($history)) {
//    echo '<div class="error" style="max-height: 500px; overflow: auto; max-width: 100%"><pre>' . implode("\n", $history) . '</pre></div>';
//  } else {
//    echo '<p>No error history.</p>';
//  }
//}


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







// .................................................
//add_action('admin_menu', 'bcs_plugin_create_menu');
//function bcs_plugin_create_menu() {
//  add_menu_page(
//      'Airtable Error Logs',
//      'Airtable Logs',
//      'manage_options',
//      'bcs_airtable_logs',
//      'bcs_plugin_logs_page'
//  );
//}
//add_action('admin_menu', 'bcs_plugin_create_submenu');
//function bcs_plugin_create_submenu() {
//  add_submenu_page(
//      'bcs_airtable_logs',
//      'Airtable Data',
//      'Airtable Data',
//      'manage_options',
//      'bcs_airtable_data',
//      'bcs_plugin_display_airtable_data_page'
//  );
//}
//add_action('admin_menu', 'bcs_plugin_create_submenu_models_meta');
//function bcs_plugin_create_submenu_models_meta() {
//  add_submenu_page(
//      'bcs_airtable_logs',
//      'Airtable Data MODELS Meta',
//      'Airtable Data MODELS Meta',
//      'manage_options',
//      'bcs_airtable_models_meta_data',
//      'bcs_display_airtable_models_meta_data_page'
//  );
//}
