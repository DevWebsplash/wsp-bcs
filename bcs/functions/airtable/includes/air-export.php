<?php

if (!defined ('ABSPATH')) {
  exit;
}

function bcs_get_required_airtable_fields() {
    return [
        [
            'name' => 'WordPress ID',
            'type' => 'number',
            'description' => 'WordPress post identifier'
        ],
        [
            'name' => 'Title',
            'type' => 'singleLineText',
            'description' => 'Vehicle title'
        ],
        [
            'name' => 'Post Status',
            'type' => 'singleLineText',
            'description' => 'Publication status'
        ],
        [
            'name' => 'Make',
            'type' => 'multipleSelects',
            'description' => 'Vehicle manufacturer'
        ],
        [
            'name' => 'Model',
            'type' => 'multipleSelects',
            'description' => 'Vehicle model'
        ]
    ];
}

function bcs_check_airtable_schema() {
  if (!bcs_validate_airtable_config()) {
    return false;
  }
    global $pat, $baseId, $tableWordpressTrims;

    error_log("Checking Airtable schema...");

    $url = "https://api.airtable.com/v0/meta/bases/{$baseId}/tables";
    $response = wp_remote_get($url, [
        'headers' => [
            'Authorization' => "Bearer {$pat}",
            'Content-Type' => 'application/json'
        ],
        'timeout' => 15, // Increase from default 5 to 15 seconds
        'sslverify' => false // Try disabling SSL verify if on development
    ]);

    if (is_wp_error($response)) {
        error_log("Failed to get Airtable schema: " . $response->get_error_message());
        return false;
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);

    // Create table if it doesn't exist
    $table_exists = false;
    foreach ($body['tables'] as $table) {
        if ($table['id'] === $tableWordpressTrims) {
            $table_exists = true;
            break;
        }
    }

    if (!$table_exists) {
        return bcs_create_airtable_table();
    }

    return bcs_validate_table_fields();
}

function bcs_create_airtable_table() {
    global $pat, $baseId, $tableWordpressTrims;

    error_log("Creating Airtable table...");

    $url = "https://api.airtable.com/v0/meta/bases/{$baseId}/tables";
    $fields = array_map(function($field) {
        return [
            'name' => $field['name'],
            'type' => $field['type'],
            'description' => $field['description']
        ];
    }, bcs_get_required_airtable_fields());

    $response = wp_remote_post($url, [
        'headers' => [
            'Authorization' => "Bearer {$pat}",
            'Content-Type' => 'application/json'
        ],
        'body' => json_encode([
            'name' => 'WordPress Vehicles',
            'description' => 'Synchronized vehicle data from WordPress',
            'fields' => $fields
        ])
    ]);

    if (is_wp_error($response)) {
        error_log("Failed to create table: " . $response->get_error_message());
        return false;
    }

    $status_code = wp_remote_retrieve_response_code($response);
    return $status_code === 200;
}

function bcs_validate_table_fields() {
    global $pat, $baseId, $tableWordpressTrims;

    error_log("Validating table fields...");

    $url = "https://api.airtable.com/v0/meta/bases/{$baseId}/tables/{$tableWordpressTrims}";
    $response = wp_remote_get($url, [
        'headers' => [
            'Authorization' => "Bearer {$pat}",
            'Content-Type' => 'application/json'
        ]
    ]);

    if (is_wp_error($response)) {
        error_log("Failed to get table schema: " . $response->get_error_message());
        return false;
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    $existing_fields = array_column($body['fields'], 'name');
    $required_fields = bcs_get_required_airtable_fields();

    $missing_fields = [];
    foreach ($required_fields as $field) {
        if (!in_array($field['name'], $existing_fields)) {
            $missing_fields[] = $field;
        }
    }

    if (!empty($missing_fields)) {
        return bcs_create_missing_fields($missing_fields);
    }

    return true;
}

function bcs_create_missing_fields($fields) {
    global $pat, $baseId, $tableWordpressTrims;

    error_log("Creating missing fields: " . print_r($fields, true));

    $url = "https://api.airtable.com/v0/meta/bases/{$baseId}/tables/{$tableWordpressTrims}/fields";

    foreach ($fields as $field) {
        // Add required options based on field type
        if ($field['type'] === 'number') {
            $field['options'] = [
                'precision' => 0,
                'negative' => false
            ];
        } elseif ($field['type'] === 'multipleSelects') {
            $field['options'] = ['choices' => []];
        }

        $response = wp_remote_post($url, [
            'headers' => [
                'Authorization' => "Bearer {$pat}",
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode($field)
        ]);

        if (is_wp_error($response)) {
            error_log("Field creation error: " . $response->get_error_message());
            return false;
        }

        $status_code = wp_remote_retrieve_response_code($response);
        if ($status_code !== 200) {
            error_log("Failed to create field {$field['name']}: " . wp_remote_retrieve_body($response));
            return false;
        }

        sleep(1); // Rate limiting
    }

    return true;
}

function bcs_export_vehicle_to_airtable ($post_id) {
    if (!bcs_check_airtable_schema()) {
        error_log("Failed to validate/create Airtable schema");
        return false;
    }

  global $pat, $baseId, $tableWordpressTrims;

  error_log ("Starting export for post ID: {$post_id}");
  error_log ("Using table: {$tableWordpressTrims}");

  $post = get_post ($post_id);
  if (!$post || $post->post_type !== 'vehicle') {
        error_log("Invalid post type for ID: {$post_id}");
    return false;
  }

    $fields = [
        'WordPress ID' => $post_id,
        'Title' => $post->post_title,
        'Post Status' => $post->post_status
    ];

  $taxonomies = get_object_taxonomies ('vehicle', 'names');
  foreach ($taxonomies as $taxonomy) {
        $terms = wp_get_post_terms($post_id, $taxonomy);
    if (!is_wp_error ($terms)) {
            $term_names = wp_list_pluck($terms, 'name');
            $fields[$taxonomy] = $term_names;
    }
  }

    error_log("Prepared fields: " . print_r($fields, true));

    $response = wp_remote_post("https://api.airtable.com/v0/{$baseId}/{$tableWordpressTrims}", [
        'headers' => [
      'Authorization' => "Bearer {$pat}",
      'Content-Type' => 'application/json'
        ],
        'body' => json_encode([
            'records' => [
                ['fields' => $fields]
            ]
        ])
    ]);

  if (is_wp_error ($response)) {
        error_log("Export failed: " . $response->get_error_message());
    return false;
  }

  $status_code = wp_remote_retrieve_response_code ($response);
  $response_body = wp_remote_retrieve_body ($response);
  error_log ("Airtable response code: {$status_code}");
  error_log ("Airtable response body: {$response_body}");

  if ($status_code !== 200) {
        error_log("Export failed with status code: {$status_code}");
        error_log("Response: " . wp_remote_retrieve_body($response));
    return false;
  }

    error_log("Successfully exported post {$post_id}");
  return true;
}

// Hook for post save/update
add_action ('save_post_vehicle', 'bcs_handle_vehicle_export', 10, 3);

function bcs_handle_vehicle_export ($post_id, $post, $update)
{
  if (defined ('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  if (!current_user_can ('edit_post', $post_id)) {
    return;
  }

//  bcs_export_vehicle_to_airtable($post_id);
  return bcs_export_vehicle_to_airtable ($post_id);
}

// Add admin page button for manual export
add_action ('admin_post_bcs_manual_export', 'bcs_handle_manual_export');
function bcs_handle_manual_export ()
{
  if (!isset($_POST[ 'manual_export_nonce' ]) ||
      !wp_verify_nonce ($_POST[ 'manual_export_nonce' ], 'bcs_manual_export_action')
  ) {
    wp_die ('Invalid nonce');
  }

  if (!isset($_POST[ 'post_id' ]) || empty($_POST[ 'post_id' ])) {
    wp_redirect (add_query_arg (
        array(
            'page' => 'bcs-airtable-sync',
            'export_status' => 'error',
            'message' => urlencode ('No vehicle selected')
        ),
        admin_url ('admin.php')
    ));
    exit;
  }

  $post_id = intval ($_POST[ 'post_id' ]);

  global $pat, $baseId, $tableWordpressTrims;

  if (empty($pat) || empty($baseId) || empty($tableWordpressTrims)) {
    $error_message = 'Airtable configuration is incomplete';
    bcs_log_event ($error_message, 'WordPress Trims');
    wp_redirect (add_query_arg (
        array(
            'page' => 'bcs-airtable-sync',
            'export_status' => 'error',
            'message' => urlencode ($error_message)
        ),
        admin_url ('admin.php')
    ));
    exit;
  }

  bcs_log_event ("Starting manual export for vehicle ID: {$post_id}", 'WordPress Trims');
  $success = bcs_export_vehicle_to_airtable ($post_id);

  if (!$success) {
    $error_message = "Failed to export vehicle (ID: {$post_id})";
    bcs_log_event ($error_message, 'WordPress Trims');
    wp_redirect (add_query_arg (
        array(
            'page' => 'bcs-airtable-sync',
            'export_status' => 'error',
            'message' => urlencode ($error_message),
            'post_id' => $post_id
        ),
        admin_url ('admin.php')
    ));
    exit;
  }

  bcs_log_event ("Successfully exported vehicle (ID: {$post_id})", 'WordPress Trims');
  wp_redirect (add_query_arg (
      array(
          'page' => 'bcs-airtable-sync',
          'export_status' => 'complete',
          'success' => 1,
          'post_id' => $post_id
      ),
      admin_url ('admin.php')
  ));
  exit;
}

// Add export button to admin page
function bcs_add_export_button ()
{
  $args = array(
      'post_type' => 'vehicle',
      'posts_per_page' => -1,
      'post_status' => 'any'
  );
  $vehicles = get_posts ($args);
  ?>
  <div class="wrap">
    <p>Manual Export to Airtable</p>

    <div class="export-info notice notice-info">
      <h3>Data Export Structure</h3>
      <p>The following data will be exported to Airtable:</p>
      <ul style="list-style-type: disc; margin-left: 20px;">
        <li><strong>Post ID:</strong> WordPress post identifier</li>
        <li><strong>Title:</strong> Vehicle post title</li>
        <li><strong>Status:</strong> Post publication status</li>
        <li><strong>Vehicle Terms:</strong> All associated vehicle taxonomy terms (as boolean values)</li>
      </ul>
    </div>

    <form method="post" action="<?php echo admin_url ('admin-post.php'); ?>">
      <?php wp_nonce_field ('bcs_manual_export_action', 'manual_export_nonce'); ?>
      <input type="hidden" name="action" value="bcs_manual_export">
      <select name="post_id" required>
        <option value="">Select a vehicle</option>
        <?php foreach ($vehicles as $vehicle): ?>
          <option value="<?php echo esc_attr ($vehicle->ID); ?>">
            <?php echo esc_html ($vehicle->post_title); ?>
          </option>
        <?php endforeach; ?>
      </select>
      <?php submit_button ('Export Selected Vehicle to Airtable', 'primary', 'submit_export'); ?>
    </form>


    <?php
    if (isset($_GET[ 'export_status' ])) {
      if ($_GET[ 'export_status' ] === 'error') {
        $message = isset($_GET[ 'message' ]) ? urldecode ($_GET[ 'message' ]) : 'Unknown error occurred';
        echo '<div class="notice notice-error"><p>';
        echo esc_html ($message);
        echo '</p></div>';
      } elseif ($_GET[ 'export_status' ] === 'complete') {
        $success = intval ($_GET[ 'success' ]);
        echo '<div class="notice notice-success"><p>';
        echo 'Successfully exported vehicle to Airtable.';
        echo '</p></div>';

        // Display the exported data
        if (isset($_GET[ 'post_id' ])) {
          $post_id = intval ($_GET[ 'post_id' ]);
          $post = get_post ($post_id);
          $vehicle_terms = wp_get_post_terms ($post_id, 'vehicle', array('fields' => 'all'));

          $exported_data = array(
              'Post ID' => $post_id,
              'Title' => $post->post_title,
              'Status' => $post->post_status,
              'Terms' => array()
          );

          foreach ($vehicle_terms as $term) {
            $exported_data[ 'Terms' ][ $term->name ] = true;
          }

          echo '<div class="notice notice-info is-dismissible"><p>';
          echo '<strong>Exported Data:</strong></p>';
          echo '<pre style="background: #f8f9fa; padding: 15px; margin-top: 10px; overflow: auto;">';
          echo esc_html (json_encode ($exported_data, JSON_PRETTY_PRINT));
          echo '</pre></div>';
        }
      }
    }
    ?>
  </div>
  <?php
}
