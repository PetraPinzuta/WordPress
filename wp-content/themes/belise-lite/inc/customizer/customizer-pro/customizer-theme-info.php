<?php
/**
 * Theme info customizer controls.
 *
 * @package belise
 * @author Themeisle
 * @version 1.1.0
 */

/**
 * Hook Theme Info section to customizer.
 *
 * @access public
 * @since 1.1.0
 * @param WP_Customize_Manager $wp_customize The wp_customize object.
 */
function belise_theme_info_customize_register( $wp_customize ) {
	// Include upsell class.
	require_once( get_template_directory() . '/inc/customizer/customizer-pro/class/class-belise-control-upsell.php' );

	// Add Theme Info Section.
	$wp_customize->add_section(
		'belise_features_section', array(
			'title'    => __( 'View PRO version', 'belise-lite' ),
			'priority' => 1,
		)
	);

	// Add upsells.
	$wp_customize->add_setting(
		'belise_upsell_pro_features_main', array(
			'sanitize_callback' => 'esc_html',
		)
	);

	$wp_customize->add_control(
		new Belise_Control_Upsell(
			$wp_customize, 'belise_upsell_pro_features_main', array(
				'section'     => 'belise_features_section',
				'priority'    => 1,
				'options'     => array(
					esc_html__( 'Get full color schemes support for your site. ', 'belise-lite' ),
					esc_html__( 'Social sharing icons', 'belise-lite' ),
					esc_html__( 'Page template for events', 'belise-lite' ),
					esc_html__( 'Control the related categories for food menus', 'belise-lite' ),
					esc_html__( 'Possibility to add your own copyright message in footer', 'belise-lite' ),
					esc_html__( 'Hide the date on single post page', 'belise-lite' ),
					esc_html__( 'Deactivate search in header', 'belise-lite' ),
					esc_html__( 'Support', 'belise-lite' ),
				),
				'button_url'  => esc_url( 'https://themeisle.com/themes/belise/' ),
				// xss ok
				'button_text' => esc_html__( 'View PRO version', 'belise-lite' ),
			)
		)
	);

}
add_action( 'customize_register', 'belise_theme_info_customize_register' );
