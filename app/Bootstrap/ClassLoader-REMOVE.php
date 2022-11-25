<?php
/**
 * Class Loader file to enter all required classes
 *
 * @since      0.1.0
 * @package    Plugin_Name
 * @subpackage Bootstrap
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Bootstrap;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class ClassLoader {

    protected static $class_loader = null;

    private function __construct()
    {   
    }

    public static function get() : ClassLoader
    {
        if (!self::$class_loader) {
            self::$class_loader = new ClassLoader();
        }

        return self::$class_loader;
    }

    public function load_helpers()
    {
        
    }
}