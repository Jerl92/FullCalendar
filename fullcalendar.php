<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://jerl92.tk
 * @since             1.0.0
 * @package           Fullcalendar
 *
 * @wordpress-plugin
 * Plugin Name:       Full Calendar
 * Plugin URI:        https://github.com/Jerl92/fullcalendar
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Jérémie Langevin
 * Author URI:        https://jerl92.tk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fullcalendar
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'FULLCALENDAR_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-fullcalendar-activator.php
 */
function activate_fullcalendar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fullcalendar-activator.php';
	Fullcalendar_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-fullcalendar-deactivator.php
 */
function deactivate_fullcalendar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fullcalendar-deactivator.php';
	Fullcalendar_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_fullcalendar' );
register_deactivation_hook( __FILE__, 'deactivate_fullcalendar' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-fullcalendar.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fullcalendar() {

	$plugin = new Fullcalendar();
	$plugin->run();

}
run_fullcalendar();
