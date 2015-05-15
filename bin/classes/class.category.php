<?php

class M_Category {

		private $id;
		private $name;
		private $title;
		private $contents = array();
		private $flagship = 0;
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

		public function get_contents() {
				return $this->contents;
		}

		public function count_contents() {
				return sizeof( $this->contents );
		}

		public function get_flagship() {
				return $this->flagship;
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

		public function permission( $id = null ) {
				if ( ! MAuth::is_auth() ) return false;

				if ( MAuth::group_id() > 2 ) {
						if ( ! $id ) {
								if ( MAuth::user_id() != $this->createdby ) return false;
						} else {
								if ( MAuth::user_id() != $id ) return false;
						}
				}

				if ( MAuth::group_id() > 3 ) return false;

				return true;
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

		public function add_content( $value ) {
				if ( ! $content_id = intval( $value ) ) return null;

				if ( $this->has_content( $content_id ) ) return null;

				$content = MObject::get( 'content', $content_id );
				if ( $content && is_object( $content ) ) {
						$this->contents[] = $content;
				}
		}

		public function remove_content( $value ) {
				if ( ! $content_id = intval( $value ) ) return null;

				$contents = array();
				foreach ( $this->contents as $content ) {
						if ( $content_id != $content->get_id() ) $contents[] = $content;
				}

				$this->contents = $contents;
		}

		public function has_content( $id ) {
				$has = false;

				if ( ! $id ) return $has;

				foreach ( $this->contents as $content ) {
						if ( $id == $content->get_id() ) $has = true;
				}

				return $has;
		}

		public function set_flagship( $value ) {
				$this->flagship = intval( $value );
		}

		public function set_enabled( $enabled ) {
				if ( 0 == $enabled || 1 == $enabled ) $this->enabled = $enabled;
		}

		public function add() {
				if ( ! MAuth::user_id() ) return null;

				$category = ORM::for_table( 'categories' )->create();

				if ( ! $category || ! $this->setup_object( $category, true ) ) return null;

				$category->created = date_format( new DateTime( 'now' ), 'Y-m-d H:i:s' );
				$category->createdby = MAuth::user_id();
				$category->modified = $category->created;
				$category->modifiedby = $category->createdby;

				if ( $category->save() ) {
						$this->set_id( $category->id );
						mapi_report_message( 'Your category was sucessfully recorded.' , 'success' );
				}
		}

		public function update( $report = true ) {
				if ( ! $this->permission() ) return mapi_report( 'No permission to edit this category' );

				if ( ! MAuth::user_id() ) return null;

				$category = null;

				if ( $this->id && MValidate::id( $this->id ) ) $category = ORM::for_table( 'categories' )->find_one( intval( $this->id ) );

				if ( ! $category || ! $this->setup_object( $category ) ) return null;

				$category->modified = date_format( new DateTime( 'now' ), 'Y-m-d H:i:s' );
				$category->modifiedby = MAuth::user_id();

				if ( $category->save() && $report ) mapi_report_message( 'Your category was sucessfully updated.' , 'success' );
		}

		public function delete() {
				if ( ! $this->permission() ) return mapi_report( 'No permission to edit this category' );

				if ( $this->id && MValidate::id( $this->id ) ) {
						$category = ORM::for_table( 'categories' )->find_one( intval( $this->id ) );

						if ( $category->delete() ) return mapi_report_message( 'Your category was sucessfully deleted.' , 'success' );
				}
		}

		private function read( $id ) {
				if ( ! $id ) return null;
				if ( is_numeric( $id ) ) $category = ORM::for_table( 'categories' )->where( 'id', intval( $id ) )->find_one();
				if ( is_string( $id ) ) $category = ORM::for_table( 'categories' )->where( 'name', $id )->find_one();

				if ( ! $category ) return null;
				
				if ( $category->id ) $this->set_id( $category->id );
				if ( $category->name ) $this->set_name( $category->name );		
				if ( $category->title ) $this->set_title( $category->title );
				if ( $category->contents ) $this->read_contents( $category->contents );
				if ( $category->flagship ) $this->set_flagship( $category->flagship );
				if ( $category->created ) $this->created = $category->created;
				if ( $category->createdby ) $this->createdby = $category->createdby;
				if ( $category->modified ) $this->modified = $category->modified;
				if ( $category->modifiedby ) $this->modifiedby = $category->modifiedby;
				if ( $category->enabled && 1 == $category->enabled ) $this->enabled = 1;
				else $this->enabled = 0;
		}

		private function setup_object( $category, $new = false ) {
				if ( ! $category || ! is_object( $category ) ) return null;

				if ( $this->title && MValidate::title( $this->title ) ) $category->title = $this->title;
				else return mapi_report_message( 'Not a valid category title: ' . $this->title );

				$category->name = $this->name;

				if ( $new ) {
						if ( ! mapi_check_double( 'categories', 'name', $this->name ) ) return mapi_report_message( 'Category with that name already exists: ' . $this->name );
				}

				$category->contents = $this->save_contents();

				if ( $this->flagship ) {
						if ( MValidate::id( $this->flagship ) ) $category->flagship = $this->flagship;
						else return mapi_report_message( 'Not a valid flagship product.' );
				}

				if ( $this->enabled && 1 == $this->enabled ) $category->enabled = 1;
				else $category->enabled = 0;

				return true;
		}

		private function read_contents( $contents ) {
				if ( ! $contents || strlen( $contents ) < 3 ) return array();

				$contents_array = explode( ';' , $contents );
				if ( sizeof( $contents_array ) > 0 ) {
						foreach ( $contents_array as $cat_wid ) {
								$cat_id = trim( $cat_wid, '{}' );
								if ( $cat_id ) $this->add_content( $cat_id );
						}
				}
				$this->save_contents();
		}

		private function save_contents() {
				if ( ! sizeof( $this->contents ) > 0 ) return null;

				$contents = '';
				foreach ( $this->contents as $content ) {
						if ( method_exists( $content,  'get_id' )  && is_numeric( $content->get_id() ) ) {
								$contents .= '{' . $content->get_id() . '};';
						}
				}

				$contents = rtrim( $contents, ';' );
				return $contents;
		}

}

?>