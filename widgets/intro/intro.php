<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_intro() {
		global $content;

		if ( ! is_object( $content ) ) return null;

		$img = $content->get_media( true );
		if ( ! is_object( $img ) ) $img = $content->get_media();

		if ( is_array( $img ) ) {
				reset( $img );
				$img = current( $img );
		}

		if ( ! is_object( $img ) ) {
				$img = new stdClass();
				$img->url = mapi_install_url() . 'media/default_content.jpg';
		}

		?>
				<div class="introimage" style="background-image: url( '<?php MPut::_link( $img->url ); ?>' );">
						&nbsp;
				</div>
		<?php
}

?>