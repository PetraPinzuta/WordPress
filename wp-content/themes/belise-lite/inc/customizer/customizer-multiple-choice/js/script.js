/* global jQuery */
/* global belise_ms_params */

jQuery( document ).ready(
	function () {
		'use strict';

		var theme_conrols = jQuery( belise_ms_params.theme_conrols );
		var multi_select  = jQuery( belise_ms_params.multi_select );
		theme_conrols.on(
			'click', '.belise-categories-multiple-select', function () {
				if ( jQuery( this ).children( ':selected' ).val() === 'random' ) {
					multi_select.val( 'random' );
				} else if ( jQuery( this ).children( ':selected' ).length === 0 ) {
					multi_select.val( 'none' );
				} else {
					var values = multi_select.val();
					if (values.length > 1) {
						var index = values.indexOf( 'none' );
						if (index > -1) {
							values.splice( index, 1 );
						}
						multi_select.val( values );

						index = values.indexOf( 'random' );
						if (index > -1) {
							values.splice( index, 1 );
						}
						multi_select.val( values );
					}
				}
				jQuery( this ).trigger( 'change' );
				event.preventDefault();
			}
		);
	}
);
