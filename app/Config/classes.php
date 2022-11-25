<?php
/**
 * @since      0.1.0
 * @package    Riedl_Catalog
 * @subpackage PluginName/Bootstrap
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

$packageClasses = [
    // Helpers
    PluginName\Helpers\Helper::class,
    // Services
    PluginName\Services\InitFrontendBackend::class,
    PluginName\Services\AddPageTemplateToDropdown::class,
    PluginName\Services\SiteService::class,

    // Controllers

    // Post Types
    PluginName\PostType\ExamplePostType::class,
    PluginName\PostType\PagePostType::class,

    // Taxonomies
    PluginName\Taxonomy\ExampleTaxonomy::class,

    // Metaboxes
    PluginName\Metabox\UserMetabox::class,
];