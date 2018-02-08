<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wordpress.org
 * @since             1.0.0
 * @package           As_Wp_Questionnaire
 *
 * @wordpress-plugin
 * Plugin Name:       As Wp Questionnaire
 * Plugin URI:        https://wordpress.org
 * Plugin Type: 	  Piklist
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Anurag Singh
 * Author URI:        https://wordpress.org
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       as-wp-questionnaire
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
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * Custom Post Types (CPT) to add.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Add all CPT to register at time of plugin registration.
 */
define( 'QUESTIONNAIRE_CPT_NAMES', serialize(array('Question', 'Answer')) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-as-wp-questionnaire-activator.php
 */
function activate_as_wp_questionnaire() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-as-wp-questionnaire-activator.php';
	As_Wp_Questionnaire_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-as-wp-questionnaire-deactivator.php
 */
function deactivate_as_wp_questionnaire() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-as-wp-questionnaire-deactivator.php';
	As_Wp_Questionnaire_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_as_wp_questionnaire' );
register_deactivation_hook( __FILE__, 'deactivate_as_wp_questionnaire' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-as-wp-questionnaire.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_as_wp_questionnaire() {

	$plugin = new As_Wp_Questionnaire();
	$plugin->run();

}
run_as_wp_questionnaire();
