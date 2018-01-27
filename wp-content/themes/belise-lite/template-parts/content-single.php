<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Belise
 */

$belise_date_on_single_hide = get_theme_mod( 'belise_date_on_single_hide' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :

			if ( (bool) $belise_date_on_single_hide === false ) {
			?>
				<div class="entry-meta">
					<?php belise_posted_on(); ?>
				</div><!-- .entry-meta -->
				<?php
			} elseif ( is_customize_preview() ) {
			?>
				<div class="entry-meta"></div>
				<?php
			}

		endif;
		?>
	</header><!-- .entry-header -->

	<?php
	if ( is_single() ) {
		if ( has_post_thumbnail() ) {
			echo '<div class="post-thumbnail">';
			the_post_thumbnail();
			echo '</div>';
		}
	}

	$post_content = get_the_content();
	if ( ! empty( $post_content ) ) {
	?>

		<div class="entry-content">
			<?php
				the_content(
					sprintf(
						wp_kses( /* translators: %s: Name of current post. */
							esc_html__( 'Continue reading %s', 'belise-lite' ), array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					)
				);

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'belise-lite' ),
						'after'  => '</div>',
					)
				);
			?>
		</div><!-- .entry-content -->
	<?php } ?>

	<footer class="entry-footer">
		<?php belise_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
