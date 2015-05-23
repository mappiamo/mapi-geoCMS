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
			//print_r(MObject::get( 'content', intval( 245 ) )); die();

				if ( sizeof( $pages ) > 0 ) {
						$ContentEnabled = NULL;
						?>
								<ul<?php echo $class; ?><?php echo $id; ?>>
										<?php foreach ( $pages as $page ): ?>
											<?PHP $TheLink = $page->get_url();
												$ContentID = substr(strrchr($TheLink, '='), 1);
												if (($ContentID) > 0) {
													$content = MObject::get( 'content', intval( $ContentID ));
													$ContentEnabled = ($content->is_enabled());
												} else {
													$ContentEnabled = 1;
												}
											?>
												<?PHP if ((($page->is_enabled()) == 1) && ($ContentEnabled == 1)) { ?>
														<li>
																<a href="<?php MPut::_link( $page->get_url() ); ?>" title="<?php MPut::_html_attr( $page->get_title() ); ?>">
																		<?php MPut::_html( $page->get_title() ); ?>
																</a>
														</li>
												<?PHP } ?>
										<?php endforeach; ?>
								</ul>
						<?php
				}
		}
}

?>