<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_Register extends M_Module {

		public function register() {
				$reg_allowed = MObject::get( 'preference', 'registration' );

				if ( 'yes' == $reg_allowed->get_value() ) {
						if ( isset( $_POST['do-register'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'register' );

						if ( isset( $_GET['activate'] ) && 1 == $_GET['activate'] ) $this->model( 'activate' );

						$this->view();
				} else {
						header( 'Location: ../index.php' );
						exit( 0 );
				}
		}
		
}

?>