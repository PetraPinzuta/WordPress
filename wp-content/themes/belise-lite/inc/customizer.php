<?php
/**
 * Belise Theme Customizer.
 *
 * @package Belise
 */

$upsell_path = trailingslashit( get_template_directory() ) . 'inc/customizer/customizer-pro/class-belise-customize-upsell.php';

if ( file_exists( $upsell_path ) ) {

	require_once $upsell_path;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function belise_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->default    = '363639';
	$wp_customize->get_setting( 'background_color' )->default    = 'f2ebe0';
	$wp_customize->get_setting( 'header_image' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'header_image_data' )->transport = 'postMessage';

	$selective_refresh = isset( $wp_customize->selective_refresh ) ? true : false;

	/* Panel */
	$wp_customize->add_panel(
		'belise_front_page_panel', array(
			'priority' => 20,
			'title'    => esc_html__( 'Frontpage sections', 'belise-lite' ),
		)
	);

	/*
	 * ADVANCED OPTIONS
	 */
	$wp_customize->add_section(
		'belise_advanced_options_section', array(
			'priority' => 190,
			'title'    => esc_html__( 'Advanced options', 'belise-lite' ),
		)
	);

	// Phone
	$default = current_user_can( 'edit_theme_options' ) ? esc_html__( 'Edit the phone number in Customizer', 'belise-lite' ) : '';
	$wp_customize->add_setting(
		'belise_contact_phone', array(
			'default'           => $default,
			'sanitize_callback' => 'belise_sanitize_text',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);
	$wp_customize->add_control(
		'belise_contact_phone', array(
			'label'   => esc_html__( 'Phone number', 'belise-lite' ),
			'section' => 'belise_advanced_options_section',
		)
	);

	// E-mail
	$default = current_user_can( 'edit_theme_options' ) ? esc_html__( 'Edit the email address in Customizer', 'belise-lite' ) : '';
	$wp_customize->add_setting(
		'belise_contact_email', array(
			'default'           => $default,
			'sanitize_callback' => 'belise_sanitize_text',
			'transport'         => $selective_refresh ? 'postMessage' : 'refresh',
		)
	);
	$wp_customize->add_control(
		'belise_contact_email', array(
			'label'   => esc_html__( 'E-mail address ', 'belise-lite' ),
			'section' => 'belise_advanced_options_section',
		)
	);

	if ( class_exists( 'WooCommerce' ) ) {
		// Remove breadcrumb from shop category
		$wp_customize->add_setting(
			'belise_woocommerce_breadcrumb_display', array(
				'default'           => false,
				'sanitize_callback' => 'belise_sanitize_checkbox',
			)
		);
		$wp_customize->add_control(
			'belise_woocommerce_breadcrumb_display', array(
				'label'    => esc_html__( 'Enable breadcrumbs on shop pages', 'belise-lite' ),
				'type'     => 'checkbox',
				'section'  => 'belise_advanced_options_section',
				'priority' => 30,
			)
		);

		// Remove ordering from shop category
		$wp_customize->add_setting(
			'belise_woocommerce_ordering_display', array(
				'default'           => false,
				'sanitize_callback' => 'belise_sanitize_checkbox',
			)
		);
		$wp_customize->add_control(
			'belise_woocommerce_ordering_display', array(
				'label'    => esc_html__( 'Enable sorting options on shop pages', 'belise-lite' ),
				'type'     => 'checkbox',
				'section'  => 'belise_advanced_options_section',
				'priority' => 35,
			)
		);

		// Show tabs on single product
		$wp_customize->add_setting(
			'belise_woocommerce_tabs_display', array(
				'default'           => false,
				'sanitize_callback' => 'belise_sanitize_checkbox',
			)
		);
		$wp_customize->add_control(
			'belise_woocommerce_tabs_display', array(
				'label'    => esc_html__( 'Enable details tabs on single product pages', 'belise-lite' ),
				'type'     => 'checkbox',
				'section'  => 'belise_advanced_options_section',
				'priority' => 40,
			)
		);
	}// End if().

	// Link on menu item title
	$wp_customize->add_setting(
		'belise_nova_menu_title_links', array(
			'default'           => false,
			'sanitize_callback' => 'belise_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'belise_nova_menu_title_links', array(
			'label'    => esc_html__( 'Add link on food menu title to single page', 'belise-lite' ),
			'type'     => 'checkbox',
			'section'  => 'belise_advanced_options_section',
			'priority' => 50,
		)
	);

}
add_action( 'customize_register', 'belise_customize_register' );


/**
 * Add selective refresh for general controls.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function belise_register_general_partials( $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	// Site title
	$wp_customize->selective_refresh->add_partial(
		'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'belise_customize_partial_blogname',
		)
	);

	// Tagline
	$wp_customize->selective_refresh->add_partial(
		'blogdescription', array(
			'selector'        => '.hero-title.front-page-title',
			'render_callback' => 'belise_customize_partial_blogdescription',
		)
	);

	// Logo
	$wp_customize->selective_refresh->add_partial(
		'custom_logo', array(
			'selector'        => '.site-branding',
			'settings'        => 'custom_logo',
			'render_callback' => 'belise_custom_logo_callback',
		)
	);

	// Phone
	$wp_customize->selective_refresh->add_partial(
		'belise_contact_phone', array(
			'selector'        => '.top-bar .bar-contact',
			'settings'        => 'belise_contact_phone',
			'render_callback' => 'belise_contact_phone_callback',
		)
	);

	// E-mail
	$wp_customize->selective_refresh->add_partial(
		'belise_contact_email', array(
			'selector'        => '.footer-bar .bar-contact',
			'settings'        => 'belise_contact_email',
			'render_callback' => 'belise_contact_email_callback',
		)
	);

	// Blog header image
	$wp_customize->selective_refresh->add_partial(
		'header_image', array(
			'selector'        => '.blog .big-title-css',
			'settings'        => 'header_image',
			'render_callback' => 'belise_blog_image_selective_refresh',
		)
	);

}
add_action( 'customize_register', 'belise_register_general_partials' );

/**
 * Custom logo callback function.
 */
function belise_custom_logo_callback() {
	if ( get_theme_mod( 'custom_logo' ) ) {
		$logo = wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' );
		if ( ! empty( $logo ) ) {
			$logo = '<img src="' . esc_url( $logo ) . '">';
		}
	} else {
		if ( is_front_page() ) {
			$logo = '<h1 class="site-title">' . get_bloginfo( 'name' ) . '</h1>';
		} else {
			$logo = '<p class="site-title">' . get_bloginfo( 'name' ) . '</p>';
		}
	}
	return $logo;
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function belise_customize_preview_js() {
	wp_enqueue_script( 'belise_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'belise_customize_preview_js' );

if ( ! function_exists( 'belise_sanitize_text' ) ) {
	/**
	 * Text Sanitization
	 */
	function belise_sanitize_text( $input ) {
		return wp_kses_post( force_balance_tags( $input ) );
	}
}

if ( ! function_exists( 'belise_sanitize_checkbox' ) ) {
	/**
	 * Checkbox Sanitization
	 *
	 * @return bool
	 */
	function belise_sanitize_checkbox( $checked ) {
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @since Belise 1.0
 * @see belise_customize_register()
 *
 * @return void
 */
function belise_customize_partial_blogname() {
	bloginfo( 'name' );
}
/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Belise 1.0
 * @see belise_customize_register()
 *
 * @return void
 */
function belise_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Callback contact phone
 */
function belise_contact_phone_callback() {
	return get_theme_mod( 'belise_contact_phone', esc_html__( 'Edit the phone number in Customizer', 'belise-lite' ) );
}

/**
 * Callback e-mail
 */
function belise_contact_email_callback() {
	return get_theme_mod( 'belise_contact_email', esc_html__( 'Edit the email address in Customizer', 'belise-lite' ) );
}


/**
 * Callback blog image
 */
function belise_blog_image_selective_refresh() {
	$header_image = get_header_image();
	if ( ! empty( $header_image ) ) { ?>
		<style class="belise-blog-title-css">
			.blog .hero-image {
				background-image: url(<?php echo ! empty( $header_image ) ? esc_url( $header_image ) : 'none'; ?>) !important;
			}
		</style>
		<?php
	}
}
