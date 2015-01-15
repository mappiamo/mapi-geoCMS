<?php
/**
* @package	#mappiamo
* @version	0.0.6
* @author	Berross s.r.o. <hello@mappiamo.com>
* @copyright    Copyright (C) 2015 Berross s.r.o. All rights reserved.
* @license      GNU/GPL, see LICENSE
*
* #mappiamo is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT for copyright notices and CREDITS for credits details.
*/


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