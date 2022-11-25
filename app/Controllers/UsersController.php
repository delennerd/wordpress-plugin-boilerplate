<?php
/**
 * @since      0.1.0
 * @package    PluginName
 * @subpackage Controllers
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Controllers;

use PluginName\Helpers\Helper;
use PluginName\Helpers\LanguageHelper;
use PluginName\Models\UserModel;
use PluginName\Services\SiteService;

if ( !defined('ABSPATH') ) exit; // Exit if accessed directly

class UsersController
{
    private $user = null;

    public function __construct()
    {
        if ( is_user_logged_in() ) {
            $this->user = UserModel::getInstance();
        }

        // add_filter( 'login_redirect', [ $this, 'redirectPathAfterLogin' ], 10, 3 );

        // Register/Update user form
        // add_action( 'user_new_form', array( $this, 'remove_required_user_register_fields' ) );
        // add_action( 'show_user_profile', array( $this, 'remove_required_user_register_fields' ) );
        // add_action( 'edit_user_profile', array( $this, 'remove_required_user_register_fields' ) );
        // add_action( 'user_profile_update_errors', array( $this, 'remove_user_profile_errors_for_fields' ), 10, 3 );

        // Generate a unique number for username
        // add_action( 'user_new_form', array( $this, 'backend_register_form' ) );

        // Some settings for subscriber
        // add_action( 'admin_init', array( $this, 'disable_admin_page_for_subscriber' ) );
        // add_action( 'wp', array( $this, 'disable_admin_bar_for_subscriber' ) );
    }

    public function initFrontend()
    {
        $this->createCustomRoleCapabilities();

        // if ( is_user_logged_in() ) {
        //     $this->disable_admin_bar();
        // }
    }

    public function initBackend()
    {
        $this->createCustomRoleCapabilities();

        // if ( is_user_logged_in() && is_admin() && ! wp_doing_ajax() ) {
        //     if ( $this->user->userIsHaendler() || $this->user->userIsPresse() ) {
        //         wp_safe_redirect( get_permalink(LanguageHelper::getTranslatedElementId( RIEDL_BAMO_HAENDLER_DASHBOARD_PAGE_ID )) );
        //     }
        // }
    }

    public function redirectPathAfterLogin( $url, $query, $user ) : string
    {
        // $url = SiteService::getDashboardUrl();
        // return $url;
    }

    public function disable_admin_bar()
    {
        // if ( 
        //     $this->user->userIsHaendler() 
        //     || $this->user->userIsPresse() 
        //     || 0 === count($this->user->getUserRoles())
        // ) {
        //     show_admin_bar( false );
        // }
    }

    public function createCustomRoleCapabilities () 
    {
        // $role_haendler = get_role( 'haendler' );
        // $role_press = get_role( 'press' );

        // $role_haendler->add_cap( 'read_b2b_shop', true );
    }

    /**
     * This will suppress empty email errors when submitting the user form
     */
    public function remove_user_profile_errors_for_fields( $errors, $update, $user )
    {
        $errors->remove('empty_email');
    }

    /**
     * This will remove javascript required validation for email input
     * It will also remove the '(required)' text in the label
     * Works for new user, user profile and edit user forms
     */
    public function remove_required_user_register_fields( $form_type )
    {
    ?>
        <script type="text/javascript">
            jQuery('#email').closest('tr').removeClass('form-required').find('.description').remove();
            // Uncheck send new user email option by default
            <?php if (isset($form_type) && $form_type === 'add-new-user') : ?>
                jQuery('#send_user_notification').removeAttr('checked');
            <?php endif; ?>
        </script>
    <?php
    }

    /**
     * Generate a unqiue number as username/user_login
     */
    public function backend_register_form( $type )
    {
        if ( $type !== 'add-new-user' ) return;

        // $new_user_login = Helper::generate_random_number();
    ?>

        <script type="text/javascript">
            jQuery('#user_login').val( '<?php //echo $new_user_login; ?>' );
        </script>

    <?php
    }

    /**
     * No admin access for subscriber
     * Hide admin bar for these
     */
    public function disable_admin_page_for_subscriber()
    {
        if ( ! is_user_logged_in() ) return null;

        if (  current_user_can( 'subscriber' ) && is_admin() ) {
            wp_redirect( home_url( '/' ) );
            exit;
        }
    }

    /**
     * 
     */
    public function disable_admin_bar_for_subscriber()
    {
        if ( ! is_user_logged_in() ) return null;

        if (  current_user_can( 'subscriber' ) ) {
            add_filter('show_admin_bar', '__return_false');
        }
    }
}