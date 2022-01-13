<?php
/**
 * Some functions for all Werke
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes/classes
 * @author     delennerd.media <mail@delennerd.de>
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class PN_Werke {
    public function __construct()
    {
        add_action( 'save_post_wr_werke', array( $this, 'create_unique_number_as_book_slug' ), 10, 3 );
        // add_action( '', array( $this, '' ) );
    }

    /**
     * Generate a unique string for book slugs with characters and numbers
     */
    public function create_unique_number_as_book_slug( $post_id, $post, $update )
    {
        // Only in admin area
        if ( ! is_admin() ) return;

        // Only set if a new post
        if ( $update ) return;

        $slug_length = 24;
        $new_slug = WR_Helper::generate_random_string( $slug_length );

        wp_update_post( array(
            'ID' => $post_id,
            'post_name' => $new_slug,
        ) );

        return '';
    }
}