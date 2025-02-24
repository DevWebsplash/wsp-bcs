<?php
// logs-page.php

if (!defined('ABSPATH')) {
  exit;
}

global $logOption, $logHistoryOption, $logNoticeOption;

?>



<div class="admin-logs-page">
  <h1>Airtable Error Logs</h1>
  <h2>Current Airtable Error Logs</h2>
  <?php
  $currentError = get_option($logOption, array());
  if (!empty($currentError)) {
    echo '<div class="error" style="max-height: 500px; overflow: auto; max-width: 100%"><p>' . implode("\n", $currentError) . '</p></div>';
  } else {
    echo '<div class="updated"><p>No current error.</p></div>';
  }
  ?>

  <h2>Test Notices</h2>
  <?php
  $testNotice = get_option($logNoticeOption, array());
  if (!empty($testNotice)) {
    echo '<div class="update-nag notice notice-warning" style="max-height: 500px; overflow: auto; max-width: 100%"><p>' . implode("\n", $testNotice) . '</p></div>';
  } else {
    echo '<p>No test notices.</p>';
  }
  ?>

  <form method="post" action="">
    <?php wp_nonce_field('airtable_test_nonce', 'airtable_test_nonce_field'); ?>
    <?php submit_button('Test Airtable Connection'); ?>
  </form>

  <form method="post" style="display:inline;">
    <?php wp_nonce_field('clear_log_nonce_key', 'clear_log_nonce_field'); ?>
    <?php submit_button('Clear Logs', 'secondary'); ?>
  </form>

  <h2>History of Airtable Error Logs</h2>
  <?php
  $history = get_option($logHistoryOption, array());
  if (!empty($history)) {
    echo '<div class="error" style="max-height: 500px; overflow: auto; max-width: 100%"><pre>' . implode("\n", $history) . '</pre></div>';
  } else {
    echo '<p>No error history.</p>';
  }
  ?>
</div>


