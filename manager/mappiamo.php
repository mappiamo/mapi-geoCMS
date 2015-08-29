<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class Mappiamo {

	public function __construct() {
			MMessaging::init();

			$SysConf = new MSettings();

		if (is_array($SysConf::$coords)) {
			global $coords;

			$coords['lat'] = $SysConf::$coords['lat'];
			$coords['lng'] = $SysConf::$coords['lng'];

		} elseif (isset($SysConf::$location)) {
			if ( MValidate::address( $SysConf::$location ) ) {
				global $geocoder;
				global $coords;

				try {
					$geocode = $geocoder->geocode( $SysConf::$location );
					$coords['lat'] = $geocode->getLatitude();
					$coords['lng'] = $geocode->getLongitude();
				} catch( Exception $e ) {

				}
			}

		} else {

			if ( MValidate::address( MSettings::$location ) ) {
				global $geocoder;
				global $coords;

				try {
					$geocode = $geocoder->geocode( MSettings::$location );
					$coords['lat'] = $geocode->getLatitude();
					$coords['lng'] = $geocode->getLongitude();
				} catch( Exception $e ) {

				}
			}
		}

			$routing = new M_URLRouter();

			$module = new M_Module();
			$module_instance = $module->instance( $routing->get_module(), $routing->get_task(), $routing->get_object() );

			$template = new M_Template();
			$template_instance = $template->instance( $module_instance );
	}

}

new Mappiamo();

?>