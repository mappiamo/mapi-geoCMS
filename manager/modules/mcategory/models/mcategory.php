<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_MCategory {

		static function get_categories() {
				return mapi_list( 'categories' );
		}

		static function get_category( $id ) {
				$category = MObject::get( 'category', $id );
				
				if ( $category->get_id() ) return $category;
				return null;
		}

		static function add_category() {
				$category = MObject::create( 'category' );
				$category->set_title( MGet::string( 'category_title' ) );

				$category->add();

				if ( 0 == ( MMessaging::any_errors() + MMessaging::any_warnings() ) ) return $category;
				else return false;

		}

		static function update_category( $id ) {
				$category = self::get_category( $id );

				if ( $category ) {
						$category->set_title( MGet::string( 'category_title' ) );
						
						if ( 1 == MGet::int( 'category_enabled' ) ) $category->set_enabled( 1 );
						else $category->set_enabled( 0 );

						if ( MGet::int( 'category_contents' ) ) {
								$category->set_flagship( MGet::int( 'category_contents' ) );
						}

						$category->update();
				}
		}

		static function delete_category( $id ) {
				$category = self::get_category( $id );

				if ( $category ) {
						$category->delete();
				}
		}

		static function data_object( $task, $object = null ) {
 				$data = new stdClass();

 				$inputs = array(
 						'title' 	=> 'category_title',
 						'flagship'	=> 'category_contents',
 						'enabled'   => 'category_enabled'
 				);

 				$data->id = 0;
 				if ( $object && method_exists( $object, 'get_id' ) ) $data->id = $object->get_id();

 				$data->title = '';
 				if ( MGet::string( $inputs['title'] ) ) $data->title = MGet::string( $inputs['title'] );
 				elseif ( $object && method_exists( $object, 'get_title' ) ) $data->title = $object->get_title();

 				$data->flagship = 0;
 				if ( MGet::int( $inputs['flagship'] ) ) $data->flagship = MGet::int( $inputs['flagship'] );
 				elseif( $object && method_exists( $object, 'get_flagship' ) ) $data->flagship = $object->get_flagship();

 				$data->enabled = false;
 				if ( MGet::int( $inputs['enabled'] ) && 1 == MGet::int( $inputs['enabled'] ) ) $data->enabled = true;
 				elseif( $object && method_exists( $object, 'is_enabled' ) && $object->is_enabled() ) $data->enabled = true;

 				$data->content_count = 0;
 				if ( $object && method_exists( $object, 'count_contents' ) ) $data->content_count = $object->count_contents();

 				$data->contents = '';
 				if ( $object && method_exists( $object, 'get_contents' ) ) $data->contents = $object->get_contents();

 				$data->created = array();
 				if ( $object && method_exists( $object, 'created' ) ) $data->created = $object->created();

 				$data->modified = array();
 				if ( $object && method_exists( $object, 'modified' ) ) $data->modified = $object->modified();

 				return $data;
 		}

}

?>