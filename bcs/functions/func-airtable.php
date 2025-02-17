<?php
function sync_airtable_to_wp() {
	$api_key    = 'YOUR_AIRTABLE_API_KEY';
	$base_id    = 'patE6bSNpJeISiotB';
	$table_name = 'Vehicles'; // Назва вашої таблиці в Airtable

	$endpoint = "https://api.airtable.com/v0/{$base_id}/{$table_name}";
	$response = wp_remote_get( $endpoint, array(
		'headers' => array(
			'Authorization' => 'Bearer ' . $api_key
		)
	) );

	if ( is_wp_error( $response ) ) {
		return;
	}

	$body = wp_remote_retrieve_body( $response );
	$data = json_decode( $body, true );

	if ( ! empty( $data['records'] ) ) {
		foreach ( $data['records'] as $record ) {
			$fields  = $record['fields'];
			$post_id = get_post_id_by_meta( 'airtable_id', $record['id'] );

			if ( $post_id ) {
// Оновлення поста, якщо він уже існує
				wp_update_post( array(
					'ID'         => $post_id,
					'post_title' => $fields['Make'] . ' ' . $fields['Model'],
				) );
			} else {
// Створення нового поста
				$post_id = wp_insert_post( array(
					'post_title'  => $fields['Make'] . ' ' . $fields['Model'],
					'post_type'   => 'vehicle',
					'post_status' => 'publish',
				) );
			}

			if ( $post_id ) {
				update_post_meta( $post_id, 'airtable_id', $record['id'] );
				update_post_meta( $post_id, 'make', $fields['Make'] );
				update_post_meta( $post_id, 'model', $fields['Model'] );
				update_post_meta( $post_id, 'year', $fields['Year'] );
			}
		}
	}
}

add_action( 'init', 'sync_airtable_to_wp' );
function get_post_id_by_meta( $meta_key, $meta_value ) {
	global $wpdb;
	$query = $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = %s", $meta_key, $meta_value );

	return $wpdb->get_var( $query );
}

function sync_wp_to_airtable($post_id) {
	if (get_post_type($post_id) !== 'vehicle') {
		return;
	}

	$api_key = 'YOUR_AIRTABLE_API_KEY';
	$base_id = 'YOUR_AIRTABLE_BASE_ID';
	$table_name = 'Vehicles';
	$airtable_id = get_post_meta($post_id, 'airtable_id', true);

	if (!$airtable_id) {
		return;
	}

	$fields = array(
		'Make'  => get_post_meta($post_id, 'make', true),
		'Model' => get_post_meta($post_id, 'model', true),
		'Year'  => get_post_meta($post_id, 'year', true),
	);

	$data = array('fields' => $fields);
	$endpoint = "https://api.airtable.com/v0/{$base_id}/{$table_name}/" . $airtable_id;

	$response = wp_remote_request($endpoint, array(
		'method'  => 'PATCH',
		'headers' => array(
			'Authorization' => 'Bearer ' . $api_key,
			'Content-Type'  => 'application/json'
		),
		'body'    => json_encode($data)
	));
}
add_action('save_post_vehicle', 'sync_wp_to_airtable');
