<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_content_image( $id ) {
		$img = mapi_get_default_media( $id, 'failover' );

		if ( ! empty( $img['url'] ) ) {
				?>
						<img class="featurette-image img-responsive" alt="<?php if ( ! empty( $img['title'] ) ) MPut::_html_attr( $img['title'] ); ?>" src="<?php MPut::_link( $img['url'] ); ?>">
				<?php
		}
}

?>