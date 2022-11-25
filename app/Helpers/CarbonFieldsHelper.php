<?php
/**
 * @since      0.1.0
 * @package    PluginName
 * @subpackage Services
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Helpers;

use PluginName\Helpers\LanguageHelper;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class CarbonFieldsHelper
{
    private static $instance = null;

    private function __construct()
    {}

    public static function getInstance()
    {
        if ( self::$instance === null ) {
            self::$instance = new CarbonFieldsHelper();
        }

        return self::$instance;
    }

    static function getI18nSuffix(): string
    {
        $suffix = '';
        // if ( ! defined( 'ICL_LANGUAGE_CODE' ) ) {
        //     return $suffix;
        // }

        $languageCode = LanguageHelper::getLanguage();

        if ( ! $languageCode ) {
            return $suffix;
        }

        $suffix = '_' . $languageCode;
        return $suffix;
    }

    static function getFieldName( string $fieldName, bool $withLanguageCodeSuffix = false ) : string
    {
        $_fieldName = PLUGIN_NAME_PREFIX . $fieldName;
        $_fieldName .= $withLanguageCodeSuffix ? self::getI18nSuffix() : '';
        return $_fieldName;
    }

    static function setFieldName( string $fieldName, bool $withLanguageCodeSuffix = false ) : string
    {
        return self::getFieldName( $fieldName, $withLanguageCodeSuffix );
    }

    static function getPostMeta( string $fieldName, int $postId = null, bool $withLanguageCodeSuffix = false )
    {
        global $post;

        $_fieldName = self::getFieldName( $fieldName, $withLanguageCodeSuffix );

        if ( null === $postId || 0 === $postId ) {
            $postId = !empty($post) || null !== $post ? $post->ID : get_the_ID();
        }

        return carbon_get_post_meta( $postId, $_fieldName );
    }
}