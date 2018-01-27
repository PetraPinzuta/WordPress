<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Belise
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="container posts-container">
				<div class="row">

					<?php
					if ( have_posts() ) :

						if ( is_home() && ! is_front_page() ) :
						?>
							<header>
								<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
							</header>

							<?php
						endif;

						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
							get_template_part( 'template-parts/content', get_post_format() );

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
	</div><!-- #primary -->

<?php
get_footer();
