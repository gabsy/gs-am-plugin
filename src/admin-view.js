/**
 * Internal dependencies
 */
import axios from 'axios';
import formattedDate from './js/utils/formatted-date';

document.addEventListener('DOMContentLoaded', function() {
	if (!document.querySelector('.btn-refresh-data')) {
		return;
	}
	const refreshButton = document.querySelector('.btn-refresh-data');
	const dataTableTitle = document.querySelector('.data-table-title span');
	const dataTableBody = document.querySelector('.data-table tbody');

	refreshButton.addEventListener('click', function () {

		// Display loading message
		dataTableBody.innerHTML = '<tr><td colspan="5" class="loader">Loading data...</td></tr>';

		// Call the fetch function
		setTimeout(() => fetchData(), 500);
	});

	async function fetchData() {
		try {
			const response = await axios.get('/wp-admin/admin-ajax.php', {
				params: {
					action: 'fetch_data',
				},
			});
			onCallSuccess(response.data, dataTableBody, dataTableTitle);
		
		} catch (error) {

			// Display error message
			dataTableBody.innerHTML = `<tr><td colspan="5" class="error-message"> ${error.message} </td></tr>`;
		}
	};
});

// On call success function
function onCallSuccess(data, dataTableBody, dataTableTitle) {

	// Convert rows object to array of objects
	const dataRows = Object.values(data.data.rows);
	const dataHeaders = data.data.headers;

	// New data string
	let newData = '';

	for (const row of dataRows) {
		let newRow = '<tr>';

		for (const value of Object.values(row)) {
			const valueIndex = Object.values(row).indexOf(value);
			dataHeaders[valueIndex] === 'Date'
				? (newRow += `<td>${formattedDate(value)}</td>`)
				: (newRow += `<td>${value}</td>`);
		}

		newRow += '</tr>';
		newData += newRow;
	}

	// Update the table title
	dataTableTitle.textContent = data.title;

	// Append the new data to the table body and replace the old data
	dataTableBody.innerHTML = newData;
}
