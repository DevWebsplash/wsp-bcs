<?php

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Export vehicle post data to Airtable
 */
function bcs_export_vehicle_to_airtable($post_id) {
  global $pat, $baseId, $tableWordpressTrims;

  $post = get_post($post_id);
  if (!$post || $post->post_type !== 'vehicle') {
    return false;
  }

  // Get taxonomy terms
  $vehicle_terms = wp_get_post_terms($post_id, 'vehicle', array('fields' => 'all'));

  // Prepare data for Airtable
  $fields = array(
      'Post ID' => $post_id,
      'Title' => $post->post_title,
      'Status' => $post->post_status
  );

  // Add taxonomy terms data
  if (!is_wp_error($vehicle_terms)) {
    foreach ($vehicle_terms as $term) {
      $fields[$term->name] = true;
    }
  }

  // Prepare the request
  $airtable_url = "https://api.airtable.com/v0/{$baseId}/{$tableWordpressTrims}";
  $args = array(
      'headers' => array(
          'Authorization' => "Bearer {$pat}",
          'Content-Type' => 'application/json'
      ),
      'body' => json_encode(array(
          'records' => array(
              array(
                  'fields' => $fields
              )
          )
      )),
      'method' => 'POST',
      'timeout' => 30
  );

  // Send request to Airtable
  $response = wp_remote_post($airtable_url, $args);

  if (is_wp_error($response)) {
    log_airtable_error('Export failed: ' . $response->get_error_message());
    return false;
  }

  $status_code = wp_remote_retrieve_response_code($response);
  if ($status_code !== 200) {
    log_airtable_error('Export failed with status code: ' . $status_code);
    return false;
  }

  return true;
}

// Hook for post save/update
add_action('save_post_vehicle', 'bcs_handle_vehicle_export', 10, 3);

function bcs_handle_vehicle_export($post_id, $post, $update) {
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

//  bcs_export_vehicle_to_airtable($post_id);
  return bcs_export_vehicle_to_airtable($post_id);
}

// Add admin page button for manual export
add_action('admin_post_bcs_manual_export', 'bcs_handle_manual_export');
function bcs_handle_manual_export() {
  if (!isset($_POST['manual_export_nonce']) ||
      !wp_verify_nonce($_POST['manual_export_nonce'], 'bcs_manual_export_action')) {
    wp_die('Invalid nonce');
  }
  if (!isset($_POST['post_id'])) {
        wp_die('No post ID specified');
    }

  $args = array(
      'post_type' => 'vehicle',
      'posts_per_page' => -1,
      'post_status' => 'any'
  );

  $vehicles = get_posts($args);
  $success_count = 0;
  $failed_count = 0;

  foreach ($vehicles as $vehicle) {
    if (bcs_export_vehicle_to_airtable($vehicle->ID)) {
      $success_count++;
    } else {
      $failed_count++;
    }
  }

  $post_id = intval($_POST['post_id']);
$success = bcs_export_vehicle_to_airtable($post_id);

//  $redirect_url = add_query_arg(
//      array(
//          'page' => 'bcs-airtable-sync',
//          'export_status' => 'complete',
//          'success' => $success_count,
//          'failed' => $failed_count
//      ),
//      admin_url('admin.php')
//  );

      $redirect_url = add_query_arg(
        array(
            'page' => 'bcs-airtable-sync',
            'export_status' => 'complete',
            'success' => $success ? 1 : 0,
            'failed' => $success ? 0 : 1
        ),
        admin_url('admin.php')
    );

  wp_redirect($redirect_url);
  exit;
}

// Add export button to admin page
function bcs_add_export_button() {
    $args = array(
        'post_type' => 'vehicle',
        'posts_per_page' => -1,
        'post_status' => 'any'
    );
    $vehicles = get_posts($args);
  ?>
  <div class="wrap">
    <h2>Manual Export to Airtable</h2>
    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
      <?php wp_nonce_field('bcs_manual_export_action', 'manual_export_nonce'); ?>
      <input type="hidden" name="action" value="bcs_manual_export">
      <select name="post_id" required>
            <option value="">Select a vehicle</option>
            <?php foreach ($vehicles as $vehicle): ?>
                <option value="<?php echo esc_attr($vehicle->ID); ?>">
                    <?php echo esc_html($vehicle->post_title); ?>
                </option>
            <?php endforeach; ?>
        </select>
    <?php submit_button('Export Selected Vehicle to Airtable', 'primary', 'submit_export'); ?>
<!--      --><?php //submit_button('Export Vehicles to Airtable', 'primary', 'submit_export'); ?>
    </form>

<!--    --><?php
//    if (isset($_GET['export_status']) && $_GET['export_status'] === 'complete') {
//      $success = intval($_GET['success']);
//      $failed = intval($_GET['failed']);
//      if ($failed > 0) {
//        echo '<div class="notice notice-warning"><p>';
//        printf('Export completed with %d successful and %d failed exports.', $success, $failed);
//        echo ' Check the error logs for details.</p></div>';
//      } else {
//        echo '<div class="notice notice-success"><p>';
//        printf('Successfully exported %d vehicles to Airtable.', $success);
//        echo '</p></div>';
//      }
//    }
//    ?>

    <?php
        if (isset($_GET['export_status']) && $_GET['export_status'] === 'complete') {
            $success = intval($_GET['success']);
            $failed = intval($_GET['failed']);
            if ($failed > 0) {
                echo '<div class="notice notice-error"><p>';
                echo 'Failed to export vehicle to Airtable. Check the error logs for details.</p></div>';
            } else {
                echo '<div class="notice notice-success"><p>';
                echo 'Successfully exported vehicle to Airtable.</p></div>';
            }
        }
        ?>
  </div>
  <?php
}
