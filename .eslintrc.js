module.exports = {
	extends: ['plugin:@wordpress/eslint-plugin/recommended'],
	globals: {
		wp: 'off',
	},
	printWidth: 100,
	env: {
		browser: true,
	},
	rules: {
		'jsdoc/require-param': 'off',
		'@wordpress/no-global-event-listener': 'off',
		'@wordpress/dependency-group': 'error',
		'@wordpress/no-unsafe-wp-apis': 'error',
	},
	parser: '@babel/eslint-parser',
	parserOptions: {
		babelOptions: {
			presets: ['@wordpress/babel-preset-default'],
		},
		requireConfigFile: false,
	},
	ignorePatterns: ['**/build/*.js', '**/build/**/*.js'],
};
