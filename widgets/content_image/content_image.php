<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_content_image( $id ) {
		$img = mapi_get_default_media( $id, NULL );

		if ( ! empty( $img['url'] ) ) {

			$file_headers = @get_headers($img['url']);

			if($file_headers[0] != 'HTTP/1.1 404 Not Found') { ?>
				<div class="content-image">
					<img class="featurette-image img-responsive" alt="<?php if ( ! empty( $img['title'] ) ) MPut::_html_attr( $img['title'] ); ?>" src="<?php MPut::_link( $img['url'] ); ?>">
				</div>
			<?PHP
			} else {
				echo NULL;
			}
		}
}

?>