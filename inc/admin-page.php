<?php
/**
 * Admin page
 *
 * @package gabischiopu
 */

declare( strict_types=1 );

namespace GS\AM\AdminPage;

use function GS\AM\APIFunctions\make_data_request;
use function GS\AM\AdminView\render_table;

/**
 * Add admin page for plugin
 * 
 * @return void
 */
function gs_register_custom_menu_page(): void {
	\add_menu_page(__('Gabi Schiopu API', 'gs-am-plugin'),
		'Gabi S. API',
		'manage_options',
		'api-plugin-admin',
		__NAMESPACE__ . '\\gs_api_plugin_page',
		'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTMgMTBDMyA1LjU4MTcyIDYuMjIwNyAyIDEwLjE5MzYgMkgxMy4yNzAyQzEzLjkwODEgMiAxNC40MjUyIDIuNTE3MSAxNC40MjUyIDMuMTU0OThWMy4xNTQ5OEMxNC40MjUyIDMuNzkyODUgMTMuOTA4MSA0LjMwOTk1IDEzLjI3MDIgNC4zMDk5NUgxMC4xOTM2QzcuMzY3ODYgNC4zMDk5NSA1LjA3NzEyIDYuODU3NDcgNS4wNzcxMiAxMEM1LjA3NzEyIDEzLjE0MjUgNy4zNjc4NiAxNS42OSAxMC4xOTM2IDE1LjY5SDEzLjg5MDJDMTQuNDYwNSAxNS42OSAxNC45MjI5IDE1LjE3NTkgMTQuOTIyOSAxNC41NDE2QzE0LjkyMjkgMTMuOTA3MyAxNC40NjA1IDEzLjM5MzEgMTMuODkwMiAxMy4zOTMxSDEwLjI1MjNDOC41MzQ4MSAxMy4zOTMxIDcuMTQyNSAxMS44NDQ4IDcuMTQyNSA5LjkzNDc1QzcuMTQyNSA4LjAyNDcyIDguNTM0ODEgNi40NzYzNSAxMC4yNTIzIDYuNDc2MzVIMTEuMDQzMUMxMS42MTA5IDYuNDc2MzUgMTIuMDcxMiA2Ljk4ODI4IDEyLjA3MTIgNy42MTk3N0MxMi4wNzEyIDguMjY0MDMgMTEuNjAxNiA4Ljc4NjMgMTEuMDIyMyA4Ljc4NjNIMTAuMjUyM0M5LjY4MTk3IDguNzg2MyA5LjIxOTYxIDkuMzAwNDggOS4yMTk2MSA5LjkzNDc1QzkuMjE5NjEgMTAuNTY5IDkuNjgxOTcgMTEuMDgzMiAxMC4yNTIzIDExLjA4MzJIMTMuODkwMkMxNS42MDc3IDExLjA4MzIgMTcgMTIuNjMxNiAxNyAxNC41NDE2QzE3IDE2LjQ1MTYgMTUuNjA3NyAxOCAxMy44OTAyIDE4SDEwLjE5MzZDNi4yMjA3IDE4IDMgMTQuNDE4MyAzIDEwWiIgZmlsbD0id2hpdGUiLz4KPC9zdmc+Cg==',
		100
	);
}

\add_action('admin_menu', __NAMESPACE__ . '\\gs_register_custom_menu_page');

/**
 * Render the admin page
 * 
 * @return void
 */
function gs_api_plugin_page(): void {
	$response = make_data_request();

	// Output the page header
	$output   = '<div class="gs-admin-wrapper"><h1><img src="' . plugin_dir_url( dirname( __FILE__ ) ) . 'assets/logo.svg" alt="' . \__('Gabi Schiopu API Plugin','gs-am-plugin') . '"></h1>';

	if ($response !== false) {
		// API response available in cache or retrieved, output the table
		$output .=  render_table($response);
	} else {
		// Unable to retrieve cached response, output error
		$output .= \__('Error: Unable to retrieve cached API response or make API request.', 'gs-am-plugin');
	}
	echo $output . '</div>';
}
