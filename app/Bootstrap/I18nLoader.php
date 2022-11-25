<?php
/**
 * Define the internationalization functionality.
 *
 * @since      0.0.1
 * @package    PluginName
 * @subpackage Bootstrap
 * @author     Pascal Lehnert <mail@delennerd.de>
 */

namespace PluginName\Bootstrap;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class I18nLoader {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.1.0
	 */
	public static function load_plugin_textdomain() {

		load_plugin_textdomain(
			'plugin-name',
			false,
			dirname( PLUGIN_NAME_BASENAME ) . '/languages/'
		);
	}
}
