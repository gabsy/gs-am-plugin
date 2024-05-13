/**
 * WordPress dependencies
 */
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { useState, useEffect } from '@wordpress/element';

/**
 * External dependencies
 */
import axios from 'axios';

/**
 * Internal dependencies
 */
import formattedDate from '../js/utils/formatted-date';

const Edit = ({ attributes, setAttributes }) => {
	const { tableRows, tableHeaders, tableTitle, showColumns, currentDataUse } = attributes;

	const [isLoading, setIsLoading] = useState(true);
	const [isError, setIsError] = useState(null);

	const blockProps = useBlockProps({
		className: 'gs-api-block',
	});

	// Set default columns status as an array of booleans, when table headers are fetched.
	// Default status is 'true' for all columns.
	const setDefaultColumnsStatus = (length) => {
		const defaultColumnsStatus = Array.from({ length }, () => true);
		setAttributes({ showColumns: defaultColumnsStatus });
	};

	// Fetch data through the existing AJAX endpoint
	const fetchData = async () => {
		try {
			const response = await axios.get('/wp-admin/admin-ajax.php', {
				params: {
					action: 'fetch_data',
				},
			});

			// Parse the response data and set the attributes
			const responseData = response.data;

			// Check if the response data is empty
			if (
				!responseData.data.headers.length ||
				!Object.values(responseData.data.rows).length
			) {
				throw new Error('No data available');
			}

			await setAttributes({ tableTitle: responseData.title });
			await setAttributes({ tableHeaders: responseData.data.headers });
			await setAttributes({ tableRows: Object.values(responseData.data.rows) });
		} catch (error) {
			setIsError(error.message);
		} finally {
			setIsLoading(false);
			setIsError(null);
		}
	};

	// Fetch data on initial render only if currentDataUse is set to false
	useEffect(() => {
		if (currentDataUse) {
			setIsLoading(false);
		} else {
			fetchData();
		}
	}, []);

	useEffect(() => {
		if (tableHeaders.length) {
			setDefaultColumnsStatus(tableHeaders.length);
		}
	}, [tableHeaders]);

	return (
		<>
			{/* Block settings */}
			<InspectorControls>
				<PanelBody>
					<h3>{__('Use current data', 'gs-am-plugin')}</h3>
					<ToggleControl
						label={__('Use current loaded data', 'gs-am-plugin')}
						checked={currentDataUse}
						onChange={() => {
							setAttributes({ currentDataUse: !currentDataUse });
						}}
						help={__(
							'Set current data as block attributes. If disabled, the block will display the latest data from cache table.',
							'gs-am-plugin',
						)}
					/>
				</PanelBody>
				<PanelBody>
					<h3>{__('Show columns', 'gs-am-plugin')}</h3>
					{/* Render toggle constrols for each column */}
					{tableHeaders.map((header, index) => (
						<ToggleControl
							key={index}
							label={header}
							checked={showColumns[index]}
							onChange={() => {
								const updatedColumnsStatus = [...showColumns];
								updatedColumnsStatus[index] = !updatedColumnsStatus[index];
								setAttributes({
									showColumns: updatedColumnsStatus,
								});
							}}
						/>
					))}
				</PanelBody>
			</InspectorControls>

			{/* Block content */}
			<div {...blockProps}>
				{isLoading && (
					<div className="loader">{__('Loading block data…', 'gs-am-plugin')}</div>
				)}
				{isError && (
					<div className="error-message">
						{__('Error:', 'gs-am-plugin')} {isError}
					</div>
				)}
				{!isLoading && (
					<>
						<h2 className="data-table-title">{tableTitle}</h2>
						<div className="table-wrapper">
							<table className="data-table">
								<thead>
									<tr>
										{tableHeaders.map((header, index) => {
											return (
												// Render columns based on their showColumns status
												showColumns[index] && <th key={index}>{header}</th>
											);
										})}
									</tr>
								</thead>
								<tbody>
									{tableRows &&
										tableRows.map((row, indexRow) => (
											<tr key={indexRow}>
												{/* Convert the row values to an array and render cells */}
												{Object.values(row).map((value, indexCol) => {
													return (
														// Render cells based on their showColumns status
														showColumns[indexCol] && (
															<td key={indexCol}>
																{tableHeaders[indexCol] === 'Date'
																	? formattedDate(value)
																	: value}
															</td>
														)
													);
												})}
											</tr>
										))}
								</tbody>
							</table>
						</div>
					</>
				)}
			</div>
		</>
	);
};

export default Edit;
