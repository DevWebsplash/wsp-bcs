<?php
if (!defined ('ABSPATH')) {
  exit;
}


global $logOption, $logHistoryOption, $logNoticeOption, $tables;
$tables = array(
    'Vehicles List' => AIRTABLE_TABLE_NAME,
    'Models Meta' => AIRTABLE_TABLE_MODELS_Meta,
    'WordPress Trims' => AIRTABLE_TABLE_WordpressTrims
);

// Додайте перевірку конфігурації
$config_status = bcs_validate_airtable_config ();
?>

<div class="wrapper">
  <h1>Airtable Sync Admin Page</h1>
  <p>Welcome to the Airtable Sync Admin Page. Use the menu on the left to navigate through the options.</p>
  <?php if (!$config_status): ?>
    <div class="notice notice-error">
      <p>Please configure Airtable settings before proceeding.</p>
    </div>
  <?php endif; ?>
</div>
<div class="air-wrapper">
  <div class="air-connections">
    <h2><?php _e ('Airtable Logs', 'bcs'); ?></h2>


    <!-- Форма для тестування з'єднання -->
    <form method="post" action="<?php echo esc_url (admin_url ('admin-post.php')); ?>" class="test-connection-form">
      <?php wp_nonce_field ('bcs_test_action', 'bcs_test_nonce'); ?>
      <input type="hidden" name="action" value="bcs_test_connection">
      <select name="test_table" required>
        <option value=""><?php _e ('Select table to test', 'bcs'); ?></option>
        <?php foreach ($tables as $key => $table): ?>
          <option value="<?php echo esc_attr ($table); ?>"><?php echo esc_html ($key); ?></option>
        <?php endforeach; ?>
      </select>
      <input type="submit" class="button button-primary" value="<?php esc_attr_e ('Test Connection', 'bcs'); ?>">
    </form>

    <h2><?php _e ('Logs', 'bcs'); ?></h2>

    <!-- Форма очищення логів -->
    <form method="post" action="<?php echo esc_url (admin_url ('admin-post.php')); ?>" class="clear-logs-form">
      <?php wp_nonce_field ('bcs_clear_action', 'bcs_clear_nonce'); ?>
      <input type="hidden" name="action" value="bcs_clear_logs">
      <input type="submit" class="button" value="<?php esc_attr_e ('Clear Logs', 'bcs'); ?>">
    </form>

    <!-- Відображення логів -->
    <div class="logs-wrapper">
      <?php bcs_display_logs (); ?>
    </div>
  </div>
  <div class="air-export">
    <h2><?php _e ('Manual Export', 'bcs'); ?></h2>
    <?php
    if ($config_status) {
      bcs_add_export_button ();
    }
    ?>
  </div>
</div>
</div>
