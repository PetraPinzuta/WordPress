<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Belise
 */

?>

	</div><!-- #content -->

	<?php belise_ribbon_widget(); ?>

	<footer id="colophon" class="site-footer">
		<?php
		belise_footer_widgets();
		if ( current_user_can( 'edit_theme_options' ) ) {
			$belise_contact_email = get_theme_mod(
				'belise_contact_email', sprintf(
					'<a href="' . admin_url( 'customize.php?autofocus[control]=belise_contact_email' ) . '">%s</a>', esc_html__( 'Edit the email address in Customizer', 'belise-lite' )
				)
			);
		} else {
			$belise_contact_email = get_theme_mod( 'belise_contact_email', '' );
		}
		?>

		<div class="footer-bar
		<?php
		if ( ! has_nav_menu( 'social-icons' ) ) {
			echo ' without-menu';
		} if ( empty( $belise_contact_email ) ) {
			echo ' without-email'; }
?>
">
			<div class="container">
				<?php
				/* translators: 1: theme name, 2: WordPress link */
				$belise_copyright_text = get_theme_mod( 'belise_copyright_text', sprintf( esc_html__( '%1$s Powered by %2$s', 'belise-lite' ), sprintf( '<a href="https://themeisle.com/themes/belise/" rel="nofollow">%s</a> <span class="sep"> | </span>', esc_html__( 'Belise', 'belise-lite' ) ), sprintf( '<a href="http://wordpress.org/" rel="nofollow">%s</a>', esc_html__( 'WordPress', 'belise-lite' ) ) ) );

				if ( ! empty( $belise_copyright_text ) || is_customize_preview() ) {
				?>
				<div class="site-info pull-left">
					<?php echo wp_kses_post( $belise_copyright_text ); ?>
				</div><!-- .site-info -->
				<?php } ?>

				<div class="footer-bar-content pull-right">
					<div class="footer-bar-inner">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'social-icons',
								'menu_class'     => 'social-icons',
								'container'      => '',
								'link_before'    => '<span class="screen-reader-text">',
								'link_after'     => '</span>',
								'depth'          => 1,
								'fallback_cb'    => false,
							)
						);

						belise_email_address();
						?>
					</div>
				</div>
			</div>
		</div> <!-- .footer-bar -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
