<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_MWidget extends M_Module {

		public function mwidget() {
				$this->set_page_title( '#mappiamo - Widgets' );
		}

		public function widget_list() {
				$widgets = $this->model( 'get_widgets' );
				$forinstall = $this->model( 'get_forinstall' );
				$this->view( 'default', array( 'installed' => $widgets, 'forinstall' => $forinstall ) );
		}

		public function widget_enable() {
				$this->set_as_ajax();

				if ( isset( $_GET['widget_action'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'enable_widget', $this->get_object() );
		}

		public function widget_disable() {
				$this->set_as_ajax();

				if ( isset( $_GET['widget_action'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'disable_widget', $this->get_object() );
		}

		public function widget_install() {
				$this->set_as_ajax();

				if ( isset( $_GET['widget_action'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'install_widget', MGet::string( 'name' ) );
		}

		public function widget_uninstall() {
				if ( isset( $_POST['widget_uninstall'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'uninstall_widgets' );

				$this->widget_list();
		}

}

?>