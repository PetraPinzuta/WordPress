<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package belise
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function belise_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'belise_body_classes' );


/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function belise_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
	}
}
add_action( 'wp_head', 'belise_pingback_header' );


/**
 * Return the site brand
 *
 * @since Belise 1.0
 */
function belise_brand() {
	if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {

		the_custom_logo();

	} else {

		if ( is_customize_preview() ) {  ?>

			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link only-customizer" title="<?php echo esc_attr( get_bloginfo( 'title' ) ); ?>">
				<img src="">
			</a>

			<?php
		}

		if ( is_front_page() && is_home() ) :
		?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php else : ?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
		endif;

	}
}


/**
 * Display the search icon
 *
 * @since Belise 1.0
 * @updated 1.1.0
 */
function belise_search_icon() {
	$belise_header_search_button_hide = get_theme_mod( 'belise_header_search_button_hide' );
	if ( (bool) $belise_header_search_button_hide === false ) {
		if ( is_customize_preview() ) {
		?>
			<style>
				.custom-search-in-header{ border-right: none; height: 48px; width: initial;
					float: left; }
			</style>
			<?php
		}
		?>
		<div class="custom-search-in-header">
			<?php get_search_form(); ?>
		</div>
		<?php
	} elseif ( is_customize_preview() ) {
	?>
		<style>
			.custom-search-in-header{ border-right: 1px solid #e1e1e1; height: 48px; width: 1px;
				float: left; }
		</style>
		<div class="custom-search-in-header"></div>
		<?php
	}
}


/**
 * Replacing sharing buttons
 *
 * @since Belise 1.0
 */
function belise_move_sharing_buttons() {
	remove_filter( 'the_content', 'sharing_display', 19 );
	remove_filter( 'the_excerpt', 'sharing_display', 19 );
	if ( class_exists( 'Jetpack_Likes' ) ) {
		remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30 );
	}
}
add_action( 'loop_start', 'belise_move_sharing_buttons' );


/**
 * Move comment field above user details.
 *
 * @since Belise 1.0
 */
function belise_comment_message( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter( 'comment_form_fields', 'belise_comment_message' );


/**
 * Control excerpt length
 *
 * @since belise 1.0
 */
function belise_excerpt_length( $length ) {
	return 15;
}

add_filter( 'excerpt_length', 'belise_excerpt_length', 999 );


/**
 * More excerpt string
 *
 * @param string $more More string excerpt.
 *
 * @return string
 */
function belise_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'belise_excerpt_more' );


/**
 * Remove featured image from events
 */
function belise_remove_event_featured_image() {
	remove_meta_box( 'postimagediv', 'event', 'side' );
}
add_action( 'do_meta_boxes', 'belise_remove_event_featured_image' );

/**
 * Change jetpack portfolio thumbnail size.
 *
 * @return string
 */
function belise_jetpack_portfolio_image_size() {
	return 'belise-jetpack-portfolio-thumbnail';
}
add_filter( 'jetpack_portfolio_thumbnail_size', 'belise_jetpack_portfolio_image_size' );

/**
 * Change jetpack testimonials thumbnail size.
 *
 * @return string
 */
function belise_jetpack_testimonial_image_size() {
	return 'belise-jetpack-testimonial-thumbnail';
}
add_filter( 'jetpack_testimonial_thumbnail_size', 'belise_jetpack_testimonial_image_size' );


/**
 * Filter options of belise_menus_section_categories customizer control to add Random option
 *
 * @param array $input Control input.
 * @since 1.1.0
 * @access public
 * @return array
 */
function belise_categories_choices( $input ) {
	$input['random'] = esc_html__( 'Random', 'belise-lite' );
	return $input;
}
add_filter( 'belise_multiple_choice_belise_menus_section_categories', 'belise_categories_choices' );
