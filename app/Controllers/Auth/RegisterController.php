<?php
/**
 * @since      0.1.0
 * @package    PluginName
 * @subpackage Controllers\Auth
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Controllers\Auth;

use PluginName\Controllers\Base\FormAlertController;
use PluginName\Controllers\MailController;
use PluginName\Models\UserModel;

if ( !defined('ABSPATH') ) exit; // Exit if accessed directly

class RegisterController
{
    private $userModel = null;
    private $formData = [];

    public function __construct()
    {
        $ajaxNameRegister = 'bamo_register_user';
        add_action("wp_ajax_{$ajaxNameRegister}", [ $this, 'registerCallback' ]);
        add_action("wp_ajax_nopriv_{$ajaxNameRegister}", [ $this, 'registerCallback' ]);
    }

    public function registerCallback()
    {
        $this->userModel = UserModel::getInstance();

        $nonce = wp_verify_nonce( sanitize_text_field( $_POST['nonce'] ?? '' ), 'register-press' );

        if ( ! $nonce ) {
            wp_send_json_error( [
                'error' => 'Nonce is invalid'
            ] );
        }

        $data = [
            'errors' => "",
        ];

        $user_email = sanitize_email($_POST['user_email'] ?? '');

        $this->formData = [
            'email' => sanitize_email($_POST['user_email'] ?? ''),
            'gender' => sanitize_text_field($_POST['asp_gender'] ?? ''),
            'name' => sanitize_text_field($_POST['name'] ?? ''),
            'firstname' => sanitize_text_field($_POST['firstname'] ?? ''),
            'newsletter' => isset($_POST['newsletter']) ? (sanitize_text_field( $_POST['newsletter'] ) === "true" ? true : false) : false,
        ];

        $this->formData['anrede'] = $this->formData['asp_gender'] === 'f' ? _('Frau') : _('Herr');

        $userId = \register_new_user($user_email, $user_email);

        if (is_wp_error($userId)) {
            $data['errors'] = FormAlertController::renderError( $userId->errors );
            \wp_send_json_error($data, 503);
        }

        // this->userModel = UserModel::getInstance();
        $newUser = $this->userModel->getUserById($userId);
        $this->userModel->setUser($newUser);

        $generatedPassword = $this->userModel->generatePassword();

        $this->_saveFormDataToNewUser($generatedPassword);
        $sendMail = $this->_sendWelcomeMail($generatedPassword);

        $successMessage = _('Vielen Dank für Ihre Registrierung.<br /><br />Eine E-Mail mit Ihrem Zugangsdaten und weiteren Informationen zu unserem Portal wurde Ihnen zugesandt.');

        \wp_send_json_success([
            'username' => $this->userModel->getUserEmail(),
            'password' => $generatedPassword,
            'id' => $this->userModel->getUserId(),
            'formData' => $this->formData,
            'sendmail' => $sendMail,
            'registration' => (bool) $newUser,
            'successMsg' => FormAlertController::renderSuccess( $successMessage ),
        ]);
    }

    private function _saveFormDataToNewUser( $userPass )
    {
        global $wpdb;

        $userId = $this->userModel->getUserId();

        // Change password
        $this->userModel->saveNewPassword( $userPass );
    	update_user_meta( $userId, 'default_password_nag', false ); // Set up the password change nag.

        // Change Username / email for press
        $wpdb->update($wpdb->users, array('user_login' => $this->formData['email']), array('ID' => $userId));
        wp_update_user( array( 'ID' => $userId, 'display_name' => $this->formData['email'] ) );
        wp_update_user( array( 'ID' => $userId, 'role' => 'press' ) );

        $this->userModel->setUserField( 'company', $this->formData['company'] );
        $this->userModel->setUserField( 'street', $this->formData['street'] );
        $this->userModel->setUserField( 'zip', $this->formData['zip'] );
        $this->userModel->setUserField( 'city', $this->formData['city'] );
        $this->userModel->setUserField( 'country', $this->formData['country'] );
        $this->userModel->setUserField( 'homepage', $this->formData['homepage'] );
        $this->userModel->setUserField( 'asp_gender', $this->formData['asp_gender'] );
        $this->userModel->setUserField( 'asp_name', $this->formData['asp_name'] );
        $this->userModel->setUserField( 'asp_firstname', $this->formData['asp_firstname'] );
        $this->userModel->setUserField( 'asp_function', $this->formData['asp_function'] );
        $this->userModel->setUserField( 'mediatitle', $this->formData['mediatitle'] );
        $this->userModel->setUserField( 'asp_phone', $this->formData['asp_phone'] );
        $this->userModel->setUserField( 'asp_fax', $this->formData['asp_fax'] );
        $this->userModel->setUserField( 'press_category', $this->formData['press_category'] );
        $this->userModel->setUserField( 'newsletter', $this->formData['newsletter'] );

        return $userPass;
    }

    private function _sendWelcomeMail( $userPass = "" )
    {
        require RIEDL_BAMO_HAENDLER_DIR . 'app/Config/config.mails.php';

        $headers = [
            'from' => $mailSet['presse-zugang-anfordern']['mailer']['from'],
            'replyTo' => $mailSet['presse-zugang-anfordern']['mailer']['from'],
        ];

        $mailData = [
            'formData' => $this->formData,
            'email' => $this->userModel->getUserEmail(),
            'userEmail' => $this->userModel->getUserEmail(),
            'userPassword' => $userPass,
        ];

        $mailer = new MailController();
        $mailer->setTemplate( 'press-account-new.php' );
        $mailer->setHeaders( $headers );
        $mailer->setSubject( $mailSet['presse-zugang-anfordern']['mailer']['subject'] );
        $mailer->setMailData( $mailData );

        $mailer->send();
    }
}