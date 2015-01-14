<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class Mappiamo {

		public function __construct() {
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

				$routing = new M_Route();

				$module = new M_Module();
				$module_instance = $module->instance( $routing->get_module(), $routing->get_task(), $routing->get_object() );

				$template = new M_Template();
				$template_instance = $template->instance( $module_instance );
		}

}

new Mappiamo();

?>