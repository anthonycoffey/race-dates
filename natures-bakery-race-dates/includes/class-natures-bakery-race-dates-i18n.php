<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.coffeywebdev.com
 * @since      1.0.0
 *
 * @package    Natures_Bakery_Race_Dates
 * @subpackage Natures_Bakery_Race_Dates/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Natures_Bakery_Race_Dates
 * @subpackage Natures_Bakery_Race_Dates/includes
 * @author     Anthony Coffey <coffey.j.anthony@gmail.com>
 */
class Natures_Bakery_Race_Dates_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'natures-bakery-race-dates',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
