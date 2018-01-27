<?php
/**
 * Page editor control
 *
 * @package Belise
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}
/**
 * Class to create a custom tags control
 */
class Belise_Page_Editor extends WP_Customize_Control {

	/**
	 * Flag to include sync scripts if needed
	 *
	 * @var bool|mixed
	 */
	private $needsync = false;

	/**
	 * Flag to do action admin_print_footer_scripts.
	 * This needs to be true only for one instance.
	 *
	 * @var bool|mixed
	 */
	private $include_admin_print_footer = false;

	/**
	 * Flag to load teeny.
	 *
	 * @var bool|mixed
	 */
	private $teeny = false;

	/**
	 * Belise_Page_Editor constructor.
	 *
	 * @param WP_Customize_Manager $manager Manager.
	 * @param string               $id Id.
	 * @param array                $args Constructor args.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
		if ( ! empty( $args['needsync'] ) ) {
			$this->needsync = $args['needsync'];
		}

		if ( ! empty( $args['include_admin_print_footer'] ) ) {
			$this->include_admin_print_footer = $args['include_admin_print_footer'];
		}

		if ( ! empty( $args['teeny'] ) ) {
			$this->teeny = $args['teeny'];
		}
	}

	/**
	 * Enqueue scripts
	 *
	 * @since   1.1.0
	 * @access  public
	 * @updated Changed wp_enqueue_scripts order and dependencies.
	 */
	public function enqueue() {
		wp_enqueue_style( 'belise_text_editor_css', get_template_directory_uri() . '/inc/customizer/customizer-page-editor/css/customizer-page-editor.css', array(), '1.0.0' );
		wp_enqueue_script( 'belise_controls_script', get_template_directory_uri() . '/inc/customizer/customizer-page-editor/js/belise-update-controls.js', array( 'jquery', 'customize-preview' ), false, true );
		if ( $this->needsync === true ) {
			wp_enqueue_script( 'belise_text_editor', get_template_directory_uri() . '/inc/customizer/customizer-page-editor/js/belise-text-editor.js', array( 'jquery' ), false, true );
			wp_localize_script(
				'belise_controls_script', 'requestpost', array(
					'ajaxurl'           => admin_url( 'admin-ajax.php' ),
					'thumbnail_control' => 'belise_feature_thumbnail', // name of image control that needs sync
					'editor_control'    => 'belise_page_editor', // name of control (theme_mod) that needs sync
				)
			);
		}
	}

	/**
	 * Render the content on the theme customizer page
	 */
	public function render_content() {
	?>

		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_textarea( $this->value() ); ?>">
		<?php
		$settings        = array(
			'textarea_name' => $this->id,
			'teeny'         => $this->teeny,
		);
		$control_content = $this->value();
		$frontpage_id    = get_option( 'page_on_front' );
		$page_content    = '';
		if ( $this->needsync === true ) {
			if ( ! empty( $frontpage_id ) ) {
				$page_content = get_post_field( 'post_content', $frontpage_id );
			}
		} else {
			$page_content = $this->value();
		}

		if ( $control_content !== $page_content ) {
			$control_content = $page_content;
		}

		wp_editor( $control_content, $this->id, $settings );

		if ( $this->include_admin_print_footer === true ) {
			do_action( 'admin_print_footer_scripts' );
		}
	}
}
