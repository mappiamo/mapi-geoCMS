<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_MMenu extends M_Module {

		public function mmenu() {
				$this->set_page_title( '#mappiamo - Edit menu' );

				$this->add_page_asset( 'css', 'datatables/datatables' );
				$this->add_page_asset( 'js', 'datatables/jquery.dataTables.min' );
				$this->add_page_asset( 'js', 'datatables/jquery.dataTables.bootstrap' );
		}

		public function menu_list() {
				$this->set_page_title( '#mappiamo - Menus list' );
				$menus = $this->model( 'get_menus' );
				$this->view( 'default', $menus );
		}

		public function menu_add() {
				$this->set_page_title( '#mappiamo - Add a new menu' );

				if ( isset( $_POST['menu_add'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) { 
						$menu = $this->model( 'add_menu' );

						if ( $menu && $menu->get_id() ) { 
								header( 'Location: index.php?module=mmenu&task=menu_list' );
								exit( 0 );
						}
				}

				$data = $this->model( 'data_object' );
				$this->view( 'add', $data );
		}

		public function menu_edit() {
				if ( isset( $_POST['menu_save'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'update_menu', $this->get_object() );

				$menu = $this->model( 'get_menu', $this->get_object() );
				if ( $menu ) {
						$data = $this->model( 'data_object', array( $menu ) );
						$this->view( 'edit', $data );
				} else {
						echo 'Menu not found';
				}
		}

		public function menu_delete() {
				$this->set_page_title( '#mappiamo - Delete menu' );

				if ( isset( $_POST['menu_delete'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'delete_menu', $this->get_object() );

				$menu = $this->model( 'get_menu', $this->get_object() );
				if ( $menu ) { 
						$this->view( 'delete', $menu );
				} else {
						$this->menu_list();
				}
		}

}

?>