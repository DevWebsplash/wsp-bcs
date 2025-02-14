<?php
/**
 * Admin functions
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */
//$is_staging = strpos($_SERVER['HTTP_HOST'], 'staging') !== false;
//$baseUrl = $is_staging ? 'https://calipology.co.uk/staging/' : 'https://calipology.co.uk/';



/**
 * Change default greeting
 */
function gulp_wp_greeting( $wp_admin_bar ) {
	$user_id = get_current_user_id();
	$current_user = wp_get_current_user();
	$profile_url = get_edit_profile_url( $user_id );

	if ( 0 !== $user_id ) {
		$avatar = get_avatar( $user_id, 28 );
		$howdy = sprintf( __( 'Hi, %1$s' ), $current_user->display_name );
		$class = empty( $avatar ) ? '' : 'with-avatar';

		$wp_admin_bar->add_menu(array(
			'id' => 'my-account',
			'parent' => 'top-secondary',
			'title' => $howdy . $avatar,
			'href' => $profile_url,
			'meta' => array(
				'class' => $class,
			),
		));
	}
}
add_action( 'admin_bar_menu', 'gulp_wp_greeting', 11 );

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
}

function add_white_background_body_class($classes) {
  if (is_page_template('templates/white-background.php')) {
    $classes[] = 'white-background';
  }
  return $classes;
}
add_filter('body_class', 'add_white_background_body_class');


// Function to modify image URLs in post content
//function modify_image_urls_in_content($content) {
//  $upload_dir = wp_get_upload_dir();
//  $baseurl = $upload_dir['baseurl'];
//  $home_url = home_url('/?image=');
//
//  if (strpos($content, $baseurl) !== false) {
//    $content = str_replace($baseurl, $home_url, $content);
//  } else {
//    // Log if baseurl is not found
//    error_log('Base URL not found in content.');
//  }
//
//  return $content;
//}
//add_filter('the_content', 'modify_image_urls_in_content');
//
//
//// Function to modify ACF image URLs
//function modify_acf_image_url($value, $post_id, $field) {
//  // Check if the field is an image field
//  if ($field['type'] === 'image') {
//    $upload_dir = wp_get_upload_dir();
//    $baseurl = $upload_dir['baseurl'];
//    $home_url = home_url('/?image=');
//
//    if (is_array($value)) {
//      // If the image is returned as an array
//      if (isset($value['url'])) {
//        $value['url'] = str_replace($baseurl, $home_url, $value['url']);
//        // Log the modified URL for debugging
//        error_log('Modified ACF Image URL (Array): ' . $value['url']);
//      }
//    } elseif (is_numeric($value)) {
//      // If the image is returned as an ID
//      $image_url = wp_get_attachment_url($value);
//      if ($image_url) {
//        $modified_url = str_replace($baseurl, $home_url, $image_url);
//        // Log the modified URL for debugging
//        error_log('Modified ACF Image URL (ID): ' . $modified_url);
//        return $modified_url;
//      }
//    } elseif (is_string($value)) {
//      // If the image is returned as a URL
//      $value = str_replace($baseurl, $home_url, $value);
//      // Log the modified URL for debugging
//      error_log('Modified ACF Image URL (String): ' . $value);
//    }
//  }
//  return $value;
//}
//add_filter('acf/format_value/type=image', 'modify_acf_image_url', 10, 3);
//
//
//
//
//// Function to serve images via query parameter
//function serve_image_via_query_param() {
//  if (isset($_GET['image'])) {
//    $image_query = sanitize_text_field($_GET['image']);
//
//    // Prevent directory traversal
//    $image_query = ltrim($image_query, '/');
//
//    // Construct the full image path
//    $upload_dir = wp_get_upload_dir();
//    $image_full_path = trailingslashit($upload_dir['basedir']) . $image_query;
//
//    // Security check: Ensure the image is within the uploads directory
//    if (file_exists($image_full_path) && strpos(realpath($image_full_path), realpath($upload_dir['basedir'])) === 0) {
//      $mime_type = mime_content_type($image_full_path);
//      header('Content-Type: ' . $mime_type);
//      header('Content-Length: ' . filesize($image_full_path));
//      readfile($image_full_path);
//      exit;
//    } else {
//      // Optional: Handle invalid image requests
//      wp_die('Invalid image request.', 'Error', array('response' => 404));
//    }
//  }
//}
//add_action('init', 'serve_image_via_query_param');
//

