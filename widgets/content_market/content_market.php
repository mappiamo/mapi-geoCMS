<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_content_market( $id ) {
		$content = MObject::get( 'content', $id );

		if ( $content ) {
				$img = mapi_get_default_media( $content->get_id(), 'failover' );
				?>
						<?php if ( isset( $img['url'] ) ): ?>
								<img class="img-circle" src="<?php MPut::_link( $img['url'] ); ?>" alt="<?php MPut::_html_attr( $img['title'] ); ?>" style="width: 140px; height: 140px;">
						<?php else: ?>
								<img class="img-circle" data-src="holder.js/140x140" alt="Generic placeholder image">
						<?php endif; ?>

	                    <a href="index.php?module=content&object=<?php MPut::_id( $content->get_id() ); ?>" title="<?php MPut::_html_attr( $content->get_title() ); ?>">
	                    		<h2><?php MPut::_html( $content->get_title() ); ?></h2>
	                    </a>
	                    <p><?php echo mapi_short_description( $content->get_text(), 5 ) ?></p>
				<?php
		}
}

?>