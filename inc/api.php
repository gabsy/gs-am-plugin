<?php
/**
 * API functions
 *
 * @package gabischiopu
 */

declare( strict_types=1 );

namespace GS\AM\APIFunctions;

/**
 * Store API response in the database
 * 
 * @param string $endpoint_url API endpoint URL
 * @param string $response_data API response data
 * @param int $expiration_time Expiration timestamp
 * 
 * @return void
 */
function store_api_response( string $endpoint_url, string $response_data, int $expiration_time ): void {
	global $wpdb;
	$table_name = $wpdb->prefix . GS_API_CACHE_TABLE;
	$wpdb->replace( $table_name, array(
		'endpoint_url' => $endpoint_url,
		'response_data' => $response_data,
		'expiration_timestamp' => $expiration_time
	));
}

/**
 * Get cached API response
 * 
 * @param string $endpoint_url API endpoint URL
 * 
 * @return mixed Cached API response data or false
 */
function get_cached_api_response( string $endpoint_url, bool $cache_only = false ): mixed {
	global $wpdb;
	$table_name = $wpdb->prefix . GS_API_CACHE_TABLE;
	$cached_data = $wpdb->get_row("SELECT * FROM $table_name WHERE endpoint_url = '$endpoint_url'", ARRAY_A);

	if (
		$cached_data && $cached_data['expiration_timestamp'] > time() ||
		$cached_data && $cache_only && $cached_data['expiration_timestamp'] < time()
		) {
		return $cached_data['response_data'];
	} else {
		return false;
	}
}

/**
 * Make API request
 * 
 * @param bool $is_forced Force API request
 * 
 * @return mixed API response data or false
 */
function make_data_request( bool $is_forced = false, bool $cache_only = false ): mixed {
	$endpoint_url = GS_API_PLUGIN_URL;

	// Check if cached data exists in the custom table
	$cached_response = get_cached_api_response($endpoint_url, $cache_only);

	if ( $cached_response !== false && !$is_forced ) {
		return $cached_response;
	} else {
		// Make new API request
		$response = \wp_remote_get($endpoint_url);
		if ( !is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200 ) {
			$response_data = \wp_remote_retrieve_body($response);
			
			// Set expiration time
			$expiration_time = \time() + GS_API_CACHE_EXPIRATION;
	
			// Store API response in the database
			store_api_response($endpoint_url, $response_data, $expiration_time);
			
			// Return API response data
			return $response_data;
		} else {
			return false;
		}
	}
}

/**
 * AJAX handler for API request
 * 
 * @return void
 */
function fetch_api_data(): void {
	$response = \json_decode( make_data_request() );
	\wp_send_json( $response );
}

/**
 * AJAX handler for fetching data
 * 
 * @return void
 */
\add_action('wp_ajax_fetch_data', __NAMESPACE__ . '\\fetch_api_data');
\add_action('wp_ajax_nopriv_fetch_data', __NAMESPACE__ . '\\fetch_api_data');
