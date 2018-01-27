<?php
/**
 * Related food menus for the front page
 *
 * @package WordPress
 * @since Belise 1.0
 */

if ( ! function_exists( 'belise_front_page_menus' ) ) {
	/**
	 * Front page working hours & menu
	 *
	 * @since belise 1.0
	 */
	function belise_front_page_menus() {

		if ( taxonomy_exists( 'nova_menu' ) ) {

			$belise_menus_section_categories = get_theme_mod( 'belise_menus_section_categories' );

			if ( ! empty( $belise_menus_section_categories ) && ( ! in_array( 'none', $belise_menus_section_categories ) ) ) {
				$menus = array();
				foreach ( $belise_menus_section_categories as $category ) {
					array_push( $menus, $category );
				}
			}
		}

		$default                          = current_user_can( 'edit_theme_options' ) ?
			sprintf(
				'<a href="' . admin_url( 'customize.php?autofocus[control]=belise_front_page_schedule_title' ) . '" class="customizer-admin-only">%s</a>',
				esc_html__( 'Change schedule title in Front Page', 'belise-lite' )
			) :
			false;
		$belise_front_page_schedule_title = get_theme_mod( 'belise_front_page_schedule_title', $default );

		$default                            = current_user_can( 'edit_theme_options' ) ?
			sprintf(
				'<a href="' . admin_url( 'customize.php?autofocus[control]=belise_front_page_schedule_content' ) . '" class="customizer-admin-only">%s</a>',
				esc_html__( 'Change schedule content in Front Page', 'belise-lite' )
			) :
			false;
		$belise_front_page_schedule_content = get_theme_mod( 'belise_front_page_schedule_content', $default );

		$section_is_empty = empty( $belise_front_page_schedule_title ) && empty( $belise_front_page_schedule_content ) && empty( $menus );
		if ( ! $section_is_empty ) { ?>
			<section class="front-page-after-content">
				<div class="container">

					<?php
					if ( ! empty( $belise_front_page_schedule_title ) ) {
					?>
						<div class="row">
							<div class="operation-hours-inner">
								<div class="operation-hours-title">
									<?php
									echo wp_kses_post( $belise_front_page_schedule_title );
									?>
								</div>
							</div>
						</div>
						<?php
					} elseif ( is_customize_preview() ) {
					?>
						<div class="row">
							<div class="operation-hours-inner">
								<div class="operation-hours-title only-customizer"></div>
							</div>
						</div>
						<?php
					}

					if ( ! empty( $belise_front_page_schedule_content ) ) {
					?>
						<div class="row">
							<div class="operation-hours-inner">
								<div class="operation-hours-content">
									<?php
									echo apply_filters( 'belise_text', $belise_front_page_schedule_content );
									?>
								</div>
							</div>
						</div>
						<?php
					} elseif ( is_customize_preview() ) {
					?>
						<div class="row">
							<div class="operation-hours-inner">
								<div class="operation-hours-content only-customizer"></div>
							</div>
						</div>
						<?php
					}

					if ( ! empty( $menus ) ) {
					?>
						<div class="row belise-menu-content">
							<?php belise_menus_content(); ?>
						</div>
						<?php
					} elseif ( is_customize_preview() ) {
					?>
						<div class="row belise-menu-content"></div>
						<?php
					}
					?>
				</div>
			</section>
			<?php
		}// End if().
	}
}// End if().
if ( function_exists( 'belise_front_page_menus' ) ) {
	add_action( 'belise_front_page_content', 'belise_front_page_menus', 10 );
}

/**
 * Display menus content.
 */
function belise_menus_content() {
	$lang = '';

	if ( ! is_customize_preview() && function_exists( 'pll_current_language' ) ) {
		$lang = pll_current_language();
	}

	if ( taxonomy_exists( 'nova_menu' ) ) {

		$belise_menus_section_categories = get_theme_mod( 'belise_menus_section_categories', 'none' );
		$menus                           = array();

		$all_cats = belise_get_food_sections( true, $lang );
		if ( ! empty( $belise_menus_section_categories ) && in_array( 'random', $belise_menus_section_categories ) ) {

			$max_rand_cat = apply_filters( 'belise_max_rand_cat', 4 );
			unset( $all_cats['none'] );
			$count = count( $all_cats );
			if ( $count > $max_rand_cat ) {
				$count = $max_rand_cat;
			}
			if ( $count !== 0 ) {
				$menus = array_rand( $all_cats, $count );
			}
		} elseif ( ! empty( $belise_menus_section_categories ) && ( ! in_array( 'none', $belise_menus_section_categories ) ) ) {
			foreach ( $belise_menus_section_categories as $category ) {

				if ( ! empty( $lang ) ) {
					if ( array_key_exists( $category, $all_cats ) ) {
						array_push( $menus, $category );
					}
				} else {
					array_push( $menus, $category );
				}
			}
		}
		if ( ! is_array( $menus ) ) {
			$menus = array( $menus );
		}
	}

	if ( ! empty( $menus ) ) {
		foreach ( $menus as $menu ) {
			if ( ! empty( $menu ) ) {
				$item = get_term_by( 'slug', $menu, 'nova_menu' );
				?>
				<div class="col-sm-12 col-md-6 col-lg-6 food-menu">
					<div class="food-menu-container">
						<div class="food-menu-content">
							<?php
							if ( ! empty( $item->name ) && ! empty( $item->slug ) ) {
							?>
								<div>
									<h3 class="food-menu-title">
										<?php echo esc_html( $item->name ); ?>
									</h3>
								</div>
								<a href="<?php echo esc_url( get_term_link( $item, 'nova_menu' ) ); ?>" title="<?php esc_attr_e( 'See menu', 'belise-lite' ); ?>">
									<?php echo apply_filters( 'belise_menu_button_label', esc_html__( 'See menu', 'belise-lite' ) ); ?>
								</a>
								<?php
							}
							?>
						</div>

						<?php
						$meta = get_term_meta( $item->term_id );
						if ( ! empty( $meta ) ) {
							if ( ! empty( $meta['category-image-id'][0] ) ) {
								$image = wp_get_attachment_url( $meta['category-image-id'][0] );
								if ( ! empty( $image ) ) {
								?>
									<div class="food-menu-image" style="background: url(<?php echo esc_url( $image ); ?>); background-size:cover"></div>
									<?php
								}
							}
						}
						?>
					</div>
				</div>
				<?php
			}
		}// End foreach().
	}// End if().

}
