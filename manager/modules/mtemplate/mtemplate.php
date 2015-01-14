<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_MTemplate extends M_Module {

		public function mtemplate() {
				$this->set_page_title( '#mappiamo - Templates' );
		}

		public function template_list() {
				$templates = $this->model( 'get_templates' );
				$forinstall = $this->model( 'get_forinstall' );
				$this->view( 'default', array( 'installed' => $templates, 'forinstall' => $forinstall ) );
		}

		public function template_enable() {
				$this->set_as_ajax();

				if ( isset( $_GET['template_action'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'enable_template', $this->get_object() );
		}

		public function template_disable() {
				$this->set_as_ajax();

				if ( isset( $_GET['template_action'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'disable_template', $this->get_object() );
		}

		public function template_install() {
				$this->set_as_ajax();

				if ( isset( $_GET['template_action'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'install_template', MGet::string( 'name' ) );
		}

		public function template_uninstall() {
				if ( isset( $_POST['template_uninstall'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'uninstall_templates' );
		
				$this->template_list();
		}

}

?>