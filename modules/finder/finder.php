<?php

	defined('DACCESS') or die;

	class MModule_Finder extends M_Module {
		public function finder() {                        
			$SearchResult = $this->model('search', $_GET['search']);

			if ($SearchResult) {
				$this->view('default', $SearchResult);
			} else {
				$this->view('default', 'Search string <strong>"'.$_GET['search'].'"</strong> have no result. Please use another keyword.');
			}
		}
	}