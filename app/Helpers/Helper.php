<?php
/**
 * @since      0.1.0
 * @package    PluginName
 * @subpackage Services
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Helpers;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Helper {

    public static function getNewSiteTitle( $title ): string
    {
        $siteName = get_bloginfo( 'name' );
        return sprintf( "%s - %s", $title, $siteName );
    }

    public static function getDashboardUrl(): string
    {
        $dashboardPageId = LanguageHelper::getTranslatedElementId( ConstantsHelper::DASHBOARD_PAGE_ID );

        return get_permalink( $dashboardPageId );
    }

    // public static function generate_random_string_by( $characters, $length )
    // {
    //     $charactersLength = strlen($characters);
    //     $randomString = '';
    //     for ($i = 0; $i < $length; $i++) {
    //         $randomString .= $characters[rand(0, $charactersLength - 1)];
    //     }
    //     return $randomString;
    // }

    // public static function generate_random_string( $length = 10 ) 
    // {
    //     $characters = '01234567899876543210abcdef0123456789';
    //     return self::generate_random_string_by( $characters, $length );
    // }

    // public static function generate_random_number( $length = 16 ) 
    // {
    //     $characters = '0123456789';
    //     return self::generate_random_string_by( $characters, $length );
    // }

    // /**
    //  * Generate a unique string for book slugs with characters and numbers
    //  */
    // public function create_unique_number_as_slug( $post_id, $post, $update )
    // {
    //     // Only in admin area
    //     if ( ! is_admin() ) return;

    //     // Only set if a new post
    //     if ( $update ) return;

    //     $slug_length = 24;
    //     $new_slug = PN_Helper::generate_random_string( $slug_length );

    //     wp_update_post( array(
    //         'ID' => $post_id,
    //         'post_name' => $new_slug,
    //     ) );

    //     return '';
    // }
}