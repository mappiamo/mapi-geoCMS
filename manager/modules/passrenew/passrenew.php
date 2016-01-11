<?php
	/**
	 * Created by PhpStorm.
	 * User: Laca
	 * Date: 2016.01.07.
	 * Time: 12:58
	 */

	defined( 'DACCESS' ) or die;

	class MModule_Passrenew extends M_Module {

		public function passrenew() {
			$this->set_page_title('#mappiamo - Password renew');

			if ($this->model('renewprocess') == TRUE) {
				$this->view('newpassdone');
			} else {
				if ($this->model('check_email') == TRUE) {
					$this->view('mail_sent');
				} else {
					if (isset($_GET['activate']) && 1 == $_GET['activate']) {
						if (is_object($this->model('activate'))) {
							$this->view('getnewpass', $this->model('activate'));
						}
					} else {
						$this->view();
					}
				}
			}
		}

	}