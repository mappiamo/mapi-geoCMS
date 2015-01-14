<?php

class M_Menu {

		private $id;
		private $name;
		private $title;
		private $pages = array();
		private $created;
		private $createdby;
		private $modified;
		private $modifiedby;
		private $enabled = 1;

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

		public function get_pages() {
				return $this->pages;
		}

		public function count_pages() {
				return sizeof( $this->pages );
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

		public function add_page( $value ) {
				if ( ! $page_id = intval( $value ) ) return null;

				if ( $this->has_page( $page_id ) ) return null;

				$page = MObject::get( 'page', $page_id );
				if ( $page && is_object( $page ) ) {
						$this->pages[] = $page;
				}
		}

		public function remove_page( $value ) {
				if ( ! $page_id = intval( $value ) ) return null;

				$pages = array();
				foreach ( $this->pages as $page ) {
						if ( $page_id != $page->get_id() ) $pages[] = $page;
				}

				$this->pages = $pages;
		}

		public function has_page( $id ) {
				$has = false;

				if ( ! $id ) return $has;

				foreach ( $this->pages as $page ) {
						if ( $id == $page->get_id() ) $has = true;
				}

				return $has;
		}

		public function set_enabled( $enabled ) {
				if ( 0 == $enabled || 1 == $enabled ) $this->enabled = $enabled;
		}

		public function add() {
				if ( ! MAuth::user_id() ) return null;

				$menu = ORM::for_table( 'menus' )->create();

				if ( ! $menu || ! $this->setup_object( $menu, true ) ) return null;

				$menu->created = date_format( new DateTime( 'now' ), 'Y-m-d H:i:s' );
				$menu->createdby = MAuth::user_id();
				$menu->modified = $menu->created;
				$menu->modifiedby = $menu->createdby;

				if ( $menu->save() ) {
						$this->set_id( $menu->id );
						mapi_report_message( 'A new menu was sucessfully recorded.' , 'success' );
				}
		}

		public function update( $report = true ) {
				if ( ! MAuth::user_id() ) return null;

				$menu = null;

				if ( $this->id && MValidate::id( $this->id ) ) $menu = ORM::for_table( 'menus' )->find_one( intval( $this->id ) );

				if ( ! $menu || ! $this->setup_object( $menu ) ) return null;

				$menu->modified = date_format( new DateTime( 'now' ), 'Y-m-d H:i:s' );
				$menu->modifiedby = MAuth::user_id();

				if ( $menu->save() && $report ) mapi_report_message( 'Sucessfully updated.' , 'success' );
		}

		public function delete() {
				if ( $this->id && MValidate::id( $this->id ) ) {
						$menu = ORM::for_table( 'menus' )->find_one( intval( $this->id ) );

						if ( $menu->delete() ) return mapi_report_message( 'Sucessfully deleted.' , 'success' );
				}
		}

		private function read( $id ) {
				if ( ! $id ) return null;
				
				$menu = ORM::for_table( 'menus' )->where( 'id', intval( $id ) )->find_one();

				if ( ! $menu ) return null;
				
				if ( $menu->id ) $this->set_id( $menu->id );
				if ( $menu->name ) $this->set_name( $menu->name );		
				if ( $menu->title ) $this->set_title( $menu->title );
				if ( $menu->pages ) $this->read_pages( $menu->pages );
				if ( $menu->created ) $this->created = $menu->created;
				if ( $menu->createdby ) $this->createdby = $menu->createdby;
				if ( $menu->modified ) $this->modified = $menu->modified;
				if ( $menu->modifiedby ) $this->modifiedby = $menu->modifiedby;
				if ( $menu->enabled && 1 == $menu->enabled ) $this->enabled = 1;
				else $this->enabled = 0;
		}

		private function setup_object( $menu, $newmenu ) {
				if ( ! $menu || ! is_object( $menu ) ) return null;

				if ( $this->title && MValidate::title( $this->title ) ) $menu->title = $this->title;
				else return mapi_report_message( 'Not a valid title.' );

				$menu->name = $this->name;

				if ( $newmenu ) {
						if ( ! mapi_check_double( 'menus', 'name', $this->name ) ) return mapi_report_message( 'Menu with that name already exists.' );
				}

				$menu->pages = $this->save_pages();

				if ( $this->enabled && 1 == $this->enabled ) $menu->enabled = 1;
				else $menu->enabled = 0;

				return true;
		}

		private function read_pages( $pages ) {
				if ( ! $pages || strlen( $pages ) < 3 ) return array();

				$pages_array = explode( ';' , $pages );
				if ( sizeof( $pages_array ) > 0 ) {
						foreach ( $pages_array as $pg_wid ) {
								$pg_id = trim( $pg_wid, '{}' );
								if ( $pg_id ) $this->add_page( $pg_id );
						}
				}
				$this->save_pages();
		}

		private function save_pages() {
				if ( ! sizeof( $this->pages ) > 0 ) return null;

				$pages = '';
				foreach ( $this->pages as $page ) {
						if ( method_exists( $page,  'get_id' )  && is_numeric( $page->get_id() ) ) {
								$pages .= '{' . $page->get_id() . '};';
						}
				}

				$pages = rtrim( $pages, ';' );
				return $pages;
		}

}

?>