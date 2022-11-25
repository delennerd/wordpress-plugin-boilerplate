<?php
/**
 * The Bootstrap class
 *
 * @since      0.0.1
 * @package    PluginName
 * @subpackage Bootstrap
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Bootstrap;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use PluginName\Bootstrap\Route;
use PluginName\Bootstrap\I18nLoader;

require_once PLUGIN_NAME_DIR . '/app/misc/enqueue.php';

class Bootstrap
{
    private static $app = null;

    private function __construct()
    {
    }

    public static function get(): Bootstrap
    {
        if (!self::$app) {
            self::$app = new Bootstrap();
        }

        return self::$app;
    }

    public function bootstrap(): void
    {
        \register_activation_hook(PLUGIN_NAME_FILE, [ $this, 'plugin_activation_action' ]);

        $this->load_i18n();
        $this->initClasses();
        
        \add_action( 'init', [ $this, 'initRoutes' ], 5 );
        \add_action( 'after_setup_theme', [ $this, 'loadCarbonFields' ] );
    }

    public function plugin_activation_action()
    {
        \flush_rewrite_rules(true);
    }

    public function initRoutes(): void
    {
        require_once PLUGIN_NAME_DIR . '/app/Config/routes.php';

        Route::initRoutes();
    }

    public function initClasses(): void
    {
        require_once PLUGIN_NAME_DIR . 'app/Config/classes.php';

        foreach( $packageClasses as $class ) {
            new $class;
        }
    }

    public function load_i18n(): void
    {
        I18nLoader::load_plugin_textdomain();
    }

    public function loadCarbonFields(): void
    {
        require_once PLUGIN_NAME_DIR . 'vendor/autoload.php';
        \Carbon_Fields\Carbon_Fields::boot();
    }
}