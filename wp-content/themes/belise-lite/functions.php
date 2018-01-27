<?php
/**
 * Belise functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Belise
 */

define( 'BELISE_PHP_INCLUDE', trailingslashit( get_template_directory() ) . 'inc' );
if ( class_exists( 'woocommerce' ) ) {
	require_once( BELISE_PHP_INCLUDE . '/woocommerce/functions.php' );
	require_once( BELISE_PHP_INCLUDE . '/woocommerce/hooks.php' );
}

$import_data = BELISE_PHP_INCLUDE . '/demo-content/functions.php';
if ( file_exists( $import_data ) ) {
	require_once( $import_data );
}

if ( ! function_exists( 'belise_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	/**
	 * Setup theme
	 */
	function belise_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on belise, use a find and replace
		 * to change 'belise' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'belise', get_template_directory() . '/languages' );

		/**
		 * Add default posts and comments RSS feed links to head.
		 */
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails', array( 'post', 'page', 'product' ) );
		add_image_size( 'belise-hero-image', 1920, 615, true );
		add_image_size( 'belise-post-image', 370, 270, true );
		add_image_size( 'belise-jetpack-portfolio-thumbnail', 500, 500, true );
		add_image_size( 'belise-jetpack-testimonial-thumbnail', 370, 270, true );

		// Added WooCommerce support
		add_theme_support( 'woocommerce' );

		// WooCommerce support for latest gallery
		if ( class_exists( 'WooCommerce' ) ) {
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
		}

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary'      => esc_html__( 'Primary', 'belise-lite' ),
				'categories'   => esc_html__( 'Categories', 'belise-lite' ),
				'social-icons' => esc_html__( 'Social Icons', 'belise-lite' ),
				'shop'         => esc_html__( 'Shop', 'belise-lite' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background', apply_filters(
				'belise_custom_background_args', array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for custom logo
		add_theme_support(
			'custom-logo', array(
				'height'     => 90,
				'width'      => 300,
				'flex-width' => true,
			)
		);

		// Add theme support for Jetpack food menus
		add_theme_support( 'nova_menu_item' );

		// Selective refresh for widgets
		add_theme_support( 'customize-selective-refresh-widgets' );

	}
endif;
add_action( 'after_setup_theme', 'belise_setup' );

if ( ! function_exists( 'belise_starter_content' ) ) :
	/**
	 * Starter Content support and items.
	 */
	function belise_starter_content() {

		$about_page_content = '<table class="values-table"><tbody><tr><th class="about-values-title" style="text-align: center;" colspan="2">Our Core Values</th></tr><tr><td><i class="fa fa-check-square-o"></i><br/><strong>High Quality</strong><p style="text-align: center;">Our ingredients are delicately sourced with both time and care by using the highest standards and regulations possible.</p></td><td><i class="fa fa-leaf"></i><br/><strong>Responsibility</strong><p style="text-align: center;">It is our job as humans to protect this wonderful planet we live on. We practice all acts of sustainability possible.</p></td></tr><tr><td style="text-align: center;"><i class="fa fa-cogs"></i><br/><strong>Community</strong><p>We value the connections we’ve made within this wonderful community and want to continue to grow + nourish them.<p></td><td><i class="fa fa-lightbulb-o"></i><br/><strong>Innovation</strong><p style="text-align: center;">Creativity is in our blood. It’s why Savor exists in the first place. We are constantly finding new ways to innovate.</p></td></tr></tbody></table></div>[portfolio columns="4" showposts="8"]<div class="testimonials-container"><div class="container">[testimonials columns="3"]</div>';

		/*
         * Starter Content Support
         */
		add_theme_support(
			'starter-content', array(
				'posts'     => array(
					'home',
					'about'   => array(
						'post_content' => wp_kses_post( $about_page_content ),
						'template'     => 'template-full-width.php',

					),
					'contact' => array(
						'template' => 'template-full-width.php',
					),
					'blog',
					'events'  => array(
						'post_type'    => 'page',
						'template'     => 'template-main-events.php',
						'post_title'   => esc_html__( 'Events', 'belise-lite' ),
						'post_content' => esc_html__( 'About Services', 'belise-lite' ),
					),
				),

				'nav_menus' => array(
					'primary'      => array(
						'name'  => esc_html__( 'Primary Menu', 'belise-lite' ),
						'items' => array(
							'page_home',
							'page_blog',
							'page_events' => array(
								'type'      => 'post_type',
								'object'    => 'page',
								'object_id' => '{{events}}',
							),
							'page_contact',
							'page_about',
						),
					),
					'social-icons' => array(
						'name'  => esc_html__( 'Social Links Menu', 'belise-lite' ),
						'items' => array(
							'link_facebook',
							'link_pinterest',
							'link_twitter',
							'link_instagram',
						),
					),
				),

				'options'   => array(
					'show_on_front'  => 'page',
					'page_on_front'  => '{{home}}',
					'page_for_posts' => '{{blog}}',
				),

				'widgets'   => array(
					'ribbon_area' => array(
						'belise_ribbon_widget_content' => array(
							'belise_ribbon-widget',
							array(
								'title'               => esc_html__( 'You can edit this ribbon under ', 'belise-lite' ),
								'text'                => esc_html__( 'Widgets in the Ribbon Area', 'belise-lite' ),
								'button_text'         => 'button',
								'button_link'         => '#',
								'image_uri'           => get_template_directory_uri() . '/img/hero-image.jpg',
								'image_in_customizer' => get_template_directory_uri() . '/img/hero-image.jpg',
							),
						),
					),
				),

			)
		);
	}
endif;
add_action( 'after_setup_theme', 'belise_starter_content' );
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function belise_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'belise_content_width', 640 );
}
add_action( 'after_setup_theme', 'belise_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function belise_widgets_init() {

	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'belise-lite' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Main sidebar widgets.', 'belise-lite' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 1', 'belise-lite' ),
			'id'            => 'footer_widget_col_1',
			'before_widget' => '<div id="%1$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 2', 'belise-lite' ),
			'id'            => 'footer_widget_col_2',
			'before_widget' => '<div id="%1$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 3', 'belise-lite' ),
			'id'            => 'footer_widget_col_3',
			'before_widget' => '<div id="%1$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Events section', 'belise-lite' ),
			'id'            => 'events_area',
			'description'   => esc_html__( 'Add widgets here to display them on FrontPage within Events Section', 'belise-lite' ),
			'before_widget' => '<div class="col-sm-12 col-md-6 col-lg-6 widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

}
add_action( 'widgets_init', 'belise_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function belise_scripts() {
	wp_enqueue_style( 'belise-style', get_stylesheet_uri(), array( 'boostrap' ), 'v0.0.2' );

	wp_enqueue_style( 'boostrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), 'v3.3.7', 'all' );

	wp_enqueue_style( 'belise-woocommerce-style', get_template_directory_uri() . '/inc/woocommerce/css/woocommerce.css', array(), 'v3' );

	wp_enqueue_style( 'belise-fonts', belise_fonts_url(), array(), null );

	wp_enqueue_script( 'skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), 'v4.7.0' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
		wp_enqueue_script( 'comments-js', get_template_directory_uri() . '/js/comments.js', array( 'jquery' ), 'v1', true );
	}

	if ( is_category() || is_search() || is_archive() || is_home() ) {

		wp_enqueue_script( 'belise-masonry-call', get_template_directory_uri() . '/js/masonry-call.js', array( 'masonry' ), '20120206', true );
	}

	wp_enqueue_script( 'belise-functions', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20120206', true );
}
add_action( 'wp_enqueue_scripts', 'belise_scripts' );
/**
 * Belise fonts url
 *
 * @return string
 */
function belise_fonts_url() {
	$fonts_url = '';

	/*
    * Translators: If there are characters in your language that are not
    * supported by Works Sans / Lora, translate this to 'off'. Do not translate
    * into your own language.
    */
	$work_sans = _x( 'on', 'Work Sans font: on or off', 'belise-lite' );
	$lora      = _x( 'on', 'Lora font: on or off', 'belise-lite' );
	if ( 'off' !== $work_sans || 'off' !== $lora ) {
		$font_families = array();
		if ( 'off' !== $work_sans ) {
			$font_families[] = 'Work Sans:500,600,700,800,900';
		}
		if ( 'off' !== $lora ) {
			$font_families[] = 'Lora:300,400';
		}
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url  = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}
	return $fonts_url;
}

/**
 * Implement the Custom Header feature.
 */
require BELISE_PHP_INCLUDE . '/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require BELISE_PHP_INCLUDE . '/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require BELISE_PHP_INCLUDE . '/extras.php';

/**
 * Customizer additions.
 */
require BELISE_PHP_INCLUDE . '/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require BELISE_PHP_INCLUDE . '/jetpack.php';

/**
 * TGM plugin activation.
 */
require_once BELISE_PHP_INCLUDE . '/class-tgm-plugin-activation.php';


/**
 * Define Allowed Files to be included.
 */
function belise_filter_features( $array ) {
	return array_merge(
		$array, array(

			'/customizer/customizer-pro/customizer-theme-info',

			'/features/belise-big-title',
			'/sections/belise-big-title-section',

			'/sections/belise-about-section',

			'/features/belise-menus',
			'/sections/belise-menus-section',

			'/sections/belise-ribbon-section',
			'/sections/belise-taxonomy-meta-image',

			'/features/belise-copyright',
			'/features/belise-sharing-icons',
			'/features/meta-controls/meta-functions',
			'/features/belise-about',

			'/customizer/customizer-color-scheme/functions',

			'/features/belise-pro-features',
			'/features/belise-about-page',
		)
	);
}
add_filter( 'belise_filter_features', 'belise_filter_features' );

/**
 * Include features files.
 *
 * @since Belise 1.0
 */
function belise_include_features() {
	$belise_allowed_phps = array();
	$belise_allowed_phps = apply_filters( 'belise_filter_features', $belise_allowed_phps );
	foreach ( $belise_allowed_phps as $file ) {
		$belise_file_to_include = BELISE_PHP_INCLUDE . $file . '.php';
		if ( file_exists( $belise_file_to_include ) ) {
			include_once( $belise_file_to_include );
		}
	}
}
add_action( 'after_setup_theme', 'belise_include_features' );

if ( file_exists( BELISE_PHP_INCLUDE . '/belise-main-events-functions.php' ) ) {
	require_once( BELISE_PHP_INCLUDE . '/belise-main-events-functions.php' );
}

/**
 * Change comments appearance
 *
 * @since Belise 1.0
 */
function belise_comment( $comment, $args, $depth ) {
	if ( 'div' === $args['style'] ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	}
	?>
	<<?php echo esc_attr( $tag ); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
		<div class="comment-author-image">
			<?php
			if ( $args['avatar_size'] != 0 ) {
				echo get_avatar( $comment, $args['avatar_size'] ); }
?>
		</div>
		<div class="comment-author-content">
			<div class="comment-author-title">
				<?php printf( '<cite class="fn">%s</cite>|', get_comment_author_link() ); ?>

				<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
						<?php
						$date_format = get_option( 'date_format' );
						printf( '%1$s', get_comment_date( $date_format ) );
						?>
						</a>
						<?php
						edit_comment_link( esc_html__( '(Edit)', 'belise-lite' ), '  ', '' );
					?>
				</div>

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"> | <?php esc_html_e( 'Your comment is awaiting moderation.', 'belise-lite' ); ?></em>
				<?php endif; ?>
			</div>

			<?php comment_text(); ?>

			<div class="reply">
				<?php
				comment_reply_link(
					array_merge(
						$args, array(
							'add_below' => $add_below,
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
						)
					)
				);
					?>
			</div>

		</div>

	</div>

	<?php if ( 'div' != $args['style'] ) : ?>
		</div>
	<?php endif; ?>
	<?php
}

/**
 * Filter the archive title
 */
function belise_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = get_the_author();
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	}

	return wp_kses_post( $title );
}

add_filter( 'get_the_archive_title', 'belise_archive_title' );

/**
 * Adds inline style from customizer
 *
 * @since Belise 1.0
 */
function belise_inline_style() {
	$header_image = get_header_image();
	$custom_css   = '';

	if ( ! class_exists( 'Belise_Color_Scheme' ) ) {
		$background_color = get_theme_mod( 'background_color' );

		if ( ! empty( $background_color ) ) {
			$custom_css .= '
	        body,
            .front-page-sidebar,
            .front-page-content,
            div.woocommerce-error, 
            div.woocommerce-info, 
            div.woocommerce-message,
            .woocommerce div.woocommerce-upsells-products{
                background-color: #' . $background_color . '
            }';
		}
	}

	if ( ! empty( $header_image ) ) {
		$custom_css .= '
                .hero-image{
	                    background-image: url(' . esc_url( $header_image ) . ');
	            }';
	}

	$belise_header_search_button_hide = get_theme_mod( 'belise_header_search_button_hide' );
	if ( (bool) $belise_header_search_button_hide === true && ! is_customize_preview() ) {
		$custom_css .= '.menu-shopping-cart{ border-left: 1px solid #e1e1e1; }';
	}
	wp_add_inline_style( 'belise-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'belise_inline_style' );


/**
 * Query WooCommerce activation
 */
function belise_woocommerce_activated() {
	return class_exists( 'woocommerce' ) ? true : false;
}

/**
 * Is WooCommerce page
 */
function belise_woocommerce_page() {
	if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
		return true;
	}

	$woocommerce_keys = array(
		'woocommerce_shop_page_id',
		'woocommerce_terms_page_id',
		'woocommerce_cart_page_id',
		'woocommerce_checkout_page_id',
		'woocommerce_pay_page_id',
		'woocommerce_thanks_page_id',
		'woocommerce_myaccount_page_id',
		'woocommerce_edit_address_page_id',
		'woocommerce_view_order_page_id',
		'woocommerce_change_password_page_id',
		'woocommerce_logout_page_id',
		'woocommerce_lost_password_page_id',
	);

	foreach ( $woocommerce_keys as $wc_page_id ) {
		if ( get_the_ID() == get_option( $wc_page_id, 0 ) ) {
			return true;
		}
	}
	return false;
}


/**
 * Filter the front page template so it's bypassed entirely if the user selects to display blog posts on their homepage instead of a static page.
 */
function belise_filter_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template', 'belise_filter_front_page_template' );

/**
 * Is Event Single
 */
function belise_is_single_event() {
	if ( is_singular( 'event' ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Register required plugins
 */
function belise_register_required_plugins() {

	$plugins = array(
		array(
			'name'     => 'Jetpack by WordPress.com',
			'slug'     => 'jetpack',
			'required' => false,
		),
		array(
			'name'     => 'Event Organiser',
			'slug'     => 'event-organiser',
			'required' => false,
		),
	);

	tgmpa( $plugins );

}
add_action( 'tgmpa_register', 'belise_register_required_plugins' );


/**
 * Filter to translate strings
 *
 * @since 1.1.0
 * @access public
 */
function belise_translate_single_string( $original_value, $domain ) {
	if ( is_customize_preview() ) {
		$wpml_translation = $original_value;
	} else {
		$wpml_translation = apply_filters( 'wpml_translate_single_string', $original_value, $domain, $original_value );
		if ( $wpml_translation === $original_value && function_exists( 'pll__' ) ) {
			return pll__( $original_value );
		}
	}
	return $wpml_translation;
}
add_filter( 'belise_translate_single_string', 'belise_translate_single_string', 10, 2 );


/**
 * Filter to remove markup added by jetpack for nova menu
 *
 * @param string       $tag    Menu item's element opening tag.
 * @param string       $field  Menu Item Markup settings field.
 * @param array        $markup Array of markup elements for the menu item.
 * @param false|object $term   Taxonomy term for current menu item.
 *
 * @since 1.1.0
 * @access public
 * @return string
 */
function belise_remove_nova_markup( $tag, $field, $markup, $term ) {
	$term->name = '';
	return '';
}
add_filter( 'jetpack_nova_menu_item_loop_open_element', 'belise_remove_nova_markup', 4, 999 );

