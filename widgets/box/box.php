<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_box( $image, $title, $desc, $link ) {
		?>
<div class="enterleave col-sm-4 col-xs-12" style="cursor: pointer; margin: 16px 0;"
<?php if ( ! empty( $link ) ) echo 'onclick="window.open(\'' . MPut::link( $link ) . '\', \'_blank\');"'; ?>>
						<img src="<?php if ( ! empty( $image ) ) MPut::_link( $image ); ?>" />
						<div class="img-caption">
								<div class="row">
										<div class="col-md-12" style="color: #fff;">
												<h2 class="img-caption-text"><?php if ( ! empty( $title ) ) MPut::_html( $title ); ?></h2>
												<div class="hidden-sm img-caption-text"><?php if ( ! empty( $desc ) ) MPut::_html( $desc ); ?></div>
										</div>
								</div>
						</div>
				</div>
		<?php
}

?>
