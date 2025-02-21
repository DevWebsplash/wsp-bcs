<?php // air-models.php


// Function to fetch data from Airtable with pagination support
function bcs_plugin_get_airtable_models_meta_data($offset = '') {
    global $pat, $baseId, $tableModelsMeta;

    $endpoint = "https://api.airtable.com/v0/{$baseId}/{$tableModelsMeta}";
    if (!empty($offset)) {
        $endpoint .= "&offset={$offset}";
    }

    $response = wp_remote_get($endpoint, array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $pat,
            'Content-Type'  => 'application/json'
        )
    ));

    if (is_wp_error($response)) {
        return json_encode(['error' => 'Error fetching data from Airtable: ' . esc_html($response->get_error_message())]);
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (empty($data['records'])) {
        return json_encode(['message' => 'No records found.']);
    }

    return json_encode([
        'html' => bcs_plugin_process_airtable_models_meta_data($data['records']),
        'next_offset' => isset($data['offset']) ? $data['offset'] : ''
    ]);
}

// Function to process and import a single record
function bcs_plugin_process_airtable_models_meta_data($records) {
    if (empty($records)) {
        return '<p>No new records to process.</p>';
    }

//    $output = '';
    $output = $records;
    print_r ($output);
    foreach ($records as $record) {
        $fields = $record['fields'];

//        if (!empty($fields['Make']) && !empty($fields['Model']) && !empty($fields['Trim'])) {
//            $trim_name = sanitize_text_field($fields['Trim']);
//            $make_name = sanitize_text_field($fields['Make']);
//            $model_name = sanitize_text_field($fields['Model']);
//            $status = '<span style="color: blue;">Skipped</span>';
//
//            $existing_post = get_page_by_title($trim_name, OBJECT, 'vehicle');
//
//            if (!$existing_post) {
//                // Add Make (parent category)
//                $make_term = term_exists($make_name, 'make');
//                if (!$make_term) {
//                    $make_term = wp_insert_term($make_name, 'make');
//                    if (!is_wp_error($make_term)) {
//                        $make_term_id = $make_term['term_id'];
//                    }
//                } else {
//                    $make_term_id = is_array($make_term) ? $make_term['term_id'] : $make_term;
//                }
//
//                // Add Model (child category of Make)
//                $model_term = term_exists($model_name, 'make');
//                if (!$model_term) {
//                    $model_term = wp_insert_term($model_name, 'make', array(
//                        'parent' => intval($make_term_id)
//                    ));
//                    if (!is_wp_error($model_term)) {
//                        $model_term_id = $model_term['term_id'];
//                    }
//                } else {
//                    $model_term_id = is_array($model_term) ? $model_term['term_id'] : $model_term;
//                }
//
//                // Create a post in CPT `vehicle`
//                $post_id = wp_insert_post(array(
//                    'post_title'  => $trim_name,
//                    'post_type'   => 'vehicle',
//                    'post_status' => 'publish'
//                ));
//
//                if (!is_wp_error($post_id)) {
//                    wp_set_object_terms($post_id, array(intval($make_term_id), intval($model_term_id)), 'make');
//                    $status = '<span style="color: green;">✔ Created</span>';
//                } else {
//                    $status = '<span style="color: red;">✘ Error</span>';
//                }
//            } else {
//                $status = '<span style="color: blue;">Already Exists</span>';
//            }
//
//            $output .= '<tr><td>' . esc_html($make_name) . '</td><td>' . esc_html($model_name) . '</td><td>' . esc_html($trim_name) . '</td><td>' . $status . '</td></tr>';
//        }
    }

    return $output;
}

// AJAX for "Load More Vehicles" button
add_action('wp_ajax_fetch_airtable_models_meta_data', function() {
    $offset = isset($_POST['offset']) ? sanitize_text_field($_POST['offset']) : '';
    echo bcs_plugin_get_airtable_models_meta_data($offset);
    wp_die();
});

// Form with Fetch and Load More buttons
function bcs_display_airtable_models_meta_data_page() {
  global $pat, $baseId, $tableName, $tableModelsMeta, $logOption, $logHistoryOption, $logNoticeOption;
  echo '<h2>Current Airtable Error Logs</h2>';


    // Replace with your actual endpoint and header
    $endpoint = "https://api.airtable.com/v0/{$baseId}/{$tableModelsMeta}";
    $headers = array(
        'Authorization' => 'Bearer ' . $pat,
        'Content-Type'  => 'application/json'
    );
    $response = wp_remote_get($endpoint, array('headers' => $headers));
    echo '<div class="update-nag notice notice-warning" style="max-height: 500px; overflow: auto; max-width: 100%"><p>' . wp_remote_retrieve_body($response) . '</p></div>';
    // Log the raw response object
    // log_airtable_error('Raw response: ' . print_r($response, true));


    // Redirect back to logs page

    exit;



    ?>
    <h2>Airtable Models Meta Data Import</h2>
    <button id="fetchAirtableModelsMetaData">Fetch from Airtable</button>
    <table id="airtableModelsMetaTable">
        <tr><th>Make</th><th>Model</th><th>Trim</th><th>Status</th></tr>
    </table>
    <button id="loadMoreModelsMeta" style="display:none;">Load More Vehicles</button>

    <script>
        document.getElementById("fetchAirtableModelsMetaData").addEventListener("click", function() {
            fetchAirtableModelsMetaData('');
        });

        document.getElementById("loadMoreModelsMeta").addEventListener("click", function() {
            let nextOffset = this.getAttribute("data-offset");
            fetchAirtableModelsMetaData(nextOffset);
        });

        function fetchAirtableModelsMetaData(offset) {
            let formData = new FormData();
            formData.append('action', 'fetch_airtable_models_meta_data');
            formData.append('offset', offset);

            fetch(ajaxurl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.html) {
                  console.log(data);
                    document.getElementById("airtableModelsMetaTable").innerHTML += data.html;
                }
                if (data.next_offset) {
                    let loadMoreBtn = document.getElementById("loadMoreModelsMeta");
                    loadMoreBtn.setAttribute("data-offset", data.next_offset);
                    loadMoreBtn.style.display = "block";
                } else {
                    document.getElementById("loadMoreModelsMeta").style.display = "none";
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
<?php
}

// Add the page to the admin menu
//add_action('admin_menu', function() {
//    add_submenu_page('tools.php', 'Airtable Models Meta Data Import', 'Airtable Models Meta Data Import', 'manage_options', 'airtable-models-meta-data-import', 'bcs_plugin_display_airtable_models_meta_data_page');
//});
