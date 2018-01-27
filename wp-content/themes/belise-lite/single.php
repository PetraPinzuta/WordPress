<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Belise
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="container single-container">

			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content-single', get_post_format() );
			?>

			</div><!-- .container -->

			<?php do_action( 'belise_author_box_hook' ); ?>

			<div class="single-navigation">
				<div class="container">
					<?php
					the_post_navigation(
						array(
							'prev_text' => esc_html__( 'Prev post', 'belise-lite' ),
							'next_text' => esc_html__( 'Next post', 'belise-lite' ),
						)
					);
					?>
				</div>
			</div>

			<?php
				// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
