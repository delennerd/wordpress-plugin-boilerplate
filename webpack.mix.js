let mix = require('laravel-mix')
const path = require('path')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

let webpackConfig = {
    module: {
        rules: [
            {
                test: /\.tsx?$/,
                loader: 'ts-loader',
                options: {},
                exclude: /node_modules/,
            },
        ],
    },
    resolve: {
        extensions: ['*', '.js', '.jsx', '.vue', '.ts', '.tsx'],
        fallback: {
            stream: require.resolve('stream-browserify'),
            crypto: false,
        },
    },
    module: {},
    devtool: false,
    optimization: {
        minimize: false,
    },
    stats: {
        children: true,
    },
}

mix.options({
    processCssUrls: false,
})

mix.alias({
    '@': path.join(__dirname, 'src/js'),
})
mix.ts('src/js/app.ts', 'assets/js/plugin-name.js')
    .extract()
    .sass('src/sass/app.scss', 'assets/css/plugin-name.css')
    .copyDirectory('src/images', 'assets/images')

if (!mix.inProduction()) {
    webpackConfig.devtool = 'source-map'
} else {
    webpackConfig.optimization.minimize = true
}

mix.webpackConfig(webpackConfig)
