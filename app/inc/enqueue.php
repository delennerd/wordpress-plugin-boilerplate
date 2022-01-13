<?php

add_action('wp_enqueue_scripts', function () {

    $app_js_v = hash_hmac('md5', filemtime(PLUGIN_NAME_DIR . 'assets/js/app.js'), 'dlm');
    wp_enqueue_script( 'plugin-name-js', PLUGIN_NAME_URL . 'assets/js/app.js', [], $app_js_v, true );

    $app_css_v = hash_hmac('md5', filemtime(PLUGIN_NAME_DIR . 'assets/css/app.css'), 'dlm' );
    wp_enqueue_style( 'plugin-name-css', PLUGIN_NAME_URL . 'assets/css/app.css', [], $app_css_v, 'all' );
});