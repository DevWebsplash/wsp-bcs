<?php
/**
 * Theme functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */

require_once 'functions/func-admin.php';
//require_once 'functions/func-debug.php';
require_once 'functions/func-menu.php';
require_once 'functions/func-script.php';
require_once 'functions/func-style.php';
require_once 'functions/func-ajax.php';

require_once 'functions/func-taxonomies.php';
require_once 'functions/func-woo.php';

require_once 'functions/airtable/func-airtable.php';


add_action('init', 'optimize_litespeed_for_vehicle_data');



function optimize_litespeed_for_vehicle_data() {
  if (class_exists('\LiteSpeed\Core')) {
    // Set longer cache time for taxonomy queries
    add_filter('litespeed_control_cacheable', function($cacheable, $type) {
      if (isset($_POST['action']) && in_array($_POST['action'], ['make_fetch', 'model_fetch', 'trim_fetch'])) {
        return true; // Make these AJAX calls cacheable
      }
      return $cacheable;
    }, 10, 2);
  }
}


//function update_acf_link_fields_in_flexible_content($post_id) {
//	// Отримуємо дані Flexible Content
//	if (have_rows('flixble_content_vehicle', $post_id)) {
//		while (have_rows('flixble_content_vehicle', $post_id)) {
//			the_row();
//
//			// Перевіряємо, чи існує поле "посилання"
//			if (get_sub_field('overview_left_side_image_link')) {
//				$imported_value = get_sub_field('overview_left_side_image_link');
//
//				// Розділяємо значення, якщо воно у форматі `URL|Title`
//				if (strpos($imported_value['url'], '|') !== false) {
//					$parts = explode('|', $imported_value['url']);
//					$link_data = array(
//						'url' => trim($parts[0]),
//						'title' => trim($parts[1]),
//					);
//
//					// Оновлюємо значення в гнучкому контенті
//					update_sub_field('overview_left_side_image_link', $link_data);
//				}
//			}
//			if (get_sub_field('overview_without_image_button')) {
//				$imported_value = get_sub_field('overview_without_image_button');
//
//				// Розділяємо значення, якщо воно у форматі `URL|Title`
//				if (strpos($imported_value['url'], '|') !== false) {
//					$parts = explode('|', $imported_value['url']);
//					$link_data = array(
//						'url' => trim($parts[0]),
//						'title' => trim($parts[1]),
//					);
//
//					// Оновлюємо значення в гнучкому контенті
//					update_sub_field('overview_without_image_button', $link_data);
//				}
//			}
//		}
//	}
//}
//add_action('acf/save_post', 'update_acf_link_fields_in_flexible_content');
