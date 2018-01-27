<?php
/**
 * Customizer functionality for the About section.
 *
 * @package Belise
 */

// Register customizer page editor functions
require_once( trailingslashit( get_template_directory() ) . 'inc/customizer/customizer-page-editor/customizer-page-editor.php' );

/**
 * Hook controls for About section to Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function belise_about_customize_register( $wp_customize ) {

	$selective_refresh = isset( $wp_customize->selective_refresh ) ? true : false;
	$frontpage_id      = get_option( 'page_on_front' );

	$wp_customize->add_section(
		'belise_about', array(
			'title'    => esc_html__( 'About section', 'belise-lite' ),
			'panel'    => 'belise_front_page_panel',
			'priority' => 30,
		)
	);

	$default = '';
	if ( ! empty( $frontpage_id ) ) {
		$default = get_post_field( 'post_content', $frontpage_id );
	}

	$wp_customize->add_setting(
		'belise_page_editor', array(
			'default'           => $default,
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		new Belise_Page_Editor(
			$wp_customize, 'belise_page_editor', array(
				'label'                      => esc_html__( 'About Content', 'belise-lite' ),
				'section'                    => 'belise_about',
				'priority'                   => 10,
				'needsync'                   => true,
				'include_admin_print_footer' => true,
			)
		)
	);

	$default = '';
	if ( ! empty( $frontpage_id ) ) {
		if ( has_post_thumbnail( $frontpage_id ) ) {
			$default = get_the_post_thumbnail_url( $frontpage_id );
		}
	}

	$wp_customize->add_setting(
		'belise_feature_thumbnail', array(
			'sanitize_callback' => 'esc_url',
			'default'           => $default,
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'belise_feature_thumbnail', array(
				'label'    => esc_html__( 'Featured image', 'belise-lite' ),
				'section'  => 'belise_about',
				'priority' => 15,
			)
		)
	);

}

add_action( 'customize_register', 'belise_about_customize_register' );


/**
 * Add selective refresh for about section controls.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function belise_register_about_partials( $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial(
		'belise_page_editor', array(
			'selector'        => '.front-page-content .row',
			'settings'        => 'belise_page_editor',
			'render_callback' => 'belise_about_render_callback',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'belise_feature_thumbnail', array(
			'selector'        => '.front-page-content .row',
			'settings'        => 'belise_feature_thumbnail',
			'render_callback' => 'belise_about_render_callback',
		)
	);

}

add_action( 'customize_register', 'belise_register_about_partials' );

/**
 * Render callback for about image selective refresh.
 */
function belise_about_render_callback() {
	$belise_about_image   = get_theme_mod( 'belise_feature_thumbnail' );
	$belise_about_content = get_theme_mod( 'belise_page_editor' );
	$class                = ! empty( $belise_about_image ) ? 'col-xs-12 col-sm-6' : 'col-md-12'; ?>

	<div class="<?php echo esc_attr( $class ); ?> belise-page-content">
		<?php echo apply_filters( 'belise_text', $belise_about_content ); ?>
	</div>

	<?php
	if ( ! empty( $belise_about_image ) ) {
	?>
		<div class="<?php echo esc_attr( $class ); ?> belise-page-thumbnail">
			<img src="<?php echo esc_url( $belise_about_image ); ?>"/>
		</div>
		<?php
	}
}
