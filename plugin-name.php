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