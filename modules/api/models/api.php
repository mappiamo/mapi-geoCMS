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

		static function telegram($options) {
			if (sizeof($options) < 1) { return FALSE; }
			if (!isset($options['ApiKey'])) { return FALSE; }
			if (!isset($options['ReturnDataNum'])) { return FALSE; }
			if (!isset($options['text'])) { return FALSE; }
			if (!isset($options['id'])) { return FALSE; }

			if (intval($options['ReturnDataNum']) > 15) { $options['ReturnDataNum'] = 15; }
			if (intval($options['ReturnDataNum']) < 1) { $options['ReturnDataNum'] = 5; }

			$ApiauthKey = ORM::for_table('preferences')->select('value')->where('name', 'api_auth')->find_one();
			if (!$ApiauthKey) {	return FALSE; }
			if ($ApiauthKey['value'] != $options['ApiKey']) {	return FALSE; }

			$LimitValue = $options['ReturnDataNum'];

			$ValidFilters = array('language', 'type', 'address');
			$ValidModifiers = array('radius', 'returndata');
			$NumericSettings = array('radius', 'returndata');
			$ValidCommands = array('language', 'type', 'address', 'setting', 'radius', 'returndata', 'category', 'search', 'location');
			$ValidActions = array('reset', 'show');

			$TheServerRoot = rtrim(((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']), '/\\');

			$LanguageSet = NULL;
			if (file_exists('telegram/' . $options['id'])) {
				$LanguageSet = self::getlanguage($options['id']);
			}

			if ((isset($options["lat"])) && (isset($options["lng"])) && (isset($options["radius"]))) {
				if (intval($options["radius"]) > 10000) { $options["radius"] = 10000; }
				if (intval($options["radius"]) < 1) { $options["radius"] = 1; }

				$LocationString = $options["lat"] . PHP_EOL . $options["lng"];
				file_put_contents('telegram/'.$options['id'].'.location', $LocationString);

				if (file_exists('telegram/' . $options['id'])) {
					$options['returndata'] = $LimitValue;

					$ReturnArray = self::stringtosave($options['id'], $ValidFilters, NULL, NULL, $ValidModifiers, $options, $ValidActions);
					$SavedWhere = $ReturnArray['SQL'];
					$options = $ReturnArray['FILTERS'];

					if ($SavedWhere) { $FilteredSQL = 'WHERE ' . rtrim($SavedWhere,  ' AND '); }
					$records = ORM::for_table('contents')
												->raw_query('SELECT id, title, address, type, start, end, (3959 * acos(cos(radians(:latitude)) * cos(radians(lat)) * cos(radians(lng) - radians(:longitude)) + sin(radians(:latitude)) * sin(radians(lat)))) AS distance FROM contents ' . $FilteredSQL . ' HAVING distance < :radius ORDER BY distance LIMIT '.
												$options["returndata"], array("latitude" => $options["lat"], "longitude" => $options["lng"],
												"radius" => $options["radius"]))->find_array();

				} else {

					$records = ORM::for_table('contents')
												->raw_query('SELECT id, title, address, type, start, end, (3959 * acos(cos(radians(:latitude)) * cos(radians(lat)) * cos(radians(lng) - radians(:longitude)) + sin(radians(:latitude)) * sin(radians(lat))))  AS distance FROM contents HAVING distance < :radius ORDER BY distance LIMIT '.
												$LimitValue, array("latitude" => $options["lat"], "longitude" => $options["lng"],
												"radius" => $options["radius"]))->find_array();
				}

				if (!isset($records)) {

					$SetContent = 'database_error';
					$SetData = NULL;
					$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);
					return $Message;

				}

				if (count($records) < 1) {

					$SetContent = 'no_return';
					$SetData['RADIUS'] = $options["radius"];
					$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);
					return $Message;

				}

				$TelegramContent = self::telegram_content($records, $TheServerRoot);

				$SetContent = 'records_show';
				$SetData['RADIUS'] = $options["radius"];
				$SetData['REC_COUNT'] = count($records);
				$SetData['REC_CONTENT'] = $TelegramContent;
				$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);
				return $Message;

			} else {

				$Command = strtolower($options['text']);
				$Command = ltrim($Command, '/');
				$Setting = explode(':', $Command);

				if (is_array($Setting)) {
					if (count($Setting) == 1) {

						if ($LanguageSet) {
							if (file_exists('telegram/' . $Setting[0] . '_' . $LanguageSet)) {
								$Setting[0] = $Setting[0] . '_' . $LanguageSet;
							}
						}

						if (file_exists('telegram/' . $Setting[0])) {

							$ReturnContent = file_get_contents('telegram/' . $Setting[0]);
							return $ReturnContent;

						} else {

							$SetContent = 'invalid_command';
							$SetData = NULL;
							$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);
							return $Message;

						}

					} elseif (count($Setting) == 2) {
						if (in_array($Setting[0], $ValidCommands)) {

							if ((in_array($Setting[0], $NumericSettings)) && (!in_array($Setting[1], $ValidActions)) && (((!is_numeric($Setting[1]))) || intval($Setting[1]) <= 0)) {

								$SetContent = 'accept_integer';
								$SetData = NULL;
								$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);
								return $Message;

							}

							if ((in_array($Setting[1], $ValidActions)) || (((is_numeric($Setting[1]))) && intval($Setting[1]) > 0)) {

								if ((in_array($Setting[0], $ValidFilters)) && (!in_array($Setting[1], $ValidActions))) {
									if (strtolower($Setting[0]) == 'address') {
										$SQL_sent = "`".$Setting[0]."` like '%".$Setting[1]."%'";
									} else {
										$SQL_sent = "`".$Setting[0]."` = '".$Setting[1]."'";
									}
									$records = ORM::for_table('contents')->select_many('id')->where_raw($SQL_sent)->where('enabled', 1)->count();

									if ($records == 0) {

										$SetContent = 'filter_cancelled';
										$SetData = NULL;
										$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);
										return $Message;

									}
								}

								if ((strtolower($Setting[0]) == 'location') && (strtolower($Setting[1]) == 'reset')) {
									if (file_exists('telegram/'.$options['id'].'.location')) {
										unlink('telegram/'.$options['id'].'.location');

										$SetContent = 'location_deleted';
										$SetData = NULL;
										$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);
										return $Message;

									} else {

										$SetContent = 'location_notsaved';
										$SetData = NULL;
										$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);
										return $Message;

									}
								}

								if ((strtolower($Setting[0]) == 'category') && (strtolower($Setting[1]) == 'show')) {
									$categories = $records = ORM::for_table('categories')->select_many('title', 'id', 'contents')->where("enabled", 1)->find_array();

									if (count($categories) > 0) {

										$SetContent = 'category_count';
										$SetData['CAT_COUNT'] = count($categories);
										$CatList = self::InternalMessage($SetContent, $SetData, $LanguageSet);

										foreach ($categories as $OneCat) {
											$CatContentList = $OneCat['contents'];
											$CatContentList = str_replace(array('{', '}'), '', $CatContentList);
											$DataArray = explode(';', $CatContentList);

											$CatList .= '- <a href="' . $TheServerRoot . '/index.php?module=category&object=' . $OneCat['id'] . '">' . $OneCat['title'] . '</a> - [' . count($DataArray) . ' content(s)]' . PHP_EOL;
										}

										return $CatList;
									} else {

										$SetContent = 'category_missing';
										$SetData = NULL;
										$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);
										return $Message;

									}
								}

								if (strtolower($Setting[1]) == 'show') {
									if (file_exists('telegram/' . $options['id'])) {
										$SavedFilters = file_get_contents('telegram/'.$options['id']);

										$SetContent = 'current_setting';
										$SetData['FILTER_LIST'] = $SavedFilters;
										$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);
										return $Message;

									} else {

										$SetContent = 'no_saved_setting';
										$SetData = NULL;
										$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);
										return $Message;
									}
								}

								if ((strtolower($Setting[0]) == 'setting') && (strtolower($Setting[1]) == 'reset')) {
									unlink('telegram/'.$options['id']);

									$SetContent = 'setting_deleted';
									$SetData = NULL;
									$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);
									return $Message;

								}

								if (file_exists('telegram/' . $options['id'])) {
									$ReturnArray = self::stringtosave($options['id'], $ValidFilters, $Setting, $SQL_sent, $ValidModifiers, $options, $ValidActions);
									$StringtoSave = $ReturnArray['STRING'];

									if ($StringtoSave) {
										file_put_contents('telegram/'.$options['id'], $StringtoSave);

										$SetContent = 'setting_received';
										$SetData['COMMAND'] = $Command;
										$SetData['SETTINGS'] = $StringtoSave;
										$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);
										return $Message;

									} else {
										unlink('telegram/'.$options['id']);

										$SetContent = 'setting_deleted';
										$SetData = NULL;
										$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);
										return $Message;

									}

								} else {
									if (!in_array($Setting[1], $ValidActions)) {
										file_put_contents('telegram/'.$options['id'], $Command);

										$SetContent = 'setting_first';
										$SetData['COMMAND'] = $Command;
										$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);
										return $Message;

									} else {

										$SetContent = 'setting_invalid';
										$SetData['COMMAND'] = $Command;
										$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);
										return $Message;

									}
								}

							} else {

								if (strtolower($Setting[0]) == 'search') {
									$Setting[1] = str_replace(array(',', '-', '"', '\'', '\\', '/'), '', $Setting[1]);
									$Setting[1] = str_replace(array('+', ' '), '_', $Setting[1]);

									if (strlen($Setting[1]) < 4) {

										$SetContent = 'invalid_queue';
										$SetData = NULL;
										$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);
										return $Message;

									}

									$SearchWords = explode('_', $Setting[1]);
									$SearchWords = array_filter($SearchWords);
									if (count($SearchWords) > 0) {

										$SearchQuery = '((`text` LIKE \'%' . implode('%\' AND `text` LIKE \'%', $SearchWords) . '%\')';
										$SearchQuery .= ' OR ';
										$SearchQuery .= '(`title` LIKE \'%' . implode('%\' AND `title` LIKE \'%', $SearchWords) . '%\')';
										$SearchQuery .= ' OR ';
										$SearchQuery .= '(`address` LIKE \'%' . implode('%\' AND `address` LIKE \'%', $SearchWords) . '%\'))';

										$SearchCount = ORM::for_table('contents')->select_many('type', 'title', 'id', 'start', 'end', 'address')->where_raw($SearchQuery)->where('enabled', 1)->count();

										$SetContent = 'search_count';
										$SetData['SEARCH_COUNT'] = $SearchCount;
										$SearchList = self::InternalMessage($SetContent, $SetData, $LanguageSet);

										if ($SearchCount == 0) {

											$SetContent = 'search_null';
											$SetData['SEARCH_COUNT'] = $SearchCount;
											$SearchList .= self::InternalMessage($SetContent, $SetData, $LanguageSet);

										} else {

											$options['returndata'] = $LimitValue;
											$SavedWhere = NULL;
											if (file_exists('telegram/' . $options['id'])) {

												$ReturnArray = self::stringtosave($options['id'], $ValidFilters, $Setting, NULL, $ValidModifiers, $options, $ValidActions);
												$SavedWhere = $ReturnArray['SQL'];
												$options = $ReturnArray['FILTERS'];

												if ($SavedWhere) { $SearchQuery .= ' AND ' . rtrim($SavedWhere,  ' AND '); }
												$LimitValue = $options['returndata'];

												$SearchCount = ORM::for_table('contents')->select_many('type', 'title', 'id', 'start', 'end', 'address')->where_raw($SearchQuery)->where('enabled', 1)->count();

												$SetContent = 'search_current';
												$SetData['SEARCH_COUNT'] = $SearchCount;
												$SearchList .= self::InternalMessage($SetContent, $SetData, $LanguageSet);

												if ($SearchCount == 0) {

													$SetContent = 'search_current_null';
													$SetData['SEARCH_COUNT'] = $SearchCount;
													$SearchList .= self::InternalMessage($SetContent, $SetData, $LanguageSet);

													return $SearchList;
												}
											}

											if (file_exists('telegram/'.$options['id'].'.location')) {

												$SetContent = 'location_info';
												$SetData['RADIUS'] = $SearchCount;
												$SearchList .= self::InternalMessage($SetContent, $SetData, $LanguageSet);

												$coords = file('telegram/'.$options['id'].'.location', FILE_IGNORE_NEW_LINES);
												$FilteredSQL = 'WHERE ' . $SearchQuery;

												$records = ORM::for_table('contents')
																			->raw_query('SELECT id, title, address, type, start, end, (3959 * acos(cos(radians(:latitude)) * cos(radians(lat)) * cos(radians(lng) - radians(:longitude)) + sin(radians(:latitude)) * sin(radians(lat)))) AS distance FROM contents ' . $FilteredSQL . ' HAVING distance < :radius ORDER BY distance LIMIT '.
																			$options["returndata"], array("latitude" => $coords[0], "longitude" => $coords[1],
																			"radius" => $options["radius"]))->find_array();

												if (count($records) == 0) {

													$SetContent = 'no_result';
													$SetData = NULL;
													$SearchList .= self::InternalMessage($SetContent, $SetData, $LanguageSet);

												} else {

													$TelegramContent = self::telegram_content($records, $TheServerRoot);

												}

												return $SearchList . $TelegramContent;

											} else {

												$SetContent = 'location_missing';
												$SetData = NULL;
												$SearchList .= self::InternalMessage($SetContent, $SetData, $LanguageSet);

												$SearchResult = ORM::for_table('contents')->select_many('type', 'title', 'id', 'start', 'end', 'address')->where_raw($SearchQuery)->where('enabled', 1)->limit($LimitValue)->find_array();
												$TelegramContent = self::telegram_content($SearchResult, $TheServerRoot);

											}
										}

										return $SearchList . $TelegramContent;
									} else {

										$SetContent = 'search_invalid';
										$SetData = NULL;
										$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);

										return $Message;
									}
								}

								if (strtolower($Setting[0]) == 'address') {
									$SQL_sent = "`".$Setting[0]."` like '%".$Setting[1]."%'";
								} else {
									$SQL_sent = "`".$Setting[0]."` = '".$Setting[1]."'";
								}

								$records = ORM::for_table('contents')->select_many('id')->where_raw($SQL_sent)->where('enabled', 1)->count();

								if ($records > 0) {

									if (file_exists('telegram/' . $options['id'])) {
										$SavedFilters = file_get_contents('telegram/' . $options['id']);

										$ReturnArray = self::stringtosave($options['id'], $ValidFilters, $Setting, $SQL_sent, $ValidModifiers, $options, $ValidActions);
										$StringtoSave = $ReturnArray['STRING'];
										$RealSQL = $ReturnArray['SQL'];

										file_put_contents('telegram/' . $options['id'], $StringtoSave);

										$filtered = ORM::for_table('contents')->select_many('id')->where_raw($RealSQL)->where('enabled', 1)->count();

										$SetContent = 'filter_saved_detailed';
										$SetData['RECORDS'] = $records;
										$SetData['SAVEDFILTERS'] = $SavedFilters;
										$SetData['FILTERED'] = $filtered;
										$SetData['STRINGTOSAVE'] = $StringtoSave;
										$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);

										return $Message;

									} else {
										file_put_contents('telegram/' . $options['id'], $Command);

										$SetContent = 'filter_saved';
										$SetData['RECORDS'] = $records;
										$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);

										return $Message;
									}

								} else {
									$SetContent = 'filter_cancelled';
									$SetData = NULL;
									$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);
									return $Message;
								}
							}

						} else {
							$SetContent = 'invalid_command';
							$SetData = NULL;
							$Message = self::InternalMessage($SetContent, $SetData, $LanguageSet);
							return $Message;
						}

					}
				} else {
					return FALSE;
				}
			}

		}

		private function InternalMessage($SetContent, $SetData, $LanguageSet) {
			if (($LanguageSet) && (file_exists('telegram/system/' . $SetContent . '_' . $LanguageSet))) {
				$LanguageSet = '_' . $LanguageSet;
			} else {
				$LanguageSet = NULL;
			}
			$MContentPath = 'telegram/system/' . $SetContent . $LanguageSet;

			if (file_exists($MContentPath)) {
				$SendContent = file_get_contents($MContentPath);

				if (is_array($SetData)) {
					foreach ($SetData as $DataKey => $DataVal) {
						$SendContent = str_replace('['.strtoupper($DataKey).']', $DataVal, $SendContent);
					}
				}

				$SendContent = str_replace(PHP_EOL, "\r\n", $SendContent);
				return $SendContent;

			} else {

				if (($LanguageSet) && (file_exists('telegram/system/default_' . $LanguageSet))) {
					$LanguageSet = '_' . $LanguageSet;
				} else {
					$LanguageSet = NULL;
				}

				$MContentPath = 'telegram/system/default' . $LanguageSet;
				if (file_exists($MContentPath)) {
					$SendContent = file_get_contents($MContentPath);
					return $SendContent;
				} else {
					return 'No answer for this error.';
				}
			}
		}

		private function getlanguage($optID) {
			$lines = file('telegram/' . $optID, FILE_IGNORE_NEW_LINES);
			foreach ($lines as $OnefilerLine) {
				$SavedSetting = explode(':', $OnefilerLine);
				$SavedArray[$SavedSetting[0]] = $SavedSetting[1];
			}

			if (isset($SavedArray['language'])) {
				return $SavedArray['language'];
			} else {
				return NULL;
			}
		}

		private function stringtosave($optID, $ValidFilters, $CommandString, $SQL_sent, $ValidModifiers, $options, $ValidActions) {

			$lines = file('telegram/' . $optID, FILE_IGNORE_NEW_LINES);
			$SavedWhere = NULL;
			$SavedArray = array();
			$StringtoSave = NULL;

			foreach ($lines as $OnefilerLine) {
				$SavedSetting = explode(':', $OnefilerLine);
				$SavedArray[$SavedSetting[0]] = $SavedSetting[1];

				if (strtolower($SavedSetting[0]) == 'address') {
					$operator = 'like'; $acceptGREP = '%';
				} else {
					$operator = '='; $acceptGREP = NULL;
				}

				if ($CommandString) {
					if ((in_array($SavedSetting[0], $ValidFilters)) && ($CommandString[0] != $SavedSetting[0]) && ($CommandString[1] != $SavedSetting[1])) {
						$SavedWhere .= "`".$SavedSetting[0]."` " . $operator . " '" . $acceptGREP . $SavedSetting[1]. $acceptGREP . "' AND ";
					}
				} else {
					if (in_array($SavedSetting[0], $ValidFilters)) {
						$SavedWhere .= "`".$SavedSetting[0]."` " . $operator . " '". $acceptGREP . $SavedSetting[1]. $acceptGREP . "' AND ";
					}
				}

				if (in_array($SavedSetting[0], $ValidModifiers)) {
					$options[$SavedSetting[0]] = $SavedSetting[1];
				}
			}

			$SavedWhere .= "(`end` is NULL OR `end` >= now()) AND ";

			$SavedArray[$CommandString[0]] = $CommandString[1];
			$RealSQL = $SavedWhere . $SQL_sent;

			foreach ($SavedArray as $SavedKey => $SavedVal) if (!in_array($SavedVal, $ValidActions)) {
				$StringtoSave .= $SavedKey . ':' . $SavedVal . PHP_EOL;
			}

			$StringtoSave = trim($StringtoSave);
			$ReturnArray['STRING'] = $StringtoSave;
			$ReturnArray['SQL'] = $RealSQL;
			$ReturnArray['FILTERS'] = $options;

			return $ReturnArray;
		}

		private function telegram_content($data, $TheServerRoot) {
			$RecordNumber = 0;
			$TelegramContent = NULL;

			foreach ($data as $RecVal) {

				$CurrentID = '{' . $RecVal['id'] . '}';
				$categories = ORM::for_table('categories')->select_many('title', 'id', 'contents')->where("enabled", 1)->where_like("contents", '%' . $CurrentID . '%')->find_array();

				$TelegramContent .= ++$RecordNumber . '; <b>' . $RecVal['title'] . '</b> - [type:' . $RecVal['type'] . ']' . PHP_EOL;
				$TelegramContent .= 'Address: <b>' . $RecVal['address'] . '</b>' . PHP_EOL;

				if (isset($RecVal['distance'])) {
					$TelegramContent .= 'Distance from you: '.round($RecVal['distance'], 2).' km.'.PHP_EOL;
				}

				if (count($categories) > 0) {
					$TelegramContent .= PHP_EOL.'<b>This content found on '.count($categories)." category(s):</b>".PHP_EOL;
					foreach ($categories as $onecategory) {
						$CatContentList = $onecategory['contents'];
						$CatContentList = str_replace(array('{', '}'), '', $CatContentList);
						$DataArray = explode(';', $CatContentList);

						$TelegramContent .= '<a href="' . $TheServerRoot . '/index.php?module=category&object=' . $onecategory['id'] . '">' . $onecategory['title'] . '</a> - [' . count($DataArray) . ' content(s)]' . PHP_EOL;
					}
				}

				if ((strlen($RecVal['start']) > 5) && (strlen($RecVal['end']) > 5)) {
					$TelegramContent .= PHP_EOL . '<b>Event date found:</b>' . PHP_EOL;
					$TelegramContent .= 'Event started: ' . $RecVal['start'] . PHP_EOL;
					$TelegramContent .= 'Event ended: ' . $RecVal['end'] . PHP_EOL;
				}

				$TelegramContent .= '<a href="' . $TheServerRoot . '/index.php?module=content&object=' . $RecVal['id']. '">Visit page from here...</a>' . PHP_EOL;
				$TelegramContent .= '---------------------------------' . PHP_EOL  . PHP_EOL;
			}

			return $TelegramContent;
		}

	}


?>
