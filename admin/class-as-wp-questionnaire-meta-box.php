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

 class As_Wp_Questionnaire_Meta_Box {

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
	 * Adds the meta box container.
	 */
	public function add_meta_box($post_type) {
		// $cpt_names = $this->cpt_names;
		// $post_types = unserialize($cpt_names);

		$post_types = array('question');


		//limit meta box to certain post types
		if (in_array($post_type, $post_types)) {
			add_meta_box('subscription-details-meta',
			'Options as Answer',
			array($this, 'meta_box_function'),
			$post_type,
			'normal',
			'high');
		}
	}

	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */

	public function meta_box_function($post) {
		$args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
		$questionType = wp_get_post_terms( $post->ID, $taxonomy = 'question_type', $args );

		if(is_array($questionType)) {
			$questionType = array_shift($questionType);
		}

		//wp_nonce_field('meta_box_nonce_check', 'meta_box_nonce_check_value');

		$options_as_answer = get_post_meta($post->ID, '_options_as_answer', false);

		if ($questionType->slug == 'text') {					// if selected taxonomy term  = 'text'
			echo '<div style="margin: 10px;>';
				echo '<label for="question-type-text">';
					echo '<strong><p>Text</p></strong>';
				echo '</label>';
				echo '<input type="text" id="question-type-text" name="question-type-text" value="'.  esc_attr($options_as_answer) .'">';
			echo '</div>';
		} elseif ($questionType->slug == 'textarea') {			// if selected taxonomy term  = 'textarea'
			echo '<div style="margin: 10px;>';
				echo '<label for="question-type-textarea">';
					echo '<strong><p>TextArea</p></strong>';
				echo '</label>';
				echo '<input type="text" id="question-type-textarea" name="question-type-textarea" value="'.  esc_attr($options_as_answer) .'">';
			echo '</div>';
		} elseif ($questionType->slug == 'radio') {				// if selected taxonomy term  = 'radio'
			$display_option_input_form = TRUE;
		} elseif ($questionType->slug == 'checkbox') {			// if selected taxonomy term  = 'checkbox'
			$display_option_input_form = TRUE;
		} else {
			echo '<div style="margin: 10px;>';
				echo '<label for="question-type-checkbox">';
					echo '<strong><p>Kindly select you <strong>Question Type</strong> first.</p></strong>';
				echo '</label>';
				// echo '<input type="text" id="question-type-checkbox" name="question-type-checkbox" value="'.  esc_attr($options_as_answer) .'">';
			echo '</div>';
		}

		echo '<div id="user-action-response"></div>';

		if($display_option_input_form === TRUE) {
			echo '<div style="margin: 10px;>';
				echo '<label for="option">';
					echo '<strong><p>Options</p></strong>';
				echo '</label>';
				echo '<input type="text" id="options_as_answer" name="question-type-radio">';

				echo '<button type="button" class="btn btn-secondary btn-sm" onclick="insert_option_as_answer('. $post->ID.')">';
				echo '<span class="dashicons dashicons-plus-alt"></span>';
				echo '</button>';
			echo '</div>';

			if(is_array($options_as_answer)) {
				$loopCounter = 1;

				$html = '<table class="wp-list-table widefat fixed striped" width="50%">';
				$html .= '<thead>';
				$html .= '<tr>';
				$html .= '<th scope="col" id="role" class="manage-column column-no">';
				$html .= '#';
				$html .= '</th>';
				$html .= '<th scope="col" id="role" class="manage-column column-value">';
				$html .= 'Value';
				$html .= '</th>';
				$html .= '<th scope="col" id="posts" class="manage-column column-action">';
				$html .= 'Action';
				$html .= '</th>';
				$html .= '</tr>';
				$html .= '</thead>';
				$html .= '<tbody id="the-list" data-wp-lists="list:user">';
				foreach ($options_as_answer as $metaValue) {
					$html .= '<tr>';
					$html .= '<td class="role column-value" data-colname="Value">';
					$html .= $loopCounter;
					$html .= '</td>';
					$html .= '<td class="role column-value" data-colname="Value">';
					$html .= $metaValue;
					$html .= '</td>';
					$html .= '<td class="role column-action" data-colname="Action">';
					$html .= '<a data-post-id="' . $post->ID. '" data-meta-val="' . $metaValue. '" onclick="delete_option_as_answer(this)">';
					$html .= '<span class="dashicons dashicons-dismiss"></span>';
					$html .= '</a>';
					$html .= '</td>';
					$html .= '</tr>';

					$loopCounter++;
				}
				$html .= '</table>';

				echo $html;
			}
			// print_r($options_as_answer);
		}

	}


	/**
	 * Add meta value from DB.
	 *
	 * @param int $post_id
	 */
	public function insert_metadata_in_question() {

		if(isset($_POST['postId'])) {
			$post_id = $_POST['postId'];			//  fetch post id
			$newOption = $_POST['newOption'];		//	fetch new val need to be added

			$updateValues = add_post_meta( $post_id, '_options_as_answer', $newOption);		// Add new value in DB

			if($updateValues != FALSE) {			// If value inserted in DB
				$response['status'] = 1;
				$response['msg'] = 'Options saved successfully.';
				$response['code response'] = $updateValues;

			} else {								// If valve not insterted in DB
				$response['status'] = 0;
				$response['msg'] = 'There is some problem';
			}

		} else {									// If post id not find
			$response['status'] = 2;
			$response['msg'] = 'Unable to retrieve post id.';
		}


		echo json_encode($response);
  		exit;
	}

	/**
	 * Delete meta value from DB.
	 *
	 * @param int $post_id
	 */
	public function delete_metadata_in_question() {

		if(isset($_POST['postId'])) {
			$post_id = $_POST['postId'];			//  fetch post id
			$metaValue = $_POST['metaValue'];		//	fetch new val need to be added

			$updateValues = delete_post_meta( $post_id, '_options_as_answer', $metaValue);		// Add new value in DB

			if($updateValues != FALSE) {			// If value inserted in DB
				$response['status'] = 1;
				$response['msg'] = 'Options deleted successfully.';
				$response['code response'] = $updateValues;

			} else {								// If valve not insterted in DB
				$response['status'] = 0;
				$response['msg'] = 'There is some problem';
				$response['post_id'] = $post_id;
				$response['metaValue'] = $metaValue;
			}

		} else {									// If post id not find
			$response['status'] = 2;
			$response['msg'] = 'Unable to retrieve post id.';
		}


		echo json_encode($response);
  		exit;
	}












	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save_meta_box($post_id) {

		/*
		 * We need to verify this came from the our screen and with
		 * proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if (!isset($_POST['meta_box_nonce_check_value']))
			return $post_id;

		$nonce = $_POST['meta_box_nonce_check_value'];

		// Verify that the nonce is valid.
		if (!wp_verify_nonce($nonce, 'meta_box_nonce_check'))
			return $post_id;

		// If this is an autosave, our form has not been submitted,
		//     so we don't want to do anything.
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return $post_id;

		// Check the user's permissions.
		if ('page' == $_POST['post_type']) {

			if (!current_user_can('edit_page', $post_id))
				return $post_id;

		} else {

			if (!current_user_can('edit_post', $post_id))
				return $post_id;
		}

		/* OK, its safe for us to save the data now. */

		// Sanitize the user input.
		$planID = sanitize_text_field($_POST['plan_id']);
		$planPrice = sanitize_text_field($_POST['plan_price']);
		$planDuration = sanitize_text_field($_POST['plan_duration']);
		$planDescription = sanitize_text_field($_POST['plan_description']);

		// Update the meta field.
		update_post_meta($post_id, '_meta_box_plan_id', $planID);
		update_post_meta($post_id, '_meta_box_plan_price', $planPrice);
		update_post_meta($post_id, '_meta_box_plan_duration', $planDuration);
		update_post_meta($post_id, '_meta_box_plan_description', $planDescription);
	}

	public function display_meta_box_content($content) {
		global $post;
		//retrieve the metadata values if they exist
		$planID = get_post_meta($post -> ID, '_meta_box_plan_id', true);
		$planPrice = get_post_meta($post -> ID, '_meta_box_plan_price', true);
		$planDuration = get_post_meta($post -> ID, '_meta_box_plan_duration', true);
		$planDescription = get_post_meta($post -> ID, '_meta_box_plan_description', true);


		// Add meta box content in wp_content
		if (!empty($planDescription)) {
			$plan_description = "<div style='background-color: #FFEBE8;border-color: #C00;padding: 2px;margin:2px;'>";
			$plan_description .= 'Description: ';
			$plan_description .= $planDescription;
			$plan_description .= "</div>";
			$content = $plan_description . $content;
		}

		if (!empty($planDuration)) {
			$duration = "<div style='background-color: #FFEBE8;border-color: #C00;padding: 2px;margin:2px;'>";
			$duration .= 'Duration: ';
			$duration .= $planDuration;
			$duration .= "</div>";
			$content = $duration . $content;
		}

		if (!empty($planPrice)) {
			$price = "<div style='background-color: #FFEBE8;border-color: #C00;padding: 2px;margin:2px;'>";
			$price .= 'Price: ';
			$price .= $planPrice;
			$price .= "</div>";
			$content = $price . $content;
		}


		if (!empty($planID)) {
			$price = "<div style='background-color: #FFEBE8;border-color: #C00;padding: 2px;margin:2px;'>";
			$price .= 'ID: ';
			$price .= $planID;
			$price .= "</div>";
			$content = $price . $content;
		}

		return $content;
	}



}
?>