<?php
/**
 * Lite Manager
 *
 * @package belise
 * @since 1.1.0
 */

/**
 * About page class
 */
require_once get_template_directory() . '/belise-about-page/class-belise-about-page.php';


/*
* About page instance
*/
$config = array(
	// Menu name under Appearance.
	'menu_name'           => esc_html__( 'About Belise Lite', 'belise-lite' ),
	// Page title.
	'page_name'           => esc_html__( 'About Belise Lite', 'belise-lite' ),
	// Main welcome title
	/* translators: %s: version number */
	'welcome_title'       => sprintf( esc_html__( 'Welcome to %s! - Version ', 'belise-lite' ), 'Belise Lite' ),
	// Main welcome content
	/* translators: 1: theme name, 2: theme name */
	'welcome_content'     => sprintf( esc_html__( '%1$s is now installed and ready to use! We want to make sure you have the best experience using %2$s and that is why we gathered here all the necessary information for you. We hope you will enjoy using %3$s, as much as we enjoy creating great products.', 'belise-lite' ), 'Belise Lite', 'Belise Lite', 'Belise Lite' ),
	/**
	 * Tabs array.
	 *
	 * The key needs to be ONLY consisted from letters and underscores. If we want to define outside the class a function to render the tab,
	 * the will be the name of the function which will be used to render the tab content.
	 */
	'tabs'                => array(
		'getting_started'     => esc_html__( 'Getting Started', 'belise-lite' ),
		'recommended_actions' => esc_html__( 'Recommended Actions', 'belise-lite' ),
		'recommended_plugins' => esc_html__( 'Recommended Plugins', 'belise-lite' ),
		'support'             => esc_html__( 'Support', 'belise-lite' ),
		'changelog'           => esc_html__( 'Changelog', 'belise-lite' ),
	),
	// Support content tab.
	'support_content'     => array(
		'first'  => array(
			'title'        => esc_html__( 'Contact Support', 'belise-lite' ),
			'icon'         => 'dashicons dashicons-sos',
			'text'         => esc_html__( 'We offer excellent support through our advanced ticketing system. Make sure to register your purchase before contacting support!', 'belise-lite' ),
			'button_label' => esc_html__( 'Contact Support', 'belise-lite' ),
			'button_link'  => esc_url( 'https://themeisle.com/contact/' ),
			'is_button'    => true,
			'is_new_tab'   => true,
		),
		'second' => array(
			'title'        => esc_html__( 'Documentation', 'belise-lite' ),
			'icon'         => 'dashicons dashicons-book-alt',
			/* translators: %s: theme name */
			'text'         => sprintf( esc_html__( 'This is the place to go to reference different aspects of the theme. Our online documentation is an incredible resource for learning the ins and outs of using %s.', 'belise-lite' ), 'belise' ),
			'button_label' => esc_html__( 'See our full documentation', 'belise-lite' ),
			'button_link'  => 'http://docs.themeisle.com/article/624-belise-documentation',
			'is_button'    => false,
			'is_new_tab'   => true,
		),
		'third'  => array(
			'title'        => esc_html__( 'Changelog', 'belise-lite' ),
			'icon'         => 'dashicons dashicons-portfolio',
			'text'         => esc_html__( 'Want to get the gist on the latest theme changes? Just consult our changelog below to get a taste of the recent fixes and features implemented.', 'belise-lite' ),
			'button_label' => esc_html__( 'See changelog', 'belise-lite' ),
			'button_link'  => esc_url( admin_url( 'themes.php?page=belise-lite-welcome&tab=changelog&show=yes' ) ),
			'is_button'    => false,
			'is_new_tab'   => false,
		),
		'fourth' => array(
			'title'        => esc_html__( 'Create a child theme', 'belise-lite' ),
			'icon'         => 'dashicons dashicons-admin-customizer',
			'text'         => esc_html__( "If you want to make changes to the theme's files, those changes are likely to be overwritten when you next update the theme. In order to prevent that from happening, you need to create a child theme. For this, please follow the documentation below.", 'belise-lite' ),
			'button_label' => esc_html__( 'View how to do this', 'belise-lite' ),
			'button_link'  => 'http://docs.themeisle.com/article/14-how-to-create-a-child-theme',
			'is_button'    => false,
			'is_new_tab'   => true,
		),
		'fifth'  => array(
			'title'        => esc_html__( 'Speed up your site', 'belise-lite' ),
			'icon'         => 'dashicons dashicons-controls-skipforward',
			'text'         => esc_html__( 'If you find yourself in the situation where everything on your site is running very slow, you might consider having a look at the below documentation where you will find the most common issues causing this and possible solutions for each of the issues.', 'belise-lite' ),
			'button_label' => esc_html__( 'View how to do this', 'belise-lite' ),
			'button_link'  => 'http://docs.themeisle.com/article/63-speed-up-your-wordpress-site',
			'is_button'    => false,
			'is_new_tab'   => true,
		),
		'sixth'  => array(
			'title'        => esc_html__( 'Build a landing page with a drag-and-drop content builder', 'belise-lite' ),
			'icon'         => 'dashicons dashicons-images-alt2',
			'text'         => esc_html__( 'In the below documentation you will find an easy way to build a great looking landing page using a drag-and-drop content builder plugin.', 'belise-lite' ),
			'button_label' => esc_html__( 'View how to do this', 'belise-lite' ),
			'button_link'  => 'http://docs.themeisle.com/article/219-how-to-build-a-landing-page-with-a-drag-and-drop-content-builder',
			'is_button'    => false,
			'is_new_tab'   => true,
		),
	),
	// Getting started tab
	'getting_started'     => array(
		array(
			'title'               => esc_html__( 'Step 1 - Implement recommended actions', 'belise-lite' ),
			'text'                => esc_html__( 'We have compiled a list of steps for you, to take make sure the experience you will have using one of our products is very easy to follow.', 'belise-lite' ),
			'button_label'        => esc_html__( 'Check recommended actions', 'belise-lite' ),
			'button_link'         => esc_url( admin_url( 'themes.php?page=belise-lite-welcome&tab=recommended_actions' ) ),
			'is_button'           => false,
			'recommended_actions' => true,
			'is_new_tab'          => false,
		),
		array(
			'title'               => esc_html__( 'Step 2 - Check our documentation', 'belise-lite' ),
			'text'                => esc_html__( 'Even if you are a long-time WordPress user, we still believe you should give our documentation a very quick Read.', 'belise-lite' ),
			'button_label'        => esc_html__( 'Full documentation', 'belise-lite' ),
			'button_link'         => 'http://docs.themeisle.com/article/624-belise-documentation',
			'is_button'           => false,
			'recommended_actions' => false,
			'is_new_tab'          => true,
		),
	),
	// Plugins array.
	'recommended_plugins' => array(
		'already_activated_message' => esc_html__( 'Already activated', 'belise-lite' ),
		'version_label'             => esc_html__( 'Version: ', 'belise-lite' ),
		'install_label'             => esc_html__( 'Install', 'belise-lite' ),
		'activate_label'            => esc_html__( 'Activate', 'belise-lite' ),
		'deactivate_label'          => esc_html__( 'Deactivate', 'belise-lite' ),
		'content'                   => array(
			array(
				'slug' => 'pirate-forms',
			),
			array(
				'slug' => 'siteorigin-panels',
			),
		),
	),
	// Required actions array.
	'recommended_actions' => array(
		'install_label'    => esc_html__( 'Install', 'belise-lite' ),
		'activate_label'   => esc_html__( 'Activate', 'belise-lite' ),
		'deactivate_label' => esc_html__( 'Deactivate', 'belise-lite' ),
		'content'          => array(
			'event-organiser' => array(
				'title'       => esc_html__( 'Event Organiser', 'belise-lite' ),
				'description' => esc_html__( 'If you want to take full advantage of the options this theme has to offer, please install and activate Event Organiser', 'belise-lite' ),
				'check'       => defined( 'EVENT_ORGANISER_VER' ),
				'plugin_slug' => 'event-organiser',
				'id'          => 'event-organiser',
			),
			'jetpack'         => array(
				'title'       => esc_html__( 'Jetpack', 'belise-lite' ),
				'description' => esc_html__( 'Belise is compatible with Jetpack sharring module.', 'belise-lite' ),
				'check'       => class_exists( 'Jetpack' ),
				'plugin_slug' => 'jetpack',
				'id'          => 'jetpack',
			),
		),
	),
);

$belise_recomm_act_extra = array(
	array(
		'title'               => esc_html__( 'Customize everything', 'belise-lite' ),
		'text'                => esc_html__( 'Using the WordPress Customizer you can easily customize every aspect of the theme.', 'belise-lite' ),
		'button_label'        => esc_html__( 'Go to Customizer', 'belise-lite' ),
		'button_link'         => esc_url( admin_url( 'customize.php' ) ),
		'is_button'           => true,
		'recommended_actions' => false,
		'is_new_tab'          => true,
	),
);

array_push( $config['getting_started'], $belise_recomm_act_extra[0] );


Belise_About_Page::init( apply_filters( 'belise_ti_about_filter', $config ) );
