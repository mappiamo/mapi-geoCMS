<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_share( $site_id ) {
		if ( $site_id && strlen( $site_id ) > 0 ) {
				?>
						<script type="text/javascript">
								//<![CDATA[
		  								( function() {
		    									var shr = document.createElement( 'script' );
		    									shr.setAttribute( 'data-cfasync', 'false' );
		    									shr.src = '//dsms0mj1bbhn4.cloudfront.net/assets/pub/shareaholic.js';
		    									shr.type = 'text/javascript'; shr.async = 'true';
		    									shr.onload = shr.onreadystatechange = function() {
		      											var rs = this.readyState;
		      											if ( rs && rs != 'complete' && rs != 'loaded' ) return;
		      											var site_id = '<?php MPut::_js( $site_id ); ?>';
		      											try { Shareaholic.init( site_id ); } catch ( e ) {}
		    									};
		    									var s = document.getElementsByTagName( 'script' )[0];
		    									s.parentNode.insertBefore( shr, s );
		  								} )();
								//]]>
						</script>

						<div class="share">
								<div class='shareaholic-canvas' data-app='share_buttons' data-app-id='593701' style="clear: none"></div>
						</div>
				<?php
		}
}

?>