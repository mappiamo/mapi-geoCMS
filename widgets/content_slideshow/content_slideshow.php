<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_content_slideshow() {
		$id = $_GET["object"];
		$type = $_GET["module"];
		
		if ( (! empty( $id )) && ($type == "content") ) {
			$images = ORM::for_table('content_media')->select_many('title', 'url')->where('external_id', $id)->find_array();
			if ((!empty($images)) && (count($images) > 1)) {
			
				?>
				<script src="assets/js/jssor/jssor.options.js"></script>
				<div class="jssor_slider" id="slider_container">
					<div class="lupe_icon"><img src="templates/gal2/images/icon-lupe.png"></div>
					<div u="slides" class="jssor_slides">
					
					<?php 
					$i = 1;
					foreach($images as $image){
					?>
					
						<div>
						<a href="<?php echo $image['url']; ?>" data-lightbox="image-<?php echo $i; ?>" data-title="<?php echo $image['title']; ?>">
							<img u="image" src="<?php echo $image['url']; ?>" />
						</a>
							<img u="thumb" src="<?php echo $image['url']; ?>" />
						</div>
						
					<?php $i++; } ?>
					</div>
					
					<!-- Arrow Left -->
					<span u="arrowleft" class="jssora02l">
					</span>
					<!-- Arrow Right -->
					<span u="arrowright" class="jssora02r">
					</span>
					
					<!-- thumbnail navigator container -->
					<div u="thumbnavigator" class="jssort03">

						<!-- the following background element is optional 
						<div style=" background-color: #000; filter:alpha(opacity=30); opacity:.3; width: 100%; height:100%;"></div> -->

						<!-- Thumbnail Item Skin Begin -->
						<div u="slides" style="cursor: default;">
							<div u="prototype" class="p">
								<div class=w><div u="thumbnailtemplate" class="t"></div></div>
								<div class=c></div>
							</div>
						</div>
						<!-- Thumbnail Item Skin End -->
					</div>
					<!--#endregion Thumbnail Navigator Skin End -->
				</div>
				<?php
			}
		}
}

?>