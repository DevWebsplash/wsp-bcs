<?php
/**
 * Airtable connections
 *
 * @package bcs/functions/airtable/includes
 */
if (!defined('ABSPATH')) {
  exit;
}
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
