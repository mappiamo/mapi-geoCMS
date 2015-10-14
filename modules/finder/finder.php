<?php
/**
 * Created by PhpStorm.
 * User: Laca
 * Date: 2015.10.14.
 * Time: 11:21
 */

	defined('DACCESS') or die;

	class MModule_Finder extends M_Module {
		public function finder() {

			$SearchResult = $this->model('search', $_POST['search']);

			if ($SearchResult) {
				$this->view('default', $SearchResult);
			} else {
				$this->view('default', 'Search string have no result. Please use another keyword.');
			}
		}
	}