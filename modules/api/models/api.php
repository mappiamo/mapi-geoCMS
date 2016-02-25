<?php

	// no direct access to this file
	defined('DACCESS') or die;

	class MModel_Api {

		static function search($options) {
			if (sizeof($options) < 1) {
				return FALSE;
			}

			if (((isset($options['field'])) && ($options['field'] == 'all')) && ((isset($options['data'])) && ($options['data'] == 'all'))) {
				if (isset($options['auth'])) {
					$ApiauthKey = ORM::for_table('preferences')->select('value')->where('name', 'api_auth')->find_one();
					if (!$ApiauthKey) {	die('Authentication failed.'); }
					if ($ApiauthKey['value'] != $options['auth']) {	die('Authentication failed.'); }

					$records = ORM::for_table('contents')->raw_query('SELECT * FROM contents')->find_many();

				} else {
					die('Authentication required.');
				}
			} elseif (((isset($options['field'])) && ($options['field'] != 'all')) && ((isset($options['data'])) && ($options['data'] != 'all'))) {

				$FiledName = $options['field'];
				$DataValue = $options['data'];
				$records_cnt = ORM::for_table('contents')->select('*')->where($FiledName, $DataValue)->count();

				if ($records_cnt == 0) {
					die('No result ot invalid search data.');
				}
				if ($records_cnt <= 10) {
					$records = ORM::for_table('contents')->select('*')->where($FiledName, $DataValue)->find_many();
				} else {
					if (isset($options['auth'])) {
						$ApiauthKey = ORM::for_table('preferences')->select('value')->where('name', 'api_auth')->find_one();
						if (!$ApiauthKey) {	die('Authentication failed.'); }
						if ($ApiauthKey['value'] != $options['auth']) {	die('Authentication failed.'); }
						$records = ORM::for_table('contents')->select('*')->where($FiledName, $DataValue)->find_many();
					} else {
						$records = ORM::for_table('contents')->select('*')->where($FiledName, $DataValue)->limit(10)->find_many();
					}
				}

			} else {

				$records = ORM::for_table('contents')
											->raw_query('SELECT id, ( 3959 * acos( cos( radians( :latitude ) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians( :longitude ) ) + sin( radians( :latitude ) )  * sin( radians( lat ) ) ) )  AS distance FROM contents HAVING distance < :radius',
																	array("latitude" => $options["lat"], "longitude" => $options["lng"],
																				"radius" => $options["radius"]))->find_many();
			}

			//print_r($records);
			//die();
			if (!isset($records)) {
				return FALSE;
			}

			if (sizeof($records) < 1) {
				return FALSE;
			}
			$contents = array();
			if (isset($options["cat"])) {
				$kategoria = MObject::get('category', $options["cat"]);
				$kat_contents = $kategoria->get_contents();
			}
			foreach ($records as $content) {
				$content = MObject::get('content', $content->id);
				$metas = $content->get_meta();
				$meta = array();
				if (sizeof($metas) > 0) {
					foreach ($metas as $m) {
						$meta[] = array("name" => $m->name, "value" => $m->value);
					}
				}
				$medias = $content->get_media();
				$media = array();
				if (sizeof($medias) > 0) {
					foreach ($medias as $med) {
						$media[] = array("title" => $med->title, "url" => $med->url, "default" => $med->default);
					}
				}
				$in = TRUE;
				if (isset($options["cat"])) {
					if (sizeof($kat_contents) < 1) {
						return FALSE;
					}

					$in = FALSE;

					foreach ($kat_contents as $kat_content) {
						if ($content->get_id() == $kat_content->get_id()) {
							$in = TRUE;
						}
					}
				}
				if ($in) {
					$createdraw = $content->created();
					$created = $createdraw["when"];
					$createdby = $createdraw["by"];
					$modifiedraw = $content->modified();
					$modified = $modifiedraw["when"];
					$modifiedby = $modifiedraw["by"];
					$contents[] =
					array("id" => $content->get_id(), "type" => $content->get_type(), "name" => $content->get_name(),
								"title" => $content->get_title(), "text" => $content->get_text(), "address" => $content->get_address(),
								"lat" => $content->get_lat(), "lon" => $content->get_lng(), "route" => $content->get_route(),
								"import_id" => $content->get_importid(), "lang" => $content->get_language(),
								"license" => $content->get_license(), "created" => $created, "modified" => $modified,
								"createdby" => $createdby, "modifiedby" => $modifiedby, "hits" => $content->get_hits(),
								"translation" => $content->is_translation(), "enabled" => $content->is_enabled(), "meta" => $meta,
								"media" => $media);
				}
			}

			return $contents;
		}

		static function category($options) {
			if (sizeof($options) < 1) {
				return FALSE;
			}
			$category = MObject::get('category', $options['object']);
			$cont = $category->get_contents();
			if (sizeof($cont) < 1) {
				return FALSE;
			}
			$contents = array();
			foreach ($cont as $content) {
				$metas = $content->get_meta();
				$meta = array();
				if (sizeof($metas) > 0) {
					foreach ($metas as $m) {
						$meta[] = array("name" => $m->name, "value" => $m->value);
					}
				}
				$medias = $content->get_media();
				$media = array();
				if (sizeof($medias) > 0) {
					foreach ($medias as $med) {
						$media[] = array("title" => $med->title, "url" => $med->url, "default" => $med->default);
					}
				}
				$createdraw = $content->created();
				$created = $createdraw["when"];
				$createdby = $createdraw["by"];
				$modifiedraw = $content->modified();
				$modified = $modifiedraw["when"];
				$modifiedby = $modifiedraw["by"];
				$contents[] = array("id" => $content->get_id(), "type" => $content->get_type(), "name" => $content->get_name(),
														"title" => $content->get_title(), "text" => $content->get_text(),
														"address" => $content->get_address(), "lat" => $content->get_lat(),
														"lon" => $content->get_lng(), "route" => $content->get_route(),
														"import_id" => $content->get_importid(), "lang" => $content->get_language(),
														"license" => $content->get_license(), "created" => $created, "modified" => $modified,
														"createdby" => $createdby, "modifiedby" => $modifiedby, "hits" => $content->get_hits(),
														"translation" => $content->is_translation(), "enabled" => $content->is_enabled(),
														"meta" => $meta, "media" => $media);
			}

			return $contents;
		}

		static function content($options) {
			if (sizeof($options) < 1) {
				return FALSE;
			}

			$content = MObject::get('content', $options['object']);
			$metas = $content->get_meta();
			$meta = array();
			if (sizeof($metas) > 0) {
				foreach ($metas as $m) {
					$meta[] = array("name" => $m->name, "value" => $m->value);
				}
			}
			$medias = $content->get_media();
			$media = array();
			if (sizeof($medias) > 0) {
				foreach ($medias as $med) {
					$media[] = array("title" => $med->title, "url" => $med->url, "default" => $med->default);
				}
			}

			$contents = array("id" => $content->get_id(), "type" => $content->get_type(), "name" => $content->get_name(),
												"title" => $content->get_title(), "text" => $content->get_text(),
												"address" => $content->get_address(), "lat" => $content->get_lat(),
												"lon" => $content->get_lng(), "route" => $content->get_route(),
												"import_id" => $content->get_importid(), "lang" => $content->get_language(),
												"license" => $content->get_license(), "created" => $content->created(),
												"modified" => $content->modified(), "hits" => $content->get_hits(),
												"translation" => $content->is_translation(), "enabled" => $content->is_enabled(),
												"meta" => $meta, "media" => $media);
			return $contents;

		}

		static function getallpois($options) {
			if (isset($options['auth'])) {
				$ApiauthKey = ORM::for_table('preferences')->select('value')->where('name', 'api_auth')->find_one();
				if (!$ApiauthKey) {	die('Authentication failed.'); }
				if ($ApiauthKey['value'] != $options['auth']) {	die('Authentication failed.'); }

				if (isset($options['lang'])) {
					$contentlang = $options['lang'];
				} else {
					$lang = new M_Language;
					$contentlang = $lang->getLanguage();
				}

				$AllPois = ORM::for_table('contents')->select('*')->where('type', 'place')->where('language', $contentlang)->find_array();
				if (!$AllPois) { return 'No result.'; }

				return $AllPois;

			} else {
				die('Authentication required.');
			}
		}

		static function getallroutes($options) {
			if (isset($options['auth'])) {
				$ApiauthKey = ORM::for_table('preferences')->select('value')->where('name', 'api_auth')->find_one();
				if (!$ApiauthKey) {	die('Authentication failed.'); }
				if ($ApiauthKey['value'] != $options['auth']) {	die('Authentication failed.'); }

				if (isset($options['lang'])) {
					$contentlang = $options['lang'];
				} else {
					$lang = new M_Language;
					$contentlang = $lang->getLanguage();
				}

				$AllRoutes = ORM::for_table('contents')->select('*')->where('type', 'route')->where('language', $contentlang)->find_array();
				if (!$AllRoutes) { return 'No result.'; }

				foreach ($AllRoutes as $Key => $OneRoute) {
					$TheGEOMData = $OneRoute['route'];
					$Geomtype_SQL = "SELECT ST_GeometryType(ST_GeomFromText('$TheGEOMData')) AS GEOMType";
					$Geomtype = ORM::for_table('contents')->raw_query($Geomtype_SQL)->where('enabled', 1)->find_array();

					if (isset($options['type'])) {
						if ($options['type'] == 'route') {
							$GetType = 'MULTILINESTRING';
						} elseif ($options['type'] == 'polygon') {
							$GetType = 'MULTIPOLYGON';
						} else {
							$GetType = 'MULTILINESTRING';
						}
					} else {
						$GetType = 'MULTILINESTRING';
					}

					if ($Geomtype[0]['GEOMType'] == $GetType) {
						$Routes[$Key] = $OneRoute;
					}
				}

				return $Routes;

			} else {
				die('Authentication required.');
			}
		}

		static function poisonroute($options) {
			if (sizeof($options) < 1) { return FALSE; }
			if (!isset($options['route'])) { return FALSE; }
			if (isset($options['auth'])) {

				$ApiauthKey = ORM::for_table('preferences')->select('value')->where('name', 'api_auth')->find_one();
				if (!$ApiauthKey) {	die('Authentication failed.'); }
				if ($ApiauthKey['value'] != $options['auth']) {	die('Authentication failed.'); }

				if (isset($options['lang'])) {
					$contentlang = $options['lang'];
				} else {
					$lang = new M_Language;
					$contentlang = $lang->getLanguage();
				}

				$RouteName = $options['route'];
				$IsRoute = ORM::for_table('contents')->select('route')->where('name', $RouteName)->where('type', 'route')->where('language', $contentlang)->count();

				if ($IsRoute == 1) {
					$TheGEOMData = ORM::for_table('contents')->select('route')->where('name', $RouteName)->where('type', 'route')->where('language', $contentlang)->find_one();
					$TheGEOMData = $TheGEOMData['route'];

					$Geomtype_SQL = "SELECT ST_GeometryType(ST_GeomFromText('$TheGEOMData')) AS GEOMType";
					$Geomtype = ORM::for_table('contents')->raw_query($Geomtype_SQL)->where('enabled', 1)->find_array();

					$AllPois = ORM::for_table('contents')->select('*')->where('type', 'place')->where('language', $contentlang)
												->find_array();

					if (!$AllPois) { return 'No result.'; }

					if ($Geomtype[0]['GEOMType'] == 'MULTILINESTRING') {
						$MaxDistance = 150;
						$theroutes = array();

						foreach ($AllPois as $markerkey => $OnePioData) {
							$PlaceString = $OnePioData['route'];
							$Placetype_SQL = "SELECT ST_GeometryType(ST_GeomFromText('$PlaceString')) AS GEOMType";
							$Pointtype = ORM::for_table('contents')->raw_query($Placetype_SQL)->where('enabled', 1)->find_array();

							if ($Pointtype[0]['GEOMType'] == 'POINT') {
								$Filter_SQL = "SELECT ST_Distance(ST_GeomFromText('$TheGEOMData', 4326), ST_GeomFromText('$PlaceString', 4326)) * 111195 AS FilterResult";
								$Filter_DATA = ORM::for_table('contents')->raw_query($Filter_SQL)->find_array();
								if ($Filter_DATA[0]['FilterResult'] <= $MaxDistance) {
									$theroutes[$markerkey] = $OnePioData;
								}
							}

						}

						return $theroutes;

					} elseif ($Geomtype[0]['GEOMType'] == 'MULTIPOLYGON') {
						$theroutes = array();

						foreach ($AllPois as $markerkey => $OnePioData) {
							$PlaceString = $OnePioData['route'];
							$Placetype_SQL = "SELECT ST_GeometryType(ST_GeomFromText('$PlaceString')) AS GEOMType";
							$Pointtype = ORM::for_table('contents')->raw_query($Placetype_SQL)->where('enabled', 1)->find_array();

							if ($Pointtype[0]['GEOMType'] == 'POINT') {
								$Filter_SQL = "SELECT ST_Contains(ST_GeomFromText('$TheGEOMData', 4326), ST_GeomFromText('$PlaceString', 4326)) AS FilterResult";
								$Filter_DATA = ORM::for_table('contents')->raw_query($Filter_SQL)->find_array();
								if ($Filter_DATA[0]['FilterResult'] == TRUE) {
									$theroutes[$markerkey] = $OnePioData;
								}
							}
						}

						return $theroutes;

					} else {
						return FALSE;
					}
				} else {
					return FALSE;
				}

			} else {
				die('Authentication required.');
			}

		}

	}


?>
