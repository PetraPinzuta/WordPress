<?php
/**
 * Template Name: Page with Header
 *
 * Template that displays pages with big header section.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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

					get_template_part( 'template-parts/content', 'page-header' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>

			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
