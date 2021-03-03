const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
	.sourceMaps()
	.extract(['bootstrap','jquery','popper.js']);

mix.styles([
	'resources/css/home.css',
	'resources/css/forum-font.css'
], 'public/css/all.css').options({
	processCssUrls: false
}).version();
