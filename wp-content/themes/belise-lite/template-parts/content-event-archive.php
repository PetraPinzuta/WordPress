<?php
/**
 * Template part for displaying events.
 *
 * @package Belise
 */

?>
<li class="events-archive-item">
	<?php
	if ( function_exists( 'eo_get_the_start' ) ) {
		$startdate = eo_get_the_start();

		if ( ! empty( $startdate ) ) {
		?>
		<div class="events-item-date-content">
			<div class="events-item-date">
				<span class="events-item-date-day"><?php echo esc_html( eo_get_the_start( 'j' ) ); ?></span>
				<span class="events-item-date-month"><?php echo esc_html( eo_get_the_start( 'M' ) ); ?></span>
			</div>
		</div>
		<?php
		}
	}
	?>

	<div class="events-archive-item-content">
		<a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php the_title_attribute(); ?>" class="events-item-name"><?php echo get_the_title(); ?></a>

		<?php
		if ( function_exists( 'eo_get_venue' ) ) {
			$eventaddress = eo_get_venue_address();

			if ( ! empty( $eventaddress ) ) {
			?>
				<address class="events-item-address">
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
			<?php
			}
		}
		?>
	</div>
</li>
