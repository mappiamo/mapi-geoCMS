<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mapi_list( $what, $props = array() ) {
		if ( ! in_array( $what,  mapi_list_availables() ) ) return array();

		$table = preg_replace( '/installed_/', '', $what );

		$results = ORM::for_table( $table );

		if ( 'users' == $what ) $results->where_gt( 'id', 1 );

		if ( isset( $props['status'] ) ) {
				if ( 'enabled' == $props['status'] ) $results->where( 'enabled', 1 );
				elseif( 'disabled' == $props['status'] ) $results->where( 'enabled', 0 );
		}

		if ( isset( $props['env'] ) ) {
				if ( 'manager' == $props['env'] ) $results->where( 'manager', 1 );
				elseif ( 'frontend' == $props['env'] ) $results->where( 'manager', 0 );
		}

		if ( isset( $props['external_id'] ) ) $results->where( 'external_id', intval( $props['external_id'] ) );

		if ( isset( $props['join'] ) ) {
				$join = $props['join'];

				if ( isset( $join['table'] ) && isset( $join['local_key'] ) && isset( $join['foreign_key'] ) ) {
						if ( in_array( $join['table'], mapi_list_availables() ) )  
								$results->join( $join['table'], array(  $what . '.' . $join['local_key'], '=',  $join['table'] . '.' . $join['foreign_key'] ) );
				}
		}

		if ( isset( $props['orderby'] ) ) {
				$orderby = $props['orderby'];

				if ( isset( $orderby['column'] ) ) {
						if ( isset( $orderby['desc'] ) && $orderby['desc'] ) $results->order_by_desc( $orderby['column'] );
						else $results->order_by_asc( $orderby['column'] );
				}
		}

		switch ( $what ) {
				case 'installed_modules':
				case 'installed_templates':
				case 'installed_widgets':
						return mapi_extension_array( $results->find_many() );
				break;
		}
 
		return $results->find_many();
}

function mapi_list_availables() {
		return array(
				'categories',
				'contents',
				'content_media',
				'content_meta',
				'licenses',
				'menus',
				'modules',
				'installed_modules',
				'installed_templates',
				'installed_widgets',
				'pages',
				'preferences',
				'templates',
				'widgets',
				'users',
				'user_groups'
		);
}

function mapi_list_content_categories( $id ) {
		if ( ! MValidate::id( $id ) ) return array();

		return ORM::for_table( 'categories' )->where_like( 'contents', '%{' . intval( $id ) . '}%' )->find_many();
}

function mapi_list_page_menus( $id ) {
		if ( ! MValidate::id( $id ) ) return array();

		return ORM::for_table( 'menus' )->where_like( 'pages', '%{' . intval( $id ) . '}%' )->find_many();
}

function mapi_for_activation() {
		$for_activation = array();

		$results = ORM::for_table( 'users' )->select( 'activation' )->where( 'enabled', 0 )->find_many();

		if ( ! sizeof( $results ) > 0 ) return $for_activation;

		foreach ( $results as $result ) {
				if ( strlen( $result->activation ) > 24 ) $for_activation[] = $result->activation;
		}

		return $for_activation;
}

function mapi_extension_array( $orm_results ) {
		$extensions = array();

		if ( $orm_results && sizeof( $orm_results ) > 0 ) {
				foreach ( $orm_results as $result ) $extensions[$result->id] = $result->name;
		}

		return $extensions;
}

function mapi_2stdclass( $input = array(), $methods = array() ) {
		$objects = array();

		if ( ! sizeof( $input ) > 0 ) return $objects;
		if ( ! sizeof( $methods ) > 0 ) return $objects;

		foreach ( $input as $obj ) {
				$object = new stdClass();
				foreach ( $methods as $key => $method ) {
						if ( method_exists( $obj, $method ) ) $object->{$key} = $obj->$method();
				}
				$objects[] = $object;
		}

		return $objects;
}

function mapi_get_one_media( $id, $default = false ) {
		if ( ! mapi_id_exists( $id, 'contents' ) ) return null;

		$media = ORM::for_table( 'content_media' );
		$media->where( 'external_id', $id );

		if ( $default ) $media->where( 'default_media', 1 );

		$result = $media->find_one();
		
		if ( $result ) {
				$ma = array( 'title' => '', 'url' => '' );
				if ( $result->title ) $ma['title'] = $result->title;
				if ( $result->url ) $ma['url'] = $result->url;
				
				return $ma;
		}

		return null;
}

function mapi_get_default_media( $id, $failover = false ) {
		$ma = mapi_get_one_media( $id, 'default' );
		
		if ( $ma ) return $ma;

		if ( $failover ) return mapi_get_one_media( $id );

		return null;
}


function mapi_stat( $what ) {
		$availables = array( 'contents', 'categories', 'modules', 'users' );

		if ( ! in_array( $what, $availables ) ) return 0;

		return ORM::for_table( $what )->count();
}

?>