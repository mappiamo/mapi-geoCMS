<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_Ajax extends M_Module {

		public function ajax() {
				if ( ! MValidate::is_ajax() ) die();
		}

		public function geocode() {
				if ( isset( $_GET['address'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $result = $this->model( 'geocode', null );

				if ( $result ) {
						echo json_encode( $result );
				}
		}

}

?>
