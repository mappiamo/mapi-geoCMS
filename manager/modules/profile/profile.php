<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_Profile extends M_Module {

		public function profile() {
				$this->set_page_title( '#mappiamo - Profile' );

				if ( isset( $_POST['profile_update'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'update_profile' );
				if ( isset( $_POST['change_password'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'change_password' );

				$profile = $this->model( 'get_profile' );
				$this->view( 'default', $profile );
		}

}

?>