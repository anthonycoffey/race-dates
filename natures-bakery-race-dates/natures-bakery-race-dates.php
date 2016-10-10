<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.coffeywebdev.com
 * @since             1.0.0
 * @package           Natures_Bakery_Race_Dates
 *
 * @wordpress-plugin
 * Plugin Name:       Natures Bakery Race Dates
 * Plugin URI:        http://www.coffeywebdev.com/
 * Description:       This plugin adds a CSV import for upcoming races that are then displayed on a page template.
 * Version:           1.0.0
 * Author:            Anthony Coffey
 * Author URI:        http://www.coffeywebdev.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       natures-bakery-race-dates
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-natures-bakery-race-dates-activator.php
 */
function activate_natures_bakery_race_dates() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-natures-bakery-race-dates-activator.php';
	Natures_Bakery_Race_Dates_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-natures-bakery-race-dates-deactivator.php
 */
function deactivate_natures_bakery_race_dates() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-natures-bakery-race-dates-deactivator.php';
	Natures_Bakery_Race_Dates_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_natures_bakery_race_dates' );
register_deactivation_hook( __FILE__, 'deactivate_natures_bakery_race_dates' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-natures-bakery-race-dates.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_natures_bakery_race_dates() {

	$plugin = new Natures_Bakery_Race_Dates();
	$plugin->run();

}
run_natures_bakery_race_dates();
