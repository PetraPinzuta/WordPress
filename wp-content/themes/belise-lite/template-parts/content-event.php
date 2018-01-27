<?php
/**
 * Template part for displaying events.
 *
 * @package Belise
 */

?>

<article id="event-<?php the_ID(); ?>" class="event-item">
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>

	<?php
	if ( function_exists( 'eo_get_venue_map' ) ) {
		$eventvenue = eo_get_venue_map();

		if ( ! empty( $eventvenue ) ) {
			?>
			<div class="event-map">
				<?php echo wp_kses_post( $eventvenue ); ?>
			</div>
			<?php
		}
	}
	?>

	<div class="entry-content">
		<ul class="event-info">
		<?php
		if ( function_exists( 'eo_get_the_start' ) ) {
			$startdate = eo_get_the_start( 'M j, Y' );
			$starthour = eo_get_the_start( 'h:i a' );

			if ( ! empty( $startdate ) ) {
				?>
				<li class="event-info-date">
					<?php echo esc_html__( 'Date', 'belise-lite' ); ?>
					<span>
						<?php
						echo esc_html( $startdate );

						if ( function_exists( 'eo_get_the_end' ) ) {
							$enddate = eo_get_the_end( 'M j, Y' );
							$endhour = eo_get_the_end( 'h:i a' );

							if ( ! empty( $enddate ) && $startdate !== $enddate ) {
								echo ' - ' . esc_html( $enddate );
							}
						}
						?>
					</span>
				</li>

				<li class="event-info-hour">
					<?php echo esc_html__( 'Hour', 'belise-lite' ); ?>
					<span>
						<?php
						echo esc_html( $starthour );

						if ( ! empty( $endhour ) && $starthour !== $endhour ) {
								echo ' - ' . esc_html( $endhour );
						}
			}
			?>
					</span>
				</li>
				<?php
		}// End if().
		?>

		<?php
		if ( function_exists( 'eo_get_venue_address' ) ) {
			$eventaddress = eo_get_venue_address();

			if ( ! empty( $eventaddress ) ) {
			?>
				<li class="event-info-address">
					<?php echo esc_html__( 'Address', 'belise-lite' ); ?>
					<address>
						<?php


						if ( ! empty( $eventaddress['address'] ) ) {
							echo esc_html( $eventaddress['address'] );
						}

						if ( ! empty( $eventaddress['city'] ) ) {
							echo ', ' . esc_html( $eventaddress['city'] );
						}

						if ( ! empty( $eventaddress['state'] ) ) {
							echo ', ' . esc_html( $eventaddress['state'] );
						}

						if ( ! empty( $eventaddress['postcode'] ) ) {
							echo ', ' . esc_html( $eventaddress['postcode'] );
						}

						if ( ! empty( $eventaddress['country'] ) ) {
							echo ', ' . esc_html( $eventaddress['country'] );
						}
						?>
					</address>
				</li>
				<?php
			}
		}
		?>

		</ul>
		<?php
		the_content(
			sprintf(
				wp_kses( /* translators: %s: Name of current post. */
					__( 'Continue reading %s', 'belise-lite' ), array(
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

	<?php belise_event_entry_footer(); ?>

</article><!-- #post-## -->
