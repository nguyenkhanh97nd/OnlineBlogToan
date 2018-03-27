const { mix } = require('laravel-mix');

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

mix.copy('node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js','public/page/js')
   .copy('node_modules/jquery/dist/jquery.min.js','public/page/js')
   .copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/','public/page/fonts/')  
   .js('resources/assets/page/js/app.js','public/page/js') 
   .sass('resources/assets/page/sass/app.scss', 'public/page/css')

   .copy('node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js','public/editor/js')
   .copy('node_modules/jquery/dist/jquery.min.js','public/editor/js')
   .copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/','public/editor/fonts/')
   
   .js('resources/assets/editor/js/app.js','public/editor/js') 
   .sass('resources/assets/editor/sass/app.scss', 'public/editor/css')

   .copy('node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js','public/admin/js')
   .copy('node_modules/jquery/dist/jquery.min.js','public/admin/js')
   .copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/','public/admin/fonts/')
   .copy('node_modules/moment/min/moment.min.js','public/admin/js')
   

   .js('resources/assets/admin/js/app.js','public/admin/js')
   .sass('resources/assets/admin/sass/app.scss', 'public/admin/css');
