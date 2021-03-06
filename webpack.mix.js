let mix = require("laravel-mix");

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
	resolve: {
		fallback: {
			stream: require.resolve("stream-browserify"),
			crypto: false,
		},
	},
	devtool: false,
};

mix
	.js("src/js/app.js", "assets/js/app.js")
	.sass("src/sass/app.scss", "assets/css/app.css")
	.options({
		processCssUrls: false,
	});

if (!mix.inProduction()) {
	webpackConfig.devtool = "inline-source-map";
}

mix.webpackConfig(webpackConfig).sourceMaps();
