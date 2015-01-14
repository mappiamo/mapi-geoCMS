<?php

class M_User {

		private $id;
		private $group_id = 0;
		private $username;
		private $password;
		private $email;
		private $name;
		private $created;
		private $createdby;
		private $modified;
		private $modifiedby;
		private $lastlogin;
		private $activation;
		private $enabled = 1;

		public function __construct( $id = null, $byusername = false ) {
				if ( $id ) {
						if ( ! $byusername ) $this->read( $id );
						else $this->read_by_username( $id );
				}
		}

		public function get_id() {
				return $this->id;
		}

		public function get_group_id() {
				return $this->group_id;
		}

		public function get_username() {
				return $this->username;
		}

		public function get_email() {
				return $this->email;
		}

		public function get_name() {
				return $this->name;
		}

		public function get_activation() {
				return $this->activation;
		}

		public function created() {
				$created = array( 'when' => $this->created, 'by' => $this->createdby );

				$user = MObject::get( 'user', $this->createdby );
				if ( $user && $user->get_username() ) $created['by_user'] = $user->get_username();
				else $created['by_user'] = 'N/A';

				return $created;
		}

		public function modified() {
				$modified = array( 'when' => $this->modified, 'by' => $this->modifiedby );

				$user = MObject::get( 'user', $this->modifiedby );
				if ( $user && $user->get_username() ) $modified['by_user'] = $user->get_username();
				else $modified['by_user'] = 'N/A';
		
				return $modified;
		}

		public function is_enabled() {
				if ( 1 == $this->enabled ) return true;

				return false;
		}

		public function compare_pass( $password ) {
				if ( md5( $password ) == $this->password ) return true;

				return false;
		}

		public function compare_lastlogin( $rand, $time, $browser ) {
				$lastlogin = base64_encode( strval( $rand ) ) . '|' . base64_encode( strval( $time ) ) . '|' . base64_encode( strval( $browser ) );

				if ( $lastlogin == $this->lastlogin ) return true;

				return false;
		}

		public function set_id( $value ) {
				$this->id = intval( $value );
		}

		public function set_group_id( $value ) {
				$this->group_id = intval( $value );
		}

		public function set_username( $value ) {
				$this->username = strval( $value );
		}

		public function set_email( $value ) {
				$this->email = strval( $value );
		}

		public function set_name( $value ) {
				$this->name = strval( $value );
		}

		public function set_activation( $value ) {
				$this->activation = strval( $value );
		}

		public function set_enabled( $enabled ) {
				if ( 0 == $enabled || 1 == $enabled ) $this->enabled = $enabled;
		}

		public function update_lastlogin( $rand, $time, $browser ) {
				if ( ! $this->id ) return null;

				$lastlogin = base64_encode( strval( $rand ) ) . '|' . base64_encode( strval( $time ) ) . '|' . base64_encode( strval( $browser ) );

				$user = ORM::for_table( 'users' )->where( 'id', intval( $this->id ) )->find_one();

				if ( $user ) {
						$user->lastlogin = $lastlogin;
						$user->save();
				}
		}

		public function change_password( $password ) {
				if ( ! $this->id ) return false;

				if ( $password && MValidate::password( $password ) ) {
						$user = ORM::for_table( 'users' )->where( 'id', intval( $this->id ) )->find_one();
						if ( $user ) {
								$user->password = md5( $password );
								if ( $user->save() ) return mapi_report_message( 'Password sucessfully updated.', 'success' );
								else return mapi_report_message( 'Password cannot be updated right now.' );
						}
				} else {
						return mapi_report_message( 'Not a valid password.' );
				}
		}

		public function add( $password ) {
				$user = ORM::for_table( 'users' )->create();

				if ( ! $user || ! $this->setup_object( $user ) ) return null;

				$user->created = date_format( new DateTime( 'now' ), 'Y-m-d H:i:s' );
				if ( MAuth::user_id() )$user->createdby = MAuth::user_id();
				else $user->createdby = 1;

				if ( $this->activation ) $user->activation = $this->activation;

				$user->modified = $user->created;
				$user->modifiedby = $user->createdby;

				if( $password && MValidate::password( $password ) ) $user->password = md5( $password );
				else return mapi_report_message( 'Not a valid password.' );

				if ( $user->save() ) {
						$this->set_id( $user->id );
						if ( $this->activation ) mapi_report_message( 'Successfully registered, check your mail.' , 'success' );
						else mapi_report_message( 'New user successfully added.' , 'success' );
				}
		}

		public function update() {
				if ( ! MAuth::user_id() ) return null;

				$user = null;

				if ( $this->id && MValidate::id( $this->id ) ) $user = ORM::for_table( 'users' )->find_one( $this->id );

				if ( ! $user || ! $this->setup_object( $user, true ) ) return null;

				$user->modified = date_format( new DateTime( 'now' ), 'Y-m-d H:i:s' );
				if ( MAuth::user_id() ) $user->modifiedby = MAuth::user_id();
				else $user->modifiedby = 1;

				if ( $user->save() ) mapi_report_message( 'User data sucessfully updated.' , 'success' );
		}

		public function delete() {
				if ( $this->id && MValidate::id( $this->id ) ) {
						$user = ORM::for_table( 'users' )->find_one( intval( $this->id ) );

						if ( $user->delete() ) return mapi_report_message( 'User sucessfully deleted.' , 'success' );
				}
		}

		private function read( $id = null ) {
				if ( ! $id ) return null;
				
				$user = ORM::for_table( 'users' )->where( 'id', intval( $id ) )->find_one();

				if ( ! $user ) return null;
				
				if ( $user->id ) $this->set_id( $user->id );
				if ( $user->group_id ) $this->set_group_id( $user->group_id ); 
				if ( $user->username ) $this->set_username( $user->username );
				if ( $user->password ) $this->password = $user->password;
				if ( $user->email ) $this->set_email( $user->email );
				if ( $user->name ) $this->set_name( $user->name );		
				if ( $user->created ) $this->created = $user->created;
				if ( $user->createdby ) $this->createdby = $user->createdby;
				if ( $user->modified ) $this->modified = $user->modified;
				if ( $user->modifiedby ) $this->modifiedby = $user->modifiedby;
				if ( $user->lastlogin ) $this->lastlogin = $user->lastlogin;
				if ( $user->activation ) $this->activation = $user->activation;
				if ( $user->enabled && 1 == $user->enabled ) $this->enabled = 1;
				else $this->enabled = 0;
		}

		private function read_by_username( $username ) {
				if ( ! $username || ! MValidate::username( $username ) ) return null;

				$user = ORM::for_table( 'users' )->where( 'username', strval( $username ) )->find_one();

				if ( $user && $user->id ) $this->read( $user->id );
		}

		private function setup_object( $user, $newuser = false ) {
				if ( ! $user || ! is_object( $user ) ) return null;

				if ( $this->group_id && MValidate::id( $this->group_id ) ) $user->group_id = $this->group_id;
				else return mapi_report_message( 'Not a valid group.' );

				if ( $this->username && MValidate::username( $this->username ) ) $user->username = $this->username;
				else return mapi_report_message( 'Not a valid username.' );

				if ( ! $newuser ) { 
						if ( ! mapi_check_double( 'users', 'username', $this->username ) ) return mapi_report_message( 'Username not available.' );
				}

				if ( $this->email && MValidate::email( $this->email ) ) $user->email = $this->email;
				else return mapi_report_message( 'Not a valid email address.' );

				if ( $this->name && MValidate::title( $this->name ) ) $user->name = $this->name;
				else return mapi_report_message( 'Not a valid name.' );

				if ( $this->enabled && 1 == $this->enabled ) $user->enabled = 1;
				else $user->enabled = 0;

				return true;
		}

}

?>