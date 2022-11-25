<?php
/**
 * @since      0.1.0
 * @package    PluginName
 * @subpackage Controllers
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Controllers\Auth;

use PluginName\Models\UserModel;

if ( !defined('ABSPATH') ) exit; // Exit if accessed directly

class AuthController
{
    private $loginCredentials = null;

    function __construct()
    {
        add_filter( 'authenticate', [ $this, 'modifyAuthentication' ], 5, 3 );
        // add_filter( 'check_password', [ $this, 'modifyCheckPassword' ], 10, 4 );
    }

    public function modifyAuthentication( $user, $username, $password )
    {
        // if ( null == $user ) {
        //     $user = new \WP_Error( 'authentication_failed', __( '<strong>ERROR</strong>: Invalid username, email address or incorrect password.' ) );
        // }

        // External authentication should only works on the frontend login forms
        if ( ! ($this->_formTypeIsHaendler() || $this->_formTypeIsPresse()) ) {
            return $user;
        }

        // For the frontend login form we doesn't need WP user authentication
        remove_action( 'authenticate', 'wp_authenticate_username_password', 20 );
        remove_action( 'authenticate', 'wp_authenticate_email_password', 20 );

        $username = sanitize_text_field( $username );
        $password = sanitize_text_field( $password );

        if (empty($username) || empty($password) ) {
            return new \WP_Error( 'authentication_failed', __( 'Bitte geben Sie Ihren Benutzernamen und Ihr Passwort ein!', 'bademoden-haendler' ) );
        }

        $externalAuth = false;
        $userByEmailWPDB = false;
        $error = false;

        if ( $this->_formTypeIsHaendler() ) {
            // Check user credentials in external database
            $haendler = new Haendler();
            $externalAuth = $haendler->login( $username, $password );
            $error = ! $externalAuth;

            $user = get_user_by( 'login', $username );
        }

        if ( $this->_formTypeIsPresse() ) {

            // Check if user exists in WP DB
            $userByEmailWPDB = get_user_by( 'email', $username );

            if ( $userByEmailWPDB ) {
                if ( wp_check_password( $password, $userByEmailWPDB->user_pass, $userByEmailWPDB->ID ) ) {
                    $user = $userByEmailWPDB;
                }
                else {
                    $error = true;
                }

                // error_log( json_encode([
                //     'error' => $error,
                //     'user' => $userByEmailWPDB,
                // ] ) );
            }
            else {
                // User is not in the WP database
                // Check the external mysql database
                $pressUser = new User();
                $externalAuth = $pressUser->login( $username, $password );
                $error = ! $externalAuth;
            }


            // error_log(json_encode([
            //     'external Auth' => $externalAuth,
            //     'error' => $error,
            //     'user WP' => $userWPDB,
            //     'user' => $user,
            // ]));


            // If not -> check data in external db

            // $pressUser = new User();
            // $externalAuth = $pressUser->login( $username, $password );

            // if ( ! $externalAuth ) {
            //     $user = get_user_by( 'email', $username );

            //     // error_log( json_encode( $user ) );

            //     // error_log( json_encode( $user && wp_check_password( $password, $user->user_pass, $user->ID ) ) );

            //     if ( $user && wp_check_password( $password, $user->user_pass, $user->ID ) ) {
            //         $externalAuth = true;
            //     }
            //     else {
            //         $externalAuth = false;
            //     }
            // }
        }

        // error_log( json_encode( $externalAuth ) );

        // internal
            // error when user not exists
            // error when password is wrong
        // external
            // externalAuth is false, error is true 
                // => user not exists
                // wrong credentials


        if ( $error && ( ! $user || ! $externalAuth ) ) {
            return new \WP_Error( 'authentication_failed', __( '<strong>FEHLER</strong>: Benutzername oder Passwort ist falsch. <br />Bitte überprüfen Sie Ihre Eingaben.', 'bademoden-haendler' ) );
        }

        if ( ! $user || $user === null ) {
            $this->loginCredentials['username'] = $username;
            $this->loginCredentials['password'] = $password;
        }

        if ( $this->_formTypeIsHaendler() ) {
            if ( $user ) {
                $this->_updateHaendlerUserDataInWP( $externalAuth, $user, $password );
            }
            else {
                $userId = $this->_createUserByFormType( $externalAuth );

                // Load new user info
                $user = new \WP_User( $userId );
            }
        }

        // error_log( json_encode( [
        //     'form type haendler' =>  $this->_formTypeIsHaendler(),
        //     '$user' => $user,
        //     '$externalAuth' => $externalAuth,
        // ] ) );

        if ( $this->_formTypeIsPresse() ) {
            if ( $externalAuth && ! $userByEmailWPDB ) {
                $userId = $this->_createUserByFormType( $externalAuth );

                // Load new user info
                $user = new \WP_User( $userId );
            }
        }

        // error_log( json_encode( [
        //     'form type presse' =>  $this->_formTypeIsPresse(),
        //     '$externalAuth && ! $userByEmailWPDB' => $externalAuth && ! $userByEmailWPDB,
        //     "externalAuth" => $externalAuth,
        // ] ) );

        // $user = $this->_createNewUpdateExistUser( $externalAuth, $username, $password );

        // error_log( print_r([
        //     'form is haendler' => $this->_formTypeIsHaendler(),
        //     'form is presse' =>  $this->_formTypeIsPresse(),
        //     'externalAuth' =>  json_encode($externalAuth),
        //     '$user' => json_encode($user),
        // ], true) );

        return $user;
    }

    // private function _createNewUpdateExistUser( $externalAuth, $username, $password )
    // {
    //     // Check if user exists in WP
    //     // Otherwise return it

    //     if ( $this->_formTypeIsPresse() ) {
    //         $user = get_user_by( 'email', $username );
    //     } 
    //     else {
    //         $user = get_user_by( 'login', $username );
    //     }

    //     if ( $user && $this->_formTypeIsHaendler() ) {
    //         $this->_updateHaendlerUserDataInWP( $externalAuth, $user, $password );
    //     }

    //     // The user does not currently exist in the WordPress user table.
    //     if ( ! $user || $user === null ) {
    //         $userId = $this->_createUserByFormType( $externalAuth );

    //         // Load new user info
    //         $user = new \WP_User( $userId );
    //     }

    //     return $user;
    // }

    private function _createUserByFormType( $externalAuth )
    {
        if ( ! is_array($this->loginCredentials) || !isset($this->loginCredentials['username']) || !isset($this->loginCredentials['password']) ) return 0;

        $formType = $this->_getFormType();

        $userId = $this->_createNewUser( $this->loginCredentials['username'], $this->loginCredentials['password'], $formType, $externalAuth );

       return $userId;
    }

    private function _createNewUser( $username, $password, $role = 'subscriber', $userData = null )
    {
        $newUserData = array(
            'user_login' => $username,
            'user_pass' => $password,
            'role' => $role,
        );

        $newUserData['user_email'] = '';

        if ( $role === 'haendler' ) {
            $newUserData['user_email'] = $userData->b2b_email ?? $userData->asp_email ?? "{$username}@example.org";
        }

        if ( $role === 'presse' ) {
            $newUserData['user_email'] = $username ?? "{$username}@example.org";
            // $newUserData['user_email'] = "{$username}@example.org";
            $newUserData['role'] = 'press';
        }


        $userId = wp_insert_user( $newUserData );

        return $userId;
    }

    private function _updateHaendlerUserDataInWP( $externalUserData, $user, $password )
    {
        $userModel = UserModel::getInstance();
        $userModel->setUser( $user );

        $userModel->saveNewPassword( $password );

        $newUserEmail = $externalUserData->b2b_mail ?? $externalUserData->asp_mail ?? "{$userModel->getUserName()}@example.org";

        update_user_meta( $userModel->getUserId() , 'user_email', esc_attr( $newUserEmail ) );
    }

    private function _loginUser( $username, $password )
    {
        $creds = array(
            'user_login' => $username,
            'user_password' => $password,
            'remember' => false
        );

        return wp_signon( $creds, false );
    }

    // public function modifyCheckPassword( $check, $password, $hash, $user_id ) : bool
    // {
    //     $user = get_user_by( 'ID', $user_id );

    //     if ( ! $user ) return false;

    //     $userModel = UserModel::getInstance();
    //     $userModel->setUser( $user );

    //     if ( ! $this->_checkFormType( $userModel ) ) {
    //         return false;
    //     }

    //     $check = $this->checkUserHasOldSystemPasswordChanged( $userModel, $password );

    //     if ( $check ) {
    //         $userModel->saveNewPassword( $password );
        
    //         $userModel->setHasOldSystemPasswordChanged();
    //     }

    //     // $save = update_user_meta( $user_id, '_riedl_bamo_haendler_old_system_password_changed', true );

    //     // error_log( print_r([
    //     //     'POST request' => json_encode($_POST),
    //     //     'password_changed' => json_encode($userModel->getHasOldSystemPasswordChanged()),
    //     // //     'check' => json_encode($check),
    //     // //     'password' => $password,
    //     // //     'hash' => $hash,
    //     // //     'user_id' => $user_id,
    //     // //     'user' => $user,
    //     // //     'userModel' => $userModel,
    //     // ], true) );

    //     return $check;
    // }

    private function _getFormType(): string
    {
        return isset($_POST['form_name']) && !empty($_POST['form_name']) ? sanitize_text_field( $_POST['form_name'] ) : '';
    }

    private function _formTypeIsHaendler()
    {
        return $this->_getFormType() === 'haendler';
    }

    private function _formTypeIsPresse()
    {
        return $this->_getFormType() === 'presse';
    }

    // private function _checkFormType( $userModel ) : bool
    // {
    //     $formType = isset($_POST['form_name']) && !empty($_POST['form_name']) ? sanitize_text_field( $_POST['form_name'] ) : '';

    //     if ( 'haendler' === $formType && ($userModel->userIsPresse() || $userModel->isBackendUser() ) ) {
    //         return false;
    //     }

    //     if ( 'presse' === $formType && ($userModel->userIsHaendler() || $userModel->isBackendUser()) ) {
    //         return false;
    //     }

    //     if ( "" === $formType && ( $userModel->userIsPresse() || $userModel->userIsHaendler() ) ) {
    //         return false;
    //     }

    //     return true;
    // }

    // private function checkUserHasOldSystemPasswordChanged( $userModel, $password ) : bool
    // {
    //     // User Param for check if password changed from old system
    //     // $userHasChangedOldSystemPassword = $userModel->getHasOldSystemPasswordChanged();
    //     $userHasChangedOldSystemPassword = true;

    //     // Skip old password check when user has logged in first time
    //     if ( $userHasChangedOldSystemPassword ) {
    //         return true;
    //     }

    //     // Skip 
    //     if ( false === ( $userModel->userIsPresse() || $userModel->userIsHaendler() ) ) {
    //         return true;
    //     }

    //     $checkOldPassword = $userModel->checkOldPassword( $password );

    //     if ( ! $checkOldPassword ) {
    //         return false;
    //     }

    //     return true;
    // }
}