<?php 
/**
 * @since      0.1.0
 * @package    PluginName
 * @subpackage Bootstrap
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use PluginName\Bootstrap\Route;

Route::addRoute( esc_attr_x( 'catalog', 'Catalog slug', 'riedl-product-catalog' ), [
    'riedl_page' => 'riedl_catalog',
] );

Route::addRoute( esc_attr_x( 'catalog', 'Catalog slug', 'riedl-product-catalog' ) . '/([0-9-]+)', [
    'riedl_page' => 'riedl_catalog_detail',
    'product_id' => '$matches[1]',
] );

// Route::add_template( function() {

//     if ( 'riedl_catalog' === get_query_var( 'riedl_page' ) ) {

//         add_filter( 'template_include', function() {
//             return RBC_DIR . '/templates/archive-catalog-list.php';
//         } );
//     }
// } );

// Route::add_template( function() {

//     if ( 'riedl_catalog_detail' === get_query_var( 'riedl_page' ) && get_query_var( 'product_id' ) ) {

//         add_filter( 'template_include', function() {

//             return RBC_DIR . '/templates/product-single.php';
//         } );
//     }
// } );


// add_action( 'rest_api_init', function () {
//     $controller = new PluginName\Api\ProductApiController();
//     $controller->register_routes();
// } );