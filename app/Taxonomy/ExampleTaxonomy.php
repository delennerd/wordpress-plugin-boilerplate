<?php
/**
 * @since      1.0.0
 * @package    PluginName
 * @subpackage Taxonomy
 * @author     delennerd.media <mail@delennerd.de>
 */

namespace PluginName\Taxonomy;

if (!defined('ABSPATH' )) exit; // Exit if accessed directly

class ExampleTaxonomy
{
    function __construct()
    {
        add_action( 'init', function() {

            register_taxonomy( 'example_category', ['example'], [
                'public' => true,
                'hierarchical' => true,
                'rewrite' => [
                    'slug' => _x( 'stellenangebote', 'URL slug' ),
                    'with_front' => false,
                ],
                'labels' => [
                    'name' => __( 'Kategorie' ),
                    'singular_name' => __( 'Kategorie' ),
                    'menu_name' => __( 'Kategorien' ),
                    'all_items' => __( 'Alle Kategorien' ),
                    'edit_item' => __( 'Kategorie bearbeiten' ),
                    'view_item' => __( 'Kategorie ansehen' ),
                    'add_new_item' => __( 'Neue Kategorie erstellen' ),
                    'search_items' => __( 'Kategorien suchen' ),
                ],
            ]);
        });
    }
}