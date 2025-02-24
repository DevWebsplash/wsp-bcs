<?php
/**
 * Airtable Sync Functions
 * Description: Синхронізація даних між Airtable та WordPress.
 * Syncs only the title from Airtable to WordPress.
 */
if (!defined('ABSPATH')) {
  exit;
}

// Визначення URL плагіну для зручного підключення assets
// Визначення констант для зручного підключення файлів і assets
if ( ! defined( 'BCS_AIRTABLE_URL' ) ) {
  define( 'BCS_AIRTABLE_URL', get_template_directory_uri() . '/functions/airtable/' );
}
if ( ! defined( 'BCS_AIRTABLE_PATH' ) ) {
  define( 'BCS_AIRTABLE_PATH', get_template_directory() . '/functions/airtable/' );
}

require_once __DIR__ . '/includes/air-connections.php';
require_once __DIR__ . '/includes/air-admin.php';
require_once __DIR__ . '/includes/air-import.php';
require_once __DIR__ . '/includes/air-export.php';
require_once __DIR__ . '/includes/air-models.php';
require_once __DIR__ . '/functions/handle_test_connection.php';


add_action('init', function() {
//  new GS_Export_Admin();

//  new Airtable_Connections();
//  new Airtable_Admin();
//  new Airtable_Import();
//  new Airtable_Export();
});
