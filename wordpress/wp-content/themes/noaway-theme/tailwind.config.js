const fg = require( 'fast-glob' );

/** @type {import('tailwindcss').Config} */
module.exports = {
	content: fg.sync( '**/*.php', { cwd: __dirname, ignore: ['node_modules'] } ),
	darkMode: 'class',
	theme: {
		extend: {
			colors: {
				primary: '#5851ec',
				background: {
					light: '#f6f6f8',
					dark: '#121121',
				},
			},
			fontFamily: {
				sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
				display: ['Inter', 'sans-serif'],
				logo: ['Montserrat', 'sans-serif'],
			},
		},
	},
	plugins: [],
};
