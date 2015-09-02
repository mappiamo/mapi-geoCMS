<?php

	// no direct access to this file
	defined( 'DACCESS' ) or die;

	function mwidget_dividedmenu( $menu_id, $class = null, $id = null ) {
		$menu = MObject::get( 'menu', $menu_id );

		if ( $class ) $class = ' class="' . MPut::html_attr( $class ) . '"';
		else $class = '';

		if ( $id ) $id = ' id="' . MPut::html_attr( $id ) . '"';
		else $id = '';

		if ( $menu ) {
			$pages = $menu->get_pages();
			$TempTitle = new M_Template;

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
					<div<?php echo $class.$id; ?> style="position: relative;">
						<a href="<?php echo $TheRealLink; //MPut::_link( $page->get_url() ); ?>" target="<?PHP echo $TargetString; ?>" title="<?php MPut::_html_attr( $page->get_title() ); ?>">
							<?php //MPut::_html( $page->get_title() ); ?>
							<?php __( $page->get_title() ); ?>
						</a>
						<div style="display:none;background-color:#000;min-width:100%;position:absolute; left: 0px; top: 20px;text-align: center;z-index: 9999;" >
							<?php $TempTitle->widget('dropdownmenu', $page->get_title() ); ?>
						</div>
					</div>
					<div class="visible-xs col-xs-3"></div>
					<div class="visible-xs col-xs-6">
						<?php $TempTitle->widget('dropdownmenu', $page->get_title() ); ?>
					</div>
					<div class="visible-xs col-xs-3"></div>
				<?php
				}
			}
		}
	}

?>


