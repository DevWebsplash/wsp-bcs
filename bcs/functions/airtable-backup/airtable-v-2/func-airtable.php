<?php
/**
 * Plugin Name: BCS Airtable Sync
 * Description: Синхронізація даних між Airtable та WordPress.
 * Version: 1.0.0
 * Author: Your Name
 */

// Забороняємо прямий доступ.
if ( ! defined( 'ABSPATH' ) ) {
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

// Підключення необхідних файлів
require_once BCS_AIRTABLE_PATH . 'includes/air-connections.php';
require_once BCS_AIRTABLE_PATH . 'includes/air-admin.php';
//require_once BCS_AIRTABLE_PATH . 'includes/air-import.php';
//require_once BCS_AIRTABLE_PATH . 'includes/air-export.php';
//require_once BCS_AIRTABLE_PATH . 'includes/air-models.php';
//require_once __DIR__ . '/includes/air-models.php';

// Ініціалізація функціоналу плагіну
function bcs_sync_init() {
  // Можна додати додаткові ініціалізаційні хуки або фільтри
}
add_action( 'plugins_loaded', 'bcs_sync_init' );





add_action('init', function() {
//  new GS_Export_Admin();

//  new Airtable_Connections();
//  new Airtable_Admin();
//  new Airtable_Import();
//  new Airtable_Export();
});



