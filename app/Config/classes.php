<?php
/**
 * @since      0.1.0
 * @package    Riedl_Catalog
 * @subpackage PluginName/Bootstrap
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Bootstrap;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

$helper_classes = [
    PluginName\Services\Helper::class,
];