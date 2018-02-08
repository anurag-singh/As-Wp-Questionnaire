<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wordpress.org
 * @since      1.0.0
 *
 * @package    As_Wp_Questionnaire
 * @subpackage As_Wp_Questionnaire/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    As_Wp_Questionnaire
 * @subpackage As_Wp_Questionnaire/admin
 * @author     Anurag Singh <email@gmail.com>
 */
class As_Wp_Questionnaire_Admin {

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
	 * The Custom Post Types (CPTs) of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $cpt_names    The ID of this plugin.
	 */
	private $cpt_names;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $cpt_names ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->cpt_names = $cpt_names;

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
		 * defined in As_Wp_Questionnaire_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The As_Wp_Questionnaire_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/as-wp-questionnaire-admin.css', array(), $this->version, 'all' );

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
		 * defined in As_Wp_Questionnaire_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The As_Wp_Questionnaire_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/as-wp-questionnaire-admin.js', array( 'jquery' ), $this->version, false );

		// Localize the script with new data
		$ajaxData = array(
	        'url' => admin_url( "admin-ajax.php" ),
	        // 'home_url' => site_url()
	    );
	    wp_localize_script( $this->plugin_name, 'ajax_object', $ajaxData );

	}

	/**
	 * Creates a new Custom Post Type.
	 *
	 * @since    1.0.0
	 */

	public function register_cpt(){


		/**
		 * Create new custom post type
		*/

		$cpt_names = $this->cpt_names;

		$cpt_names = unserialize($cpt_names);

		foreach ($cpt_names as $cpt_name) {
			$singleCpt = ucwords(strtolower(preg_replace('/\s+/', ' ', $cpt_name) ));

			$last_character = substr($singleCpt, -1);

			if ($last_character === 'y') {
				$pluralCpt = substr_replace($singleCpt, 'ies', -1);
			}
			else {
				$pluralCpt = $singleCpt.'s'; 		// add 's' to convert singular name to plural
			}
			$cap_type = 'post';

			$opts['can_export'] = TRUE;
			$opts['capability_type'] = $cap_type;
			$opts['description'] = '';
			$opts['exclude_from_search'] = FALSE;
			$opts['has_archive'] = FALSE;
			$opts['hierarchical'] = FALSE;
			$opts['map_meta_cap'] = TRUE;
			$opts['menu_icon'] = 'dashicons-admin-post';
			$opts['menu_position'] = 25;
			$opts['public'] = TRUE;
			$opts['publicly_querable'] = TRUE;
			$opts['query_var'] = TRUE;
			$opts['register_meta_box_cb'] = '';
			$opts['rewrite'] = FALSE;
			$opts['show_in_admin_bar'] = TRUE; // Define For 'Top Menu' bar
			$opts['show_in_menu'] = TRUE;
			$opts['show_in_nav_menu'] = TRUE;
			$opts['show_ui'] = TRUE;
			$opts['supports'] = array( 'title' );
			$opts['taxonomies'] = array();
			$opts['capabilities']['delete_others_posts'] = "delete_others_{$cap_type}s";
			$opts['capabilities']['delete_post'] = "delete_{$cap_type}";
			$opts['capabilities']['delete_posts'] = "delete_{$cap_type}s";
			$opts['capabilities']['delete_private_posts'] = "delete_private_{$cap_type}s";
			$opts['capabilities']['delete_published_posts'] = "delete_published_{$cap_type}s";
			$opts['capabilities']['edit_others_posts'] = "edit_others_{$cap_type}s";
			$opts['capabilities']['edit_post'] = "edit_{$cap_type}";
			$opts['capabilities']['edit_posts'] = "edit_{$cap_type}s";
			$opts['capabilities']['edit_private_posts'] = "edit_private_{$cap_type}s";
			$opts['capabilities']['edit_published_posts'] = "edit_published_{$cap_type}s";
			$opts['capabilities']['publish_posts'] = "publish_{$cap_type}s";
			$opts['capabilities']['read_post'] = "read_{$cap_type}";
			$opts['capabilities']['read_private_posts'] = "read_private_{$cap_type}s";

			$opts['labels']['add_new'] = __( "Add New {$singleCpt}", $this->i18n );
			$opts['labels']['add_new_item'] = __( "Add New {$singleCpt}", $this->i18n );
			$opts['labels']['all_items'] = __( $pluralCpt, $this->i18n );
			$opts['labels']['edit_item'] = __( "Edit {$singleCpt}" , $this->i18n);
			$opts['labels']['menu_name'] = __( $pluralCpt, $this->i18n );
			$opts['labels']['name'] = __( $pluralCpt, $this->i18n );
			$opts['labels']['name_admin_bar'] = __( $singleCpt, $this->i18n );
			$opts['labels']['new_item'] = __( "New {$singleCpt}", $this->i18n );
			$opts['labels']['not_found'] = __( "No {$pluralCpt} Found", $this->i18n );
			$opts['labels']['not_found_in_trash'] = __( "No {$pluralCpt} Found in Trash", $this->i18n );
			$opts['labels']['parent_item_colon'] = __( "Parent {$pluralCpt} :", $this->i18n );
			$opts['labels']['search_items'] = __( "Search {$pluralCpt}", $this->i18n );
			$opts['labels']['singular_name'] = __( $singleCpt, $this->i18n );
			$opts['labels']['view_item'] = __( "View {$singleCpt}", $this->i18n );
			$opts['rewrite']['ep_mask'] = EP_PERMALINK;
			$opts['rewrite']['feeds'] = FALSE;
			$opts['rewrite']['pages'] = TRUE;
			$opts['rewrite']['slug'] = __( strtolower( $pluralCpt ), $this->i18n );
			$opts['rewrite']['with_front'] = FALSE;

			register_post_type( strtolower( $cpt_name ), $opts );
		}

		/**
		 * Create new custom taxonomy
		*/

		$cpt_name = 'question';
		$sanitized_cpt = sanitize_title($cpt_name);

		$taxonomy_names = array('Question Type');
		foreach ($taxonomy_names as $taxonomy_name) {

			$singleTaxo = ucwords(strtolower(preg_replace('/\s+/', ' ', $taxonomy_name) ));

			$last_character = substr($singleTaxo, -1);

			if ($last_character === 'y') {
			$pluralTaxo = substr_replace($singleTaxo, 'ies', -1);
			}
			else {
			$pluralTaxo = $singleTaxo.'s'; // add 's' to convert singular name to plural
			}

			$tax_slug = strtolower(str_replace(" ", "_", $singleTaxo)); // Sanitize slug

			$opts['hierarchical'] = TRUE;
			//$opts['meta_box_cb'] = '';
			$opts['public'] = TRUE;
			$opts['query_var'] = $tax_slug;
			$opts['show_admin_column'] = TRUE;
			$opts['show_in_nav_menus'] = TRUE;
			$opts['show_tag_cloud'] = TRUE;
			$opts['show_ui'] = TRUE;
			$opts['sort'] = '';
			//$opts['update_count_callback'] = '';

			$opts['capabilities']['assign_terms'] = 'edit_posts';
			$opts['capabilities']['delete_terms'] = 'manage_categories';
			$opts['capabilities']['edit_terms'] = 'manage_categories';
			$opts['capabilities']['manage_terms'] = 'manage_categories';

			$opts['labels']['add_new_item'] = __( "Add New {$singleTaxo}", $this->plugin_name );
			$opts['labels']['add_or_remove_items'] = __( "Add or remove {$pluralTaxo}", $this->plugin_name );
			$opts['labels']['all_items'] = __( $pluralTaxo, $this->plugin_name );
			$opts['labels']['choose_from_most_used'] = __( "Choose from most used {$pluralTaxo}", $this->plugin_name );
			$opts['labels']['edit_item'] = __( "Edit {$singleTaxo}" , $this->plugin_name);
			$opts['labels']['menu_name'] = __( $pluralTaxo, $this->plugin_name );
			$opts['labels']['name'] = __( $pluralTaxo, $this->plugin_name );
			$opts['labels']['new_item_name'] = __( "New {$singleTaxo} Name", $this->plugin_name );
			$opts['labels']['not_found'] = __( "No {$pluralTaxo} Found", $this->plugin_name );
			$opts['labels']['parent_item'] = __( "Parent {$singleTaxo}", $this->plugin_name );
			$opts['labels']['parent_item_colon'] = __( "Parent {$singleTaxo}:", $this->plugin_name );
			$opts['labels']['popular_items'] = __( "Popular {$pluralTaxo}", $this->plugin_name );
			$opts['labels']['search_items'] = __( "Search {$pluralTaxo}", $this->plugin_name );
			$opts['labels']['separate_items_with_commas'] = __( "Separate {$pluralTaxo} with commas", $this->plugin_name );
			$opts['labels']['singular_name'] = __( $singleTaxo, $this->plugin_name );
			$opts['labels']['update_item'] = __( "Update {$singleTaxo}", $this->plugin_name );
			$opts['labels']['view_item'] = __( "View {$singleTaxo}", $this->plugin_name );

			$opts['rewrite']['ep_mask'] = EP_NONE;
			$opts['rewrite']['hierarchical'] = FALSE;
			$opts['rewrite']['slug'] = __( $tax_slug, $this->plugin_name );
			$opts['rewrite']['with_front'] = FALSE;

			register_taxonomy( $tax_slug, $sanitized_cpt, $opts );
		}
	}






}


