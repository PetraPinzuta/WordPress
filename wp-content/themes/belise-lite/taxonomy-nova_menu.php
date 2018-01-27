<?php
/**
 * The template for displaying archive menu pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Belise
 */

get_header(); ?>

<div class="food-menus">
	<div class="container">
		<div class="row">
			<?php

			$menu = get_queried_object();

			$labels = get_terms(
				array(
					'taxonomy' => 'nova_menu_item_label',
				)
			);

			$title_links = get_theme_mod( 'belise_nova_menu_title_links', false );

			foreach ( $labels as $label ) {
				$args  = array(
					'post_type' => 'nova_menu_item',
					'fields'    => 'ids',
					'tax_query' => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'nova_menu',
							'field'    => 'slug',
							'terms'    => $menu->slug,
						),
						array(
							'taxonomy' => 'nova_menu_item_label',
							'field'    => 'slug',
							'terms'    => $label->slug,
						),
					),
				);
				$query = new WP_Query( $args );
				?>

					<?php

					if ( $query->have_posts() ) {
					?>
						<div class="food-menu-label">
							<h2><?php echo esc_html( $label->name ); ?></h2>
							<ul>
								<?php
								while ( $query->have_posts() ) {
									$query->the_post();
								?>

									<li class="food-menu-item">
										<div class="food-menu-item-content">

											<?php if ( (bool) $title_links === true ) { ?>
												<a href="<?php the_permalink(); ?>"
													title="<?php the_title_attribute(); ?>"
													class="food-menu-name"><?php echo esc_html( get_the_title() ); ?></a>
											<?php } else { ?>
												<span class="food-menu-name"><?php echo esc_html( get_the_title() ); ?></span>
											<?php
}

											$menu_description = '';
if ( has_excerpt() ) {
	$menu_description = get_the_excerpt();
} else {
	$menu_description = get_the_content();
}

if ( ! empty( $menu_description ) ) {
?>
												<p class="food-menu-description"><?php echo strip_tags( apply_filters( 'the_content', $menu_description ) ); ?></p>
												<?php
}
											?>

										</div>

										<?php
										$menu_price = get_post_meta( $id, 'nova_price', true );
										if ( ! empty( $menu_price ) ) {
										?>

											<div class="food-menu-item-price">
												<span class="food-menu-price"><?php echo esc_html( $menu_price ); ?></span>
											</div>

										<?php
										}
										?>

									</li>

								<?php
								}// End while().
								?>
							</ul>
						</div>
					<?php
						wp_reset_postdata();
					}// End if().
			}// End foreach().
			?>

		</div>
	</div>
</div>

<?php

belise_related_food_menus();

get_footer();

?>
