<?php

// admin-page.php

if (!defined ('ABSPATH')) {
  exit;
}

global $logOption, $logHistoryOption, $logNoticeOption;

?>
<div class="wrap">
  <h1>Airtable Sync Admin Page</h1>
  <p>Welcome to the Airtable Sync Admin Page. Use the menu on the left to navigate through the options.</p>
</div>
<div class="wrap">
  <h1><?php _e( 'Airtable Logs', 'bcs' ); ?></h1>

  <!-- Форма для тестування з’єднання -->
  <form method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
    <?php wp_nonce_field( 'bcs_test_action', 'bcs_test_nonce' ); ?>
    <input type="hidden" name="action" value="bcs_test_connection">
    <input type="submit" class="button button-primary" value="<?php esc_attr_e( 'Test Connection', 'bcs' ); ?>">
  </form>

  <!-- Форма для очищення логів -->
  <form method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" style="margin-top:20px;">
    <?php wp_nonce_field( 'bcs_clear_action', 'bcs_clear_nonce' ); ?>
    <input type="hidden" name="action" value="bcs_clear_logs">
    <input type="submit" class="button" value="<?php esc_attr_e( 'Clear Logs', 'bcs' ); ?>">
  </form>

  <!-- Відображення логів -->
  <div class="logs">
    <div class="logs">
      <?php
      // Формуємо шлях до файлу логів
      $log_file = BCS_AIRTABLE_PATH . 'logs.txt';

      // Перевіряємо чи файл існує
      if ( file_exists( $log_file ) ) {
        // Отримуємо вміст файлу
        $logs = file_get_contents( $log_file );
        // Виводимо вміст, обгортаючи у тег <pre> для зручного форматування
        echo '<pre>' . esc_html( $logs ) . '</pre>';
      } else {
        echo '<p>No logs available.</p>';
      }
      ?>
    </div>
  </div>
</div>
