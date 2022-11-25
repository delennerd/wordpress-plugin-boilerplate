<?php
/**
 * @since      0.1.0
 * @package    PluginName
 * @subpackage Helpers
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Models;

use PluginName\Helpers\CarbonFieldsHelper;
use PluginName\Lib\Classes\Haendler\Haendler;
use PluginName\Lib\Classes\Presse\User;

class UserModel
{
    private static $instance = null;
    private $user = null;

    private function __construct()
    {
        if ( \is_user_logged_in() ) {
            $this->user = \wp_get_current_user();
        }
    }

    public static function getInstance()
    {
        if ( self::$instance === null ) {
            self::$instance = new UserModel();
        }

        return self::$instance;
    }

    public function getUserById( int $userId )
    {
        return get_user_by( 'ID', $userId );
    }

    public function getUserByEmail( string $email )
    {
        return get_user_by( 'email', $email );
    }

    public function setUser( $user = null )
    {
        $this->user = $user;
    }

    public function getUserData()
    {
        return $this->user;
    }

    public function getUserId(): int
    {
        return $this->user->data->ID ?? 0;
    }

    public function getUserName(): string
    {
        return $this->user->data->user_login ?? "";
        // return $this->user->data->user_email ?? "";
    }

    public function getUserEmail(): string
    {
        return $this->user->data->user_email ?? "";
    }

    public function getPassword(): string
    {
        return $this->user->data->user_pass ?? "";
    }

    public function getUserRoles(): array
    {
        return $this->user->roles ?? array();
    }

    public function getUserCaps(): array
    {
        return $this->user->allcaps ?? array();
    }

    public function isBackendUser(): bool
    {
        $haystack = array(
            'administrator',
            'editor',
            'author',
            'subscriber',
        );

        return count(array_intersect( $haystack, $this->getUserRoles() )) > 0;
    }

    public function userIsHaendler(): bool
    {
        return in_array( 'haendler', $this->getUserRoles() );
    }

    public function userIsPresse(): bool
    {
        return in_array( 'press', $this->getUserRoles() );
    }

    public function saveNewPassword( string $plainPassword ): void
    {
        wp_set_password( $plainPassword, $this->getUserId() );
    }

    public function setUserField( $field, $value ): void
    {
        carbon_set_user_meta( $this->getUserId(), CarbonFieldsHelper::getFieldName( $field ), $value );
    }

    public function getUserField( $field ): string
    {
        $returnField = carbon_get_user_meta( $this->getUserId(), CarbonFieldsHelper::getFieldName( $field ) );
        return $returnField ?? "";
    }

    public function convertPasswordToHaendlerDbHashed( string $plainPassword ): string
    {
        return password_hash(
            $plainPassword,
            \PASSWORD_DEFAULT,
            ["cost" => \PASSWORD_COST]
        );
    }

    public function checkOldPassword( string $plainPassword ): bool
    {
        $oldPasswordHashed = password_hash(
            $plainPassword,
            \PASSWORD_DEFAULT,
            ["cost" => \PASSWORD_COST]
        );

        if ( $oldPasswordHashed !== $this->getPassword() ) {
            return false;
        }
        
        return true;
    }

    public function generatePassword()
    {
        return \wp_generate_password( 12, false );
    }
}