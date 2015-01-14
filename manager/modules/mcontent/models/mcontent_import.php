<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_MContent_Import {

		static $availables = array( 'facebook' );

		static function import() {
				$what = MGet::string( 'import_what' );

				if ( ! in_array( $what, self::$availables ) ) return null;

				$import_method = 'import_' . $what;

				if ( method_exists( 'MModel_MContent_Import', $import_method ) ) return self::$import_method();

				return null;
		}

		static function import_facebook() {
				$results = array( 'header' => 'Import Facebook events', 'type' => 'event' );

				$facebook = self::facebook_init();
				if ( ! $facebook ) {
						mapi_report( 'Cannot download events, try again later.', 'error' );
						return $results;
				}

				if ( ! $facebook->getUser() ) {
						mapi_report( 'Please login first with your facebook account.' );
						return $results;
				}

				try {
						$events = $facebook->api( '/me/events', 'GET' );
        				
        				if ( isset( $events['data'] ) && is_array( $events['data'] ) && sizeof( $events['data'] ) > 0 ) {
        						$i = 0;
            					foreach ( $events['data'] as $event ) {
            							if ( isset( $event['id'] ) ) {
		                						try{
									                    $query = 'SELECT pic_big, description, creator FROM event WHERE eid = '. $event['id'];

									                    $object = $facebook->api( array( 'method' => 'fql.query', 'query' => $query ) );

									                    $events['data'][$i]['uid'] = $object[0]['creator'];
									                    $events['data'][$i]['image_url'] = $object[0]['pic_big'];
									                    $events['data'][$i]['description'] = $object[0]['description'];
								                }catch( FacebookApiException $e ) {

												}

								                try{
									                    $query = 'SELECT name FROM user WHERE uid = '.$events['data'][$i]['uid'];

									                    $object = $facebook->api( array( 'method' => 'fql.query', 'query' => $query ) );

									                    $events['data'][$i]['host'] = $object[0]['name'];
								                }catch( FacebookApiException $e ){
								                		mapi_report( 'Event data not complete.' );
												}

												if ( isset( $events['data'][$i]['location'] ) && sizeof( isset( $events['data'][$i]['location'] ) ) ) {
														global $geocoder;

														$geocode = $geocoder->geocode( $events['data'][$i]['location'] );
														
														$events['data'][$i]['lat'] = $geocode->getLatitude();
														$events['data'][$i]['lng'] = $geocode->getLongitude();
												}

                								$i++;
        								}
        						}
        				}

        				if ( sizeof( $events['data'] ) > 0 ) $results['data'] = $events['data'];

      			} catch( FacebookApiException $e ) {
      					mapi_report( 'Cannot download events, try again later.', 'error' );
      			}

				return $results;
		}

		static function facebook_init() {
				$appid = MObject::get( 'preference', 'facebook_app_id' );
				$secret = MObject::get( 'preference', 'facebook_secret' );

				$facebook = new Facebook( array( 'appId' => $appid->get_value(), 'secret' => $secret->get_value(), 'allowSignedRequest' => false ) );
  				return $facebook;
		}

		static function facebook_login_link() {
				$appid = MObject::get( 'preference', 'facebook_app_id' );
				$secret = MObject::get( 'preference', 'facebook_secret' );
				$scope = array( 'scope' => 'user_events' );

				$facebook = new Facebook( array( 'appId' => $appid->get_value(), 'secret' => $secret->get_value(), 'allowSignedRequest' => false ) );

				return $facebook->getLoginUrl( $scope );
		}

}

?>