<?php
/**
 * The template for displaying all single events.
 *
 * @package Belise
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="container single-container">

				<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/content-event', get_post_format() );
				}
				?>

			</div><!-- .container -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
