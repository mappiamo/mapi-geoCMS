<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_Content {

		static function display_post( $post ) {
				?>

						<?php self::add_schema( $post ); ?>


								<h1 class="content-title"><?php MPut::_html( $post->get_title() ); ?></h1>

								<?php self::content_props( $post ); ?>
								
								<div class="content-text">
										<?php MPut::_text( $post->get_text() ); ?>
								</div>

								<div style="clear: both;"></div>

							<br><br>
							<button type="button" class="btn btn-default btn-sm" id="AddressButton">
								<span class="glyphicon glyphicon-map-marker"></span>&nbsp;&nbsp;&nbsp;<?php self::content_location( $post ); ?>
							</button>

				<?php
		}

		static function display_place( $place ) {
				?>

						<?php self::add_schema( $place ); ?>

								<h1 class="content-title"><?php MPut::_html( $place->get_title() ); ?></h1>

								<?php self::content_props( $place ); ?>
								
								<div class="content-text">
										<?php MPut::_text( $place->get_text() ); ?>
								</div>

								<div style="clear: both;"></div>

							<br><br>
							<button type="button" class="btn btn-default btn-sm" id="AddressButton">
								<span class="glyphicon glyphicon-map-marker"></span>&nbsp;&nbsp;&nbsp;<?php self::content_location( $place ); ?>
							</button>

				<?php
		}

		static function display_event( $event ) {
				?>

						<?php self::add_schema( $event ); ?>

								<h1 class="content-title"><?php MPut::_html( $event->get_title() ); ?></h1>

								<?php self::content_props( $event ); ?>
								
								<div class="content-text">
										<div class="content-dates">
												<h5>
														<span class="glyphicon glyphicon-circle-arrow-right"></span> <?php MPut::_html_attr( date_format( new Datetime( $event->get_start() ), 'Y-m-d H:i' ) ); ?>&nbsp;
														<span class="glyphicon glyphicon-circle-arrow-left"></span> <?php MPut::_html_attr( date_format( new Datetime( $event->get_end() ), 'Y-m-d H:i' ) ); ?>
												</h5>
										</div>
										<?php MPut::_text( $event->get_text() ); ?>
								</div>

								<div style="clear: both;"></div>

							<br><br>
							<button type="button" class="btn btn-default btn-sm" id="AddressButton">
								<span class="glyphicon glyphicon-map-marker"></span>&nbsp;&nbsp;&nbsp;<?php self::content_location( $event ); ?>
							</button>

				<?php
		}

		static function add_schema( $data ) {
				$schema_data = array();
				$FullURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; //rtrim(((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']), '/\\');

				$schema_data['@context'] = 'http://schema.org';
				if ($data->get_type() == 'post') {
					$schema_data['@type'] = 'blog';
					$LocationString = 'contentLocation';
				} else {
					$schema_data['@type'] = $data->get_type();
					$LocationString = 'location';
				}

				$schema_data['name'] = $data->get_title();
				$schema_data['url'] = $FullURL;

				if ($data->get_type() == 'place') {
					$schema_data['address']['@type'] = 'Place';
					$schema_data['address'] = $data->get_address();
					$schema_data['geo']['@type'] = 'GeoCoordinates';
					$schema_data['geo']['latitude'] = $data->get_lat();
					$schema_data['geo']['longitude'] = $data->get_lng();
				} else {
					$schema_data[$LocationString]['@type'] = 'Place';
					$schema_data[$LocationString]['address'] = $data->get_address();
					$schema_data[$LocationString]['geo']['@type'] = 'GeoCoordinates';
					$schema_data[$LocationString]['geo']['latitude'] = $data->get_lat();
					$schema_data[$LocationString]['geo']['longitude'] = $data->get_lng();
				}

				$schema_data['description'] = mb_substr(str_replace('"', '', strip_tags($data->get_text())), 0, 100, 'UTF-8');

				if ($data->get_type() == 'event') {
					$schema_data['startDate'] = $data->get_start();
					$schema_data['endDate'] = $data->get_end();
					$schema_data[$LocationString]['name'] = $data->get_address();
				} elseif ($data->get_type() == 'post') {
					$schema_data['inLanguage'] = strtolower($data->get_language()) . '_' . strtoupper($data->get_language());
					$schema_data['dateCreated'] = $data->created()['when'];
					$schema_data['text'] = mb_substr(str_replace('"', '', strip_tags($data->get_text())), 0, 200, 'UTF-8');
					$schema_data['author'] = $data->created()['by_name'];
				}

				?>

				<div class="microformat">
					<script type="application/ld+json">

						[<?PHP print_r(json_encode($schema_data)); ?>]

					</script>
				</div>

				<?PHP
		}

		static function content_props( $content ) {
				$created = $content->created();

				?>
						<div class="content-data">

								<?PHP if (!isset($created['by_email'])) { ?>
									<img src="<?PHP
										$NewWidget = new M_Template();
										$NewWidget->widget('gravatar', array(NULL)); ?>" style="height: 42px; border-radius: 21px; position: relative; top: -8px;" />
								<?PHP } else { $CreatorMail = $created['by_email']; ?>
									<img src="<?PHP
										$NewWidget = new M_Template();
										$NewWidget->widget('gravatar', array($CreatorMail)); ?>" style="height: 42px; border-radius: 21px; position: relative; top: -8px;" />
								<?PHP } ?>

								<div style="display: inline-block; font-size: 10pt;">
										<?php if( isset( $created['by_name'] ) ) { ?>
							  					<?php MPut::_html( $created['by_name'] ); ?>, &nbsp;
							  			<?php } else { ?>
													Unknown author, &nbsp;
											<?PHP } ?>
										<?php if( isset( $created['when'] ) ): ?>
												<br />
												<?php MPut::_html( $created['when'] ); ?>
										<?php endif; ?>
								</div>
						</div>
				<?php
		}

		static function content_location( $content ) {
				?>
						<div class="content-location">
										<?php MPut::_text( $content->get_address() ); ?>
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