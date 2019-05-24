<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://jerl92.tk
 * @since      1.0.0
 *
 * @package    Fullcalendar
 * @subpackage Fullcalendar/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Fullcalendar
 * @subpackage Fullcalendar/public
 * @author     Jérémie Langevin <jeremie.langevin@outlook.com>
 */
class Fullcalendar_Public {

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
		 * defined in Fullcalendar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fullcalendar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/fullcalendar-public.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'fullcalendar-core', plugin_dir_url( __FILE__ ) . 'css/fullcalendar.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'daygrid', plugin_dir_url( __FILE__ ) . 'css/daygrid.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'timegrid', plugin_dir_url( __FILE__ ) . 'css/timegrid.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'list', plugin_dir_url( __FILE__ ) . 'css/list.css', array(), $this->version, 'all' );

		wp_enqueue_style( 'datepicker', plugin_dir_url( __FILE__ ) . 'css/datepicker.css', array(), $this->version, 'all' );

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
		 * defined in Fullcalendar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Fullcalendar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_script( 'fullcalendar-locales-all', plugin_dir_url( __FILE__ ) . 'js/core/locales-all.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( 'fullcalendar-core', plugin_dir_url( __FILE__ ) . 'js/core/main.js', array( 'jquery' ), $this->version, false );	

		wp_enqueue_script( 'daygrid', plugin_dir_url( __FILE__ ) . 'js/daygrid/main.js', array( 'jquery' ), $this->version, false );
		
		wp_enqueue_script( 'interaction', plugin_dir_url( __FILE__ ) . 'js/interaction/main.js', array( 'jquery' ), $this->version, false );

		// wp_enqueue_script( 'rrule', plugin_dir_url( __FILE__ ) . 'js/rrule/main.js', array( 'jquery' ), $this->version, false );	

		wp_enqueue_script( 'list', plugin_dir_url( __FILE__ ) . 'js/list/main.js', array( 'jquery' ), $this->version, false );	

		wp_enqueue_script( 'timegrid', plugin_dir_url( __FILE__ ) . 'js/timegrid/main.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( 'datepicker', plugin_dir_url( __FILE__ ) . 'js/datepicker.js', array( 'jquery' ), $this->version, false );
		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/fullcalendar-public.js', array( 'jquery' ), $this->version, false );

	}

}
