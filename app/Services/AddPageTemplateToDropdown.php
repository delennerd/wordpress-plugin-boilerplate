<?php
/**
 * @since      0.1.0
 * @package    PluginName
 * @subpackage Services
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Services;

use PluginName\Controllers\HttpRequestController;

class AddPageTemplateToDropdown
{
    function __construct() 
    {
        add_filter( 'theme_page_templates', [ $this, 'addPageTemplateToDropdown' ] );
        add_filter( 'template_include', [ $this, 'changePageTemplate' ], 99 );
    }

    /**
    * Add page templates.
    *
    * @param  array  $templates  The list of page templates
    *
    * @return array  $templates  The modified list of page templates
    */
    function addPageTemplateToDropdown( $templates )
    {
        $templates[ PLUGIN_NAME_TEMPLATES_DIR . 'dashboard.php'] = __( 'Dashboard Template', 'plugin-name' );

        return $templates;
    }

    /**
     * Change the page template to the selected template on the dropdown
     * 
     * @param $template
     *
     * @return mixed
     */
    function changePageTemplate( $template )
    {
        if (is_page()) {
            $meta = get_post_meta(get_the_ID());

            if ( !empty($meta['_wp_page_template'][0]) && $meta['_wp_page_template'][0] != $template && 'default' !== $meta['_wp_page_template'][0] ) {

                if ( false !== strpos( $meta['_wp_page_template'][0], 'plugin-name' ) ) {
                    $template = $meta['_wp_page_template'][0];
                }
            }
        }

        // if ( 'template-login.php' === $template ) {
        //     return get_stylesheet_directory() . '/'. $template;
        // }

        return $template;
    }
}