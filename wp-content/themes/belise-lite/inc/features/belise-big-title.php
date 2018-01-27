<?php
/**
 * Customizer functionality for the Big title section.
 *
 * @package Belise
 */

/**
 * Hook controls for Big title section to Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function belise_big_title_customize_register( $wp_customize ) {

	$selective_refresh = isset( $wp_customize->selective_refresh ) ? true : false;

	$wp_customize->add_section(
		'belise_front_page_big_title', array(
			'priority' => 10,
			'title'    => esc_html__( 'Big title section', 'belise-lite' ),
			'panel'    => 'belise_front_page_panel',
		)
	);

	/* Title */
	$default = current_user_can( 'edit_theme_options' ) ? '<p>' . esc_html__( 'Edit this text in Customizer', 'belise-lite' ) . '</p>' : false;
	$wp_customize->add_setting(
		'belise_front_page_title', array(
			'default'           => $default,
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);
	$wp_customize->add_control(
		'belise_front_page_title', array(
			'label'   => esc_html__( 'Title', 'belise-lite' ),
			'section' => 'belise_front_page_big_title',
		)
	);

	/* Button text */
	$default = current_user_can( 'edit_theme_options' ) ? esc_html__( 'Change button text in Front Page', 'belise-lite' ) : false;
	$wp_customize->add_setting(
		'belise_front_page_button_text', array(
			'default'           => $default,
			'sanitize_callback' => 'belise_sanitize_text',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);
	$wp_customize->add_control(
		'belise_front_page_button_text', array(
			'label'   => esc_html__( 'Button Text', 'belise-lite' ),
			'section' => 'belise_front_page_big_title',
		)
	);

	/* Button link */
	$default = current_user_can( 'edit_theme_options' ) ? '#' : false;
	$wp_customize->add_setting(
		'belise_front_page_button_link', array(
			'default'           => $default,
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);
	$wp_customize->add_control(
		'belise_front_page_button_link', array(
			'label'   => esc_html__( 'Button Link', 'belise-lite' ),
			'section' => 'belise_front_page_big_title',
		)
	);

	// Hero background
	$default = current_user_can( 'edit_theme_options' ) ? get_template_directory_uri() . '/img/front-page-hero-image.jpg' : false;
	$wp_customize->add_setting(
		'belise_front_page_image', array(
			'default'           => $default,
			'sanitize_callback' => 'esc_url',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'belise_front_page_image', array(
				'label'   => esc_html__( 'Hero image', 'belise-lite' ),
				'section' => 'belise_front_page_big_title',
			)
		)
	);
}
add_action( 'customize_register', 'belise_big_title_customize_register' );


/**
 * Add selective refresh for big title controls.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function belise_register_big_title_partials( $wp_customize ) {

	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	// Front page title
	$wp_customize->selective_refresh->add_partial(
		'belise_front_page_title', array(
			'selector'        => '#hero .front-page-title',
			'settings'        => 'belise_front_page_title',
			'render_callback' => 'belise_front_page_title_callback',
		)
	);

	// Front page button
	$wp_customize->selective_refresh->add_partial(
		'belise_front_page_button', array(
			'selector'        => '#hero .hero-btn-container',
			'settings'        => array( 'belise_front_page_button_text', 'belise_front_page_button_link' ),
			'render_callback' => 'belise_front_page_button_callback',
		)
	);

	// Front page button
	$wp_customize->selective_refresh->add_partial(
		'belise_front_page_button_link', array(
			'selector'        => '#hero .hero-btn-container',
			'settings'        => array( 'belise_front_page_button_text', 'belise_front_page_button_link' ),
			'render_callback' => 'belise_front_page_button_callback',
		)
	);

	// Front page image
	$wp_customize->selective_refresh->add_partial(
		'belise_front_page_image', array(
			'selector'        => '.page-template-template-with-header .big-title-css',
			'settings'        => 'belise_front_page_image',
			'render_callback' => 'belise_front_page_image_callback',
		)
	);
}
add_action( 'customize_register', 'belise_register_big_title_partials' );

/**
 * Callback front page title
 */
function belise_front_page_title_callback() {
	return get_theme_mod( 'belise_front_page_title' );
}

/**
 * Callback front page button
 */
function belise_front_page_button_callback() {
	$button_text = get_theme_mod( 'belise_front_page_button_text' );
	$button_link = get_theme_mod( 'belise_front_page_button_link' );

	return '<a href=" ' . esc_url( $button_link ) . '">' . esc_html( $button_text ) . '</a>';
}

/**
 * Callback front page image
 */
function belise_front_page_image_callback() {
	$belise_front_page_image = get_theme_mod( 'belise_front_page_image' );

	if ( ! empty( $belise_front_page_image ) ) { ?>
		<style class="belise-big-title-css">
			.front-page-hero-image {
				background-image: url(<?php echo ! empty( $belise_front_page_image ) ? esc_url( $belise_front_page_image ) : 'none'; ?>)!important;
			}
		</style>
		<?php
	}
}
