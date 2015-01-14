<?php

class M_URL extends M_Post {
	
		protected $type = 'url';
		protected $url;
		protected $kind;

		public function __construct( $id = null ) {
				if ( $id ) $this->read( $id );
		}

		public function get_url() {
				return $this->url;
		}

		public function get_kind() {
				return $this->kind;
		}

		public function set_url( $value ) {
				if ( $url = strval( $value ) ) $this->url = $url;
		}

		public function set_kind( $value ) {
				if ( $kind = strval( $value ) ) $this->kind = $kind;
		}

		protected function set_vars( $post ) {
				if ( ! $post || ! is_object( $post ) ) return null;

				if ( $this->text ) $post->text = MPurifier::clean( $this->text );
				else $this->text = '';

				if ( $this->url && MValidate::url( $this->url ) ) $post->url = urlencode( $this->url );
				else return mapi_report_message( 'Not a valid url.' );

				return true;
		}

}

?>