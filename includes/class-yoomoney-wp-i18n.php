<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/L0L1K1510/yoomoney-wp
 * @since      1.0.0
 *
 * @package    Yoomoney-WP
 * @subpackage Yoomoney-WP/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Yoomoney-WP
 * @subpackage Yoomoney-WP/includes
 * @author     Maxim <parkin01@inbox.ru>
 */
class yoomoney_wp_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'yoomoney-wp',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
