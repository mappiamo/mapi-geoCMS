<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mapi_list_filtered($table) {
	if (!in_array($table, mapi_list_availables())) return array();
	$table = preg_replace('/installed_/', '', $table);

	$count = ORM::for_table($table)->count();
	$count_results = NULL;

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$SearchQuery = NULL;
		$LimitOffset = 0;

		if (isset($_POST['limit_start']) && (intval($_POST['limit_start']) > 0) && is_int(intval($_POST['limit_start']))) {
			$LimitOffset = ((intval($_POST['limit_start'])) - 1);
		}

		if (isset($_POST['limit_value']) && (intval($_POST['limit_value']) > 0) && is_int(intval($_POST['limit_value']))) {
			$LimitValue = (intval($_POST['limit_value']));
		} else {
			$LimitValue = 250;
			$_POST['limit_value'] = 250;
		}

		if (isset($_POST['keyword']) && strlen(trim($_POST['keyword'])) > 2) {
			$searchstring = $_POST['keyword'];
			$searchstring = str_replace(array('\'', '`'), array('\\\'', '\\`'), $searchstring);

			$SearchQueryArray = explode(' ', $searchstring);

			$SearchQuery = '((`text` LIKE \'%' . implode('%\' AND `text` LIKE \'%', $SearchQueryArray) . '%\')';
			$SearchQuery .= ' OR ';
			$SearchQuery .= '(`title` LIKE \'%' . implode('%\' AND `title` LIKE \'%', $SearchQueryArray) . '%\')';
			$SearchQuery .= ' OR ';
			$SearchQuery .= '(`address` LIKE \'%' . implode('%\' AND `address` LIKE \'%', $SearchQueryArray) . '%\'))';
			//$SearchQuery .= ' AND (`type` = \'place\' OR `type` = \'event\' OR `type` = \'route\')';
		}

		if (isset($_POST['language']) && strlen(trim($_POST['language'])) == 2) {
			if ($SearchQuery) { $SearchQuery .= ' AND '; }
			$SearchQuery .= '(`language` LIKE \'' . trim($_POST['language']) . '\')';
		}

		if (isset($_POST['type']) && strlen(trim($_POST['type'])) > 1) {
			if ($SearchQuery) { $SearchQuery .= ' AND '; }
			$SearchQuery .= '(`type` LIKE \'' . trim($_POST['type']) . '\')';
		}

		if ($SearchQuery) {

			$SearchQuery = 'WHERE ' . $SearchQuery;

			if ((isset($_POST['location'])) && (strlen(trim($_POST['location'])) > 0) && (isset($_POST['lon'])) && (isset($_POST['radius'])) && (isset($_POST['lat'])) && (is_numeric($_POST['lon'])) && (is_numeric($_POST['lat'])) && (is_numeric($_POST['radius']))) {

				$count_results = count(ORM::for_table('contents')
				->raw_query('SELECT id, (3959 * acos(cos(radians(:latitude)) * cos(radians(lat)) * cos(radians(lng) - radians(:longitude)) + sin(radians(:latitude))  * sin(radians(lat)))) * 1000 AS distance FROM contents ' . $SearchQuery . ' HAVING distance < :radius AND distance > 0',
				array("latitude" => $_POST["lat"], "longitude" => $_POST["lon"], "radius" => $_POST["radius"]))->find_many());

				if ($count_results > 10) {
					if ($LimitOffset > ($count_results - 10)) {
						$LimitOffset = ($count_results - 10);
						$_POST['limit_start'] = ($LimitOffset + 1);
					}
				} else {
					$LimitOffset = 0;
					$_POST['limit_start'] = ($LimitOffset + 1);
				}

				$results = ORM::for_table('contents')
				->raw_query('SELECT id, type, title, address, hits, enabled, language, modified, (3959 * acos(cos(radians(:latitude)) * cos(radians(lat)) * cos(radians(lng) - radians(:longitude)) + sin(radians(:latitude))  * sin(radians(lat)))) * 1000 AS distance FROM contents ' . $SearchQuery . ' HAVING distance < :radius AND distance > 0 LIMIT ' . $LimitValue . ' OFFSET '. $LimitOffset,
				array("latitude" => $_POST["lat"], "longitude" => $_POST["lon"], "radius" => $_POST["radius"]))->order_by_desc('id');

			} else {

				$SearchQuery = "SELECT id, type, title, address, hits, enabled, language, modified FROM $table " . $SearchQuery;
				$count_results = count(ORM::for_table($table)->raw_query($SearchQuery)->find_many());

				if ($count_results > 10) {
					if ($LimitOffset > ($count_results - 10)) {
						$LimitOffset = ($count_results - 10);
						$_POST['limit_start'] = ($LimitOffset + 1);
					}
				} else {
					$LimitOffset = 0;
					$_POST['limit_start'] = ($LimitOffset + 1);
				}

				$SearchQuery = $SearchQuery . ' LIMIT ' . $LimitValue . ' OFFSET ' . $LimitOffset;
				$results = ORM::for_table($table)->raw_query($SearchQuery)->order_by_desc('id');
			}

		} else {

			if ((isset($_POST['location'])) && (strlen(trim($_POST['location'])) > 0) && (isset($_POST['lon'])) && (isset($_POST['radius'])) && (isset($_POST['lat'])) && (is_numeric($_POST['lon'])) && (is_numeric($_POST['lat'])) && (is_numeric($_POST['radius']))) {

				$count_results = count(ORM::for_table('contents')
				->raw_query('SELECT id, (3959 * acos(cos(radians(:latitude)) * cos(radians(lat)) * cos(radians(lng) - radians(:longitude)) + sin(radians(:latitude))  * sin(radians(lat)))) * 1000 AS distance FROM contents HAVING distance < :radius AND distance > 0',
				array("latitude" => $_POST["lat"], "longitude" => $_POST["lon"], "radius" => $_POST["radius"]))->find_many());

				if ($count_results > 10) {
					if ($LimitOffset > ($count_results - 10)) {
						$LimitOffset = ($count_results - 10);
						$_POST['limit_start'] = ($LimitOffset + 1);
					}
				} else {
					$LimitOffset = 0;
					$_POST['limit_start'] = ($LimitOffset + 1);
				}

				$results = ORM::for_table('contents')
				->raw_query('SELECT id, type, title, address, hits, enabled, language, modified, (3959 * acos(cos(radians(:latitude)) * cos(radians(lat)) * cos(radians(lng) - radians(:longitude)) + sin(radians(:latitude))  * sin(radians(lat)))) * 1000 AS distance FROM contents HAVING distance < :radius AND distance > 0 LIMIT ' . $LimitValue . ' OFFSET ' . $LimitOffset,
				array("latitude" => $_POST["lat"], "longitude" => $_POST["lon"], "radius" => $_POST["radius"]))->order_by_desc('id');

			} else {
				$results = ORM::for_table($table)->select_many('id', 'type', 'title', 'address', 'hits', 'enabled', 'language', 'modified')->limit($LimitValue)->offset($LimitOffset)->order_by_desc('id');
			}
		}

	} else {
		$results = ORM::for_table($table)->select_many('id', 'type', 'title', 'address', 'hits', 'enabled', 'language', 'modified')->limit(250)->offset(0)->order_by_desc('id');
	}

	$Return['filtered_count'] = count($results->find_many());
	if ($count_results) {
		$Return['search_count'] = $count_results;
	} else {
		$Return['search_count'] = $count;
	}
	$Return['table'] = $results->find_many();
	$Return['count'] = $count;

	$Return['LangList'] = ORM::for_table('contents')->distinct()->select('language')->find_array();
	$Return['TypeList'] = ORM::for_table('contents')->distinct()->select('type')->find_array();

	return $Return;
}

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