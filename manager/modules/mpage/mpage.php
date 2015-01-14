<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_MPage extends M_Module {

		public function mpage() {
				$this->set_page_title( '#mappiamo - Edit page' );

				$this->add_page_asset( 'css', 'datatables/datatables' );
				$this->add_page_asset( 'js', 'datatables/jquery.dataTables.min' );
				$this->add_page_asset( 'js', 'datatables/jquery.dataTables.bootstrap' );
		}

		public function page_list() {
				$this->set_page_title( '#mappiamo - Pages list' );
				$pages = $this->model( 'get_pages' );
				$this->view( 'default', $pages );
		}

		public function page_add() {
				$this->set_page_title( '#mappiamo - Add page' );

				if ( isset( $_POST['page_add'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) { 
						$page = $this->model( 'add_page' );

						if ( $page && $page->get_id() ) { 
								header( 'Location: index.php?module=mpage&task=page_list' );
								exit( 0 );
						}
				}

				$data = $this->model( 'data_object' );
				$this->view( 'add', $data );
		}

		public function page_edit() {
				if ( isset( $_POST['page_save'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'update_page', $this->get_object() );

				$page = $this->model( 'get_page', $this->get_object() );
				if ( $page ) {
						$data = $this->model( 'data_object', $page );
						$this->view( 'edit', $data );
				} else {
						echo 'Page not found';
				}
		}

		public function page_delete() {
				$this->set_page_title( '#mappiamo - Delete page' );

				if ( isset( $_POST['page_delete'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'delete_page', $this->get_object() );

				$page = $this->model( 'get_page', $this->get_object() );
				if ( $page ) { 
						$this->view( 'delete', $page );
				} else {
						$this->page_list();
				}
		}

		public function page_menu() {
				$this->set_as_ajax();
				
				if ( isset( $_GET['menu_add'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'add_menu', $this->get_object() );
				if ( isset( $_GET['menu_remove'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'remove_menu', $this->get_object() );
		}

}

?>