<?php
/**
 * Customizer functionality for Menus section.
 *
 * @package Belise
 */

// Load Customizer page editor.
require_once( trailingslashit( get_template_directory() ) . 'inc/customizer/customizer-page-editor/class/customizer-page-editor-control.php' );

// Load Customizer text control.
require_once( trailingslashit( get_template_directory() ) . '/inc/customizer/customizer-text-control.php' );

// Load Customizer multiple select.
require_once( trailingslashit( get_template_directory() ) . '/inc/customizer/customizer-multiple-choice/customizer-multiple-choice.php' );

/**
 * Hook controls for Menus section to Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function belise_menus_customize_register( $wp_customize ) {

	$selective_refresh = isset( $wp_customize->selective_refresh ) ? true : false;

	$wp_customize->add_section(
		'belise_front_page_menus', array(
			'priority' => 20,
			'title'    => esc_html__( 'Menus section', 'belise-lite' ),
			'panel'    => 'belise_front_page_panel',
		)
	);

	/* Food sections */
	$wp_customize->add_setting(
		'belise_menus_section_categories', array(
			'default'           => array( 'none' ),
			'sanitize_callback' => 'belise_sanitize_multiple_select',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		new Belise_Customize_Control_Multiple_Select(
			$wp_customize, 'belise_menus_section_categories', array(
				'type'     => 'multiple-select',
				'label'    => esc_html__( 'Menus Categories', 'belise-lite' ),
				'section'  => 'belise_front_page_menus',
				'choices'  => belise_get_food_sections(),
				'priority' => 10,
			)
		)
	);

	/* Schedule title */
	$default = current_user_can( 'edit_theme_options' ) ? esc_html__( 'Change schedule title in Front Page', 'belise-lite' ) : false;
	$wp_customize->add_setting(
		'belise_front_page_schedule_title', array(
			'default'           => $default,
			'sanitize_callback' => 'belise_sanitize_text',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);
	$wp_customize->add_control(
		'belise_front_page_schedule_title', array(
			'label'   => esc_html__( 'Schedule Title', 'belise-lite' ),
			'section' => 'belise_front_page_menus',
		)
	);

	/* Schedule content */
	$default = current_user_can( 'edit_theme_options' ) ? esc_html__( 'Change schedule content in Front Page', 'belise-lite' ) : false;
	$wp_customize->add_setting(
		'belise_front_page_schedule_content', array(
			'default'           => $default,
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);

	$wp_customize->add_control(
		'belise_front_page_schedule_content', array(
			'label'    => esc_html__( 'Schedule Content', 'belise-lite' ),
			'section'  => 'belise_front_page_menus',
			'priority' => 10,
		)
	);

	if ( ! class_exists( 'Jetpack' ) ) {

		$wp_customize->add_setting(
			'belise_install_jetpack', array(
				'sanitize_callback' => 'wp_kses_post',
			)
		);

		$wp_customize->add_control(
			new Belise_Customizer_Message(
				$wp_customize, 'belise_install_jetpack', array(
					'section'        => 'belise_front_page_menus',
					'priority'       => 100,
					'belise_message' => sprintf(
						/* translators: %s: plugin name  */
						esc_html__( 'To have access to a food menu section please install and configure %1$s.', 'belise-lite' ),
						sprintf( '<a href="' . esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=jetpack' ), 'install-plugin_jetpack' ) ) . '" rel="nofollow">%s</a>', esc_html__( 'Jetpack plugin', 'belise-lite' ) )
					),
				)
			)
		);
	}
}
add_action( 'customize_register', 'belise_menus_customize_register' );

/**
 * Get Food Menu sections.
 *
 * @param bool $placeholder Choose whether or not to display "Select category".
 *
 * @return array
 * @modified 1.0.7
 */
function belise_get_food_sections( $placeholder = true, $lang = '' ) {
	$belise_food_sections_array = $placeholder === true ? array(
		'none' => esc_html__( 'None', 'belise-lite' ),
	) : array();

	if ( ! taxonomy_exists( 'nova_menu' ) ) {
		return $belise_food_sections_array;
	}

	$args = array(
		'taxonomy' => 'nova_menu',
		'number'   => 0,
		'lang'     => '',
	);

	if ( ! empty( $lang ) ) {
		$args['lang'] = $lang;
	}

	$belise_food_sections = get_terms( $args );

	if ( ! empty( $belise_food_sections ) ) {
		foreach ( $belise_food_sections as $food_section ) {
			if ( ! empty( $food_section->term_id ) && ! empty( $food_section->name ) ) {
				$belise_food_sections_array[ $food_section->slug ] = $food_section->name;
			}
		}
	}

	return $belise_food_sections_array;
}

/**
 * Add selective refresh for big title controls.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function belise_register_menus_partials( $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->selective_refresh->add_partial(
		'belise_menus_section_categories', array(
			'selector'        => '.front-page-after-content .belise-menu-content',
			'settings'        => 'belise_menus_section_categories',
			'render_callback' => 'belise_menus_content',
		)
	);

	// Front page menus - Schedule title
	$wp_customize->selective_refresh->add_partial(
		'belise_front_page_schedule_title', array(
			'selector'        => '.front-page-after-content .operation-hours-title',
			'settings'        => 'belise_front_page_schedule_title',
			'render_callback' => 'belise_front_page_schedule_title_callback',
		)
	);

	// Front page menus - Schedule content
	$wp_customize->selective_refresh->add_partial(
		'belise_front_page_schedule_content', array(
			'selector'        => '.front-page-after-content .operation-hours-content',
			'settings'        => 'belise_front_page_schedule_content',
			'render_callback' => 'belise_front_page_schedule_content_callback',
		)
	);
}
add_action( 'customize_register', 'belise_register_menus_partials' );

/**
 * Callback front page schedule title
 */
function belise_front_page_schedule_title_callback() {
	return get_theme_mod( 'belise_front_page_schedule_title', esc_html__( 'Change schedule title in Front Page', 'belise-lite' ) );
}

/**
 * Callback front page schedule content
 */
function belise_front_page_schedule_content_callback() {
	$content = get_theme_mod( 'belise_front_page_schedule_content' );
	;
	return apply_fiters( 'belise_text', $content );
}
