<?php
	/**
	 * Created by PhpStorm.
	 * User: Laca
	 * Date: 2015.11.03.
	 * Time: 11:33
	 */

	defined('DACCESS') or die;

	function mwidget_address() { ?>

		<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php echo $_SESSION['mapi_csrf']; ?>" />
		<input type="text" name="search" id="address_search_input" class="text" value="" placeholder="Address, City, Country"/>
		<input type="submit" name="search_button" id="address_search_button" class="button" value="Go!" />

		<script>
			$(document).ready(function() {

				$("#address_search_button").click(function() {

					if (!$('#address_search_input').val()) return null;

					var module = 'ajax';

					var url = 'index.php?module=' + module + '&task=geocode';
					url += '&address=' + $( '#address_search_input' ).val();
					url += '&mapi_csrf=' + encodeURIComponent( $( '#mapi_csrf' ).val() );

					if ( '#address_search_button' ) $( '#address_search_button' ).val( 'Searching...' );

					$.ajax( { url: url, dataType: "json" } ).done( function( result ) {
						if ( result.status === 'OK' ) {
							if ( $( '#content_lat' ) ) $( '#content_lat' ).val( result.lat );
							if ( $( '#content_lat' ) ) $( '#content_lng' ).val( result.lng );
							map.panTo( [result.lat, result.lng] );
						} else {
							alert( 'Address not found!' );
						}
					} ).done( function() {
						if ( '#address_search_button' ) $( '#address_search_button' ).val( 'Go!' );
					} );

				});
			});
		</script>


	<?PHP }