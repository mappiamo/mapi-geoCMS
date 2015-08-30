<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_MContent extends M_Module {

		public function mcontent() {
				$this->set_page_title( '#mappiamo - Edit content' );

				$this->add_page_asset( 'css', 'datatables/datatables' );
				$this->add_page_asset( 'js', 'datatables/jquery.dataTables.min' );
				$this->add_page_asset( 'js', 'datatables/jquery.dataTables.bootstrap' );

				$this->add_page_asset( 'css', 'dropzone/dropzone' );
				$this->add_page_asset( 'js', 'dropzone/dropzone.min' );
		}

		public function content_list() {
				$this->set_page_title( '#mappiamo - Contents list' );
				$contents = $this->model( 'get_contents' );
				$this->view( 'default', $contents );
		}

		public function content_add() {
				$this->set_page_title( '#mappiamo - Add content' );

				if ( isset( $_POST['content_add'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) { 
						$content = $this->model( 'add_content' );

						if ( $content && $content->get_id() ) { 
								header( 'Location: index.php?module=mcontent&task=content_edit&object=' . intval( $content->get_id() ) );
								exit( 0 );
						}
				}

				$data = $this->model( 'data_object', 'content_add' );
				$this->view( 'add', $data );
		}

		public function content_add_translation() {
				
				$this->set_page_title( '#mappiamo - Translate content' );
				
				$content = $this->model( 'add_content_translation' );
				if ( $content && $content->get_id() ) { 
						header( 'Location: index.php?module=mcontent&task=content_edit&object=' . intval( $content->get_id() ) );
						exit( 0 );
				}
				
		}
		
		public function content_edit() {
				$this->add_page_asset( 'js', 'tinymce/tinymce.min' );
				$this->add_page_asset( 'js', 'tinymce/tinymce.init' );

				if ( isset( $_POST['content_save'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) {
					$this->model( 'update_content', $this->get_object() );
				}

				$content = $this->model( 'get_content', $this->get_object() );

				if ( $content ) {
						$data = $this->model( 'data_object', array( 'content_edit', $content ) );

						$this->view( 'edit', $data );
						
				} else {
						echo 'Content not found';
				}
		}

		public function content_delete() {
				$this->set_page_title( '#mappiamo - Delete content' );

				if ( isset( $_POST['content_delete'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'delete_content', $this->get_object() );

				$content = $this->model( 'get_content', $this->get_object() );
				if ( $content ) { 
						$this->view( 'delete', $content );
				} else {
						$this->content_list();
				}
		}

		public function content_meta() {
				$this->set_as_ajax();
				
				if ( isset( $_GET['meta_add'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'add_meta', $this->get_object() );
				if ( isset( $_GET['meta_remove'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'delete_meta', $this->get_object() );
		}

		public function content_category() {
				$this->set_as_ajax();
				
				if ( isset( $_GET['category_add'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'add_category', $this->get_object() );
				if ( isset( $_GET['category_remove'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'remove_category', $this->get_object() );
		}

		public function content_media() {
				$this->set_as_ajax();

				if ( isset( $_GET['media_add'] ) && ! empty( $_FILES ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'add_media', $this->get_object() );
				if ( isset( $_GET['media_remove'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'remove_media', $this->get_object() );
				if ( isset( $_GET['media_default'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'default_media', $this->get_object() );
		}

		public function content_import() {
				$this->set_page_title( '#mappiamo - Import content' );

				if ( isset( $_POST['content_import'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) { 
						$content = $this->model( 'import_content' );

						if ( $content && $content->get_id() ) { 
								header( 'Location: index.php?module=mcontent&task=content_edit&object=' . intval( $content->get_id() ) );
								exit( 0 );
						}
				}

				if ( isset( $_POST['import_begin'] ) ) {
						$data = $this->model( 'import', null, 'mcontent_import' );

						$this->view( 'import_results', $data );
				} else {
						$this->view( 'import' );
				}
		}

}

?>