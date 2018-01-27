/**
 * comments.js
 *
 * Scroll and focus on message field from comments area.
 */

jQuery( document ).ready(
	function ($) {
		'use strict';

		$( '#leave-a-reply' ).click(
			function () {
				$( 'html, body' ).animate(
					{
						scrollTop: $( '#respond' ).offset().top
					}, 750, function(){
						$( '#comment' ).focus();
					}
				);

			}
		);

	}
);
