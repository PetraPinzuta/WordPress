<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Belise
 */

if ( ! function_exists( 'belise_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function belise_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

			$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

			$byline = sprintf( /* translators: %s: author name */
				esc_html_x( 'by %s', 'post author', 'belise-lite' ),
				'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
			);

			echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'belise_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function belise_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* Tags */
			if ( has_tag() ) {
				echo '<div class="tags">';
				the_tags( '<span class="tags-title">' . esc_html__( 'Tags', 'belise-lite' ) . '</span>', ', ', '' );
				echo '</div>';
			}

			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'belise-lite' ) );
			if ( $categories_list && belise_categorized_blog() ) { ?>
				<div class="cat-links 
				<?php
				if ( ! class_exists( 'Jetpack' ) || ! Jetpack::is_module_active( 'sharedaddy' ) || ! has_action( 'belise_sharing_icons' ) ) {
					echo 'fullwidth'; }
?>
">
				<?php
				echo '<span class="cat-links-title">' . esc_html__( 'Posted under', 'belise-lite' ) . '</span>'; //
				// WPCS: XSS OK.
				echo wp_kses_post( $categories_list );
				echo '</div>';
			}

			// Sharing icons
			do_action( 'belise_sharing_icons' );
		}
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function belise_categorized_blog() {
	$all_the_cool_cats = get_transient( 'belise_categories' );
	if ( false === $all_the_cool_cats ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories(
			array(
				'fields'     => 'ids',
				'hide_empty' => 1,
				// We only need to know if there is more than one category.
				'number'     => 2,
			)
		);

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'belise_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so belise_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so belise_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in belise_categorized_blog.
 */
function belise_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'belise_categories' );
}
add_action( 'edit_category', 'belise_category_transient_flusher' );
add_action( 'save_post', 'belise_category_transient_flusher' );

if ( ! function_exists( 'belise_get_author' ) ) :
	/**
	 * Returns the author meta data outside the loop.
	 *
	 * @since belise 1.0
	 */
	function belise_get_author( $info ) {
		global $post;
		$author_id = $post->post_author;
		$author    = get_the_author_meta( $info, $author_id );
		return $author;
	}
endif;

if ( ! function_exists( 'belise_author_box' ) ) :
	/**
	 * Display author box below the posts.
	 *
	 * @since belise 1.0
	 */
	function belise_author_box() {
			$author_first_name  = get_the_author_meta( 'first_name' );
			$author_last_name   = get_the_author_meta( 'last_name' );
			$author_description = wp_kses_post( nl2br( get_the_author_meta( 'description' ) ) );

			$author_name = '';
		if ( ! empty( $author_first_name ) ) {
			$author_name .= sanitize_text_field( $author_first_name ) . ' ';
		}
		if ( ! empty( $author_last_name ) ) {
			$author_name .= sanitize_text_field( $author_last_name );
		}

		if ( ! empty( $author_description ) ) {
			?>
			<div class="author vcard" itemscope="itemscope" itemtype="http://schema.org/Person" itemprop="author">
				<div class="container author-container">
					<div class="author-image" itemprop="image">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), '145' ); ?>
					</div>
					<div class="author-content">
						<?php
						if ( ! empty( $author_name ) ) {
							echo '<div class="author-title">';
							echo '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( $author_name ) . '" class="author-name" itemprop="name">' . esc_html( $author_name ) . '</a>';
							echo ' - ' . esc_html__( 'Post Author', 'belise-lite' );
							echo '</div>';
						}
?>

						<?php
						if ( ! empty( $author_description ) ) { // Description
							echo '<p class="author-description" itemprop="description">' . wp_kses_post( $author_description ) . '</p>';
						}
?>

											</div>
				</div>
			</div><!-- .author -->
		<?php
		}// End if().
	}

	add_action( 'belise_author_box_hook', 'belise_author_box' );
endif;


if ( ! function_exists( 'belise_comments_template' ) ) :
	/**
	 * Custom list of comments for the theme.
	 *
	 * @since belise 1.0
	 */
	function belise_comments_template() {
		$req       = get_option( 'require_name_email' );
		$aria_req  = ( $req ? " aria-required='true'" : '' );
		$commenter = wp_get_current_commenter();
		$args      = array(
			'title_reply'          => esc_html__( 'Leave your reply', 'belise-lite' ),
			'comment_notes_before' => '',
			'class_submit'         => 'btn btn-primary pull-right',
			'title_reply_before'   => '<h3>',
			'title_reply_after'    => '</h3>',
			'label_submit'         => esc_html__( 'Submit', 'belise-lite' ),
			'fields'               => apply_filters(
				'comment_form_default_fields', array(
					'author' =>
					'<p class="comment-form-author"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
					'" size="30" placeholder="' . esc_attr__( 'Name', 'belise-lite' ) . ( $req ? ' *' : '' ) . '
					"' . esc_html( $aria_req ) . ' /></p>',

					'email'  =>
					'<p class="comment-form-email"><input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .
					'" size="30" placeholder="' . esc_attr__( 'Email', 'belise-lite' ) . ( $req ? ' *' : '' ) . ' "' .
					esc_html( $aria_req ) . ' /></p>',

					'url'    =>
					'<p class="comment-form-url">' .
					'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
					'" placeholder="' . esc_attr__( 'Website', 'belise-lite' ) . '" /></p>',
				)
			),
			'comment_field'        => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="15" placeholder="' . esc_html__( 'Comment', 'belise-lite' ) . '" aria-required="true"></textarea></p>',
		);
		return $args;
	}
endif;

/**
 * Display phone number in header
 *
 * @since belise 1.0
 */
function belise_phone_number() {
	if ( current_user_can( 'edit_theme_options' ) ) {
		$belise_contact_phone = get_theme_mod( 'belise_contact_phone', sprintf( '<a href="' . admin_url( 'customize.php?autofocus[control]=belise_contact_phone' ) . '">%s</a>', esc_html__( 'Edit the phone number in Customizer', 'belise-lite' ) ) );
	} else {
		$belise_contact_phone = get_theme_mod( 'belise_contact_phone', '' );
	}

	if ( ! empty( $belise_contact_phone ) ) :
		echo '<span class="bar-contact">' . wp_kses_post( $belise_contact_phone ) . '</span>';
	elseif ( is_customize_preview() ) :
		echo '<span class="bar-contact only-customizer"><a href=""></a></span>';
	endif;
}

/**
 * Display hero content
 *
 * @since belise 1.0
 */
function belise_hero_content() {
	if ( is_single() ) {
		return;
	}
	/* Current page ID */
	$belise_hero_id = get_the_ID();
	/* Link to main content of the page */
	$belise_hero_link = apply_filters( 'belise_hero_link', '#content', get_the_ID() );
	/* Size of the hero container */
	$belise_hero_size = 'small-hero';
	/* Main title in hero container */
	$belise_hero_title = get_the_title();
	/* Current page type */
	$belise_hero_type = 'page';
	/* Check if hero has arrow to content or not */
	$belise_hero_arrow = true;
	/* Current page image */
	$belise_hero_image = get_the_post_thumbnail_url( get_the_ID(), 'belise-hero-image' );
	/* Before title Text */
	$belise_hero_before_title       = '';
	$belise_hero_before_title_class = '';

	switch ( true ) {
		/* latest posts */
		case ( is_home() && ( 'posts' == get_option( 'show_on_front' ) ) ):
			$belise_hero_image = 'none';
			$belise_hero_title = get_bloginfo( 'description', 'display' );
			$belise_hero_type  = 'latest-posts';
			$belise_hero_arrow = false;
			break;
		/* blog page */
		case ( is_home() && ( 'page' == get_option( 'show_on_front' ) ) ):
			$belise_hero_id    = get_option( 'page_for_posts' );
			$belise_hero_title = get_the_title( $belise_hero_id );
			$belise_hero_type  = 'blog-page';
			$belise_hero_image = get_the_post_thumbnail_url( $belise_hero_id, 'belise-hero-image' );
			$belise_hero_arrow = false;
			$stored_meta       = get_post_meta( $belise_hero_id );
			if ( isset( $stored_meta['text-before-title'] ) ) {
				$belise_hero_before_title = $stored_meta['text-before-title'][0];
			}
			break;
		/* frontpage */
		case is_front_page():
			$belise_hero_type = 'frontpage';
			$belise_hero_size = 'big-hero front-page-hero';
			break;
		/* Shop page */
		case ( class_exists( 'WooCommerce' ) && is_shop() ):
			if ( function_exists( 'wc_get_page_id' ) ) {
				$belise_hero_id = wc_get_page_id( 'shop' );
				if ( ! empty( $belise_hero_id ) ) {
					$belise_hero_image = get_the_post_thumbnail_url( $belise_hero_id, 'belise-hero-image' );
				}
			}
			$belise_hero_type  = 'shop-page';
			$belise_hero_size  = 'big-hero';
			$belise_hero_title = belise_woocommerce_page_title( false );
			$stored_meta       = get_post_meta( $belise_hero_id );
			if ( isset( $stored_meta['text-before-title'] ) ) {
				$belise_hero_before_title = $stored_meta['text-before-title'][0];
			}
			break;
		/* Taxonomy archive for nova menu cpt */
		case is_tax( 'nova_menu' ):
			$belise_hero_title = single_term_title( '', false );
			$belise_hero_arrow = false;
			$belise_hero_type  = 'archive-page';
			$belise_tax_id     = get_queried_object_id();

			if ( ! empty( $belise_tax_id ) ) {

				$term_meta = get_option( "taxonomy_$belise_tax_id" );
				if ( ! empty( $term_meta ) && isset( $term_meta['before_title_meta'] ) ) {
					$belise_hero_before_title = $term_meta['before_title_meta'];
				}

				$belise_tax_meta = get_term_meta( $belise_tax_id );
				if ( ! empty( $belise_tax_meta ) ) {
					if ( ! empty( $belise_tax_meta['category-image-id'] ) ) {
						if ( ! empty( $belise_tax_meta['category-image-id'][0] ) ) {
							$belise_hero_id = $belise_tax_meta['category-image-id'][0];
						}
					}
				}
			}
			if ( ! empty( $belise_hero_id ) ) {
				$belise_hero_image = wp_get_attachment_url( $belise_hero_id, 'belise-hero-image' );
			}

			$belise_hero_before_title_class = 'supra-title-nova-menu';
			break;
		/* Archive page */
		case is_archive():
			$belise_hero_title = get_the_archive_title();
			$belise_hero_arrow = false;
			$belise_hero_type  = 'archive-page';

			$belise_tax_id = get_queried_object_id();

			if ( ! empty( $belise_tax_id ) ) {
				$belise_tax_meta = get_term_meta( $belise_tax_id );
				if ( ! empty( $belise_tax_meta ) ) {
					if ( ! empty( $belise_tax_meta['category-image-id'] ) ) {
						if ( ! empty( $belise_tax_meta['category-image-id'][0] ) ) {
							$belise_hero_id = $belise_tax_meta['category-image-id'][0];
						}
					}
				}
			}
			if ( ! empty( $belise_hero_id ) ) {
				$belise_hero_image = wp_get_attachment_url( $belise_hero_id, 'belise-hero-image' );
			}

			if ( class_exists( 'WooCommerce' ) && is_product_category() ) {

				$belise_tax_id = get_queried_object_id();
				if ( ! empty( $belise_tax_id ) ) {
					$term_meta    = get_option( "taxonomy_$belise_tax_id" );
					$thumbnail_id = get_term_meta( $belise_tax_id, 'thumbnail_id', true );

					if ( ! empty( $term_meta ) && isset( $term_meta['before_title_meta'] ) ) {
						$belise_hero_before_title = $term_meta['before_title_meta'];
					}

					if ( ! empty( $thumbnail_id ) ) {
						$product_category_image = wp_get_attachment_url( $thumbnail_id );
						if ( ! empty( $product_category_image ) ) {
							$belise_hero_image = $product_category_image;
						}
					}
				}

				$belise_hero_before_title_class = 'supra-title-shop';
			}
			break;
		/* Default page template */
		case is_page_template( 'template-with-header.php' ) || is_page_template( 'template-full-width.php' ) || is_page_template( 'template-main-events.php' ):
			$page_id     = get_the_ID();
			$stored_meta = get_post_meta( $page_id );
			if ( isset( $stored_meta['text-before-title'] ) ) {
				$belise_hero_before_title = $stored_meta['text-before-title'][0];
			}

			$belise_hero_size = 'big-hero';
			break;
		/* Search page */
		case is_search():
			/* translators: %s: search query */
			$belise_hero_title = sprintf( esc_html__( 'Search Results for: %s', 'belise-lite' ), '<span>' . get_search_query() . '</span>' );
			$belise_hero_type  = 'search-page';
			$belise_hero_arrow = false;
			break;
		/* 404 page */
		case is_404():
			$belise_hero_title = esc_html__( 'Oops! That page can&rsquo;t be found.', 'belise-lite' );
			$belise_hero_type  = '404-page';
			$belise_hero_arrow = false;
			break;
	}// End switch().

	if ( ( $belise_hero_type !== 'page' ) || ( ( $belise_hero_type == 'page' ) && is_page_template( 'template-with-header.php' ) ) || ( is_page_template( 'template-full-width.php' ) && ( $belise_hero_type == 'page' ) ) || ( is_page_template( 'template-main-events.php' ) && ( $belise_hero_type == 'page' ) ) ) {

		if ( $belise_hero_type !== 'frontpage' ) {
			?>
			<div id="hero">
				<?php
				if ( is_customize_preview() ) {
				?>
					<div class="big-title-css"></div>
					<?php
				}
				?>
				<div class="hero-content <?php echo esc_attr( $belise_hero_size ); ?>">
					<div class="container">
						<?php
						if ( is_front_page() && is_home() ) {
							$frontpage_hero_title_class = 'front-page-title';
						} else {
							$frontpage_hero_title_class = '';
						}
						/* Supra-title */
						if ( ! empty( $belise_hero_before_title ) ) {
							echo '<h5 class="' . esc_attr( $belise_hero_before_title_class ) . '">' . wp_kses_post( $belise_hero_before_title ) . '</h5>';
						}

						/* Hero title */
						if ( ! empty( $belise_hero_title ) && display_header_text() ) {
							echo '<h1 class="hero-title ' . esc_attr( $frontpage_hero_title_class ) . '">' . wp_kses_post( $belise_hero_title ) . '</h1>';
						} else {
							echo '<h1 class="hero-title ' . esc_attr( $frontpage_hero_title_class ) . '">' . esc_html__( 'Blog', 'belise-lite' ) . '</h1>';
						}
						/* Hero arrow */
						if ( $belise_hero_arrow ) {
							echo '<a href="' . esc_url( $belise_hero_link ) . '" class="hero-btn"><i class="fa fa-angle-down" aria-hidden="true"></i></a>';
						}
						?>
					</div>
				</div><!-- .hero-content -->
				<?php
				/* Hero image */
				if ( $belise_hero_type !== 'frontpage' ) {
					if ( ! empty( $belise_hero_image ) && ( $belise_hero_image != 'none' ) ) {
						?>
						<div class="hero-image" style="background: url(<?php echo esc_url( $belise_hero_image ); ?>); background-size: cover; background-position: center center;"></div>
							<?php
					} else {
						echo '<div class="hero-image"></div>';
					}
				}
				?>
			</div><!-- #hero -->
			<?php
		} else {
			/* Hero for Static Frontpage */
			do_action( 'belise_front_page_hero' );
		}// End if().
	}// End if().
}


/**
 * Display categories menu
 *
 * @since belise 1.0
 */
function belise_categories_menu() {
	if ( has_nav_menu( 'categories' ) && ( is_single() || is_category() || is_home() ) && ! belise_woocommerce_page() && ! belise_is_single_event() ) {
	?>

		<div class="categories">
			<div class="container">
				<div class="row">
					<div class="categories-menu-toggle">
						<button class="menu-toggle" aria-controls="categories-menu" aria-expanded="false">
							<?php echo esc_html__( 'Post categories +', 'belise-lite' ); ?>
						</button>
					</div>
					<nav id="categories-menu" class="categories-navigation site-navigation">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'categories',
							'menu_id'        => 'categories-menu',
							'depth'          => 1,
						)
					);
						?>
				</nav><!-- .categories -->
				</div>
			</div>
		</div>
	<?php
	}

	if ( has_nav_menu( 'shop' ) && belise_woocommerce_activated() && belise_woocommerce_page() ) {
	?>

		<div class="categories">
			<div class="container">
				<div class="row">
					<div class="categories-menu-toggle">
						<button class="menu-toggle" aria-controls="categories-menu" aria-expanded="false">
							<?php echo esc_html__( 'Shop menu +', 'belise-lite' ); ?>
						</button>
					</div>
					<nav id="categories-menu" class="categories-navigation site-navigation">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'shop',
								'menu_id'        => 'categories-menu',
								'depth'          => 1,
							)
						);
							?>
					</nav><!-- .categories -->
				</div>
			</div>
		</div>
<?php
	}
}

/**
 * Display footer widgets
 *
 * @since belise 1.0
 */
function belise_footer_widgets() {
	if ( is_active_sidebar( 'footer_widget_col_1' ) || is_active_sidebar( 'footer_widget_col_2' ) || is_active_sidebar( 'footer_widget_col_3' ) ) :
	?>
		<div class="container">
			<div class="row footer-widgets">
				<?php if ( is_active_sidebar( 'footer_widget_col_1' ) ) : ?>
					<div class="col-sm-12 col-md-4">
						<?php dynamic_sidebar( 'footer_widget_col_1' ); ?>
					</div>
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'footer_widget_col_2' ) ) : ?>
					<div class="col-sm-12 col-md-4">
						<?php dynamic_sidebar( 'footer_widget_col_2' ); ?>
					</div>
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'footer_widget_col_3' ) ) : ?>
					<div class="col-sm-12 col-md-4">
						<?php dynamic_sidebar( 'footer_widget_col_3' ); ?>
					</div>
				<?php endif; ?>
			</div> <!-- .footer-widgets -->
		</div>
	<?php
	endif;
}

/**
 * Display ribbon widget
 *
 * @since belise 1.0
 */
function belise_ribbon_widget() {
	if ( is_active_sidebar( 'ribbon_area' ) && ! is_page_template( 'template-full-width.php' ) ) :
		?>
		<section class="ribbon-sidebar">
				<?php dynamic_sidebar( 'ribbon_area' ); ?>
		</section>
	<?php
	endif;
}

/**
 * Display e-mail address in footer
 *
 * @since belise 1.0
 */
function belise_email_address() {
	if ( current_user_can( 'edit_theme_options' ) ) {
		$belise_contact_email = get_theme_mod(
			'belise_contact_email', sprintf(
				'<a href="' . admin_url( 'customize.php?autofocus[control]=belise_contact_email' ) . '">%s</a>', esc_html__( 'Edit the email address in Customizer', 'belise-lite' )
			)
		);
	} else {
		$belise_contact_email = get_theme_mod( 'belise_contact_email', '' );
	}

	if ( ! empty( $belise_contact_email ) ) :
		echo '<span class="bar-contact">' . wp_kses_post( $belise_contact_email ) . '</span>';
	elseif ( is_customize_preview() ) :
		echo '<span class="bar-contact only-customizer"><a href=""></a></span>';
	endif;
}


/**
 * Front page after content sidebar
 *
 * @since belise 1.0
 */
function belise_front_page_events() {
	if ( is_active_sidebar( 'events_area' ) ) {
	?>
		<section class="sidebar front-page-sidebar">
			<div class="container">
				<div class="row">
					<?php dynamic_sidebar( 'events_area' ); ?>
				</div>
			</div>
		</section>
	<?php
	} elseif ( current_user_can( 'edit_theme_options' ) ) {
	?>
		<section class="sidebar front-page-sidebar customizer-admin-only">
			<div class="container">
				<div class="row">
					<?php echo '<a href="' . admin_url( 'customize.php?autofocus[section]=sidebar-widgets-events_area' ) . '">' . esc_html__( 'Customize this section by adding widgets in the Events area', 'belise-lite' ) . '</a>'; ?>
				</div>
			</div>
		</section>
	<?php
	}
}

/**
 * Related food menus
 *
 * @since belise 1.0
 */
function belise_related_food_menus() {
	global $post;

	if ( ! empty( $post ) ) {
		$currenttax = wp_get_post_terms( $post->ID, 'nova_menu' );
	}

	// Get list of related categories that you want to display
	$belise_tax_id = get_queried_object_id();
	if ( ! empty( $belise_tax_id ) ) {
		$term_meta = get_option( "taxonomy_$belise_tax_id" );
		if ( ! empty( $term_meta ) && isset( $term_meta['related_categories'] ) ) {
			$belise_menu_related = $term_meta['related_categories'];
			if ( $belise_menu_related[0] === 'none' ) {
				return;
			}
		}
	}

	if ( ! empty( $currenttax ) ) {
		?>
		<section class="related-food-menus">
			<div class="container">
				<div class="row">
					<?php

					if ( taxonomy_exists( 'nova_menu' ) ) {
						$args = array(
							'taxonomy' => 'nova_menu',
							'exclude'  => $currenttax[0]->term_id,
							'number'   => 0,
						);
						if ( ! empty( $belise_menu_related ) ) {
							$term_ids = array();
							foreach ( $belise_menu_related as $menu ) {
								$term = get_term_by( 'slug', $menu, 'nova_menu' );
								array_push( $term_ids, $term->term_id );
							}
							if ( ! empty( $term_ids ) ) {
								$args['include'] = $term_ids;
							}
						}
						$menus = get_terms( $args );
					}

					if ( ! empty( $menus ) ) {

						foreach ( $menus as $menu ) {

							if ( ! empty( $menu ) ) {

					?>

						<div class="col-sm-12 col-md-4 col-lg-4 food-menu">
							<div class="food-menu-container">
								<?php if ( ! empty( $menu->name ) ) { ?>
									<div class="food-menu-content">
										<?php
										echo '<div><span class="food-menu-title">' . esc_html( $menu->name ) . '</span></div><a href="' . esc_attr( get_term_link( $menu, 'nova_menu' ) ) . '" 
			title="' . esc_attr__( 'See menu', 'belise-lite' ) . '">
			' . esc_html__( 'See menu', 'belise-lite' ) . '</a>';
?>
									</div>
									<?php
}

if ( ! empty( $menu->term_id ) ) {
	$meta = get_term_meta( $menu->term_id );

	if ( ! empty( $meta['category-image-id'][0] ) ) {
		$image = wp_get_attachment_url( $meta['category-image-id'][0] );
		if ( ! empty( $image ) ) {
			echo '<div class="food-menu-image" style="background: url(' . esc_url( $image ) . '); background-size:cover"></div>';
		}
	}
}

								echo '</div></div>';
							}
						}
					}
						?>
						</div>
					</div>
		</section>
		<?php
	}// End if().
}

if ( ! function_exists( 'belise_event_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the events
	 */
	function belise_event_entry_footer() {
		if ( 'event' === get_post_type() ) {
			/* Tags */
			$eventtags = get_the_terms( get_the_ID(), 'event-tag' );

			if ( ! empty( $eventtags ) || ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'sharedaddy' ) ) ) {
			?>
				<footer class="entry-footer event-footer">
				<?php
				if ( ! empty( $eventtags ) ) {
				?>
				<div class="tags">
					<span class="tags-title"><?php echo esc_html__( 'Tags', 'belise-lite' ); ?></span>
					<?php the_terms( get_the_ID(), 'event-tag' ); ?>
				</div>
				<?php
				}

				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( esc_html__( ', ', 'belise-lite' ) );
				if ( $categories_list && belise_categorized_blog() ) {
				?>
				<div class="cat-links 
				<?php
				if ( ! class_exists( 'Jetpack' ) || ! Jetpack::is_module_active( 'sharedaddy' ) ) {
					echo 'fullwidth'; }
?>
">
					<?php
					echo '<span class="cat-links-title">' . esc_html__( 'Posted under', 'belise-lite' ) . '</span>'; //
					// WPCS: XSS OK.
					echo wp_kses_post( $categories_list );
					echo '</div>';
				}

				// Sharing icons
				do_action( 'belise_sharing_icons' );

				?>
			</footer>
			<?php
			}
		}
	}
endif;
