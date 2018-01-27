<?php
/**
 * Customize control multiple choice.
 *
 * @package WordPress
 * @subpackage Belise
 * @since Belise 1.0
 */
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}

/**
 * Class Customize_Control_Multiple_Select
 */
class Belise_Customize_Control_Multiple_Select extends WP_Customize_Control {

	/**
	 * Id of customizer control
	 *
	 * @var string
	 */
	public $id;

	/**
	 * The type of customize control being rendered.
	 *
	 * @var string
	 */
	public $type = 'multiple-select';

	/**
	 * Belise_Customize_Control_Multiple_Select constructor.
	 *
	 * @param WP_Customize_Manager $manager Manager.
	 * @param string               $id Control id.
	 * @param array                $args Arguments.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
		$this->id = $id;
	}

	/**
	 * Enqueue necessary script
	 */
	public function enqueue() {
		wp_enqueue_script( 'customizer-multiple-choice-script', get_template_directory_uri() . '/inc/customizer/customizer-multiple-choice/js/script.js', array( 'jquery' ), '1.0.0', true );
		$params = array(
			'theme_conrols' => '#customize-theme-controls',
			'multi_select'  => '.belise-categories-multiple-select',
		);
		wp_localize_script( 'customizer-multiple-choice-script', 'belise_ms_params', $params );
	}

	/**
	 * Displays the multiple select on the customize screen.
	 */
	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}
		$this->choices = apply_filters( 'belise_multiple_choice_' . $this->id, $this->choices ); ?>
		<label>

			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<select class="belise-categories-multiple-select" <?php $this->link(); ?> multiple="multiple"
					style="height: 100%;">
				<?php
				foreach ( $this->choices as $value => $label ) {
					$selected = ( in_array( $value, $this->value() ) ) ? selected( 1, 1, false ) : '';
					echo '<option value="' . esc_attr( $value ) . '"' . $selected . '>' . $label . '</option>';
				}
				?>
			</select>
		</label>
		<?php
	}
}

if ( ! function_exists( 'belise_sanitize_multiple_select' ) ) :
	/**
	 * Sanitization function for multiple select control.
	 *
	 * @param array $input Multiple select input.
	 * @sice 1.0.0
	 * @modified 1.1.0
	 * @access public
	 * @return array
	 */
	function belise_sanitize_multiple_select( $input ) {
		if ( ! empty( $input ) ) {

			$food_sections = belise_get_food_sections();

			$food_sections['random'] = esc_html__( 'Random', 'belise-lite' );
			foreach ( $input as $selected_cat ) {
				if ( ! array_key_exists( $selected_cat, $food_sections ) ) {
					return array( 'none' );
				}
			}
		}

		return $input;
	}
endif;
