<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_slider( $slider_id ) {
		$sid = intval( $slider_id );

		if ( $sid ) {
				$contents = array();

				$category = MObject::get( 'category', $sid );
				if ( $category && $category->get_id() ) {
						$contents = $category->get_contents();
				}
				$filtered_contents = array();
				$language = new M_Language();
				$lang = $language->getLanguage();
				//var_dump($contents);die();

				if ( sizeof( $contents ) > 0 ) {
				foreach ( $contents as $content ) {
					if ( $lang == $content->get_language() ) {
						$filtered_contents[] = $content;
					}
				}
				$filtered = false;
				if ( sizeof( $filtered_contents ) > 0 ) {
					$contents = $filtered_contents;
					$filtered = true;
				}
						?>
								<div id="carousel-captions" class="carousel slide" data-ride="carousel">
										<ol class="carousel-indicators">
												<?php
												$k = 0;
												foreach ( $contents as $content ) {
												?>
												<li data-target="#carousel-captions" data-slide-to="<?php echo $k; ?>" class="<?php if ( 0 == $k ) echo "active"; ?>"></li>
												<?php
												$k++;
												}
												?>
										</ol>
										<div class="carousel-inner">
						<?php
						$i = 0;
						foreach ( $contents as $content ) {
								if ( $filtered && 3 == $i ) { break; }
								$slide = $content->get_media( true );
								if ( ! is_object( $slide ) ) $slide = $content->get_media();

								if ( is_array( $slide ) ) {
									reset( $slide );
									$slide = current( $slide );
								}

								if ( ! is_object( $slide ) ) {
									$slide = new stdClass();
									$slide->url = mapi_install_url() . 'media/default_slider.jpg';
								}

								?>
										<div class="item<?php if ( 0 == $i ) echo ' active'; ?>" style="cursor: pointer;" onclick="location.href='index.php?module=content&object=<?php echo intval( $content->get_id() ); ?>'">
												<img class="carousel-image" src="<?php MPut::_link( $slide->url ); ?>" style="width: 100%;">
												<div class="carousel-caption">
									<h3 class="hidden-xs hidden-sm"><?php MPut::_html( $content->get_title() ); ?></h3>
									<h4 class="hidden-md hidden-lg"><?php MPut::_html( $content->get_title() ); ?></h4>
														<p class="hidden-xs hidden-sm"><?php echo mapi_short_description( $content->get_text(), 1 ); ?></p>
														
												</div>
												<?php 
														$hashtag = $content->get_meta( 'slide-hashtag' );
														if ( $hashtag->get_value() ) {
																?>
																		<a class="carousel-red-label">
																				#<?php MPut::_html( $hashtag->get_value() ); ?>
																		</a>
																<?php
														}
												?>
										</div>
								<?php
						$i++;
						}

						?>
								</div>
								<a class="left carousel-control" href="#carousel-captions" data-slide="prev">
										<span class="glyphicon glyphicon-chevron-left"></span>
								</a>
								<a class="right carousel-control" href="#carousel-captions" data-slide="next">
										<span class="glyphicon glyphicon-chevron-right"></span>
								</a>
						<?php
				}
		}
}

?>
