<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Belise
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="container posts-container">
				<div class="row posts-row">
				<?php
				if ( have_posts() ) :
				?>

					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', 'search' );

					endwhile;

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
				</div><!-- .row -->

				<?php
				the_posts_pagination(
					array(
						'prev_text' => esc_html__( 'Prev page', 'belise-lite' ),
						'next_text' => esc_html__( 'Next page', 'belise-lite' ),
					)
				);
				?>

			</div><!-- .container -->
		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
