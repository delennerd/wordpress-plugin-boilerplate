<?php
/**
 * @since             1.0.0
 * @package           PluginName
 *
 * @wordpress-plugin
 * Plugin Name:       Plugin Name
 * Description:       A custom plugin for the client
 * Version:           0.0.1
 * Author:            delennerd.media
 * Author URI:        https://delennerd.media
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

define( 'PLUGIN_NAME_VERSION', '0.0.1' );
define( 'PLUGIN_NAME_FILE', __FILE__ );
define( 'PLUGIN_NAME_DIR', plugin_dir_path( __FILE__ ) );
define( 'PLUGIN_NAME_BASENAME', plugin_basename( __FILE__ ) );
define( 'PLUGIN_NAME_URL', plugin_dir_url( __FILE__ ) );
define( 'PLUGIN_NAME_PREFIX', 'plugin_name_' );
define( 'PLUGIN_NAME_TEMPLATES_DIR', PLUGIN_NAME_DIR . 'templates' );
define( 'PLUGIN_NAME_COMPONENTS_DIR', PLUGIN_NAME_DIR . 'template-components/' );

/*
|--------------------------------------------------------------------------
| Autoloader
|--------------------------------------------------------------------------
*/

require_once dirname(__FILE__) . '/vendor/autoload.php';

$app = PluginName\Bootstrap\Bootstrap::get();
$app->bootstrap();

// $autoloadDirs = [
//     '/app/Classes/class-helper',
//     '/app/Bootstrap/i18n',
//     '/app/Include/enqueue',
//     '/app/Bootstrap/loader',
//     '/app/PostType/*',
//     '/app/Taxonomy/*',
// ];

// foreach ($autoloadDirs as $file) {
//     if ( false !== strpos( $file, '/*' ) ) {
//         $file_name = str_replace( '*', '', $file );
//         foreach (glob(__DIR__ . $file_name . '*.php') as $sub_file) {
//             if (file_exists($sub_file)) {
//                 require_once $sub_file;
//             }
//         }

//         continue;
//     }
//     require_once PLUGIN_NAME_DIR . $file . '.php';
// }

/*
|--------------------------------------------------------------------------
| Register Loader
|--------------------------------------------------------------------------
*/

// global $plugin_name;

// if ( !function_exists('plugin_name') ) {
//     function plugin_name()
//     {
//         global $plugin_name;
//         $plugin_name = PN_Loader::get_instance();
//         return $plugin_name;
//     }
// }
// plugin_name();
