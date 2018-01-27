<?php
/**
 * Template part for displaying food menu items.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Belise
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
	</header><!-- .entry-header -->

	<?php
	if ( has_post_thumbnail() ) {
		echo '<div class="post-thumbnail">';
		the_post_thumbnail();
		echo '</div>';
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
		?>
	</div><!-- .entry-content -->
	<?php } ?>

	<footer class="entry-footer">
		<?php
		if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'sharedaddy' ) ) {
			echo '<div class="share">';

			if ( function_exists( 'sharing_display' ) ) {
				sharing_display( '', true );
			}

			if ( class_exists( 'Jetpack_Likes' ) ) {
				$custom_likes = new Jetpack_Likes;
				echo $custom_likes->post_likes( '' );
			}

			echo '</div>';
		}
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
