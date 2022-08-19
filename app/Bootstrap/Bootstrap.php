<?php
/**
 * The Bootstrap class
 *
 * @since      0.0.1
 * @package    Plugin_Name
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

    public static function get() : Bootstrap
    {
        if (!self::$app) {
            self::$app = new Bootstrap();
        }

        return self::$app;
    }

    public function bootstrap() : void
    {
        register_activation_hook(PLUGIN_NAME_FILE, [ $this, 'plugin_activation_action' ]);

        $this->load_i18n();
        $this->initRoutes();
    }

    public function plugin_activation_action()
    {
        flush_rewrite_rules(true);
    }

    public function initRoutes() : void
    {
        require_once PLUGIN_NAME_DIR . '/app/config/routes.php';

        add_action('init', function () {
            Route::initRoutes();
        });
    }

    public function load_i18n() : void
    {
        I18nLoader::load_plugin_textdomain();
    }
}