<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Belise
 */

?>

<div class="col-sm-12">
	<section class="no-results not-found">
		<div class="page-content">
			<?php
			if ( is_home() && current_user_can( 'publish_posts' ) ) :
			?>
				<p>
				<?php
					/* translators: 1: link href, 2: link title  */
					printf( esc_html__( 'Ready to publish your first post? %s.', 'belise-lite' ), sprintf( '<a href="%1$s">%2$s</a>', esc_url( admin_url( 'post-new.php' ) ), esc_html__( 'Get started here', 'belise-lite' ) ) );
					?>
					</p>

			<?php elseif ( is_search() ) : ?>

				<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'belise-lite' ); ?></p>
				<?php
					get_search_form();

			else :
			?>

				<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'belise-lite' ); ?></p>
				<?php
					get_search_form();

			endif;
			?>
		</div><!-- .page-content -->
	</section><!-- .no-results -->
</div>
