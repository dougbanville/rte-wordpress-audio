<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://radio.rte.ie
 * @since      1.0.0
 *
 * @package    Rte_Radio_Clip
 * @subpackage Rte_Radio_Clip/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Rte_Radio_Clip
 * @subpackage Rte_Radio_Clip/includes
 * @author     Doug Banville <doug.banville@gmail.com>
 */
class Rte_Radio_Clip_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'rte-radio-clip',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
