<?php
/**
 * @since      0.1.0
 * @package    PluginName
 * @subpackage Helpers
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Helpers;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class LanguageHelper
{
    private static $instance = null;

    private function __construct()
    {}

    public static function getInstance()
    {
        if ( self::$instance === null ) {
            self::$instance = new LanguageHelper();
        }

        return self::$instance;
    }

    static function getLanguage()
    {
        return apply_filters( 'wpml_current_language', null );
    }

    static function getTranslatedElementId( int $originalPageId, string $elementType = 'page' )
    {
        return apply_filters( 'wpml_object_id', $originalPageId, $elementType, true );
    }
}