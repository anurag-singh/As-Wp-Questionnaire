<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://wordpress.org
 * @since      1.0.0
 *
 * @package    As_Wp_Questionnaire
 * @subpackage As_Wp_Questionnaire/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    As_Wp_Questionnaire
 * @subpackage As_Wp_Questionnaire/includes
 * @author     Anurag Singh <email@gmail.com>
 */
class As_Wp_Questionnaire_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'as-wp-questionnaire',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
