<?php
/**
 * A helper class
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/App/Classes
 * @author     delennerd.media <mail@delennerd.de>
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class PN_Helper {

    public static function generate_random_string_by( $characters, $length )
    {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function generate_random_string( $length = 10 ) 
    {
        $characters = '01234567899876543210abcdef0123456789';
        return self::generate_random_string_by( $characters, $length );
    }

    public static function generate_random_number( $length = 16 ) 
    {
        $characters = '0123456789';
        return self::generate_random_string_by( $characters, $length );
    }
}