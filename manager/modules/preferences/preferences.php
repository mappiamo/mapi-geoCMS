<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_Preferences extends M_Module {

		public function preferences() {
				$this->set_page_title( '#mappiamo - Preferences' );

				if ( isset( $_POST['preferences_update'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'update_preferences' );

				$preferences = $this->model( 'get_preferences' );
				$this->view( 'default', $preferences );
		}

}

?>