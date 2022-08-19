<?php
/**
 * Enqueue the CSS and JS files
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

add_action('wp_enqueue_scripts', function () {

    $app_js_v = hash_hmac('md5', filemtime(PLUGIN_NAME_DIR . 'assets/js/plugin-name.js'), 'dlm');
    wp_enqueue_script( 'plugin-name-js', PLUGIN_NAME_URL . 'assets/js/plugin-name.js', [], $app_js_v, true );

    $app_css_v = hash_hmac('md5', filemtime(PLUGIN_NAME_DIR . 'assets/css/plugin-name.css'), 'dlm' );
    wp_enqueue_style( 'plugin-name-css', PLUGIN_NAME_URL . 'assets/css/plugin-name.css', [], $app_css_v, 'all' );

    wp_localize_script('plugin-name-js', 'pluginNameConfig', array(
        'apiUrl' => home_url('/wp-json'),
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'siteUrl' => str_replace(array('https://', 'https://www.', 'www.'), '', get_bloginfo('wpurl')),
        'homeUrl' => home_url('/'),
        'currentUrl' => add_query_arg( array(), home_url( $_SERVER['REQUEST_URI'] )),
    ));
});