<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_MCategory extends M_Module {

		public function mcategory() {
				$this->set_page_title( '#mappiamo - Edit category' );

				$this->add_page_asset( 'css', 'datatables/datatables' );
				$this->add_page_asset( 'js', 'datatables/jquery.dataTables.min' );
				$this->add_page_asset( 'js', 'datatables/jquery.dataTables.bootstrap' );
		}

		public function category_list() {
				$this->set_page_title( '#mappiamo - Categories list' );
				$categories = $this->model( 'get_categories' );
				$this->view( 'default', $categories );
		}

		public function category_add() {
				$this->set_page_title( '#mappiamo - Add category' );

				if ( isset( $_POST['category_add'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) { 
						$category = $this->model( 'add_category' );

						if ( $category && $category->get_id() ) { 
								header( 'Location: index.php?module=mcategory&task=category_list' );
								exit( 0 );
						}
				}

				$data = $this->model( 'data_object', 'category_add' );
				$this->view( 'add', $data );
		}

		public function category_edit() {
				if ( isset( $_POST['category_save'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'update_category', $this->get_object() );

				$category = $this->model( 'get_category', $this->get_object() );
				if ( $category ) {
						$data = $this->model( 'data_object', array( 'category_edit', $category ) );
						$this->view( 'edit', $data );
				} else {
						echo 'Category not found';
				}
		}

		public function category_delete() {
				$this->set_page_title( '#mappiamo - Delete category' );

				if ( isset( $_POST['category_delete'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'delete_category', $this->get_object() );

				$category = $this->model( 'get_category', $this->get_object() );
				if ( $category ) { 
						$this->view( 'delete', $category );
				} else {
						$this->category_list();
				}
		}

}

?>