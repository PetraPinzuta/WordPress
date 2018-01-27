<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Belise
 */

?>

<div class="col-xs-12 col-sm-6 col-md-4 post-col">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	if ( has_post_thumbnail() ) {
		echo '<div class="post-thumbnail"><a href="' . esc_url( get_permalink() ) . '" title="' . the_title_attribute(
			array(
				'echo' => false,
			)
		) . '">';
		the_post_thumbnail( 'belise-thumbnail' );
		echo '</a></div>';
	}
?>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

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
