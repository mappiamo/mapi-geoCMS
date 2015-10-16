<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_Content {

		static function display_post( $post ) {
				?>
						<div itemscope itemtype="http://schema.org/Blog">
								<h1 class="content-title"><span itemprop="name"><?php MPut::_html( $post->get_title() ); ?></span></h1>

								<?php self::content_props( $post ); ?>
								
								<div class="content-text"  itemprop="articleBody">
										<?php MPut::_text( $post->get_text() ); ?>
								</div>

								<div style="clear: both;"></div>

							<br><br>
							<button type="button" class="btn btn-default btn-sm" id="AddressButton">
								<span class="glyphicon glyphicon-map-marker"></span>&nbsp;&nbsp;&nbsp;<?php self::content_location( $post ); ?>
							</button>

						</div>
				<?php
		}

		static function display_place( $place ) {
				?>
						<div itemscope itemtype="http://schema.org/Place">
								<h1 class="content-title"><span itemprop="name"><?php MPut::_html( $place->get_title() ); ?></span></h1>

								<?php self::content_props( $place ); ?>
								
								<div class="content-text" itemprop="description">
										<?php MPut::_text( $place->get_text() ); ?>
								</div>

								<div style="clear: both;"></div>

							<br><br>
							<button type="button" class="btn btn-default btn-sm" id="AddressButton">
								<span class="glyphicon glyphicon-map-marker"></span>&nbsp;&nbsp;&nbsp;<?php self::content_location( $place ); ?>
							</button>

						</div>
				<?php
		}

		static function display_event( $event ) {
				?>
						<div itemscope itemtype="http://schema.org/Event">
								<h1 class="content-title"><span itemprop="name"><?php MPut::_html( $event->get_title() ); ?></span></h1>

								<?php self::content_props( $event ); ?>
								
								<div class="content-text" itemprop="description">
										<div class="content-dates">
												<meta itemprop="startDate" content="<?php MPut::_html_attr( date_format( new Datetime( $event->get_start() ), 'Y-m-dTH:i' ) ); ?>">
												<meta itemprop="endDate" content="<?php MPut::_html_attr( date_format( new Datetime( $event->get_end() ), 'Y-m-dTH:i' ) ); ?>">
												<!-- <h5>
														<span class="glyphicon glyphicon-circle-arrow-right"></span> <?php MPut::_html_attr( date_format( new Datetime( $event->get_start() ), 'Y-m-d H:i' ) ); ?>&nbsp;
														<span class="glyphicon glyphicon-circle-arrow-left"></span> <?php MPut::_html_attr( date_format( new Datetime( $event->get_end() ), 'Y-m-d H:i' ) ); ?>
												</h5> -->
										</div>
										<?php MPut::_text( $event->get_text() ); ?>
								</div>

								<div style="clear: both;"></div>

							<br><br>
							<button type="button" class="btn btn-default btn-sm" id="AddressButton">
								<span class="glyphicon glyphicon-map-marker"></span>&nbsp;&nbsp;&nbsp;<?php self::content_location( $event ); ?>
							</button>

						</div>
				<?php
		}

		static function content_props( $content ) {
				$created = $content->created();
				
				?>
						<div class="content-data">
								<img src="media/images/avatar.png" style="height: 42px; position: relative; top: -8px;" />
								<div style="display: inline-block; font-size: 10pt;">
										<?php if( isset( $created['by_name'] ) ): ?>
							  					<span itemprop="author"><?php MPut::_html( $created['by_name'] ); ?></span>, &nbsp;
							  			<?php endif; ?>
										<?php if( isset( $created['when'] ) ): ?>
												<br />
												<span itemprop="datePublished"><?php MPut::_html( $created['when'] ); ?></span>
										<?php endif; ?>
								</div>
						</div>
				<?php
		}

		static function content_location( $content ) {
				?>
						<div class="content-location">
								<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
										<span itemprop="streetAddress"><?php MPut::_text( $content->get_address() ); ?></span>
								</div>
								<span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
										<meta itemprop="latitude" content="<?php MPut::_numeric( $content->get_lat() ); ?>" />
										<meta itemprop="longitude" content="<?php MPut::_numeric( $content->get_lng() ); ?>"  />
								</span>
						</div>
				<?php
		}

		static function add_hit( $id ) {
				$content = ORM::for_table( 'contents' )->where( 'id', intval( $id ) )->find_one();

				if ( $content ) {
						$content->hits = $content->hits + 1;
						$content->save();
				}
		}
		
		static function get_translation( $id, $lang ) {
				$content = ORM::for_table( 'contents' )->where( 'id', intval( $id ) )->find_one();
				//var_dump($content->parent); die();
				if ( $content->parent ) {
						//ez mar forditas
						$translations = ORM::for_table( 'contents' )->where_raw('(`id` = ? OR `parent` = ?)', array(intval( $content->parent ), intval( $content->parent )))->find_many();
				}
				else {
						//ez a  fo cikk
						$translations = ORM::for_table( 'contents' )->where_raw('(`id` = ? OR `parent` = ?)', array(intval( $id ), intval( $id )))->find_many();
				}
				foreach( $translations as $translation ) {
						if ( $lang == $translation->get( "language" ) ) {
								return $translation->get( "id" );
						}
				}
				return $id;
				
		}
}

?>