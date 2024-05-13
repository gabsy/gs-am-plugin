<?php
/**
 * Plugin Name: Gabi Schiopu - API Plugin
 * Description: Gabi Schiopu's API Plugin for Awesome Motive.
 * Author: Gabi Schiopu
 * Text Domain: gs-am-plugin
 * Version: 1.0.0
 *
 * @package gabischiopu
 */

declare( strict_types=1 );

namespace GS\AM;

// Constants
define('GS_API_CACHE_TABLE', 'gs_api_cache');
define('GS_API_PLUGIN_URL', 'https://miusage.com/v1/challenge/1/');
define('GS_API_CACHE_EXPIRATION', 3600);

require_once __DIR__ . '/inc/api.php';
require_once __DIR__ . '/inc/setup-table.php';
require_once __DIR__ . '/inc/admin-page.php';
require_once __DIR__ . '/inc/admin-view.php';
require_once __DIR__ . '/inc/cli-command.php';

use function GS\AM\SetupTable\create_cache_table;

\add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_domain' );
\add_action('admin_enqueue_scripts', __NAMESPACE__ . '\\enqueue_gs_scripts');

/**
 * Load the plugin text domain.
 * 
 * @return void
 */
function load_domain(): void {
	\load_plugin_textdomain( 'gs-am-plugin', false, basename( __DIR__ ) . '/lang/' );
}

/**
 * Enqueue plugin admin scripts and styles
 * 
 * @return void
 */

function enqueue_gs_scripts(): void {
	\wp_enqueue_style('gs-admin-style', plugins_url('/build/admin-view.css', __FILE__));
	\wp_enqueue_script('gs-admin-script', plugins_url('/build/admin-view.js', __FILE__), array(), false, true);
	\wp_localize_script('gs-admin-script', 'gs_admin_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}

/**
 * Load blocks templates.
 */
foreach ( glob( __DIR__ . '/src/*/block.php' ) as $file ) {
	include_once $file;
}

function plugin_activation() {
	// Create the custom table for caching on plugin activation
	create_cache_table();
}

\register_activation_hook( __FILE__, __NAMESPACE__ . '\\plugin_activation' );
