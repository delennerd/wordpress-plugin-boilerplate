<?php
/**
 * @since      0.1.0
 * @package    PluginName
 * @subpackage Services
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Services;

use PluginName\Controllers\Auth\AuthController;
use PluginName\Controllers\UsersController;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class InitFrontendBackend {

    public function __construct()
    {
        add_action( 'init', function() {
            // $user = new UsersController();
            // $user->initFrontend();

            // new AuthController();
        } );

        // add_action( 'admin_init', function() {
        //     $user = new UsersController();
        //     $user->initBackend();
        // } );

        // add_action( 'tml_registered_action', function( $action ) {
        //     if ( in_array( $action, array( 'lostpassword', 'resetpass', 'register', 'dashboard' ) ) ) {
        // 		\tml_unregister_action( $action );
        // 	}
        // } );
    }
}