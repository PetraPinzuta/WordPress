/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize(
		'blogname', function( value ) {
			value.bind(
				function( to ) {
					$( '.site-title a' ).text( to );
				}
			);
		}
	);
	wp.customize(
		'blogdescription', function( value ) {
			value.bind(
				function( to ) {
					$( '.site-description' ).text( to );
					$( '.hero-title' ).text( to );
				}
			);
		}
	);

	// Logo
	wp.customize(
		'custom_logo', function( value ) {
			value.bind(
				function( to ) {
					if ( to !== '' ) {
						$( '.custom-logo-link' ).removeClass( 'only-customizer' );
					} else {
						$( '.custom-logo-link' ).addClass( 'only-customizer' );
					}
				}
			);
		}
	);

	// Header text color.
	wp.customize(
		'header_textcolor', function( value ) {
			value.bind(
				function( to ) {
					if ( 'blank' === to ) {
						$( '.site-title a, .site-description' ).css(
							{
								'clip': 'rect(1px, 1px, 1px, 1px)',
								'position': 'absolute'
							}
						);
					} else {
						$( '.site-title a, .site-description' ).css(
							{
								'clip': 'auto',
								'position': 'relative'
							}
						);
						$( '.site-title a, .site-description' ).css(
							{
								'color': to
							}
						);
					}
				}
			);
		}
	);

	// Header text color.
	wp.customize(
		'background_color', function( value ) {
			value.bind(
				function( to ) {
					if ( to !== 'undefined') {
						$( 'body, .front-page-sidebar, .front-page-content, div.woocommerce-error, div.woocommerce-info, div.woocommerce-message, .woocommerce div.woocommerce-upsells-products' ).css( 'background',to );
					}
				}
			);
		}
	);

	// Header phone
	wp.customize(
		'belise_contact_phone', function( value ) {
			value.bind(
				function( to ) {
					if ( to !== '' ) {
						$( '.top-bar .bar-contact' ).removeClass( 'only-customizer' );
					} else {
						$( '.top-bar .bar-contact' ).addClass( 'only-customizer' );
					}
					$( '.top-bar .bar-contact a' ).html( to );
					var tel_string = 'tel:' + to;
					$( '.top-bar .bar-contact a' ).attr( 'href', tel_string );
				}
			);
		}
	);

	// Footer e-mail
	wp.customize(
		'belise_contact_email', function( value ) {
			value.bind(
				function( to ) {
					if ( to !== '' ) {
						$( '.footer-bar .bar-contact' ).removeClass( 'only-customizer' );
					} else {
						$( '.footer-bar .bar-contact' ).addClass( 'only-customizer' );
					}
					$( '.footer-bar .bar-contact a' ).html( to );
					var email_string = 'mailto' + to;
					$( '.footer-bar .bar-contact a' ).attr( 'href', email_string );
				}
			);
		}
	);

	// Front page title
	wp.customize(
		'belise_front_page_title', function( value ) {
			value.bind(
				function( to ) {
					if ( to !== '' ) {
						$( '#hero .front-page-title' ).removeClass( 'only-customizer' );
					} else {
						$( '#hero .front-page-title' ).addClass( 'only-customizer' );
					}
					$( '#hero .front-page-title' ).html( to );
				}
			);
		}
	);

	// Front page button text
	wp.customize(
		'belise_front_page_button', function( value ) {
			value.bind(
				function( to ) {
					if ( to !== '' ) {
						$( '#hero .hero-btn-container' ).removeClass( 'only-customizer' );
					} else {
						$( '#hero .hero-btn-container' ).addClass( 'only-customizer' );
					}
					$( '#hero .hero-btn-container' ).html( to );
				}
			);
		}
	);
} )( jQuery );
