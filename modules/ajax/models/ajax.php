<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_Ajax {

                static function geocode() {
                                $result = array( 'status' => 'FAIL', 'lat' => null, 'lng' => null );

                                $address = MGet::string( 'address' );

                                if ( ! MValidate::address( $address ) ) return $result;

                                global $geocoder;

                                try {
                                                $geocode = $geocoder->geocode( $address );
                                                $result['status'] = 'OK';
                                                $result['lat'] = $geocode->getLatitude();
                                                $result['lng'] = $geocode->getLongitude();
                                } catch( Exception $e ) {
                                                return $result;
                                }

                                return $result;
                }

}


?>
