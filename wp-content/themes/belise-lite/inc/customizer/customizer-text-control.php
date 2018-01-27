<?php
/**
 * Class for messages controls in customizer
 *
 * @package Belise
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * Class Belise_Customizer_Message
 */
class Belise_Customizer_Message extends WP_Customize_Control {

	/**
	 * The message to display in the controler
	 *
	 * @var string $message The message to display in the controler
	 */
	private $message = '';

	/**
	 * Belise_Customizer_Message constructor.
	 *
	 * @param string  $manager Manager.
	 * @param integer $id Id.
	 * @param array   $args Array of arguments.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
		if ( ! empty( $args['belise_message'] ) ) {
			$this->message = $args['belise_message'];
		}
	}
	/**
	 * The render function for the controler
	 */
	public function render_content() {
		echo '<span class="customize-control-title">' . $this->label . '</span>';
		echo wp_kses_post( $this->message );
	}
}
