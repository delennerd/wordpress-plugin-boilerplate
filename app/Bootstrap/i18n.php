<?php
/**
 * Define the internationalization functionality.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/App/Bootstrap
 * @author     delennerd.media <mail@delennerd.de>
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class PN_I18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'plugin-name',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
