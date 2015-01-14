<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_map( $zoom = 9, $cat_id = null ) {
		global $content;
		global $coords;

		if ( MValidate::coord( $coords['lat'] ) && MValidate::coord( $coords['lng'] ) ) {
				?>
						<div id="mmap" style="width: 100%; height: 100%;"></div>
	                	<script>
	                        	var mmap = new MMap();
	                        	mmap.set_lat( <?php MPut::_numeric( $coords['lat'] ) ?> );
	                        	mmap.set_lng( <?php MPut::_numeric( $coords['lng'] ) ?> );
	                        	mmap.set_zoom( <?php MPut::_numeric( $zoom ); ?> );
	                        	mmap.create_map( 'mmap' );

	                        	<?php if ( $content ): ?>
	                        			mmap.create_marker();
	                        	<?php endif; ?>

					mmap.address_search();

	                        	var mmap_control = new MMapControl( mmap );
	                        	<?php if ( $cat_id ) echo 'mmap_control.auto_on( ' . intval( $cat_id ) . ' );'; ?>
	                	</script>
				<?php
		}
}

?>
