<?php 
/**
 * @since      0.1.0
 * @package    PluginName
 * @subpackage Bootstrap
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use PluginName\Bootstrap\Route;
use PluginName\Helpers\ConstantsHelper;
use PluginName\Helpers\LanguageHelper;
use PluginName\Models\UserModel;
use PluginName\Services\SiteService;

// Route::addRoute( esc_attr_x( 'catalog', 'Catalog slug', 'riedl-product-catalog' ), [
//     'riedl_page' => 'riedl_catalog',
// ] );

// Route::addRoute( esc_attr_x( 'catalog', 'Catalog slug', 'riedl-product-catalog' ) . '/([0-9-]+)', [
//     'riedl_page' => 'riedl_catalog_detail',
//     'product_id' => '$matches[1]',
// ] );


add_action( 'init', function() {
    add_rewrite_endpoint( SiteService::PAGE_ONEPAGE, \EP_PAGES );
} );

add_action( 'template_redirect', function() {
    // global $wp_query;
    // Todo: To change site title for a page, open file app/Services/SiteService.php

    // Redirection works on login page
    // $loginPageId = LanguageHelper::getTranslatedElementId( ConstantsHelper::LOGIN_PAGE_ID );
    // $dashboardPageId = LanguageHelper::getTranslatedElementId( ConstantsHelper::DASHBOARD_PAGE_ID );


    // if ( is_user_logged_in() && is_admin() && ! wp_doing_ajax() ) {
    //     $user = UserModel::getInstance();
    //     wp_safe_redirect( get_permalink( $dashboardPageId ) );
    // }

    // // Redirect to dashboard if logged in
    // if ( is_page( $loginPageId ) && is_user_logged_in() ) {
    //     wp_safe_redirect( get_permalink( $dashboardPageId ) );
    //     die;
    // }

    // // Redirection works on dashboard page and endpoints of dashboard
    // if ( is_page( $dashboardPageId ) && ! is_user_logged_in() ) {
    //     wp_safe_redirect( get_permalink( $loginPageId ) );
    //     die;
    // }

    // if ( HttpRequestController::isUserPage( SiteService::PAGE_PRESSETEXTE ) ) {
    //     if ( ! current_user_can( 'read_presstexts' ) ) {
    //         wp_redirect( Helper::getDashboardUrl() );
    //         die();
    //     }

    //     include RIEDL_BAMO_HAENDLER_TEMPLATES_DIR . 'presstexts.php';
    //     die;
    // }

    // // Example a redirect
    // if ( HttpRequestController::isUserPage( SiteService::PAGE_ONEPAGE ) ) {
    //     if ( ! current_user_can( 'read_b2b_shop' ) || ! current_user_can( 'read_finance' ) ) {
    //         wp_redirect( Helper::getDashboardUrl() );
    //         die();
    //     }

    //     $b2b = B2bController::getInstance();
    //     $b2b->init();
    //     $b2b->login();
    //     die;
    // }
} );


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