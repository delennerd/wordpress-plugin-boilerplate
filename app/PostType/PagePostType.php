<?php
/**
 * A example class
 *
 * @since      1.0.0
 * @package    PluginName
 * @subpackage PostType
 * @author     delennerd.media <mail@delennerd.de>
 */

namespace PluginName\PostType;

if (!defined('ABSPATH' )) exit; // Exit if accessed directly

class PagePostType
{
    public function __construct()
    {
        add_action('init', function () {
            // remove_post_type_support('page', 'thumbnail');
        });
    }
}