/**
 * functions.js
 *
 * Handles toggling the navigation menu for small screens and enables tab
 * support for dropdown menus.
 */

( function($) {

	( function() {
		var containers = $( '.site-navigation' );
		if ( containers.length === 0 ) {
			return;
		}

		$.each(
			containers, function(i){
				var container = containers.eq( i );
				var button    = container.parent().find( '.menu-toggle' );
				if ( 'undefined' !== typeof button ) {
					var menu = container.find( 'ul' );
					if ( 'undefined' !== typeof menu ) {
						menu.attr( 'aria-expanded','false' );
						if ( ! menu.hasClass( 'nav-menu' )) {
							menu.addClass( 'nav-menu' );
						}
						button.click(
							function(){
								if (container.hasClass( 'toggled' )) {
									container.removeClass( 'toggled' );
									button.attr( 'aria-expanded', 'false' );
									menu.attr( 'aria-expanded', 'false' );
								} else {
									container.addClass( 'toggled' );
									button.attr( 'aria-expanded', 'true' );
									menu.attr( 'aria-expanded', 'true' );
								}
							}
						);
					} else {
						button.hide();
					}

					// Get all the link elements within the menu.
					var links    = menu[ 0 ].getElementsByTagName( 'a' );
					var subMenus = menu[ 0 ].getElementsByTagName( 'ul' );

					// Set menu items with submenus to aria-haspopup="true".
					for ( i = 0; i < subMenus.length; i++ ) {
						subMenus[i].parentNode.setAttribute( 'aria-haspopup', 'true' );
					}

					// Each time a menu link is focused or blurred, toggle focus.
					for ( i = 0; i < links.length; i++ ) {
						links[i].addEventListener( 'focus', toggleFocus, true );
						links[i].addEventListener( 'blur', toggleFocus, true );
					}
				}

			}
		);

		/**
		 * Sets or removes .focus class on an element.
		 */
		function toggleFocus() {
			var self = this;

			// Move up through the ancestors of the current link until we hit .nav-menu.
			while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

				// On li elements toggle the class .focus.
				if ( 'li' === self.tagName.toLowerCase() ) {
					if ( -1 !== self.className.indexOf( 'focus' ) ) {
						self.className = self.className.replace( ' focus', '' );
					} else {
						self.className += ' focus';
					}
				}

				self = self.parentElement;
			}
		}
	} )();

	$( document ).ready(
		function() {

				callback_mobile_dropdown();
				dropdownHorizontalAlign();

		}
	);

	$( window ).load(
		function(){
			'use strict';

			/* PRE LOADER */
			jQuery( '.status' ).fadeOut();
			jQuery( '.preloader' ).delay( 1000 ).fadeOut( 'slow' );

		}
	);

	$( window ).resize(
		function() {

			dropdownHorizontalAlign();

			/* Hide menu on resize */
			if ( getWidth() >= 992 ) {
				if ( $( '.site-navigation' ).hasClass( 'toggled' ) ) {
					$( '.site-navigation' ).removeClass( 'toggled' );
				}
				if ( $( '.site-navigation li.has_children' ).hasClass( 'opened' ) ) {
					$( '.site-navigation li.has_children' ).removeClass( 'opened' );
				}
			}

		}
	);

	/*** DROPDOWN FOR MOBILE MENU */
	var callback_mobile_dropdown = function () {
		var $navLi = $( '#site-navigation li' );
		$navLi.each(
			function(){
				if ( $( this ).find( 'ul' ).length > 0 && ! $( this ).hasClass( 'has_children' ) ) {
					$( this ).addClass( 'has_children' );
				}
			}
		);
		$( '.dropdownmenu' ).click(
			function(){
				if ( $( this ).parent( 'li' ).hasClass( 'this-open' ) ) {
					$( this ).parent( 'li' ).removeClass( 'this-open' );
				} else {
					$( this ).parent( 'li' ).addClass( 'this-open' );
				}
			}
		);
	};

	jQuery( document ).ready(
		function($){

			/* Dropdown menu delay */
			if ( getWidth() >= 992 ) {
				var timeout_submenu;

				$( '.main-navigation > div > ul > li' ).on(
					'mouseleave', function () {
						var ul          = $( this ).find( '>ul' );
						timeout_submenu = setTimeout(
							function () {
								ul.hide();
							}, 100
						);
					}
				);
				$( '.main-navigation > div > ul > li' ).on(
					'mouseenter', function () {
						var th = $( this );
						th.find( '>ul' ).show();

					}
				);

				$( '.main-navigation > div > ul > li > ul' ).on(
					'mouseenter', function () {
						clearTimeout( timeout_submenu );
					}
				);

			} else {

				$( '.site-navigation' ).find( '.menu-item-has-children > a' ).after( '<span class="dropdown-toggle"></span>' );

				$( '.dropdown-toggle' ).on(
					'click', function () {
						var th = $( this );

						if ( th.parent().hasClass( 'opened' ) ) {
							th.parent().removeClass( 'opened' );
							th.removeClass( 'angle-up' );
						} else {
							th.parent().addClass( 'opened' );
							th.addClass( 'angle-up' );
						}

					}
				);
			}

			/* Social icons menu toggle */
			$( '.social-icons-toggle' ).click(
				function(){
					$( '.social-icons-wrapper' ).slideToggle();
				}
			);
		}
	);

	function dropdownHorizontalAlign() {
		$( '#site-navigation li.menu-item-has-children , #site-navigation li.page_item_has_children' ).each(
			function(){
					var thLi    = $( this ),
					windowWidth = getWidth(),
					liOffset    = $( thLi ).offset().left - parseInt( $( '.header-container' ).css( 'margin-left' ) ) + $( thLi ).width() / 2;
				if ( windowWidth <= ( liOffset + $( thLi ).find( 'ul' ).width() / 2 ) ) {
					$( thLi ).find( 'ul' ).css( 'left', windowWidth - $( thLi ).find( 'ul' ).width() / 2 );
				} else {
					$( thLi ).find( 'ul' ).css( 'left', liOffset );
				}
			}
		);
	}

	/* Modal */
	if ( $( '#siteModal' ).hasClass( 'site-modal-open' ) ) {
		$( '#siteModal' ).modal( 'show' );
	}

	$( '.open-modal' ).click(
		function() {
				$( '#siteModal' ).modal( 'show' );
		}
	);

	/* Search field */
	$( '.top-bar form.search-form' ).submit(
		function(){

				var form     = $( this ),
				$searchField = $( '.top-bar form .search-field' );

			if (form.hasClass( 'search-visible' )) {

				return true;

			}

				$searchField.animate(
					{

						marginLeft: parseInt( $searchField.css( 'marginLeft' ),10 ) === 0 ?
						$searchField.outerWidth() : 0

					}
				);

				/* Responsive search form */
			if ( getWidth() > 992 ) {

				$searchField.parent().parent().addClass( 'search-visible' ).find( '.search-field' ).focus();

				/* Hide search field when click outside on desktop devices */
				$( '.top-bar form.search-form' ).outside(
					'click', function() {

						if ( form.hasClass( 'search-visible' ) ) {
							$searchField.animate(
								{

									marginLeft: -(parseInt( $searchField.css( 'marginLeft' ) + 10,10 ) === 0 ?
									$searchField.outerWidth() : 0)

								}
							);

							form.removeClass( 'search-visible' );
						}
					}
				);

			} else {

				$searchField.parent().parent().addClass( 'search-visible' ).css( 'margin-left', 0 ).find( '.search-field' );

				$searchField.closest( '.top-bar-icons-wrapper' ).find( '.social-icons-toggle' ).animate(
					{
						opacity: 0,
						width: 0,
						}
				);

				$searchField.closest( '.top-bar-icons-wrapper' ).find( '.menu-shopping-cart' ).animate(
					{
						opacity: 0,
						width: 0,
						}
				);

				if ( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test( navigator.userAgent ) ) {
					$( 'body' ).addClass( 'belise-cursor-pointer' );
				}

				/* Hide search field when click outside on mobile devices */
				$( '.top-bar form.search-form' ).outside(
					'click', function() {
						if ( form.hasClass( 'search-visible' ) ) {
							$searchField.animate(
								{

									marginLeft: -(parseInt( $searchField.css( 'marginLeft' ),10 ) === 0 ?
									$searchField.outerWidth() : 0)

								}
							);

							$searchField.closest( '.top-bar-icons-wrapper' ).find( '.social-icons-toggle' ).animate(
								{
									opacity: 100,
									width: 48,
								 }
							);

							$searchField.closest( '.top-bar-icons-wrapper' ).find( '.menu-shopping-cart' ).animate(
								{
									opacity: 100,
									width: 48,
								 }
							);

							form.removeClass( 'search-visible' );

							if ( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test( navigator.userAgent ) ) {
								$( 'body' ).removeClass( 'belise-cursor-pointer' );
							}

						}
					}
				);

			}

				return false;
		}
	);

	/* Smooth scroll */
	$( '#hero a[href*="#"]:not([href="#"])' ).click(
		function() {
			if (location.pathname.replace( /^\//,'' ) === this.pathname.replace( /^\//,'' ) && location.hostname === this.hostname) {
				var target = $( this.hash );
				target     = target.length ? target : $( '[name=' + this.hash.slice( 1 ) + ']' );
				if (target.length) {
					$( 'html, body' ).animate(
						{
							scrollTop: target.offset().top
						}, 500
					);
					return false;
				}
			}
		}
	);

} )( jQuery,window );


/* Detecting outside clicks of an element */
(function($){
	$.fn.outside = function(ename, cb){
		return this.each(
			function(){
				var self = this;

				$( document ).bind(
					ename, function tempo(e){
					if (e.target !== self && ! $.contains( self, e.target )) {
						cb.apply( self, [e] );
						if ( ! self.parentNode) {
							$( document.body ).unbind( ename, tempo );
						}
					}
					}
				);
			}
		);
	};
}(jQuery));


											/* Get window width depending on the browser */
											function getWidth() {
												if (this.innerWidth) {
													return this.innerWidth;
												}

												if (document.documentElement && document.documentElement.clientWidth) {
													return document.documentElement.clientWidth;
												}

												if (document.body) {
													return document.body.clientWidth;
												}
											}
