<?php
/**
 * Create custom Cache table
 *
 * @package gabischiopu
 */

declare( strict_types=1 );

namespace GS\AM\SetupTable;

/**
 * Create the custom table for caching API responses
 * 
 * @return void
 */
function create_cache_table(): void {
	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();
	$table_name      = $wpdb->prefix . GS_API_CACHE_TABLE;

	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		endpoint_url varchar(255) NOT NULL,
		response_data longtext NOT NULL,
		expiration_timestamp bigint(20) NOT NULL,
		PRIMARY KEY  (id),
		UNIQUE KEY endpoint_url (endpoint_url)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	\dbDelta( $sql );
}
