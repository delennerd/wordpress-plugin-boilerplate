<?php
/**
 * @since      0.1.0
 * @package    PluginName
 * @subpackage Classes
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Services;

use PluginName\Controllers\HttpRequestController;
use PluginName\Helpers\ConstantsHelper;
use PluginName\Helpers\Helper;
use PluginName\Helpers\LanguageHelper;

class SiteService
{
    public const PAGE_ONEPAGE = 'onepage';

    function __construct() 
    {
        add_filter( 'wpseo_title', [$this, 'setPageSeoTitle'] );
        add_filter( 'wpseo_opengraph_title', [$this, 'setPageSeoTitle'] );
        add_filter( 'the_title', [ $this, 'setPageTitle' ], 10, 2 );
        add_filter( 'nav_menu_item_title', [ $this, 'restoreDefaultTitleForNavigation' ], 10, 4 );

        add_filter( 'wpseo_opengraph_url', [ $this, 'changeUrl' ] );
    }

    public function setPageSeoTitle( $title )
    {
        $pageTitle = $this->_getSiteTitle( $title );

        return Helper::getNewSiteTitle( $pageTitle );
        // return $pageTitle;
    }

    public function setPageTitle( $title, $post_id = null )
    {
        global $wp_query;

        if ( is_admin() || is_null( $post_id ) ) return $title;

        $post_type = get_post_type( $post_id );
        $post = get_post( $post_id );

        if ( $wp_query->is_main_query() && ('page' === $post_type || 'post' === $post_type) && $post instanceof \WP_Post && ( $post->post_type === 'page' ) ) {

            $title = $this->_getSiteTitle( $title );
        }

        return $title;
    }

    public function restoreDefaultTitleForNavigation( $title, $item, $args, $depth ) 
    {
        // Remove filter to not affect title
        remove_filter( 'the_title', [ $this, 'setPageTitle' ], 10, 2 );

        $post_id = $item->object_id;
        $title   = get_the_title( $post_id );

        // Add the title filter back
        add_filter( 'the_title', [ $this, 'setPageTitle' ], 10, 2 );

        return $title;
    }

    private function _getSiteTitle( $title ): string
    {
        global $wp;

        // if ( HttpRequestController::isUserPage( self::PAGE_DOWNLOADCENTER ) ) {
        //     $title = __( 'Der Seitentitel', 'plugin-name' );
        // }

        if ( site_url( $wp->request . '/' ) === tml_get_action_url( 'lostpassword' ) ) {
            $title = __( 'Passwort vergessen?', 'plugin-name');
        }

        return $title;
    }

    public static function getDashboardUrl( $subPage = '' )
    {
        $dashboardPageId = LanguageHelper::getTranslatedElementId( ConstantsHelper::DASHBOARD_PAGE_ID );
        $subPage = $subPage ? $subPage : '';

        // if ( ! is_page( $dashboardPageId ) ) {
        //     return home_url( $subPage );
        // }

        return get_permalink( $dashboardPageId ) . $subPage;
    }

    public function changeUrl( $url )
    {
        global $wp;

        $dashboardPageId = LanguageHelper::getTranslatedElementId( ConstantsHelper::DASHBOARD_PAGE_ID );

        if ( is_page( $dashboardPageId ) ) {
            $url = home_url( $wp->request );
        }

        return $url;
    }
}