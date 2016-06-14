<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_homescreen( $cat_id = null ) {
		$screens = array();

		if ( $cat_id ) {
				$category = MObject::get( 'category', $cat_id );

				if ( $category ) {
						$contents = $category->get_contents();

						if ( sizeof( $contents ) > 0 ) {
								foreach ( $contents as $content ) {
										$img = mapi_get_default_media( $content->get_id() );

										if ( $img && isset( $img['url'] ) && ! empty( $img['url'] ) )
												$screens[] = array( $content, $img['url'] );
								}
						}
				}
		}

		if ( sizeof( $screens ) > 0 ) {
				$key = array_rand( $screens );
				$back = $screens[$key];

				global $content;
				$content = $back[0];

				?>
						<div id="big-image" style="background: #006699 url( '<?php echo strip_tags( $back[1] ); ?>' ) center center; background-size: cover; cursor: pointer;" onclick="location.href='index.php?module=content&object=<?php echo intval( $back[0]->get_id() ); ?>'">
							<div class="caption"><?php echo strip_tags( $back[0]->get_title() ); ?></div>
						</div>
				<?php
		} else {
				?>
						<div id="big-image" style="background: #fff url( 'media/images/default_back.jpg' ) center center; background-size: cover;">
							<div class="caption"><?php echo strip_tags( $back[0]->get_title() ); ?></div>
						</div>
				<?php
		}
}

?>