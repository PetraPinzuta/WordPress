<?php
/**
 * Big title section for the front page
 *
 * @package WordPress
 * @since Belise 1.0
 */

if ( ! function_exists( 'belise_front_page_hero' ) ) :

	/**
	 * Big title section
	 */
	function belise_front_page_hero() {

		$default                 = current_user_can( 'edit_theme_options' ) ? sprintf( '<p><a href="' . admin_url( 'customize.php?autofocus[control]=belise_front_page_title' ) . '">%s</a></p>', esc_html__( 'Edit this text in Customizer', 'belise-lite' ) ) : false;
		$belise_front_page_title = get_theme_mod( 'belise_front_page_title', $default );

		$default                       = current_user_can( 'edit_theme_options' ) ? esc_html__( 'Change button text in Front Page', 'belise-lite' ) : false;
		$belise_front_page_button_text = get_theme_mod( 'belise_front_page_button_text', $default );

		$default                       = current_user_can( 'edit_theme_options' ) ? admin_url( 'customize.php?autofocus[control]=belise_front_page_button_text' ) : false;
		$belise_front_page_button_link = get_theme_mod( 'belise_front_page_button_link', $default );

		$section_is_empty = empty( $belise_front_page_title ) && empty( $belise_front_page_image ) && empty( $belise_front_page_button_text ) && empty( $belise_front_page_button_link );

		if ( ! $section_is_empty ) { ?>
			<div id="hero">
				<?php
				if ( is_customize_preview() ) {
				?>
					<div class="big-title-css"></div>
					<?php
				}
				?>
				<div class="hero-content big-hero front-page-hero">
					<div class="container">

						<div class="hero-title-container">
							<?php
							if ( ! empty( $belise_front_page_title ) ) :
								echo '<div class="front-page-title">' . wp_kses_post( $belise_front_page_title ) . '</div>';
							elseif ( is_customize_preview() ) :
								echo '<div class="front-page-title only-customizer"></div>';
							endif;
							?>
						</div>

						<div class="hero-btn-container">
							<?php
							if ( ! empty( $belise_front_page_button_text ) && ! empty( $belise_front_page_button_link ) ) :
								echo '<a href="' . esc_url( $belise_front_page_button_link ) . '">' . esc_html( $belise_front_page_button_text ) . '</a>';
							endif;
							?>
						</div>
					</div><!-- .container -->
				</div><!-- .hero-content big-hero front-page-hero -->
				<div class="front-page-hero-background">
					<?php

					if ( current_user_can( 'edit_theme_options' ) ) {
						$belise_front_page_image = get_theme_mod( 'belise_front_page_image', get_template_directory_uri() . '/img/front-page-hero-image.jpg' );
					} else {
						$belise_front_page_image = get_theme_mod( 'belise_front_page_image' );
					}
					if ( ! empty( $belise_front_page_image ) ) {
						echo '<div class="front-page-hero-image" style="background-image: url(' . esc_url( $belise_front_page_image ) . ')"></div>';
					}

					?>
				</div>
			</div><!-- #hero -->
			<?php
		}// End if().
	}
endif;

if ( function_exists( 'belise_front_page_hero' ) ) {
	add_action( 'belise_front_page_hero', 'belise_front_page_hero' );
}
