<?php
/**
 * Airtable Sync Functions
 *
 * This file contains functions to sync data between Airtable and WordPress.
 *
 * @package  <Package>
 * @version  1.0.0
 * @author   <Author>
 */

// Recommended: Store sensitive data in environment variables or constants
// Define constants in `wp-config.php`
// define('AIRTABLE_PAT', 'your_airtable_pat');
// define('AIRTABLE_BASE_ID', 'your_base_id');

// Replace with your actual token, base ID, and table name
$pat       = 'patE6bSNpJeISiotB'; // Airtable Personal Access Token
$baseId    = 'appu3QXHr7ai2NLwi/tblXbISQ9nRhz0YfJ'; // Airtable Base ID
$tableName = 'Vehicles'; // Airtable Table Name
$postType  = 'vehicle'; // WordPress Post Type
$logOption = 'my_plugin_error_log'; // Option name for storing error logs

/**
 * Create an admin page to display error logs
 */
add_action('admin_menu', 'my_plugin_create_menu');
function my_plugin_create_menu() {
    $pageTitle = 'Airtable Error Logs';
    $menuTitle = 'Airtable Logs';
    $menuSlug  = 'my_airtable_logs';
    add_menu_page(
        $pageTitle,
        $menuTitle,
        'manage_options',
        $menuSlug,
        'my_plugin_logs_page'
    );
}

/**
 * Display the error logs on the admin page
 */
function my_plugin_logs_page() {
    global $logOption;
    echo '<h2>Airtable Error Logs</h2>';
    $logs = get_option($logOption, array());
    if (!empty($logs)) {
        echo '<pre>' . implode("\n", $logs) . '</pre>';
    } else {
        echo '<p>No errors logged.</p>';
    }
}

/**
 * Log errors in WordPress options
 *
 * @param string $message The error message to log
 */
function log_airtable_error($message) {
    global $logOption;
    $logs = get_option($logOption, array());
    $logs[] = date('Y-m-d H:i:s') . ' - ' . $message;
    update_option($logOption, $logs);
}

/**
 * Sync data from Airtable to WordPress
 */
function sync_airtable_to_wp() {
    global $pat, $baseId, $tableName, $postType;
    $endpoint = "https://api.airtable.com/v0/{$baseId}/{$tableName}";
    $response = wp_remote_get($endpoint, array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $pat
        )
    ));

    if (is_wp_error($response)) {
        log_airtable_error('Error fetching data from Airtable: ' . $response->get_error_message());
        return;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!empty($data['records'])) {
        foreach ($data['records'] as $record) {
            $fields  = $record['fields'];
            $post_id = get_post_id_by_meta('airtable_id', $record['id']);

            if ($post_id) {
                // Update existing post
                $result = wp_update_post(array(
                    'ID'         => $post_id,
                    'post_title' => $fields['Make'] . ' ' . $fields['Model'],
                ));

                if (is_wp_error($result)) {
                    log_airtable_error('Error updating post: ' . $result->get_error_message());
                    continue;
                }
            } else {
                // Create a new post
                $post_id = wp_insert_post(array(
                    'post_title'  => $fields['Make'] . ' ' . $fields['Model'],
                    'post_type'   => $postType,
                    'post_status' => 'publish',
                ));

                if (is_wp_error($post_id)) {
                    log_airtable_error('Error inserting post: ' . $post_id->get_error_message());
                    continue;
                }
            }

            if ($post_id) {
                update_post_meta($post_id, 'airtable_id', $record['id']);
                update_post_meta($post_id, 'make', $fields['Make']);
                update_post_meta($post_id, 'model', $fields['Model']);
                update_post_meta($post_id, 'year', $fields['Year']);
            }
        }
    }
}
add_action('init', 'sync_airtable_to_wp');

/**
 * Find a post by meta value
 *
 * @param string $meta_key The meta key to search for
 * @param string $meta_value The meta value to search for
 * @return int|null The post ID if found, null otherwise
 */
function get_post_id_by_meta($meta_key, $meta_value) {
    global $wpdb;
    $query = $wpdb->prepare(
        "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = %s",
        $meta_key,
        $meta_value
    );
    return $wpdb->get_var($query);
}

/**
 * Sync data from WordPress to Airtable
 *
 * @param int $post_id The ID of the post being saved
 */
function sync_wp_to_airtable($post_id) {
    global $pat, $baseId, $tableName, $postType;
    if (get_post_type($post_id) !== $postType) {
        return;
    }

    $airtable_id = get_post_meta($post_id, 'airtable_id', true);
    if (!$airtable_id) {
        return;
    }

    $fields = array(
        'Make'  => get_post_meta($post_id, 'make', true),
        'Model' => get_post_meta($post_id, 'model', true),
        'Year'  => get_post_meta($post_id, 'year', true),
    );

    $endpoint = "https://api.airtable.com/v0/{$baseId}/{$tableName}/" . $airtable_id;
    $response = wp_remote_request($endpoint, array(
        'method'  => 'PATCH',
        'headers' => array(
            'Authorization' => 'Bearer ' . $pat,
            'Content-Type'  => 'application/json'
        ),
        'body'    => json_encode(array('fields' => $fields))
    ));

    if (is_wp_error($response)) {
        log_airtable_error('Error updating data to Airtable: ' . $response->get_error_message());
    }
}

add_action('save_post_vehicle', 'sync_wp_to_airtable');