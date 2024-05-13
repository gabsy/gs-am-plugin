/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */

import name from './block.json';
import edit from './edit';
import save from './save';
import './style.css';

registerBlockType(name, {
	edit,
	save,
	icon: {
		src: (
			<svg
				width="32"
				height="32"
				viewBox="0 0 32 32"
				fill="none"
				xmlns="http://www.w3.org/2000/svg"
			>
				<path
					d="M4 16.5C4 9.59644 9.5212 4 16.3319 4H21.7814C22.7781 4 23.586 4.80797 23.586 5.80465V5.80465C23.586 6.80133 22.7781 7.6093 21.7814 7.6093H16.3319C11.4878 7.6093 7.56077 11.5898 7.56077 16.5C7.56077 21.4102 11.4878 25.3907 16.3319 25.3907H22.6689C23.6466 25.3907 24.4392 24.5873 24.4392 23.5962C24.4392 22.6052 23.6466 21.8018 22.6689 21.8018H16.4325C13.4882 21.8018 11.1014 19.3825 11.1014 16.398C11.1014 13.4136 13.4882 10.9943 16.4325 10.9943H17.7881C18.7616 10.9943 19.5507 11.7942 19.5507 12.7809C19.5507 13.7875 18.7456 14.6036 17.7525 14.6036H16.4325C15.4548 14.6036 14.6622 15.407 14.6622 16.398C14.6622 17.3891 15.4548 18.1925 16.4325 18.1925H22.6689C25.6132 18.1925 28 20.6118 28 23.5962C28 26.5807 25.6132 29 22.6689 29H16.3319C9.5212 29 4 23.4036 4 16.5Z"
					fill="#6179FF"
				/>
			</svg>
		),
	},
});
