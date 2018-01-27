<?php
/**
 * The template for displaying archive events.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Belise
 */

get_header();
?>
	<div class="events-archive 
	<?php
	if ( ! have_posts() ) {
		echo 'no-events';}
?>
">
		<div class="container">
			<div class="row">
				<ul>
					<?php
					if ( have_posts() ) :
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content-event-archive', get_post_format() );
						endwhile;
					else :
						get_template_part( 'template-parts/content', 'none' );
					endif;
					?>
				</ul>
			</div>
		</div>
	</div>

<?php if ( $wp_query->max_num_pages > 1 ) { ?>
	<div class="events-archive-pagination">
		<div class="container">
			<div class="row">
				<?php
				the_posts_pagination(
					array(
						'prev_text' => esc_html__( 'Prev page', 'belise-lite' ),
						'next_text' => esc_html__( 'Next page', 'belise-lite' ),
					)
				);
				?>
			</div>
		</div>
	</div>
	<?php
}
get_footer();
