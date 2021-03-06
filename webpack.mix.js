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

mix.styles([
	'resources/css/home.css',
	'resources/css/forum-font.css',
	'resources/css/os-theme-round-light.css'
], 'public/css/home.css').options({
	processCssUrls: false
}).version();

mix.styles([
	'resources/css/thread.css',
	'resources/css/forum-font.css',
	'resources/css/os-theme-round-light.css'
], 'public/css/thread.css').options({
	processCssUrls: false
}).version();

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
	.sourceMaps()
	.extract(['bootstrap','jquery','popper.js','overlayscrollbars']);

mix.scripts([
	'resources/js/scrollbars.js',
	'resources/js/home.js'
], 'public/js/home.js').options({
	processCssUrls: false
}).version();
