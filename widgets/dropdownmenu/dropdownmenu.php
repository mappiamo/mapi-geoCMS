<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_dropdownmenu( $menu_item ) {
		$menu_item = strtolower( $menu_item );
		switch( $menu_item ) {
			case "associarsi": $menu_id = 5; break;
			case "chi siamo": $menu_id = 6; break;
			case "eventi": $menu_id = 7; break;
			case "attivita'": $menu_id = 8; break;
			default: $menu_id = null; break;
		}
		$menu = MObject::get( 'menu', $menu_id );

		if ( $menu ) {
				$pages = $menu->get_pages();
				?>
				<ul style="margin:0;">
				<?php
				if ( sizeof( $pages ) > 0 ) {
						foreach ( $pages as $page ) {
							$TheLink = $page->get_url();
							if (strrpos($TheLink, '/', 8)) {
								$TheLinkRoot = substr($TheLink, 0, strrpos($TheLink, '/', 8));
							} else {
								$TheLinkRoot = $TheLink;
							}
							$TheServerRoot = str_replace("/manager", "", rtrim(((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']), '/\\'));
							$TheRealLink = str_replace($TheLinkRoot, $TheServerRoot, $TheLink);

							if ($page->page_on_blank() == TRUE) { $TargetString = '_blank'; } else { $TargetString = '_self'; }

							?>
										<div style="position: relative; margin:6px; text-align:left;">
												<li style="white-space:nowrap;">
												<a href="<?php MPut::_link( $page->get_url() ); //echo $TheRealLink; ?>" target="<?PHP echo $TargetString; ?>" title="<?php MPut::_html_attr( $page->get_title() ); ?>" style="margin: 6px 0; font-size: 13px;">
														<?php //MPut::_html( $page->get_title() ); ?>
														<?php __( $page->get_title() ); ?>
												</a>
												</li>
										</div>
								<?php
						}
				}
				?>
				</ul>
				<?php
		}
}

?>
