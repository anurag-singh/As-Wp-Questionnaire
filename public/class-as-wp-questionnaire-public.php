<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wordpress.org
 * @since      1.0.0
 *
 * @package    As_Wp_Questionnaire
 * @subpackage As_Wp_Questionnaire/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    As_Wp_Questionnaire
 * @subpackage As_Wp_Questionnaire/public
 * @author     Anurag Singh <email@gmail.com>
 */
class As_Wp_Questionnaire_Public {

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
		 * defined in As_Wp_Questionnaire_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The As_Wp_Questionnaire_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/as-wp-questionnaire-public.css', array(), $this->version, 'all' );

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
		 * defined in As_Wp_Questionnaire_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The As_Wp_Questionnaire_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/as-wp-questionnaire-public.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Display content through short code
	 *
	 * @since    1.0.0
	 */
	public function render_questions() {
		global $post;
		$questionArg = array(
							'post_type' => 'question'
						);

		$questionsArr = new WP_Query($questionArg);


		if($questionsArr->have_posts()) :
			while ($questionsArr->have_posts())  : $questionsArr->the_post();
				$getQuestionType = wp_get_post_terms( $post->ID, 'question_type', array("fields" => "slugs") );

				$question = get_the_title();
				$answerOptions = get_post_meta( $post->ID, $key = 'options_as_answer', $single = false );

				// echo '<pre>';
				// print_r($getQuestionType);

				if (in_array('text', $getQuestionType)) {
					$this->gender_input_type_text($question, $answerOptions);
					echo '<br>';
				} elseif (in_array('textarea', $getQuestionType))  {
					$this->gender_input_type_textarea($question, $answerOptions);
					echo '<br>';
				} elseif (in_array('radio', $getQuestionType))  {
					$this->gender_input_type_radio($question, $answerOptions);
					echo '<br>';
				} elseif (in_array('checkbox', $getQuestionType))  {
					$this->gender_input_type_chekboxes($question, $answerOptions);
					echo '<br>';
				}

				// $answerOptions = get_post_meta( $post->ID, $key = 'options_as_answer', $single = false );
				// print_r($answerOptions);
				// the_meta();
			endwhile;
		endif;

		wp_reset_postdata();
	}

	/**
	 * Display input type  - Text
	 *
	 * @since    1.0.0
	 */
	function gender_input_type_text($question, $option) {

		if(is_array($option)){
			$option = array_shift($option);
		}

		$option_slug = sanitize_title( $option );

		$output .= '<div class="col-12">';
		    $output .= '<label for="' . $option_slug . '">' . $question . '</label>';
		    $output .= '<input type="text" class="form-control" id="' . $option_slug . '" name="' . $option_slug . '" placeholder="' . $option . '">';
		$output .= '</div>';

		echo $output;
	}

	/**
	 * Display input type  - Textarea
	 *
	 * @since    1.0.0
	 */
	function gender_input_type_textarea($question, $option) {

		if(is_array($option)){
			$option = array_shift($option);
		}

		$option_slug = sanitize_title( $option );

		$output .= '<div class="col-12">';
		    $output .= '<label for="' . $option_slug . '">' . $question . '</label>';
		    $output .= '<textarea name="' . $option_slug . '" id="' . $option_slug . '"  rows="10" cols="50">' . $option . '</textarea>';
		$output .= '</div>';

		echo $output;
	}



	/**
	 * Display input type  - Checkbox
	 *
	 * @since    1.0.0
	 */
	function gender_input_type_chekboxes($question, $options) {
		$output .= '<label for="' . $option_slug . '">' . $question . '</label>';
		foreach($options as $option){
			$option_slug = sanitize_title( $option );
			$output .= '<div class="form-check form-check-inline"><label class="form-check-label" for="'.$option_slug.'"><input class="form-check-input" type="checkbox" id="'.$option_slug.'" name="'.$option_slug.'" value="'.$option.'"> '.$option.'</label></div>';
		}
		echo $output;
	}



	/**
	 * Display input type  - Radio
	 *
	 * @since    1.0.0
	 */
	function gender_input_type_radio($question, $options) {
		$output .= '<label for="' . $option_slug . '">' . $question . '</label>';
		foreach($options as $option){
			$option_slug = sanitize_title( $option );
		    $output .= '<div class="form-check form-check-inline">';
		    	$output .= '<label class="form-check-label">';
		    		$output .= '<input class="form-check-input" type="radio" name="'.$option_slug.'" id="'.$option_slug.'" value="'.$option.'">';
		    			$output .= $option;
		    	$output .= '</label>';
		    $output .= '</div>';
		}
		echo $output;
	}

}
