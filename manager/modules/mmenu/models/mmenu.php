<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_MMenu {

		static function get_menus() {
				return mapi_list( 'menus' );
		}

		static function get_menu( $id ) {
				$menu = MObject::get( 'menu', $id );
				
				if ( $menu && $menu->get_id() ) return $menu;
				return null;
		}

		static function add_menu() {
				$menu = MObject::create( 'menu' );
				$menu->set_title( MGet::string( 'menu_title' ) );

				$menu->add();

				if ( 0 == ( MMessaging::any_errors() + MMessaging::any_warnings() ) ) return $menu;
				else return false;

		}

		static function update_menu( $id ) {
				$menu = self::get_menu( $id );

				if ( $menu ) {
						$menu->set_title( MGet::string( 'menu_title' ) );
						
						if ( 1 == MGet::int( 'menu_enabled' ) ) $menu->set_enabled( 1 );
						else $menu->set_enabled( 0 );

						$menu->update();
				}
		}

		static function delete_menu( $id ) {
				$menu = self::get_menu( $id );

				if ( $menu ) {
						$menu->delete();
				}
		}

		static function data_object( $object = null ) {
 				$data = new stdClass();

 				$inputs = array(
 						'title' 	=> 'menu_title',
 						'enabled'   => 'menu_enabled'
 				);

 				$data->id = 0;
 				if ( $object && method_exists( $object, 'get_id' ) ) $data->id = $object->get_id();

 				$data->title = '';
 				if ( MGet::string( $inputs['title'] ) ) $data->title = MGet::string( $inputs['title'] );
 				elseif ( $object && method_exists( $object, 'get_title' ) ) $data->title = $object->get_title();

 				$data->enabled = false;
 				if ( MGet::int( $inputs['enabled'] ) && 1 == MGet::int( $inputs['enabled'] ) ) $data->enabled = true;
 				elseif( $object && method_exists( $object, 'is_enabled' ) && $object->is_enabled() ) $data->enabled = true;

 				$data->pages_count = 0;
 				if ( $object && method_exists( $object, 'count_pages' ) ) $data->pages_count = $object->count_pages();

 				$data->pages = array();
 				if ( $object && method_exists( $object, 'get_pages' ) ) $data->pages = $object->get_pages();

 				$data->created = array();
 				if ( $object && method_exists( $object, 'created' ) ) $data->created = $object->created();

 				$data->modified = array();
 				if ( $object && method_exists( $object, 'modified' ) ) $data->modified = $object->modified();

 				return $data;
 		}

}

?>