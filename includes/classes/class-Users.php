<?php
/**
 * Define the internationalization functionality.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes/classes
 * @author     delennerd.media <mail@delennerd.de>
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class PN_Users {
    public function __construct()
    {
        // Register/Update user form
        add_action( 'user_new_form', array( $this, 'remove_required_user_register_fields' ) );
        add_action( 'show_user_profile', array( $this, 'remove_required_user_register_fields' ) );
        add_action( 'edit_user_profile', array( $this, 'remove_required_user_register_fields' ) );
        add_action( 'user_profile_update_errors', array( $this, 'remove_user_profile_errors_for_fields' ), 10, 3 );

        // Generate a unique number for username
        add_action( 'user_new_form', array( $this, 'backend_register_form' ) );

        // Some settings for clients
        add_action( 'admin_init', array( $this, 'disable_admin_page_for_clients' ) );
        add_action( 'wp', array( $this, 'disable_admin_bar_for_clients' ) );
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

        $new_user_login = PN_Helper::generate_random_number();
    ?>

        <script type="text/javascript">
            jQuery('#user_login').val( '<?php echo $new_user_login; ?>' );
        </script>

    <?php
    }

    /**
     * No admin access for clients (subscriber)
     * Hide admin bar for these
     */
    public function disable_admin_page_for_clients()
    {
        if ( ! is_user_logged_in() ) return null;

        if (  current_user_can( 'subscriber' ) && is_admin() ) {
            wp_redirect( home_url( '/' ) );
            exit;
        }
    }

    public function disable_admin_bar_for_clients()
    {
        if ( ! is_user_logged_in() ) return null;

        if (  current_user_can( 'subscriber' ) ) {
            add_filter('show_admin_bar', '__return_false');
        }
    }
}