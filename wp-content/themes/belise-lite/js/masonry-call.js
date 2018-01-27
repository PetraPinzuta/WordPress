/**
 * masonry-call.js
 *
 * Call Masonry.
 */

jQuery(
	function ($) {

		$( window ).load(
			function() {
				if ( $( '.blog .posts-container,.archive .posts-container,.search-results .posts-container' ).length > 0 ) {
					$( '.posts-container .row' ).masonry(
						{
							itemSelector: '.post-col'
						}
					);
				}

				if ( $( '.woocommerce ul.products' ).length > 0 ) {
					$( 'ul.products' ).masonry(
						{
							itemSelector: '.product'
						}
					);
				}
			}
		);

	}
);
