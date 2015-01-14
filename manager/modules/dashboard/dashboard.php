<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_Dashboard extends M_Module {

		public function dashboard() {
				$this->set_page_title( '#mappiamo - Dashboard' );

				$this->view();
		}

}

?>