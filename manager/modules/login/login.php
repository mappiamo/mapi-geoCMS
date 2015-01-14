<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_Login extends M_Module {

		public function login() {
				$this->set_page_title( '#mappiamo - Login' );

				if( isset( $_POST['do-login'] ) ) {
						if ( isset( $_POST['remember'] ) ) MAuth::$remember = true;
						
						MAuth::do_login();
				}

				if( isset( $_POST['do-logout'] ) ) MAuth::do_logout();

				$this->view();
		}

}

?>