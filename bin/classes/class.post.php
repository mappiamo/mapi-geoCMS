<?php

class M_Post extends M_Record {
	
		protected $type = 'post';
		protected $url;
		protected $text;

		public function __construct( $id = null ) {
				if ( $id ) $this->read( $id );
		}

		public function get_text() {
				return $this->text;
		}

		public function set_text( $value ) {
				$this->text = strval( $value );
		}

		public function add() {
				$post = $this->add_record();

				if ( $post ) {
						$post->type = $this->type;

						if ( $this->set_vars( $post ) ) $saved = $post->save();
						else $saved = false;
						
						if ( $saved ) { 
							$this->set_id( $post->id );
							return mapi_report_message( 'Your content was sucessfully recorded. Don\'t forget to add some text!' , 'success' );
						}
				}
		}

		public function update() {
				$post = $this->update_record();

				if ( $post ) {
						if ( $this->set_vars( $post ) ) $saved = $post->save();
						else $saved = false;

						if ( $saved ) return mapi_report_message( 'Your content was sucessfully updated.' , 'success' );
				}
		}

		public function delete() {
				$deleted = $this->delete_record();

				if ( $deleted ) return mapi_report_message( 'Your content was sucessfully deleted.' , 'success' );
		}

		protected function read( $id ) {
				if ( ! MValidate::id( $id ) ) return null;

				$post = $this->read_record( $id, $this->type );

				if ( $post && $post->text ) $this->set_text( $post->text );
		}

		protected function set_vars( $post ) {
				if ( ! $post || ! is_object( $post ) ) return null;

				if ( $this->text ) $post->text = MPurifier::clean( $this->text );
				else $this->text = null;

				return true;
		}

}

?>