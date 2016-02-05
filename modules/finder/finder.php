<?php

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