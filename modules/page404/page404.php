<?php

	// no direct access to this file
	defined('DACCESS') or die;

	class MModule_page404 extends M_Module {

		private $content;
		private $content_id;

		public function page404() {
					$this->view('default');
		}


	}

?>
