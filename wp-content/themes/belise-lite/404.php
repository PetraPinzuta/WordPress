<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Belise
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'belise-lite' ); ?></p>
						<?php get_search_form(); ?>

					</div>
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
