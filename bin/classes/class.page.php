<?php

class M_Page {

		private $id;
		private $name;
		private $title;
		private $type = 'url';
		private $url;
		private $blank = 0;
		private $created;
		private $createdby;
		private $modified;
		private $modifiedby;
		private $enabled = 1;

		private $types = array( 'content', 'category', 'module', 'url' );

		public function __construct( $id = null ) {
				if ( $id ) $this->read( $id );
		}

		public function get_id() {
				return $this->id;
		}

		public function get_name() {
				return $this->name;
		}

		public function get_title() {
				return $this->title;
		}

		public function get_type() {
				return $this->type;
		}

		public function get_url() {
				return $this->url;
		}

		public function page_on_blank() {
				if ( 1 == $this->blank ) return true;

				return false;
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

		public function get_menus() {
				if ( $this->id ) return mapi_list_page_menus( $this->id );
				else return array();
		}

		public function set_id( $value ) {
				$this->id = intval( $value );
		}

		public function set_title( $value ) {
				$this->title = strval( $value );
				$this->set_name( mapi_convert_to_name( $this->title ) );
		}

		public function set_name( $value ) {
				$this->name = strval( $value );
		}

		public function set_type( $value ) {
				$this->type = strval( $value );
		}

		public function set_url( $value ) {
				$this->url = strval( $value );
		}

		public function set_on_blank( $blank ) {
				if ( 0 == $blank || 1 == $blank ) $this->blank = $blank;
		}

		public function set_enabled( $enabled ) {
				if ( 0 == $enabled || 1 == $enabled ) $this->enabled = $enabled;
		}

		public function add() {
				if ( ! MAuth::user_id() ) return null;

				$page = ORM::for_table( 'pages' )->create();

				if ( ! $page || ! $this->setup_object( $page, true ) ) return null;

				$page->created = date_format( new DateTime( 'now' ), 'Y-m-d H:i:s' );
				$page->createdby = MAuth::user_id();
				$page->modified = $page->created;
				$page->modifiedby = $page->createdby;

				if ( $page->save() ) {
						$this->set_id( $page->id );
						mapi_report_message( 'New page sucessfully recorded.' , 'success' );
				}
		}

		public function update( $report = true ) {
				if ( ! MAuth::user_id() ) return null;

				$page = null;

				if ( $this->id && MValidate::id( $this->id ) ) $page = ORM::for_table( 'pages' )->find_one( intval( $this->id ) );

				if ( ! $page || ! $this->setup_object( $page ) ) return null;

				$page->modified = date_format( new DateTime( 'now' ), 'Y-m-d H:i:s' );
				$page->modifiedby = MAuth::user_id();

				if ( $page->save() && $report ) mapi_report_message( 'Sucessfully updated.' , 'success' );
		}

		public function delete() {
				if ( $this->id && MValidate::id( $this->id ) ) {
						$page = ORM::for_table( 'pages' )->find_one( intval( $this->id ) );

						if ( $page->delete() ) return mapi_report_message( 'Sucessfully deleted.' , 'success' );
				}
		}

		private function read( $id ) {
				if ( ! $id ) return null;
				
				$page = ORM::for_table( 'pages' )->where( 'id', intval( $id ) )->find_one();

				if ( ! $page ) return null;
				
				if ( $page->id ) $this->set_id( $page->id );
				if ( $page->name ) $this->set_name( $page->name );		
				if ( $page->title ) $this->set_title( $page->title );
				if ( $page->url ) $this->set_url( $page->url );
				if ( $page->created ) $this->created = $page->created;
				if ( $page->createdby ) $this->createdby = $page->createdby;
				if ( $page->modified ) $this->modified = $page->modified;
				if ( $page->modifiedby ) $this->modifiedby = $page->modifiedby;
				if ( $page->enabled && 1 == $page->enabled ) $this->enabled = 1;
				else $this->enabled = 0;
		}

		private function setup_object( $page, $newpage = false ) {
				if ( ! $page || ! is_object( $page ) ) return null;

				if ( $this->title && MValidate::title( $this->title ) ) $page->title = $this->title;
				else { echo $this->title; return mapi_report_message( 'Not a valid page title.' ); }

				$page->name = $this->name;

				if ( $newpage ) {
						if ( ! mapi_check_double( 'pages', 'name', $this->name ) ) return mapi_report_message( 'Page with that name already exists.' );
				}

				if ( in_array( $this->type, $this->types ) ) $page->type = $this->type;
				else $page->type = 'url';

				if ( $this->url && MValidate::url( $this->url ) ) $page->url = $this->url;
				else return mapi_report_message( 'Not a valid url.' );

				if ( $this->blank && 1 == $this->blank ) $page->blank = 1;
				else $page->blank = 0;

				if ( $this->enabled && 1 == $this->enabled ) $page->enabled = 1;
				else $page->enabled = 0;

				return true;
		}

}

?>