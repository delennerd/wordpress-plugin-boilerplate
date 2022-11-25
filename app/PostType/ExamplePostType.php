<?php
/**
 * @since      1.0.0
 * @package    PluginName
 * @subpackage PostType
 * @author     delennerd.media <mail@delennerd.de>
 */

namespace PluginName\PostType;

if (!defined('ABSPATH' )) exit; // Exit if accessed directly

class ExamplePostType
{
    function __construct()
    {
        add_action('init', function () {
            register_post_type( 'example', [
                'label' => __( 'Example', 'plugin-name' ),
                'description' => __( 'Example', 'plugin-name' ),
                'supports' => array( 'title', 'editor', 'page-attributes' ),
                'hierarchical' => false,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_admin_bar' => true,
                'show_in_nav_menus' => true,
                'menu_position' => 5,
                'menu_icon' => 'dashicons-clipboard', // https://developer.wordpress.org/resource/dashicons/
                'can_export' => true,
                'has_archive' => true,
                'exclude_from_search' => false,
                'publicly_queryable' => true,
                'rewrite' => [
                    'slug' => _x('stellenangebot', 'URL slug' ),
                    'with_front' => false,
                    'pages' => true,
                    'feeds' => false,
                ],
                'capability_type' => 'page',
                'labels' => [
                    'name' => _x( 'Example', 'Post Type General Name', 'plugin-name' ),
                    'singular_name' => _x(' Example', 'Post Type Singular Name', 'plugin-name' ),
                    'menu_name' => __( 'Example', 'plugin-name' ),
                    'name_admin_bar' => __( 'Example', 'plugin-name' ),
                    'archives' => __( 'Example Archiv', 'plugin-name' ),
                    'attributes' => __( 'Example Attribute', 'plugin-name' ),
                    'all_items' => __( 'Alle Example', 'plugin-name' ),
                    'add_new_item' => __( 'Neuen Eintrag erstellen', 'plugin-name' ),
                    'add_new' => __( 'Hinzufügen', 'plugin-name' ),
                    'new_item' => __( 'Neuer Eintrag', 'plugin-name' ),
                    'edit_item' => __( 'Eintrag bearbeiten', 'plugin-name' ),
                    'update_item' => __( 'Eintrag aktualisieren', 'plugin-name' ),
                    'view_item' => __( 'Eintrag anzeigen', 'plugin-name' ),
                    'view_items' => __( 'Einträge anzeigen', 'plugin-name' ),
                    'search_items' => __( 'Einträge durchsuchen', 'plugin-name' ),
                    'not_found' => __( 'Es wurden keine Einträge gefunden.', 'plugin-name' ),
                    'not_found_in_trash' => __( 'Es wurden keine Einträge im Papierkorb gefunden.', 'plugin-name' ),
                ],
            ]);
        } );       
    }
}