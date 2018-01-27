<?php
/**
 * Content for the front page
 *
 * @package WordPress
 * @since Belise 1.0
 */

if ( ! function_exists( 'belise_front_page_content' ) ) {

	/**
	 * Front page content
	 *
	 * @since belise 1.0
	 */
	function belise_front_page_content() {
		$page_id      = get_the_ID();
		$page_content = get_post_field( 'post_content', $page_id );
		if ( empty( $page_content ) ) {
			return;
		} ?>

		<section class="front-page-content">
			<div class="container">
				<div class="row">
					<?php
					// Show the selected frontpage content
					if ( have_posts() ) :
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content', 'frontpage' );
						endwhile;
					endif;
					?>
				</div>
			</div>
		</section>

	<?php
	}
}// End if().

if ( function_exists( 'belise_front_page_content' ) ) {
	add_action( 'belise_front_page_content', 'belise_front_page_content' );
}
