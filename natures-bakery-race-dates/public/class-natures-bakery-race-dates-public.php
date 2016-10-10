<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.coffeywebdev.com
 * @since      1.0.0
 *
 * @package    Natures_Bakery_Race_Dates
 * @subpackage Natures_Bakery_Race_Dates/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Natures_Bakery_Race_Dates
 * @subpackage Natures_Bakery_Race_Dates/public
 * @author     Anthony Coffey <coffey.j.anthony@gmail.com>
 */
class Natures_Bakery_Race_Dates_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Natures_Bakery_Race_Dates_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Natures_Bakery_Race_Dates_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/natures-bakery-race-dates-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Natures_Bakery_Race_Dates_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Natures_Bakery_Race_Dates_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/natures-bakery-race-dates-public.js', array( 'jquery' ), $this->version, false );

	}

	public function add_races_to_page(){
		/*
		*   this function adds the variables to the page so that they can be used within the page template
		*/
		global $wpdb;
		global $next_race;

		// set table name
		$table_name = $wpdb->prefix . "race_dates";

		// select upcoming races
		$sql = "SELECT * FROM {$table_name} WHERE race_date >= CURDATE()";
		$next_race = $wpdb->get_row($sql, ARRAY_A);

		// format date/time for front-end
		$date = date_create($next_race['race_date']);
		$time = date_create($next_race['race_time']);
		$next_race['race_date'] = date_format($date,"m.d.Y");
		$next_race['race_time'] = date_format($time,"h:i A");

	}

}
