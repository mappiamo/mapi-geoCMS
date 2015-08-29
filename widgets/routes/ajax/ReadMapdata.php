<?php
/**
 * Created by PhpStorm.
 * User: Laca
 * Date: 2015.07.15.
 * Time: 21:14
 */
 
	error_reporting( E_ALL );
	ini_set( 'display_errors', 0 );

	define( 'DACCESS', 1 );

	define( 'APATH', dirname( __FILE__ ) );

	$settings = APATH . '/../../../settings.php';
	$idiorm_lib = APATH . '/../../../lib/idiorm/idiorm.php';
	
	if ( ! is_file( $settings ) || ! is_readable( $settings ) ) die( 'M_ERROR (00110): A required file: settings.php is missing or not readable!' );
	else include( $settings );

	if ( ! is_file( $idiorm_lib ) || ! is_readable( $idiorm_lib ) ) die( 'M_ERROR (00111): A required file: idiorm.php is missing or not readable!' );
	else include( $idiorm_lib );
	
	ORM::configure('mysql:host=' . MSettings::$db_host . ';dbname=' . MSettings::$db);
	ORM::configure('username', MSettings::$db_user);
	ORM::configure('password', MSettings::$db_pass);
	ORM::configure('return_result_sets', true); // returns result sets
	ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	
	$submenu_array = $_POST["menuon"];
	$routeon = $_POST["routeon"];
	$type_filter = $_POST["contentfilter"];
	$content_filter = $_POST["datafilter"];
	$categorystate = $_POST["categorystate"];
	$contentlang = $_POST["contentlang"];
	$searchstring = trim($_POST["searchstring"]);
	$Geomtype = NULL;
	$TheGEOMData = NULL;
	$MaxDistance = 150;
	$markerkey = 0;
	$EventFilter = TRUE;

	if ((!$submenu_array) && (!$routeon) && (!$searchstring)) { return; }
	if (!$type_filter) { $type_filter = 'place'; }
	if (!$categorystate) { $categorystate = 0; }

	if ($routeon) {
		$route = ORM::for_table('contents')->select_many('id', 'route', 'title', 'address', 'text')->where_like('name', $routeon . '%')->where('type', 'route')->where('enabled', '1')->where('language', $contentlang)->find_array();
	}
	
	//echo print_r($routeon, 1); die();
	//echo print_r(count($theroutes), 1); die();
	if (count($route) > 0) {
		$TheDataID = $route[0]['id'];
		$TheGEOMData = $route[0]['route'];
		$theroutes[0]['route'] = $TheGEOMData;
		$theroutes[0]['id'] = $TheDataID;
		$theroutes[0]['title'] = $route[0]['title'];
		$theroutes[0]['address'] = $route[0]['address'];
		$theroutes[0]['content_part'] = mb_substr(strip_tags($route[0]['text']), 0, 170, 'UTF-8') . '...';

		$thecolors = ORM::for_table('content_meta')->select_many('value')->where('name', 'route-color')->where('external_id', $TheDataID)->find_one();
		$theroutes['TheColor'] = $thecolors['value'];

		$theimage = ORM::for_table('content_media')->select_many('url')->where('external_id', $TheDataID)->where('default_media', 1)->find_one();
		$theroutes[0]['defimage'] = $theimage['url'];
		
		$Geomtype_SQL = "SELECT ST_GeometryType(ST_GeomFromText('$TheGEOMData')) AS GEOMType";
		$Geomtype = ORM::for_table('contents')->raw_query($Geomtype_SQL)->where('enabled', 1)->find_array();
	}
	
	//echo print_r($theroutes, 1); die();

	//$ActiveRoute = 'paduli';
	//echo print_r($Geomtype, 1); die();

	/* if ($Geomtype[0]['GEOMType'] == 'MULTIPOLYGON') {
		$Distanced_SQL = "SELECT ST_Contains(ST_GeomFromText('$LineString', 4326), ST_GeomFromText('$PlaceString', 4326)) * 111195 AS Distance";
	} elseif ($Geomtype[0]['GEOMType'] == 'MULTILINESTRING') {
		$Distanced_SQL = "SELECT ST_Distance(ST_GeomFromText('$PlaceString', 4326), ST_GeomFromText('$LineString', 4326)) * 111195 AS Distance";
	}
	$Distane_meters = ORM::for_table('contents')->raw_query($Distanced_SQL)->find_array(); */
	
	if ($categorystate == 0) { $submenu_array[0]	= $routeon; }
	if ((!$routeon) && ($type_filter == 'Markers') && (strlen($searchstring) >= 3)) { $submenu_array[0] = $searchstring; }
	
	if (is_array($submenu_array)) {
		if (count($submenu_array) > 0) {

			foreach ($submenu_array as $menukey => $menudata) {
				$QueryString = NULL;

				if ($type_filter == 'Markers') {

					$SearchQueryArray = explode(' ', $menudata);
					$SearchQuery = '(`title` LIKE \'%' . implode('%\' AND `title` LIKE \'%', $SearchQueryArray) . '%\')';

					$theplaces = ORM::for_table('categories')->select_many('contents', 'title', 'id')->where_raw($SearchQuery)->where('enabled', '1')->find_one();
				} else {
					$theplaces = ORM::for_table('categories')->select_many('contents', 'title', 'id')->where_like('name', $menudata . '%')->where('enabled', '1')->find_one();
				}

				/* if ($ActiveRoute) {

					$theroutefilter = ORM::for_table('categories')->select_many('contents')->where_like('title', $ActiveRoute . '%')->where('enabled', '1')->find_one();

					if (count($theroutefilter) > 0) {
						$RouteString = $theroutefilter['contents'];
						if (strlen(trim($RouteString)) > 0) {
							$RouteString = str_replace(array('{', '}'), '', $RouteString);
							$RouteArray = explode(';', $RouteString);
						}
					}
				} */

				if ((count($theplaces) > 0) || ($type_filter == 'Markers')) {

					$PlacesString = $theplaces['contents'];
					if ((strlen(trim($PlacesString)) > 0) || ($type_filter == 'Markers')) {

						$PlacesString = str_replace(array('{', '}'), '', $PlacesString);
						$PlacesArray = explode(';', $PlacesString);

						/* if (count($RouteArray) > 0) {
							$PlacesArray = array_intersect($RouteArray, $PlacesArray);
						} */

						if (count($PlacesArray) > 0) {
							foreach ($PlacesArray as $ContentID) {
								if (is_numeric($ContentID)) {
									$QueryString .= '`id` = ' .  $ContentID . ' OR ';
								}
							}

							$QueryString = '(' . rtrim($QueryString, ' OR ') . ')';

							/* if ($ActiveRoute) {
								if ((!$theroutefilter) || (count($theroutefilter) == 0)) {
									$AddressString = '`address` like \'%' . $ActiveRoute . '%\'';
									$CheckAddress = ORM::for_table('contents')->select_many('id')->where_raw($AddressString)->where('enabled', 1)->where('type', 'place')->find_array();
									if (count($CheckAddress) > 0) {
										$QueryString = $QueryString . ' AND (' . $AddressString . ')';
									}
								}
							} */

							$PlacesArray = array_filter($PlacesArray);
							//print_r($PlacesArray); die();

							$CheckRouteSQL = "SHOW COLUMNS FROM `contents` WHERE Field = 'route'";
							$RouteExist = ORM::for_table('contents')->raw_query($CheckRouteSQL)->find_array();

							if (count($RouteExist) > 0) {
								//$PlaceData = ORM::for_table('contents')->select_many('id', 'route', 'lat', 'lng')->where_raw($QueryString)->where('enabled', 1)->where('type', 'place')->find_array();
								if ($type_filter == 'Markers') {
									if (count($PlacesArray) > 0) {
										$PlaceData = ORM::for_table('contents')->select('title')->select('route', 'point')->select('id')->select('lat')->select('lng')->select('start')->select('end')->select('address')->select('text')->where_raw($QueryString)->where('enabled', 1)->where('language', $contentlang)->find_array();
									}
								} else {
									$PlaceData = ORM::for_table('contents')->select('title')->select('route', 'point')->select('id')->select('lat')->select('lng')->select('start')->select('end')->select('address')->select('text')->where_raw($QueryString)->where('enabled', 1)->where('type', $type_filter)->where('language', $contentlang)->find_array();
								}
							} else {
								//$PlaceData = ORM::for_table('contents')->select_many('id', 'lat', 'lng')->where_raw($QueryString)->where('enabled', 1)->where('type', 'place')->find_array();
								$PlaceQuery = "SELECT id, title, lat, lng, start, end, address, text FROM contents WHERE $QueryString";
								if ($type_filter == 'Markers') {
									if (count($PlacesArray) > 0) {
										$PlaceData = ORM::for_table('contents')->raw_query($PlaceQuery)->where('enabled', 1)->where('language', $contentlang)->find_array();
									}
								} else {
									$PlaceData = ORM::for_table('contents')->raw_query($PlaceQuery)->where('type', $type_filter)->where('enabled', 1)->where('language', $contentlang)->find_array();
								}
								foreach ($PlaceData as $PlaceKey => $OnePlace_array) {
									$PlaceData[$PlaceKey]['point'] = 'POINT(' . $OnePlace_array['lng'] . ' ' . $OnePlace_array['lat'] . ')';
								}
							}

							if (($type_filter == 'Markers') && ($searchstring)) {

								$SearchQueryArray = explode(' ', $searchstring);
								$SearchQuery = '((`text` LIKE \'%' . implode('%\' AND `text` LIKE \'%', $SearchQueryArray) . '%\')';
								$SearchQuery .= ' OR ';
								$SearchQuery .= '(`title` LIKE \'%' . implode('%\' AND `title` LIKE \'%', $SearchQueryArray) . '%\'))';
								$SearchQuery .= ' AND (`type` = \'place\' OR `type` = \'event\')';

								//$SearchQuery = "(`text` LIKE '%" . $searchstring . "%' OR `title` LIKE '%" . $searchstring . "%') AND (`type` = 'place' OR `type` = 'event')";
								$PlaceSearch = ORM::for_table('contents')->select('title')->select('route', 'point')->select('id')->select('lat')->select('lng')->select('start')->select('end')->select('address')->select('text')->where_raw($SearchQuery)->where('enabled', 1)->where('language', $contentlang)->find_array();
							}

							if (is_array($PlaceSearch)) {
								if (count($PlaceSearch) > 0) {
									foreach ($PlaceSearch as $OneSearchResult) {
										if (!in_array($OneSearchResult['id'], $PlacesArray)) {
											$PlaceData[] = $OneSearchResult;
										}
									}
								}
							}

							//print_r($PlaceData); die();

							foreach ($PlaceData as $PlaceKey => $PlaceVal) {

								if ($content_filter) {
									if (($content_filter == 'week') && ($type_filter == 'event')) {
										$Current_week = date("Y-W", strtotime(date("Y-m-d")));
										$EndTime_week = date("Y-W", strtotime(date($PlaceVal['end'])));
										$StartTime_week = date("Y-W", strtotime(date($PlaceVal['start'])));

										$Today = strtotime(date("Y-m-d"));
										$E_start = strtotime(date($PlaceVal['start']));
										$E_end = strtotime(date($PlaceVal['end']));
										//if (($Current_week == $EndTime_week) && ($Today >= $E_start) && ($Today <= $E_end)) {
										if ((($Current_week == $EndTime_week) || ($Current_week == $StartTime_week)) && ($Today <= $E_end)) {
											$EventFilter = TRUE;
										} else {
											$EventFilter = FALSE;
										}
									}
								}

								//die();
								if ($EventFilter == TRUE) {
									if (($Geomtype) && ($TheGEOMData) && ($categorystate == 1)) {
										$PlaceString = $PlaceVal['point'];

										if ($Geomtype[0]['GEOMType'] == 'MULTIPOLYGON') {
											$Filter_SQL = "SELECT ST_Contains(ST_GeomFromText('$TheGEOMData', 4326), ST_GeomFromText('$PlaceString', 4326)) AS FilterResult";
										} elseif ($Geomtype[0]['GEOMType'] == 'MULTILINESTRING') {
											$Filter_SQL = "SELECT ST_Distance(ST_GeomFromText('$TheGEOMData', 4326), ST_GeomFromText('$PlaceString', 4326)) * 111195 AS FilterResult";
										}
										$Filter_DATA = ORM::for_table('contents')->raw_query($Filter_SQL)->find_array();

										if ($Geomtype[0]['GEOMType'] == 'MULTILINESTRING') {
											if ($Filter_DATA[0]['FilterResult'] <= $MaxDistance) {
												$theroutes['places'][$markerkey] = $PlaceVal;
												$theroutes['places'][$markerkey]['distance'] = round($Filter_DATA[0]['FilterResult'], 2);
											}
										} elseif ($Geomtype[0]['GEOMType'] == 'MULTIPOLYGON') {
											if ($Filter_DATA[0]['FilterResult'] == TRUE) {
												$theroutes['places'][$markerkey] = $PlaceVal;
											}
										}

									} else {
										$theroutes['places'][$markerkey] = $PlaceVal;
									}
									$theroutes['places'][$markerkey]['content_title'] = $PlaceVal['title'];
									$theroutes['places'][$markerkey]['address'] = $PlaceVal['address'];
									$theroutes['places'][$markerkey]['cat_name'] = $theplaces['title'];
									$theroutes['places'][$markerkey]['cat_id'] = $theplaces['id'];
									$theroutes['places'][$markerkey]['content_part'] = mb_substr(strip_tags($PlaceVal['text']), 0, 170, 'UTF-8') . '...';

									$PointGeom = $PlaceVal['point'];
									preg_match('/^([^\(]*)([\(]*)([^A-Za-z]*[^\)$])([\)]*[^,])$/', $PointGeom, $Match);
									$LanLotCoords = explode(' ', $Match[3]);
									$theroutes['places'][$markerkey]['coords_lat'] = $LanLotCoords[1];
									$theroutes['places'][$markerkey]['coords_lon'] = $LanLotCoords[0];

									if ($type_filter == 'event') {
										$theroutes['places'][$markerkey]['start_date'] = date("Y-m-d H:i", strtotime($PlaceVal['start']));
										$theroutes['places'][$markerkey]['end_date'] = date("Y-m-d H:i", strtotime($PlaceVal['end']));
									}
									$markerkey++;
								}
							}

							foreach ($theroutes['places'] as $Key => $ContentArray) {
								$ContentID = $ContentArray['id'];

								$MarkerIcon = ORM::for_table('content_meta')->select_many('value')->where('external_id', $ContentID)->where('name', 'icon-file')->find_one();
								if ($MarkerIcon) {
									$theroutes['places'][$Key]['icondata'] = $MarkerIcon['value'];
								}

								$DefaultImage = ORM::for_table('content_media')->select_many('url')->where('external_id', $ContentID)->where('default_media', 1)->find_one();
								if ($DefaultImage) {
									$theroutes['places'][$Key]['default_image'] = $DefaultImage['url'];
								}

								$TheMainCat = ORM::for_table('content_meta')->select_many('value')->where('name', 'categoria')->where('external_id', $ContentID)->find_one();
								if ($TheMainCat) {
									$SubCatString = $TheMainCat['value'];
									$subcatname = mb_substr(str_replace(array(' ', '\\', '.', ',', '\'', '`', '/'), array('-', '-', '-', '-', '-', '-', '-'), strtolower(strip_tags($SubCatString))), 0, 35, 'UTF-8');
									$SubCatID = ORM::for_table('categories')->select_many('id')->where_like('name', $subcatname . '%')->where('enabled', '1')->find_one();
									if (($SubCatID) && ($menudata != $subcatname)) {
										$theroutes['places'][$Key]['subcat_name'] = $SubCatString;
										$theroutes['places'][$Key]['subcat_id'] = $SubCatID['id'];
									}
								}
							}

							$TheDataID = $PlaceData[0]['id'];
						}
					}
				}
				//echo print_r(($theroutes), 1); die();
			}

		}
	}

	//echo 'legalul...' . print_r(($theroutes), 1); die();

	echo json_encode($theroutes);