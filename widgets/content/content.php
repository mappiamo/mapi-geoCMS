<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_content( $id ) {
		$content = MObject::get( 'content', $id );

		if ( $content ) {
		$title_addon = $content->get_meta( 'title-addon' );
				?>
					<h2 class="featurette-heading"><?php MPut::_html( $content->get_title() ); ?>
							<?php if( $title_addon ): ?> 
								<br />
								<span class="text-muted"><?php ' ' . MPut::_html( $title_addon->get_value() ); ?></span>
							<?php endif; ?>
					</h2>
					<p class="lead"><?php MPut::_text( $content->get_text() ); ?></p>
				<?php
		}
}

?>
