<?php
/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes/classes
 * @author     delennerd.media <mail@delennerd.de>
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class PN_Loader {
    const CLASS_DIR = 'app/Classes/';

    private $werke_class;
    private $users_class;

    private $admin_url;

    private static $_instance;

    function __construct()
    {
        $this->load_classes();
    }

    public static function get_instance()
    {
        if (!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function load_classes()
    {
        $this->require_class( 'users' );
        $this->users_class = new PN_Users();
    }

    public function require_class( $file = "" )
    {
        return $this->required( self::CLASS_DIR . 'class-' . $file );
    }

    // public function admin_url( $view = 'settings' )
    // {
    //     return admin_url('options-general.php?page=plugin-name.php&view=' . $view);
    // }

    public function required( $file = "" )
    {
        $dir = PLUGIN_NAME_DIR;

        if ( empty($dir) || !is_dir($dir) ) {
            return false;
        }

        $file = path_join( $dir, $file . '.php' );

        if ( !file_exists($file) ) {
            return false;
        }

        require_once $file;
    }

    // Todo: Add a admin page
    /*
    public function get_view( $file = "" )
    {
        $this->required( self::VIEW_DIR . $file );
    }

    public function admin_view( $file = "" )
    {
        $this->get_view( 'admin/' . $file );
    }

    public function get_active_view()
    {
        $default = 'settings';

        if (!isset($_GET['view'])) {
            return $default;
        }

        $available = array('wizard', 'settings');
        $view = wp_filter_kses($_GET['view']);

        return (in_array($view, $available)) ? $view : $default;

    }
    */
}