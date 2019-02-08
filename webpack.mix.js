const mix = require('laravel-mix');
const monacoWebpackPlugin = require('monaco-editor-webpack-plugin');
const CompressionPlugin = require('compression-webpack-plugin');

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
   .sass('resources/sass/app.scss', 'public/css').version()
    .webpackConfig({
        plugins: [
            new monacoWebpackPlugin(),
            new CompressionPlugin({
                algorithm: "gzip",
                test: /\.(js|css|ttf|eot|woff|woff2|svg)$/,
                threshold: 1240,
                minRatio: 0.8
            })
        ]
    }).browserSync('http://editor.test');
