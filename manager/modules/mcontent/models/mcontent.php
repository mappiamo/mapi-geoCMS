<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_MContent {

		static function get_contents() {
				return mapi_list( 'contents' );
		}

		static function get_content( $id ) {
				return MObject::get( 'content', $id );
		}

		static function add_content() {

				if ( ! isset( $_POST['content_type'] ) ) return false;

				switch ( MGet::string( 'content_type' ) ) {
						case 'post':
								$content = MObject::create( 'post' );
								$content->set_title( MGet::string( 'post_title' ) );
								$content->set_license( MGet::int( 'post_license' ) );
						break;
						case 'place':
								$content = MObject::create( 'place' );
								$content->set_title( MGet::string( 'place_title' ) );
								$content->set_license( MGet::int( 'place_license' ) );
						break;
						case 'route':
							$content = MObject::create( 'route' );
							$content->set_title( MGet::string( 'route_title' ) );
							$content->set_license( MGet::int( 'route_license' ) );
						break;
						case 'event':
								$content = MObject::create( 'event' );
								$content->set_title( MGet::string( 'event_title' ) );
								$content->set_start( MGet::string( 'event_start' ) );
								$content->set_end( MGet::string( 'event_end' ) );
								$content->set_license( MGet::int( 'event_license' ) );
						break;
					
					default:
							return false;
					break;
				}

				if ( is_object( $content ) ) {
						$content->set_address( MGet::string( 'content_address' ) );
						$content->set_lat( MGet::double( 'content_lat' ) );
						$content->set_lng( MGet::double( 'content_lng' ) );
						$content->set_route( MGet::string( 'content_route' ) );
				}

				$content->add();

				if ( 0 == ( MMessaging::any_errors() + MMessaging::any_warnings() ) ) return $content;
				else return false;

		}
				
		static function add_content_translation() {
				$id = intval( $_GET["object"] );
				$language = strval( $_GET["language"] );
				
				$content = self::get_content( $id );
				if ( strval( $language ) == $content->get_language() ) {
						return $content;
				}
				if ( $content->get_parent() ) {
						$translations = ORM::for_table( 'contents' )->where_raw('(`id` = ? OR `parent` = ?)', array(intval( $content->get_parent() ), intval( $content->get_parent() )))->find_many();
				}
				else {
						$translations = ORM::for_table( 'contents' )->where( 'parent', intval( $content->get_id() ) )->find_many();	
				}
				
				foreach( $translations as $translation ) {
						if ( $language == $translation->get( "language" ) ) {
								return self::get_content( $translation->get( "id" ) );
						}
				}
				
				$translated_content = MObject::create( $content->get_type() );
				$translated_content->set_title( $content->get_title() . " (" . substr( $language, 0, 2 ) . ")" );
				$translated_content->set_license( $content->get_license() );
				$translated_content->set_address( $content->get_address() );
				$translated_content->set_lat( $content->get_lat() );
				$translated_content->set_lng( $content->get_lng() );
				$translated_content->set_route( $content->get_route() );

				$translated_content->set_start( date("Y-m-d H:i", strtotime($content->get_start())) );
				$translated_content->set_end( date("Y-m-d H:i", strtotime($content->get_end())) );
				//		$translated_content->set_id( $content->get_id() );

				$translated_content->set_text( $content->get_text() );
				$content_metas = $content->get_meta();
				if ( $content->get_parent() ) {
						$translated_content->set_parent( intval( $content->get_parent() ) );
				}
				else {
						$translated_content->set_parent( $id );
				}
				$translated_content->set_language( $language );
				$content_categories = $content->get_categories();
				
				
				$translated_content->add();
				//var_dump($content_categories); //die();
				foreach( $content_categories as $cat ) {
					$category = new M_Category( intval($cat->get("id")) );
					
					$category->add_content( $translated_content->get_id() );
					
					$category->update();
				}
				foreach( $content_metas as $meta ) {
						$translated_content->add_meta( $meta->get("name"), $meta->get("value") );
				}

				return $translated_content;
				
		}
				
		static function import_content() {
				if ( ! isset( $_POST['content_type'] ) ) return false;

				$content = MObject::create( MGet::string( 'content_type' ) );

				if ( ! $content ) return false;

				$content->set_title( MGet::string( 'content_title' ) );
				$content->set_license( 2 );
				$content->set_address( MGet::string( 'content_address' ) );
				$content->set_lat( MGet::double( 'content_lat' ) );
				$content->set_lng( MGet::double( 'content_lng' ) );
				$content->set_route( MGet::string( 'content_route' ) );

				if ( 'event' == MGet::string( 'content_type' ) ) {
						$content->set_start( MGet::string( 'content_start' ) );
						$content->set_end( MGet::string( 'content_end' ) );
				}

				$content->set_text( MGet::string( 'content_text' ) );

				$content->add();

				if ( 0 == ( MMessaging::any_errors() + MMessaging::any_warnings() ) ) return $content;
				else return false;

		}

		static function update_content( $id ) {
				$content = self::get_content( $id );

				if ( $content ) {
						$content->set_title( MGet::string( 'content_title' ) );
						$content->set_text( MGet::string( 'content_text' ) );
						$content->set_address( MGet::string( 'content_address' ) );
						$content->set_lat( MGet::double( 'content_lat' ) );
						$content->set_lng( MGet::double( 'content_lng' ) );
						$content->set_route( MGet::string( 'content_route' ) );
						$content->set_license( MGet::int( 'content_license' ) );

						if ( 'event' == $content->get_type() ) {
								$content->set_start( MGet::string( 'content_start' ) );
								$content->set_end( MGet::string( 'content_end' ) );
						}

						if ( 1 == MGet::int( 'content_enabled' ) ) $content->set_enabled( 1 );
						else $content->set_enabled( 0 );

						$content->update();
				}
		}

		static function delete_content( $id ) {
				$content = self::get_content( $id );

				if ( $content ) {
						$content->delete();
				}
		}

		static function add_meta( $id ) {
				$content = self::get_content( $id );

				if ( $content ) {
						$content->add_meta( MGet::string( 'meta_name', 'GET' ), MGet::string( 'meta_value', 'GET' ) );
				}
 		}

 		static function delete_meta( $id ) {
 				$content = self::get_content( $id );

 				if ( $content ) {
 						$content->delete_meta( MGet::string( 'meta_name', 'GET' ) );
 				}
 		}

 		static function add_category( $content_id ) {
 				$id = MGet::int( 'category_id' );
 				$category = MObject::get( 'category', $id );

 				if ( $category ) {
 						$category->add_content( $content_id );
 						$category->update( false );
 				}
 		}

 		static function remove_category( $content_id ) {
 				$id = MGet::int( 'category_id' );
 				$category = MObject::get( 'category', $id );

 				if ( $category ) {
 						$category->remove_content( $content_id );
 						$category->update( false );
 				}
 		}

 		static function default_media( $content_id ) {
 				$id = MGet::int( 'media_id' );

 				$media_records = ORM::for_table( 'content_media' )->where( 'external_id', intval( $content_id ) )->find_many();
 				if ( sizeof( $media_records ) > 0 ) {
 						foreach ( $media_records as $media ) {
 								if ( $id == $media->id ) $media->default_media = 1;
 								else $media->default_media = 0;

 								$media->save();
 						}
 				}
 		}

 		static function add_media( $id ) {
				$upload = MGet::file();

				if ( ! $upload ) return null;
				if ( ! isset( $upload['name'] ) ) return null;
				if ( ! isset( $upload['size'] ) ) return null;
				if ( ! isset( $upload['tmp'] ) ) return null;

				if ( ! MValidate::mime_type( $upload['tmp'], 'image' ) ) return null;

				if ( ! MValidate::file_size( $upload['size'] ) ) return null;

				$title = null;
				$name_array = explode( '.', $upload['name'] );
				if ( isset( $name_array[0] ) && strlen( $name_array[0] ) > 0 ) {
						if ( MValidate::title( $name_array[0] ) ) $title = $name_array[0];
				}

				$mapi_url = mapi_url_current();

				$url = '';
				if ( isset( $mapi_url['host'] ) && strlen( $mapi_url['host'] ) > 0 ) {
						$url .= $mapi_url['protocol'] . '://';
						$url .= $mapi_url['host'];

						if ( '80' != $mapi_url['port'] ) $url .= ':' . $mapi_url['port'];

						$url .= str_replace( 'manager', 'media', RPATH );
						
						$url .= '/contents/';
						$url .= sha1_file( $upload['tmp'] ) . '_' . $upload['name'];
				}

				if ( ! strlen( $url ) > 0 ) return null;

				$upload['path'] = APATH . '/media/contents/' . sha1_file( $upload['tmp'] ) . '_' . $upload['name'];

				if ( ! move_uploaded_file( $upload['tmp'], $upload['path'] ) ) return null;

				$content = self::get_content( $id );

				if ( $content ) {
						$img = ORM::for_table( 'content_media' )->create();
						$img->external_id = $id;
						$img->title = $title;
						$img->url = $url;
						$img->save();
				}
		}

 		static function remove_media( $content_id ) {
 				$id = MGet::int( 'media_id' );

 				$media = ORM::for_table( 'content_media' )->where( 'id', intval( $id ) )->where( 'external_id', intval( $content_id ) )->find_one();
 				if( $media ) $media->delete();
 		}

 		static function data_object( $task, $object = null ) {
 				$data = new stdClass();

 				$inputs = array(
 						'type'		=> 'content_type',
 						'title' 	=> 'content_title',
 						'address' 	=> 'content_address',
 						'lat' 		=> 'content_lat',
 						'lng' 		=> 'content_lng',
 						'start'		=> 'content_start',
 						'end'		=> 'content_end',
 						'license'	=> 'content_license',
 						'enabled'   	=> 'content_enabled', 
 						'text'		=> 'content_text',
						'route'		=> 'content_route'
 				);

 				if ( 'content_add' == $task && MGet::string( 'content_type' ) ) {
 						if ( 'post' == MGet::string( 'content_type' ) ) { 
 								$inputs['title'] = 'post_title';
 								$inputs['license'] = 'post_license';
 						}
 						
 						if ( 'place' == MGet::string( 'content_type' ) ) {
 								$inputs['title'] = 'place_title';
 								$inputs['license'] = 'place_license';
 						}

						if ( 'route' == MGet::string( 'content_type' ) ) {
								$inputs['title'] = 'route_title';
								$inputs['license'] = 'route_license';
						}

 						if ( 'event' == MGet::string( 'content_type' ) ) {
 								$inputs['title'] = 'event_title';
 								$inputs['start'] = 'event_start';
 								$inputs['end'] = 'event_end';
 								$inputs['license'] = 'event_license';
 						}
 				}

 				$data->id = 0;
 				if ( $object && method_exists( $object, 'get_id' ) ) $data->id = $object->get_id();

 				if ( MGet::string( $inputs['type'] ) ) $data->type = MGet::string( $inputs['type'] );
 				elseif ( $object && method_exists( $object, 'get_type' ) ) $data->type = $object->get_type();

 				$data->title = '';
 				if ( MGet::string( $inputs['title'] ) ) $data->title = MGet::string( $inputs['title'] );
 				elseif ( $object && method_exists( $object, 'get_title' ) ) $data->title = $object->get_title();

 				$data->address = '';
 				if ( MGet::string( $inputs['address'] ) ) $data->address = MGet::string( $inputs['address'] );
 				elseif ( $object && method_exists( $object, 'get_address' ) ) $data->address = $object->get_address();

 				$data->lat = '';
 				if ( MGet::double( $inputs['lat'] ) ) $data->lat = MGet::double( $inputs['lat'] );
 				elseif ( $object && method_exists( $object, 'get_lat' ) ) $data->lat = $object->get_lat();

 				$data->lng = '';
 				if ( MGet::double( $inputs['lng'] ) ) $data->lng = MGet::double( $inputs['lng'] );
 				elseif ( $object && method_exists( $object, 'get_lng' ) ) $data->lng = $object->get_lng();

				$data->route = '';
				if ( MGet::string( $inputs['route'] ) ) $data->route = MGet::string( $inputs['route'] );
				elseif ( $object && method_exists( $object, 'get_route' ) ) $data->route = $object->get_route();

 				$data->start = '';
 				if ( MGet::string( $inputs['start'] ) ) $data->start = MGet::string( $inputs['start'] );
 				elseif ( $object && method_exists( $object, 'get_start' ) ) $data->start = $object->get_start();

 				$data->end = '';
 				if ( MGet::string( $inputs['end'] ) ) $data->end = MGet::string( $inputs['end'] );
 				elseif ( $object && method_exists( $object, 'get_end' ) ) $data->end = $object->get_end();

 				$data->license = 0;
 				if ( MGet::int( $inputs['license'] ) ) $data->license = MGet::int( $inputs['license'] );
 				elseif ( $object && method_exists( $object, 'get_license' ) ) $data->license = $object->get_license();

 				$data->enabled = false;
 				if ( MGet::int( $inputs['enabled'] ) && 1 == MGet::int( $inputs['enabled'] ) ) $data->enabled = true;
 				elseif( $object && method_exists( $object, 'is_enabled' ) && $object->is_enabled() ) $data->enabled = true; 

 				$data->text = '';
 				if ( MGet::string( $inputs['text'] ) ) $data->text = MGet::string( $inputs['text'] );
 				elseif( $object && method_exists( $object, 'get_text' ) ) $data->text = $object->get_text();

 				$data->hits = '';
 				if ( $object && method_exists( $object, 'get_hits' ) ) $data->hits = $object->get_hits();
 				
				$data->parent = '';
 				if ( $object && method_exists( $object, 'get_parent' ) ) $data->parent = $object->get_parent();
 				
				$data->language = '';
 				if ( $object && method_exists( $object, 'get_language' ) ) $data->language = $object->get_language();

 				$data->categories = array();
 				if ( $object && method_exists( $object, 'get_categories' ) ) $data->categories = $object->get_categories();

 				$data->meta = array();
 				if ( $object && method_exists( $object, 'get_meta' ) ) $data->meta = $object->get_meta();

 				$data->media = array();
 				if ( $object && method_exists( $object, 'get_media' ) ) $data->media = $object->get_media();

 				$data->created = array();
 				if ( $object && method_exists( $object, 'created' ) ) $data->created = $object->created();

 				$data->modified = array();
 				if ( $object && method_exists( $object, 'modified' ) ) $data->modified = $object->modified();

 				return $data;
 		}

}

?>