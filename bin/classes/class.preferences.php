<?php

class M_Preference {
	
		private $id;
		private $name;
		private $value;

		public function __construct( $name = null ) {
			if( $name ) $this->read( strtolower( $name ) );
		}

		public function get_id() {
				return $this->id;
		}

		public function get_name() {
				return $this->name;
		}

		public function get_value() {
				return $this->value;
		}

		public function set_value( $value ) {
				if( $value && $val = strval( $value ) ) $this->value = $val;
		}

		public function update() {
				if ( $this->id && MValidate::id( $this->id ) ) $preference = ORM::for_table( 'preferences' )->find_one( $this->id );

				if ( $preference && $this->setup_object( $preference ) ) {
						if ( $preference->save() ) return true;
						else return false;
				}
		}

		private function read( $name ) {
				if ( ! $name ) return null;

				$preference = ORM::for_table( 'preferences' )->where( 'name', strval( $name ) )->find_one();

				if ( ! $preference ) return null;

				if ( $preference->id ) $this->set_id( $preference->id );
				if ( $preference->name ) $this->set_name( $preference->name );
				if ( $preference->value ) $this->set_value( $preference->value );
		}

		private function setup_object( $preference ) {
				if ( ! $preference || ! is_object( $preference ) ) return null;

				if ( $this->name && MValidate::pref_name( $this->name ) ) $preference->name = $this->name;
				else return null;

				if ( $this->value && MValidate::pref_value( $this->value ) ) $preference->value = $this->value;
				else return null;

				return true;
		}

		private function set_id( $value ) {
				if( $value && $id = intval( $value ) ) $this->id = $id;
		}

		private function set_name( $value ) {
				if( $value && $name = strval( $value ) ) $this->name = $name;
		}

}


?>