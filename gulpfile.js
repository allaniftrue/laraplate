var elixir = require('laravel-elixir'),
    gulp = require("gulp");

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass(['**/*.scss'], 'resources/assets/css/app.css')
        .styles([
            'normalize.css',
            'app.css'
        ]);
});

elixir(function(mix) {
    mix.scripts([
        'hammer-time.js',
        'app.js'
    ], 'public/js/app.js');
});

elixir(function(mix) {
    mix.version(['css/all.css', 'js/app.js']);
});
