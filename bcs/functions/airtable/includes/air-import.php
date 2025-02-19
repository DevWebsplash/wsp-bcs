<?php

function bcs_plugin_get_airtable_data() {
  global $pat, $baseId, $tableName;

  $endpoint = "https://api.airtable.com/v0/{$baseId}/{$tableName}";
  $response = wp_remote_get($endpoint, array(
      'headers' => array('Authorization' => 'Bearer ' . $pat)
  ));

  if (is_wp_error($response)) {
    return 'Error fetching data from Airtable: ' . $response->get_error_message();
  }

  $body = wp_remote_retrieve_body($response);
  $data = json_decode($body, true);

  if (!empty($data['records'])) {
    $output = '<table><tr><th>#</th><th>Make</th><th>Model</th><th>Trim</th></tr>';
    $counter = 1;
    foreach ($data['records'] as $record) {
      $fields = $record['fields'];
      if (!empty($fields['Make']) && !empty($fields['Model']) && !empty($fields['Trim'])) {
        $output .= '<tr><td>' . $counter++ . '</td><td>' . esc_html($fields['Make']) . '</td><td>' . esc_html($fields['Model']) . '</td><td>' . esc_html($fields['Trim']) . '</td></tr>';
      }
    }
    $output .= '</table>';
    return $output;
  } else {
    return 'No records found.';
  }
}
