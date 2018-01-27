/**
 * Customizer editor upload
 */

jQuery( document ).ready(
	function($) {
		function ct_media_upload(button_class) {
			var _custom_media         = true,
				_orig_send_attachment = wp.media.editor.send.attachment;
			$( 'body' ).on(
				'click', button_class, function() {

					var button_id = '#' + $( this ).attr( 'id' );
					// var send_attachment_bkp = wp.media.editor.send.attachment;
					var button                      = $( button_id );
					_custom_media                   = true;
					wp.media.editor.send.attachment = function(props, attachment){
						if ( _custom_media ) {
							$( '#category-image-id' ).val( attachment.id );
							$( '#category-image-wrapper' ).html( '<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />' );

							$( '#category-image-wrapper .custom_media_image' ).attr( 'src', attachment.sizes.thumbnail.url ).css( 'display', 'block' );

						} else {
							return _orig_send_attachment.apply( button_id, [props, attachment] );
						}
					};
						wp.media.editor.open( button );
						return false;
				}
			);
		}
			ct_media_upload( '.belise_media_button.button' );
			$( 'body' ).on(
				'click','.belise_media_remove',function(){
					$( '#category-image-id' ).val( '' );
					$( '#category-image-wrapper' ).html( '<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />' );
				}
			);

			$( document ).ajaxComplete(
				function(event, xhr, settings) {

					if ( typeof( settings.data ) !== 'undefined' ) {
						var queryStringArr = settings.data.split( '&' );
						if ( typeof( queryStringArr ) !== 'undefined' ) {
							if (jQuery.inArray( 'action=add-tag', queryStringArr ) !== -1) {
								var xml = xhr.responseXML;

								var response = $( xml ).find( 'term_id' ).text();

								if (response !== '') {

									$( '#category-image-wrapper' ).html( '' );
								}
							}
						}
					}
				}
			);
	}
);
