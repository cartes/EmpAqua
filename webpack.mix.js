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
    .sourceMaps()
    .sass('resources/sass/app.scss', 'public/css');

mix.copy('vendor/tinymce/tinymce/tinymce.min.js', 'public/js/tinymce');
mix.copy('vendor/tinymce/tinymce/themes', 'public/js/tinymce/themes');
mix.copy('vendor/tinymce/tinymce/skins', 'public/js/tinymce/skins');
mix.copy('vendor/tinymce/tinymce/plugins', 'public/js/tinymce/plugins');