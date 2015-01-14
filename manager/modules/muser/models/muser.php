<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_MUser {

		static function get_users() {
				return mapi_list( 'users' );
		}

		static function get_user( $id ) {
				$user = MObject::get( 'user', $id );
				
				if ( $user->get_id() ) return $user;
				return null;
		}


		static function add_user() {
				$user = MObject::create( 'user' );

				$user->set_group_id( MGet::int( 'user_group_id' ) );
				$user->set_username( MGet::string( 'user_username' ) );
				$user->set_email( MGet::string( 'user_email' ) );
				$user->set_name( MGet::string( 'user_name' ) );

				if ( MGet::string( 'user_pass' ) != MGet::string( 'user_pass_repeat' ) ) return mapi_report_message( 'Passwords do not match' );

				$user->add( MGet::string( 'user_pass' ) );

				if ( 0 == ( MMessaging::any_errors() + MMessaging::any_warnings() ) ) return $user;
				else return false;

		}

		static function update_user( $id ) {
				$user = self::get_user( $id );

				if ( $user ) {
						$user->set_group_id( MGet::int( 'user_group_id' ) );
						$user->set_email( MGet::string( 'user_email' ) );
						$user->set_name( MGet::string( 'user_name' ) );

						if ( 1 == MGet::int( 'user_enabled' ) ) $user->set_enabled( 1 );
						else $user->set_enabled( 0 );
						$user->update();
				}
		}

		static function delete_user( $id ) {
				$user = self::get_user( $id );

				if ( $user ) {
						$user->delete();
				}
		}

		static function change_password( $id, $newuser = false ) {
				if ( ! MGet::string( 'user_pass' ) ) return null;

				$user = self::get_user( $id );

				if ( $user ) {
						if ( MGet::string( 'user_pass' ) != MGet::string( 'user_pass_repeat' ) ) return mapi_report_message( 'Passwords do not match' );

						$user->change_password( MGet::string( 'user_pass' ), $newuser );
				}
		}

 		static function data_object( $object = null ) {
 				$data = new stdClass();

 				$inputs = array(
 						'group_id'	=> 'user_group_id',
 						'username' 	=> 'user_username',
 						'email' 	=> 'user_email',
 						'name' 		=> 'user_name',
 						'enabled'   => 'user_enabled'
 				);

 				$data->id = 0;
 				if ( $object && method_exists( $object, 'get_id' ) ) $data->id = $object->get_id();

 				$data->group = 3;
 				if ( MGet::int( $inputs['group_id'] ) ) $data->group = MGet::int( $inputs['group_id'] );
 				elseif ( $object && method_exists( $object, 'get_group_id' ) ) $data->group = $object->get_group_id();

 				$data->username = '';
 				if ( MGet::string( $inputs['username'] ) ) $data->username = MGet::string( $inputs['username'] );
 				elseif ( $object && method_exists( $object, 'get_username' ) ) $data->username = $object->get_username();

 				$data->email = '';
 				if ( MGet::string( $inputs['email'] ) ) $data->email = MGet::string( $inputs['email'] );
 				elseif ( $object && method_exists( $object, 'get_email' ) ) $data->email = $object->get_email();

 				$data->name = '';
 				if ( MGet::string( $inputs['name'] ) ) $data->name = MGet::string( $inputs['name'] );
 				elseif ( $object && method_exists( $object, 'get_name' ) ) $data->name = $object->get_name();

 				$data->enabled = false;
 				if ( MGet::int( $inputs['enabled'] ) && 1 == MGet::int( $inputs['enabled'] ) ) $data->enabled = true;
 				elseif( $object && method_exists( $object, 'is_enabled' ) && $object->is_enabled() ) $data->enabled = true;

 				$data->created = array();
 				if ( $object && method_exists( $object, 'created' ) ) $data->created = $object->created();

 				$data->modified = array();
 				if ( $object && method_exists( $object, 'modified' ) ) $data->modified = $object->modified();

 				$data->created = array();
 				if ( $object && method_exists( $object, 'created' ) ) $data->created = $object->created();

 				$data->modified = array();
 				if ( $object && method_exists( $object, 'modified' ) ) $data->modified = $object->modified();

 				return $data;
 		}

}

?>