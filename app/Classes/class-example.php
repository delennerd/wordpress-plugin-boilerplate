<?php
/**
 * A example class
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/PluginName/Classes
 * @author     delennerd.media <mail@delennerd.de>
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class PN_Example {
    public function __construct()
    {
        add_action( 'save_post_wr_werke', array( $this, 'create_unique_number_as_slug' ), 10, 3 );
    }

    /**
     * Generate a unique string for book slugs with characters and numbers
     */
    public function create_unique_number_as_slug( $post_id, $post, $update )
    {
        // Only in admin area
        if ( ! is_admin() ) return;

        // Only set if a new post
        if ( $update ) return;

        $slug_length = 24;
        $new_slug = PN_Helper::generate_random_string( $slug_length );

        wp_update_post( array(
            'ID' => $post_id,
            'post_name' => $new_slug,
        ) );

        return '';
    }
}