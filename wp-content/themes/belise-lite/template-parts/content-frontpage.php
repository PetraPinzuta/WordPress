<?php
/**
 * Template part for displaying frontpage content.
 *
 * @package Belise
 */

if ( is_customize_preview() ) {
	$frontpage_id = get_option( 'page_on_front' );
	$default      = '';
	if ( ! empty( $frontpage_id ) ) {
		$default = get_post_field( 'post_content', $frontpage_id );
		$content = get_theme_mod( 'belise_page_editor', $default );
		$content = apply_filters( 'belise_text', $content );
		$image   = get_theme_mod( 'belise_feature_thumbnail' );
		$class   = 'col-md-12';
		if ( ! empty( $image ) ) {
			$class = 'col-xs-12 col-sm-6';
		} ?>

		<div class="<?php echo esc_attr( $class ); ?> belise-page-content">
			<?php echo wp_kses_post( $content ); ?>
		</div>

		<?php
		if ( ! empty( $image ) ) {
		?>
			<div class="<?php echo esc_attr( $class ); ?> belise-page-thumbnail">
				<img src="<?php echo esc_url( $image ); ?>" />
			</div>
			<?php
		}
	} else {
		the_content();
	}
} else {
	$class = 'col-md-12';
	if ( has_post_thumbnail() ) {
		$class = 'cox-xs-12 col-sm-6';
	}
	?>

	<div class="<?php echo esc_attr( $class ); ?> belise-page-content">
		<?php
		the_content();
		?>
	</div>

	<?php
	if ( has_post_thumbnail() ) {
	?>
		<div class="<?php echo esc_attr( $class ); ?> belise-page-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
		<?php
	}
}// End if().
