<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_Home extends M_Module {

		public function home() {
				$title = MObject::get( 'preference', 'website_title' );

				if ( strlen( $title->get_value() ) > 0 ) $this->set_page_title( $title->get_value() );
		}

}

?>