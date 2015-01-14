<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_Denied extends M_Module {

		public function denied() {
				$this->set_page_title( '#mappiamo - Access denied' );

				$this->view();
		}

}

?>