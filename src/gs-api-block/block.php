<?php
/**
 * GS API Block
 *
 * @package gabischiopu
 */

declare( strict_types = 1 );

namespace GS\AM\APIBlock;

use function GS\AM\APIFunctions\make_data_request;

/**
 * Register block.
 */
\add_action( 'init', function () {
	\register_block_type( __DIR__ , [
		'render_callback' => __NAMESPACE__ . '\\render',
	] );
} );

/**
 * Render callback.
 *
 * @param array  $attributes Block attributes.
 */
function render( array $attributes ): string {
	// Parse attributes.
	$atts = \wp_parse_args( $attributes );

	// Check if the stored data in attributes should be used or load data from API.
	if ( $atts['currentDataUse'] === false ) {
		$data = make_data_request(false, true);

		// Decode the JSON string into a PHP array
		$data_array = \json_decode($data, true);

		// Access the parsed data
		$title   = \esc_html($data_array['title']);
		$headers = \array_map('esc_html', $data_array['data']['headers']);
		$rows    = $data_array['data']['rows'];

	} else {
		$title = \esc_html($atts['tableTitle']) ?? __('No table data.', 'gs-am-plugin');
		$headers = $atts['tableHeaders'] ?? [];
		$rows = $atts['tableRows'] ?? [];
	}

	// Show columns status array
	$show_columns = $atts['showColumns'] ?? [];

	$wrapper_attributes = \get_block_wrapper_attributes( [
		'class' => 'gs-api-block',
	] );

	// Initialize the table output string
	$table_output = '<h2 class="data-table-title">' . $title;
	$table_output .= '</h2><div class="table-wrapper"><table class="data-table"><thead>';
	$table_output .= '<tr>';

	// Add table headers
	foreach ($headers as $header) {
		// Get header index in $header array
		$header_index = \array_search($header, $headers);

		// Check if header status is 'true' in $show_columns
 		if( $show_columns[$header_index] === true ) {
			$table_output .= '<th>' . \esc_html($header) . '</th>';
		}
	}
	$table_output .= '</tr></thead><tbody>';

	// Add table rows
	foreach ($rows as $row) {
		$table_output .= '<tr>';
		foreach ($row as $key => $value) {
			// Get key-value pair index in $row array
			$key_index = \array_search($key, \array_keys($row));

			// Check if cell status is 'true' in show_columns
			if( $show_columns[$key_index] === true ) {

				// Check if the column is 'Date' and format the value
				if( $headers[$key_index] === 'Date' ) {
					$table_output .= '<td>' . \esc_html(date('Y/m/d H:i', $value)) . '</td>';
				} else {
					$table_output .= '<td>' . \esc_html($value) . '</td>';
				}
			}
		}
		$table_output .= '</tr>';
	}

	$table_output .= '</tbody></table></div>';

	return \sprintf( '
		<div %s>
			%s
		</div>',
		$wrapper_attributes,
		$table_output,
	);
}
