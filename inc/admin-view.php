<?php
/**
 * Render Data table on admin page
 *
 * @package gabischiopu
 */

declare( strict_types=1 );

namespace GS\AM\AdminView;

/**
 * Render the data table
 * 
 * @param string $data JSON data
 * 
 * @return string Table output
 */

function render_table( string $data ): string {
	// Decode the JSON string into a PHP array
	$data_array = \json_decode($data, true);

	// Access the parsed data
	$title   = \esc_html($data_array['title']);
	$headers = \array_map('esc_html', $data_array['data']['headers']);
	$rows    = $data_array['data']['rows'];

	// Initialize the table output string
	$table_output = '<h2 class="data-table-title"><span>' . $title . '</span>';
	$table_output .= '<button class="btn-refresh-data">Refresh data</button>';
	$table_output .= '</h2><div class="table-wrapper"><table class="data-table"><thead>';
	$table_output .= '<tr>';

	// Add table headers
	foreach ($headers as $header) {
		$table_output .= '<th>' . $header . '</th>';
	}
	$table_output .= '</tr></thead><tbody>';

	// Add table rows
	foreach ($rows as $row) {
		$table_output .= '<tr>';
		$table_output .= '<td>' . \esc_html($row['id']) . '</td>';
		$table_output .= '<td>' . \esc_html($row['fname']) . '</td>';
		$table_output .= '<td>' . \esc_html($row['lname']) . '</td>';
		$table_output .= '<td>' . \esc_html($row['email']) . '</td>';
		$table_output .= '<td>' . \esc_html(date('Y/m/d H:i', $row['date'])) . '</td>';
		$table_output .= '</tr>';
	}

	$table_output .= '</tbody></table></div>';

	return $table_output;
}
