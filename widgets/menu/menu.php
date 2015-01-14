<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_menu( $menu_id, $class = null, $id = null ) {
		$menu = MObject::get( 'menu', $menu_id );

		if ( $class ) $class = ' class="' . MPut::html_attr( $class ) . '"';
		else $class = '';

		if ( $id ) $id = ' id="' . MPut::html_attr( $id ) . '"';
		else $id = '';

		if ( $menu ) {
				$pages = $menu->get_pages();

				if ( sizeof( $pages ) > 0 ) {
						?>
								<ul<?php echo $class; ?><?php echo $id; ?>>
										<?php foreach ( $pages as $page ): ?>
												<li>
														<a href="<?php MPut::_link( $page->get_url() ); ?>" title="<?php MPut::_html_attr( $page->get_title() ); ?>">
																<?php MPut::_html( $page->get_title() ); ?>
														</a>
												</li>
										<?php endforeach; ?>
								</ul>
						<?php
				}
		}
}

?>