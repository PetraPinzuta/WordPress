<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Belise
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'belise-lite' ); ?></a>

		<header id="masthead" class="site-header">
			<?php
			if ( current_user_can( 'edit_theme_options' ) ) {
				$belise_contact_phone = get_theme_mod( 'belise_contact_phone', sprintf( '<a href="' . admin_url( 'customize.php?autofocus[control]=belise_contact_phone' ) . '">%s</a>', esc_html__( 'Edit the phone number in Customizer', 'belise-lite' ) ) );
			} else {
				$belise_contact_phone = get_theme_mod( 'belise_contact_phone', '' );
			}
			?>
			<div class="top-bar 
			<?php
			if ( $belise_contact_phone == '' ) {
				echo 'without-phone';}
?>
">
				<div class="container">
					<div class="top-bar-content">
						<div class="social-icons-wrapper">
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
							?>
						</div>

						<div class="top-bar-icons-wrapper">
							<?php
							if ( has_nav_menu( 'social-icons' ) ) {
							?>
								<span class="social-icons-toggle"><i class="fa fa-share-alt"></i></span>
								<?php
							}

							belise_search_icon();

							if ( belise_woocommerce_activated() ) {
								belise_cart_icon();
							}
							?>
						</div>
						<div class="top-bar-contact-wrapper">
							<?php belise_phone_number(); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="container header-container">
				<div class="navbar-header">
					<div class="site-branding">
						<?php belise_brand(); ?>
					</div><!-- .site-branding -->

					<span class="menu-toggle-content">
						<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><i class="fa fa-bars" aria-hidden="true"></i></button>
					</span>
				</div>

				<nav id="site-navigation" class="main-navigation site-navigation">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'depth'          => 2,
						)
					);
						?>
				</nav><!-- #site-navigation -->
			</div>

		</header><!-- #masthead -->

		<?php belise_hero_content(); ?>

		<?php belise_categories_menu(); ?>

		<div id="content" class="site-content">
