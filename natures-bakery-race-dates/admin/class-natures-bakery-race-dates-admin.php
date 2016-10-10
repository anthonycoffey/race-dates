<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.coffeywebdev.com
 * @since      1.0.0
 *
 * @package    Natures_Bakery_Race_Dates
 * @subpackage Natures_Bakery_Race_Dates/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Natures_Bakery_Race_Dates
 * @subpackage Natures_Bakery_Race_Dates/admin
 * @author     Anthony Coffey <coffey.j.anthony@gmail.com>
 */
class Natures_Bakery_Race_Dates_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/natures-bakery-race-dates-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/natures-bakery-race-dates-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function register_menu_page(){

		add_submenu_page( 'options-general.php', 'NB Race Dates', 'NB Race Dates', 'activate_plugins', 'natures-bakery-race-dates', array( $this, 'submenu_page' ) );

	}

/*	public function register_settings(){
		register_setting('racedate_options', 'racedate_options');
	}*/

	/*
	 * Callback for add_submenu_page for generating markup of page
	 */
	public function submenu_page() {
		?>
		<div class="wrap">
			<h2>Race Dates Import</h2>
			<div id="notice">
				<p>Please note: You must use military time in your CSV when importing races!</p>
				<p>Please see the example CSV file below for proper formatting.</p>
				<p>	Example import file: <a href="<?php echo plugin_dir_url( __FILE__ ) . 'includes/example_race_dates.csv'; ?>">Example CSV</a></p>
			</div>

			<table id="import-races">
				<form method="POST"  enctype="multipart/form-data">
					<tr><td colspan="2"><h3>Select a CSV...</h3></td></tr>
					<tr>
						<td width="50%">Delete previously imported race data?</td>
						<td width="50%"><label for="delete-records"><input type="checkbox" id="delete-records" name="delete-records" value="delete"> Yes</label></td>
					<tr>
						<td width="20%">Select file</td>
						<td width="80%"><input type="file" name="file" id="file" /></td>
					</tr>
					<tr>
						<td>Submit</td>
						<td><input type="submit" name="submit" /></td>
					</tr>
				</form>
			</table>
		</div>
		<?php


		if ( isset($_POST["submit"]) ) {

		   if ( isset($_FILES["file"])) {

		            //if there was an error uploading the file
		        if ($_FILES["file"]["error"] > 0) {
		            echo "There was an error, please try again. Make sure you've selected a file!";

		        }
		        else {

							global $wpdb;
							$wpdb->show_errors();

							$table_name = $wpdb->prefix . "race_dates";

							if($_POST['delete-records']=="delete"){ // if user select to delete all, then clear existing records
								$delete = $wpdb->query("TRUNCATE TABLE ".$table_name);
								if($delete==1){
									echo "<p>Table cleared!</p>";
								}
							}

								$csvAsArray = array_map('str_getcsv', file($_FILES["file"]["tmp_name"]));
								$values = '';
								for($i=0; $i < count($csvAsArray); $i++) {
									if($i<>0){ // skip the first row, that's just the column headers
										if ( $i == (count($csvAsArray)-1) ) { // do not include a comma at the end of the last set of values
											$values .= "('".addslashes($csvAsArray[$i][0])."','".addslashes($csvAsArray[$i][1])."','".addslashes($csvAsArray[$i][2])."','{$csvAsArray[$i][3]}','{$csvAsArray[$i][4]}')";
										} else { // create row with values
											$values .= "('".addslashes($csvAsArray[$i][0])."','".addslashes($csvAsArray[$i][1])."','".addslashes($csvAsArray[$i][2])."','{$csvAsArray[$i][3]}','{$csvAsArray[$i][4]}'),";
										}
									}
								}

								// build SQL query
								$sql = "INSERT INTO ".$table_name." (`race_title`, `race_location`, `tv_channel`, `race_time`, `race_date`) VALUES ";
								$sql .= $values;

								$insert = $wpdb->query($sql);

								echo "<p>Rows inserted: " . $insert . "</p>";

								$this->display_race_table();
		        }
		     } else {
		             echo "No file selected <br />";
		     }
		} // end if submit

			$this->display_race_table();
	}

	public function display_race_table(){
		global $wpdb;
		$wpdb->show_errors();
		$table_name = $wpdb->prefix . "race_dates";
		// get current table data and print to screen for better UX
		$get_races = $wpdb->get_results("SELECT * FROM ".$table_name);
		echo "<h3>Races</h3>";
		echo "<table id='race-table'><tbody>";
		echo "<tr>";
		echo "<th width='1%'>ID</th><th width='25%'>Race Title</th><th width='25%'>Race Location</th><th width='20%'>TV Channel</th><th width='20%'>Time</th><th width='20%'>Date</th>";
		echo "</tr>";
		foreach ($get_races as $race) {
			$date = date_create($race->race_date);
			$time = date_create($race->race_time);
			$date = date_format($date,"m-d-Y");
			$time = date_format($time,"h:i A");
			echo "<tr>";
				echo "<td>" . $race->primary_id . "</td>";
				echo "<td>" . $race->race_title . "</td>";
				echo "<td>" . $race->race_location . "</td>";
				echo "<td>" . $race->tv_channel . "</td>";
				echo "<td>" . $date . "</td>";
				echo "<td>" . $time . "</td>";
			echo "</tr>";
		}
		echo "</tbody></table>";
	}

}
