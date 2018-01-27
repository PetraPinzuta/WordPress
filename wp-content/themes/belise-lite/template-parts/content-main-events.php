<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Belise
 */

?>

<div class="col-xs-12 col-sm-12 col-md-4 post-col">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php
		if ( has_post_thumbnail() ) {
			echo '<div class="post-thumbnail"><a href="' . esc_url( get_the_permalink() ) . '" >';
			the_post_thumbnail( 'belise-post-image' );
			echo '</a></div>';
		}
?>
		<header class="entry-header">
			<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
			?>

			<?php if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php belise_posted_on(); ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<?php
		$content_excerpt = wp_strip_all_tags( strip_shortcodes( get_the_content() ) );
		if ( has_excerpt() || ! empty( $content_excerpt ) ) {
			?>
			<div class="entry-content">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->
		<?php } ?>

	</article><!-- #post-## -->
</div>
