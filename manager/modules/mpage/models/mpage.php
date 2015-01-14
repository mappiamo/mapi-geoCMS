<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_MPage {

		static function get_pages() {
				return mapi_list( 'pages' );
		}

		static function get_page( $id ) {
				$page = MObject::get( 'page', $id );

				if ( $page && is_numeric( $page->get_id() ) ) return $page;
				else return null;
		}

		static function add_page() {
				$page = MObject::create( 'page' );
				$page->set_type( MGet::string( 'page_type' ) );
				$page->set_title( MGet::string( 'page_title' ) );
				$page->set_url( MGet::string( 'page_url' ) );

				if ( 1 == MGet::int( 'page_on_blank' ) ) $page->set_on_blank( 1 );
				else $page->set_on_blank( 0 );

				$page->add();

				if ( 0 == ( MMessaging::any_errors() + MMessaging::any_warnings() ) ) return $page;
				else return false;

		}

		static function update_page( $id ) {
				$page = self::get_page( $id );

				if ( $page ) {
						$page->set_type( MGet::string( 'page_type' ) );
						$page->set_title( MGet::string( 'page_title' ) );
						$page->set_url( MGet::string( 'page_url' ) );
						
						if ( 1 == MGet::int( 'page_on_blank' ) ) $page->set_on_blank( 1 );
						else $page->set_on_blank( 0 );
						if ( 1 == MGet::int( 'page_enabled' ) ) $page->set_enabled( 1 );
						else $page->set_enabled( 0 );

						$page->update();
				}
		}

		static function delete_page( $id ) {
				$page = self::get_page( $id );

				if ( $page ) {
						$page->delete();
				}
		}

		static function add_menu( $page_id ) {
 				$id = MGet::int( 'menu_id' );
 				$menu = MObject::get( 'menu', $id );

 				if ( $menu ) {
 						$menu->add_page( $page_id );
 						$menu->update( false );
 				}
 		}

 		static function remove_menu( $page_id ) {
 				$id = MGet::int( 'menu_id' );
 				$menu = MObject::get( 'menu', $id );

 				if ( $menu ) {
 						$menu->remove_page( $page_id );
 						$menu->update( false );
 				}
 		}

		static function data_object( $object = null ) {
 				$data = new stdClass();

 				$inputs = array(
 						'title' 	=> 'page_title',
 						'url'		=> 'page_url',
 						'blank'		=> 'page_on_blank',
 						'enabled'   => 'page_enabled'
 				);

 				$data->id = 0;
 				if ( $object && method_exists( $object, 'get_id' ) ) $data->id = $object->get_id();

 				$data->title = '';
 				if ( MGet::string( $inputs['title'] ) ) $data->title = MGet::string( $inputs['title'] );
 				elseif ( $object && method_exists( $object, 'get_title' ) ) $data->title = $object->get_title();

 				$data->url = '';
 				if ( MGet::string( $inputs['url'] ) ) $data->url = MGet::string( $inputs['url'] );
 				elseif( $object && method_exists( $object, 'get_url' ) ) $data->url = $object->get_url();

 				$data->blank = false;
 				if ( MGet::int( $inputs['blank'] ) && 1 == MGet::int( $inputs['blank'] ) ) $data->blank = true;
 				elseif( $object && method_exists( $object, 'page_on_blank' ) && $object->page_on_blank() ) $data->blank = true;

 				$data->enabled = false;
 				if ( MGet::int( $inputs['enabled'] ) && 1 == MGet::int( $inputs['enabled'] ) ) $data->enabled = true;
 				elseif( $object && method_exists( $object, 'is_enabled' ) && $object->is_enabled() ) $data->enabled = true;

 				$data->menus = array();
 				if ( $object && method_exists( $object, 'get_menus' ) ) $data->menus = $object->get_menus();

 				$data->created = array();
 				if ( $object && method_exists( $object, 'created' ) ) $data->created = $object->created();

 				$data->modified = array();
 				if ( $object && method_exists( $object, 'modified' ) ) $data->modified = $object->modified();

 				return $data;
 		}

}

?>