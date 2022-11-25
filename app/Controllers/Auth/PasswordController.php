<?php
/**
 * @since      0.1.0
 * @package    PluginName
 * @subpackage Controllers
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Controllers\Auth;

use PluginName\Controllers\Base\FormAlertController;
use PluginName\Controllers\MailController;
use PluginName\Helpers\LanguageHelper;
use PluginName\Models\UserModel;

if ( !defined('ABSPATH') ) exit; // Exit if accessed directly

class PasswordController
{
    private $userModel = null;
    private $formData = [];

    public function __construct()
    {
        $ajaxNameResetPassword = 'bamo_haendler_password_reset';
        add_action("wp_ajax_{$ajaxNameResetPassword}", [ $this, 'ajaxCallback' ]);
        add_action("wp_ajax_nopriv_{$ajaxNameResetPassword}", [ $this, 'ajaxCallback' ]);
    }

    public function ajaxCallback()
    {
        $this->userModel = UserModel::getInstance();

        $nonce = wp_verify_nonce( sanitize_text_field( $_POST['nonce'] ), 'lost-password' );

        if ( ! $nonce ) {
            wp_send_json_error( [
                'error' => 'Nonce is invalid'
            ] );
        }

        $data = [
            'errors' => "",
        ];

        $this->formData = [
            'email' => sanitize_email($_POST['user_login'] ?? ''),
        ];

        $user = $this->userModel->getUserByEmail( $this->formData['email'] );

        if ( ! $user ) {
            $data['errors'] = FormAlertController::renderError( 'Es ist ein Fehler aufgetreten beim Zur&uuml;cksetzen Ihres Passworts. Haben Sie sich vertippt?' );

            \wp_send_json_error( $data, 503 );
        }

        $this->userModel->setUser( $user );

        $generatedPassword = $this->userModel->generatePassword();
        $this->userModel->saveNewPassword( $generatedPassword );
        \update_user_meta( $this->userModel->getUserId(), 'default_password_nag', false ); // Set up the password change nag.

        $sendMail = $this->_sendResetPasswordMail( $generatedPassword );

        $successMessage = _( 'Ihr Passwort wurde erfolgreich zurückgesetzt.<br /><br />Eine E-Mail mit Ihrem neuen Zugangsdaten wurde Ihnen zugesandt.<br /><br />Sie können sich nun mit diesen Zugangsdaten im <a href="../login">Presseportal</a> anmelden.' );

        \wp_send_json_success([
            'username' => $this->userModel->getUserEmail(),
            'password' => $generatedPassword,
            'id' => $this->userModel->getUserId(),
            'formData' => $this->formData,
            'sendmail' => $sendMail,
            'successMsg' => FormAlertController::renderSuccess( $successMessage ),
        ]);
    }

    private function _sendResetPasswordMail( string $password )
    {
        require RIEDL_BAMO_HAENDLER_DIR . 'app/Config/config.mails.php';

        $headers = [
            'from' => $mailSet['presse-passwort-vergessen']['mailer']['from'],
            'replyTo' => $mailSet['presse-passwort-vergessen']['mailer']['from'],
        ];

        $mailData = [
            'formData' => $this->formData,
            'email' => $this->userModel->getUserEmail(),
            'userEmail' => $this->userModel->getUserEmail(),
            'userPassword' => $password,
        ];

        $mailer = new MailController();
        $mailer->setTemplate( 'press-password-reset.php' );
        $mailer->setHeaders( $headers );
        $mailer->setSubject( $mailSet['presse-passwort-vergessen']['mailer']['subject'] );
        $mailer->setMailData( $mailData );

        $mailer->send();
    }
}