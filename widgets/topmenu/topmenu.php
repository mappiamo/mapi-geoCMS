<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_topmenu( $menu_id, $class = null, $id = null ) {
		$menu = MObject::get( 'menu', $menu_id );

		if ( $class ) $class = ' class="' . MPut::html_attr( $class ) . '"';
		else $class = '';

		if ( $id ) $id = ' id="' . MPut::html_attr( $id ) . '"';
		else $id = '';

		if ( $menu ) {
				$pages = $menu->get_pages();
				$size = sizeof( $pages );

				if ( $size > 0 ) {
						$i = 0;
						foreach ( $pages as $page ) {
								$i++;
								?>
										<a href="<?php MPut::_link( $page->get_url() ); ?>" title="<?php MPut::_html_attr( $page->get_title() ); ?>">
												<?php //MPut::_html( $page->get_title() ); ?>
												<?php __( $page->get_title() );?>
										</a>
										<?php if ( $i != $size ) echo '&nbsp;|&nbsp;'; ?>
								<?php
						}
				}
		}
}

?>
