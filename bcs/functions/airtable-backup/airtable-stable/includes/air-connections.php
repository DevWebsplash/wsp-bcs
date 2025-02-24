<?php
/**
 * Airtable connections
 *
 * @package bcs/functions/airtable/includes
 */
if (!defined('ABSPATH')) {
  exit;
}

// wp-config.php
define('AIRTABLE_PAT', 'patkpWz5coirjheoV.a8dc92e7f906af8d8ad3fa06671fa176cbe48662930c73f9cae52f1c1aea8aab');
define('AIRTABLE_BASE_ID', 'appu3QXHr7ai2NLwi');
define('AIRTABLE_TABLE_NAME', 'tblXbISQ9nRhz0YfJ');

define('AIRTABLE_TABLE_MODELS_Meta', 'tblk2WqLZS5wdPPqp');
// Recommended: Store sensitive data in environment variables or constants
// Define constants in `wp-config.php`
// define('AIRTABLE_PAT', 'your_airtable_pat');
// define('AIRTABLE_BASE_ID', 'your_base_id');


// Replace with your actual token, base ID, and table name
//$pat       = AIRTABLE_PAT; // Airtable Personal Access Token
//$baseId    = AIRTABLE_BASE_ID; // Airtable Base ID
//$tableName = AIRTABLE_TABLE_NAME; // Airtable Table Name
//
//$tableModelsMeta = AIRTABLE_TABLE_NAME; // Airtable Table MODELS Meta



$pat       = 'patkpWz5coirjheoV.a8dc92e7f906af8d8ad3fa06671fa176cbe48662930c73f9cae52f1c1aea8aab';
$baseId    = 'appu3QXHr7ai2NLwi';
$tableName = 'tblXbISQ9nRhz0YfJ';

$tableModelsMeta = 'tblk2WqLZS5wdPPqp';

//$tableName = urlencode('Vehicle List Incl. Variant');

$postType  = 'vehicle'; // WordPress Post Type
$logOption = 'bcs_plugin_error_log'; // Option name for storing error logs
$logHistoryOption = 'bcs_plugin_error_history';
// Define a new option for test notices
$logNoticeOption = 'bcs_plugin_test_notice';
