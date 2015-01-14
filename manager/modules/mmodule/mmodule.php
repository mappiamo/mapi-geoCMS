<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_MModule extends M_Module {

		public function mmodule() {
				$this->set_page_title( '#mappiamo - Modules' );
		}

		public function module_list() {
				$modules = $this->model( 'get_modules' );
				$forinstall = $this->model( 'get_forinstall' );
				$this->view( 'default', array( 'installed' => $modules, 'forinstall' => $forinstall ) );
		}

		public function module_enable() {
				$this->set_as_ajax();

				if ( isset( $_GET['module_action'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'enable_module', $this->get_object() );
		}

		public function module_disable() {
				$this->set_as_ajax();

				if ( isset( $_GET['module_action'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'disable_module', $this->get_object() );
		}

		public function module_install() {
				$this->set_as_ajax();

				if ( isset( $_GET['module_action'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'install_module', MGet::string( 'name' ) );
		}

		public function module_uninstall() {
				if ( isset( $_POST['module_uninstall'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'uninstall_modules' );

				$this->module_list();
		}

}

?>