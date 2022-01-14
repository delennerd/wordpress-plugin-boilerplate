<?php
/**
 * A example class
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/App/PostType
 * @author     delennerd.media <mail@delennerd.de>
 */
if (!defined('ABSPATH')) exit; // Exit if accessed directly

add_action('init', function () {
    // remove_post_type_support('page', 'thumbnail');
});