<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_MUser extends M_Module {

		public function muser() {
				$this->set_page_title( '#mappiamo - Users list' );

				$this->add_page_asset( 'css', 'datatables/datatables' );
				$this->add_page_asset( 'js', 'datatables/jquery.dataTables.min' );
				$this->add_page_asset( 'js', 'datatables/jquery.dataTables.bootstrap' );
		}

		public function user_list() {
				$users = $this->model( 'get_users' );
				$this->view( 'default', $users );
		}

		public function user_add() {
				$this->set_page_title( '#mappiamo - Add user' );

				if ( isset( $_POST['user_add'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) { 
						$user = $this->model( 'add_user' );

						if ( $user && $user->get_id() ) { 
								header( 'Location: index.php?module=muser&task=user_list' );
								exit( 0 );
						}
				}

				$data = $this->model( 'data_object' );
				$this->view( 'add', $data );
		}

		public function user_edit() {
				if ( isset( $_POST['user_save'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'update_user', $this->get_object() );
				if ( isset( $_POST['change_password'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'change_password', $this->get_object() );

				$user = $this->model( 'get_user', $this->get_object() );
				if ( $user ) {
						$data = $this->model( 'data_object', array( $user ) );
						$this->view( 'edit', $data );
				} else {
						echo 'User not found';
				}
		}

		public function user_delete() {
				$this->set_page_title( '#mappiamo - Delete user' );

				if ( isset( $_POST['user_delete'] ) && mapi_csrf_check( MGet::string( 'mapi_csrf' ) ) ) $this->model( 'delete_user', $this->get_object() );

				$user = $this->model( 'get_user', $this->get_object() );

				if ( $user ) { 
						$this->view( 'delete', $user );
				} else {
						$this->user_list();
				}
		}

}

?>