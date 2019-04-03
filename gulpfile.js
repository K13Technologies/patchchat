var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less('app.less');
    
    mix.scripts([
        '../../../bower_components/jquery/dist/jquery.js',        
        '../../../bower_components/bootstrap/dist/js/bootstrap.js',
        '../../../bower_components/angular/angular.js',
        '../../../bower_components/summernote/dist/summernote.js', 
        '../../../bower_components/angular-summernote/dist/angular-summernote.js', 
        '../../../bower_components/angular-modal-service/dst/angular-modal-service.js',
        '../../../bower_components/angular-modal-service/dst/angular-modal-service.js',
        '../../../bower_components/magnific-popup/dist/jquery.magnific-popup.js',
        '*.js'        
    ], 'public/js/all.js')
    
    mix.copy('bower_components/angular-i18n/*.js', 'public/js/i18n');
    
    mix.scripts(['resources/assets/js/patchchat/map.js'], 'public/js/map.js')
    
    //mix.copy('resources/assets/js/all.js', 'public/js/all.js');
    //mix.copy('resources/assets/js/all.js.map', 'public/js/all.js.map');
    mix.copy('resources/assets/img', 'public/img');
});
