<?php
/**
 * @since             1.0.0
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       Plugin_Name
 * Description:       A custom plugin for the client
 * Version:           1.0.0
 * Author:            delennerd.media
 * Author URI:        https://delennerd.media
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_NAME_VERSION', '1.0.0' );
define( 'PLUGIN_NAME_DIR', plugin_dir_path( __FILE__ ) );
define( 'PLUGIN_NAME_BASENAME', plugin_basename( __FILE__ ) );
define( 'PLUGIN_NAME_URL', plugin_dir_url( __FILE__ ) );
define( 'PLUGIN_NAME_DIR_TEMPLATES', PLUGIN_NAME_DIR . 'templates' );

/*
|--------------------------------------------------------------------------
| Autoloader
|--------------------------------------------------------------------------
*/
$autoloadDirs = [
    'app/Classes/class-helper',
    'app/Bootstrap/i18n',
    'app/inc/enqueue',
    'app/Bootstrap/loader',
];

foreach ($autoloadDirs as $file) {
    require_once PLUGIN_NAME_DIR . $file . '.php';
}

/*
|--------------------------------------------------------------------------
| Register Loader
|--------------------------------------------------------------------------
*/

global $plugin_name;

if ( !function_exists('plugin_name') ) {
    function plugin_name()
    {
        global $plugin_name;
        $plugin_name = PN_Loader::get_instance();
        return $plugin_name;
    }
}
plugin_name();
