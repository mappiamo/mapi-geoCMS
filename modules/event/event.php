<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_Event extends M_Module {

	public function event() {

		$AllEvents = $this->model('QueryURL');
		$PageTitle = $this->model('GetEventTitle');
		$TemplateName = $this->model('GetTemplateName');

		//print_r($TemplateName);
		//die();

		if ($AllEvents) {
			$this->view( 'default', array($AllEvents, $PageTitle, $TemplateName));
		} else {
			$this->view( 'default', array(array(), $PageTitle, $TemplateName));
		}
	}
}

?>