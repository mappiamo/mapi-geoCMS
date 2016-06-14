<?php

class M_Meta {
	
		private $id;
		private $external;
		private $external_id;
		private $name;
		private $value;

		private $tables = array(
				'contents'	=> 'content_meta',
				'users' 	=> 'user_meta'
		);

		public function __construct( $external = null, $external_id = null, $name = null ) {
				if ( $external && $external_id && $name ) $this->read( $external, $external_id, $name );
		}

		public function get_id() {
				return $this->id;
		}

		public function get_external() {
				return $this->external;
		}

		public function get_external_id() {
				return $this->external_id;
		}

		public function get_name() {
				return $this->name;
		}

		public function get_value() {
				return $this->value;
		}

		public function set_id( $value ) {
				if ( $id = intval( $value ) ) $this->id = $id;
		}

		public function set_external( $value ) {
				$external = trim( strval( $value ) );
				if ( isset( $this->tables[$external] ) ) $this->external = $external;
		}

		public function set_external_id( $value ) {
				if ( $external_id = intval( $value ) ) $this->external_id = $external_id;
		}

		public function set_name( $value ) {
				if ( $name = strval( $value ) ) $this->name = $name;
		}

		public function set_value( $value ) {
				if ( $val = strval( $value ) ) $this->value = $val;
		}

		public function add() {
				$found_params = true;

				if ( ! $this->external || ! isset( $this->tables[$this->external] ) ) $found_params = false;
				if ( ! $this->external_id || ! MValidate::id( $this->external_id ) ) $found_params = false;

				if ( $this->check_for_existing() ) return mapi_report_message( 'This meta allready exists.' );

				if ( $found_params ) {
						$meta = ORM::for_table( $this->tables[$this->external] )->create();
						$record = ORM::for_table( $this->external )->find_one( $this->external_id );
				}

				if ( $meta && $record ) {
						$meta->external_id = $this->external_id;

						if ( $this->setup_object( $meta ) ) {
								if ( $meta->save() ) return true;
						}
				}

				// $this->update_modified( );  -> see if this is needed ???
		}

		public function update() {
				if ( $this->id && MValidate::id( $this->id ) && isset( $this->tables[$this->external] ) ) 
						$meta = ORM::for_table( $this->tables[$this->external] )->find_one( intval( $this->id ) );

				if ( $meta && $this->setup_object( $meta ) ) {
						if ( $meta->save() ) return true;
				}

				// $this->update_modified( );  -> see if this is needed ???
		}

		public function delete() {
				if ( ! isset( $this->tables[$this->external] ) || ! MValidate::id( $this->external_id ) ) return null;
				if ( ! MValidate::meta_name( $this->name ) ) return null;

				$meta = ORM::for_table( $this->tables[$this->external] )->where( 'external_id', intval( $this->external_id ) )->where( 'name', strval( $this->name ) )->find_one();

				if ( $meta ) {
						$deleted = $meta->delete();

						if ( ! $deleted ) mapi_report_message( 'Sorry, the content meta cannot be deleted this time.' );
				}
		}

		public function read( $external, $external_id, $name ) {
				if ( ! isset( $this->tables[$external] ) || ! MValidate::id( $external_id ) ) return null;

				if ( ! MValidate::meta_name( $name ) ) return null;

				$meta = ORM::for_table( $this->tables[$external] )->where( 'external_id', intval( $external_id ) )->where( 'name', strval( $name ) )->find_one();

				if ( ! $meta ) return null;

				if ( $meta->id ) $this->set_id( $meta->id );
				if ( $meta->name ) $this->set_name( $meta->name );
				if ( $meta->value ) $this->set_value( $meta->value );

				$this->set_external( $external );
				$this->set_external_id( $external_id );
		}

		private function setup_object( $meta ) {

				if ((isset($this->name)) && (isset($this->value))) {
						if ( MValidate::meta_name( $this->name ) ) $meta->name  = $this->name;
						else return mapi_report_message( 'Not a valid meta name: ' . $this->name);

						//if (MValidate::meta_value($this->value)) $meta->value = $this->value;
						//else return mapi_report_message( 'Not a valid meta value: ' . $this->value );
						$meta->value = $this->value;
				}

				return true;
		}

		private function check_for_existing() {
				if ( ! isset( $this->tables[$this->external] ) || ! MValidate::id( $this->external_id ) ) return false;
				if ( ! MValidate::meta_name( $this->name ) ) return false;

				$meta = ORM::for_table( $this->tables[$this->external] )->where( 'external_id', intval( $this->external_id ) )->where( 'name', $this->name )->find_one();

				return $meta;
		}

}


?>