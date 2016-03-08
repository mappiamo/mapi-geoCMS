<?php

	defined( 'DACCESS' ) or die;

	class MModel_Mgeojsonimport {

		static function parse_ini() {
			if (isset($_FILES["ini_file"])) {
				$geo_ini = $_FILES["ini_file"];

				if (isset($geo_ini["tmp_name"])) {
					$IniPath = $geo_ini["tmp_name"];
					$inifile_content = parse_ini_file($IniPath, TRUE);

					if ($inifile_content) {
						return $inifile_content;
					} else {
						return FALSE;
					}
				} else {
					return FALSE;
				}
			} else {
				return FALSE;
			}
		}

		static function parse_geojson() {

			if (isset($_FILES["geojson_file"])) {
				$geojson = $_FILES["geojson_file"];

				if (isset($geojson["tmp_name"])) {
					$geojson_content = json_decode(file_get_contents($geojson["tmp_name"]));

					if ($geojson_content) {
						$GeoData = $geojson_content->features;
						$ChoordString = NULL;
						$ChoordsArray = array();
						$PropArray = array();
						$TypeArray = array();
						$ReturnData = array();
						$DefaultLatLon = array();
						$ZoneLetter = NULL;

						if (isset($_POST['zone_shift'])) {
							sscanf($_POST['zone_shift'], "%d%s", $ZoneNumber, $ZoneLetter);
							if ((is_int($ZoneNumber)) && ($ZoneNumber > 0) && (($ZoneLetter == 'N') || ($ZoneLetter == 'E'))) {
								$ZoneCode = $ZoneNumber . $ZoneLetter;
							} else {
								$ZoneCode = NULL;
							}
						}

						//print_r($GeoData); die();

						$CoordsToLatLon = new CoordsConverter();

						foreach ($GeoData as $GKey => $OneGeo) {
							$GeoType = strtoupper($OneGeo->geometry->type);
							$GeoCoords = $OneGeo->geometry->coordinates;
							$GeoProp = $OneGeo->properties;

							switch ($GeoType) {
								case 'MULTIPOLYGON':
									$SubGeoType = 'POLYGON';
									$breacketL = '((';
									$breacketR = '))';
									break;
								case 'MULTILINESTRING':
									$SubGeoType = 'LINESTRING';
									$breacketL = '(';
									$breacketR = ')';
									break;
								case 'MULTIPOINT':
									$SubGeoType = 'POINT';
									$breacketL = '(';
									$breacketR = ')';
									break;
							}

							$GeoDataDeept = self::ArrayDeept($GeoCoords);

							if ((is_int($GeoDataDeept)) && ($GeoDataDeept > 0)) {
								switch ($GeoDataDeept) {
									case 1:
										$Data = $GeoCoords;
										break;
									case 2:
										$Data = $GeoCoords[0];
										break;
									case 3:
										$Data = $GeoCoords[0][0];
										break;
								}

								//print_r($Data); die();

								foreach ($Data as $ChordKey => $Coord) {

									$CoordsToLatLon->setUTM($Coord[0], $Coord[1], $ZoneCode);
									$CoordsToLatLon->convertTMtoLL();
									$Coord[0] = round($CoordsToLatLon->long, 8);
									$Coord[1] = round($CoordsToLatLon->lat, 8);

									//$ChoordString .= implode(' ', $Coord) . ', ';
									$ChoordString .= $Coord[0] . ' ' . $Coord[1] . ', ';

									if ($ChordKey == 0) {
										$LatLon['lat'] = $Coord[1];
										$LatLon['lon'] = $Coord[0];
									}
								}

							} else {
								return FALSE;
							}

							$ChoordString = $SubGeoType . ' ' . $breacketL . rtrim($ChoordString, ', ') . $breacketR;
							$ChoordsArray[$GKey] = $ChoordString;
							$ChoordString = NULL;
							$PropArray[$GKey] = $GeoProp;
							$TypeArray[$GKey] = $GeoType;
							$DefaultLatLon[$GKey] = $LatLon;

						}

						//print_r($ChoordsArray); die();
						//$WKTString = 'GeometryCollection(' . implode(',', $ChoordsArray) . ')';

						$ReturnData['DataQTY'] = count($ChoordsArray);
						$ReturnData['GeoType'] = $TypeArray;
						$ReturnData['GeoProp'] = $PropArray;
						//$ReturnData['WKTString'] = $WKTString;
						$ReturnData['WKTString'] = $ChoordsArray;
						$ReturnData['DefaultCoords'] = $DefaultLatLon;
						return $ReturnData;

					} else {
						return FALSE;
					}
				} else {
					return FALSE;
				}
			} else {
				return FALSE;
			}
		}

		static function ArrayDeept(array $array) {
			$max_depth = 0;

			foreach ($array as $value) {
				if (is_array($value)) {
					$depth = self::ArrayDeept($value) + 1;

					if ($depth > $max_depth) {
						$max_depth = $depth;
					}
				}
			}
			return $max_depth;
		}

		static function getallcategory() {
			$AllCats = ORM::for_table('categories')->select_many('name', 'title')->find_array();
			return $AllCats;
		}

		static function geojson_ini_check($checkdata) {

			if ((isset($checkdata['ini'])) && (isset($checkdata['geo']))) {

				$object_vars = get_object_vars($checkdata['geo']['GeoProp']['0']);
				$FieldNames = array_keys($object_vars);

				$TableNames = array_keys($checkdata['ini']);
				$SHPProperty = array();

				foreach ($TableNames as $OneTableName) {
					if (strtolower($OneTableName) != 'fixed_data') {
						$ColumnsArray = array_keys($checkdata['ini'][$OneTableName]);
						$RequiredTables['DataBase'][$OneTableName] = $ColumnsArray;

						foreach ($ColumnsArray as $ColumnName) {
							$PropertiesArray = $checkdata['ini'][$OneTableName][$ColumnName];
							foreach ($PropertiesArray as $OneProperty) {
								if (!in_array($OneProperty, $SHPProperty)) {
									$SHPProperty[] = $OneProperty;
								}
							}
						}

					} else {

						$TablesArray = array_keys($checkdata['ini']['fixed_data']);
						foreach ($TablesArray as $OneTableName) {
							$ColumnsArray = array_keys($checkdata['ini']['fixed_data'][$OneTableName]);
							if (isset($RequiredTables['DataBase'][$OneTableName])) {
								foreach ($ColumnsArray as $OneColName) {
									$RequiredTables['DataBase'][$OneTableName][] = $OneColName;
								}
							} else {
								$RequiredTables['DataBase'][$OneTableName] = $ColumnsArray;
							}
						}
					}
				}

				$difference = array_diff($SHPProperty, $FieldNames);

				if (count($difference) == 0) {
					foreach ($RequiredTables['DataBase'] as $TableName => $Colnames) {
						foreach ($Colnames as $OneCol) {
							$SQL = "SHOW COLUMNS FROM `" . $TableName . "` WHERE Field = '" . $OneCol . "'";
							$ColumnExist = ORM::for_table($TableName)->raw_query($SQL)->find_one();
							if (!$ColumnExist) { return FALSE; }
						}
					}

					$SQL = "SHOW COLUMNS FROM `categories` WHERE Field = 'name'";
					$ColumnExist = ORM::for_table('categories')->raw_query($SQL)->find_one();
					if (!$ColumnExist) { return FALSE; }

					return TRUE;
				} else {
					return FALSE;
				}

			} else {
				return FALSE;
			}

		}

		static function import_content($ImporterData) {
			//echo '<pre>' . print_r($ImporterData, 1) . '</pre>'; die();
			$result['catname'] = $ImporterData['geo']['CatName'];
			$result['all'] = $ImporterData['geo']['DataQTY'];

			$succedd = 0;
			$failed = 0;
			$savedmeta = 0;
			$doubled = 0;

			$CatName = $result['catname'];
			$CatExist = ORM::for_table('categories')->select_many('id')->where('name', $CatName)->find_one();

			if (!$CatExist) {
				$Message = 'Category name [' . $result['catname'] . '] not available. Please create empty category for import.';
				MMessaging::add_error($Message);
				return $result;
			} else {
				$Message = 'Category name [' . $result['catname'] . '] available. All imported data will be saved to this category.';
				MMessaging::add_success($Message);
			}

			$userID = MAuth::user_id();
			if ((!$userID) || (!is_int($userID))) {
				$Message = 'This user have no rights to do this task.';
				MMessaging::add_error($Message);
				return $result;
			}

			$Message = 'Selected GeoJson datafile contains ' . $result['all'] . ' data. Import process starts.';
			MMessaging::add_warning($Message);

			$PropData = $ImporterData['geo']['GeoProp'];
			$RouteData = $ImporterData['geo']['WKTString'];
			$LatLonData = $ImporterData['geo']['DefaultCoords'];
			$ContIniArray = $ImporterData['ini']['contents'];
			$CategoryIDs = array();

			$MaixID_SQL = "SELECT MAX(id) as MaxID FROM contents";
			$MaxID = ORM::for_table('contents')->raw_query($MaixID_SQL)->find_one();
			if ($MaxID) { $MaxID = $MaxID['MaxID']; } else { $MaxID = 0; }

			foreach ($RouteData as $RouteKey => $RouteVal) {

				$contents = ORM::for_table('contents')->create();

				if (isset($ImporterData['ini']['fixed_data'])) {
					if (isset($ImporterData['ini']['fixed_data']['contents'])) {
						$fixedFields = $ImporterData['ini']['fixed_data']['contents'];
						foreach ($fixedFields as $FixedColum => $FixedData) {

							$contents->set($FixedColum, $FixedData);

						}
					}
				}

				$PropObject = (array)$PropData[$RouteKey];
				$TitleData = NULL;

				foreach ($ContIniArray as $Colname => $SHPFields) {
					if (is_array($SHPFields)) {
						if (count($SHPFields) > 0) {
							$DataValue = NULL;

							foreach ($SHPFields as $SHP_PropName) {
								if (isset($PropObject[$SHP_PropName])) {
									$DataValue .= $PropObject[$SHP_PropName] . ', ';
								}
							}

							$DataValue = rtrim($DataValue, ', ');
							//$DataValue = str_replace('\'', '\\\'', $DataValue);

							if ($Colname == 'title') {
								$TitleData = $DataValue;
							} else {
								$contents->set($Colname, $DataValue);
							}
						}
					}
				}

				$MaxID++;

				foreach ($PropObject as $MetaName => $MetaValue) if ($MetaValue) {
					$metadata = ORM::for_table('content_meta')->create();
					$metadata->set('name', $MetaName);
					$metadata->set('value', $MetaValue);
					$metadata->set('external_id', $MaxID);
					$metadata->save();
					$savedmeta++;
				}

				if (!$TitleData) { $TitleData = 'Imported content from GeoJson [' . $MaxID . ']'; }
				$NameData = mb_substr(str_replace(array(' ', '\\', '.', ',', '\'', '`', '/', '&', '?'), array('-', '-', '-', '-', '-', '-', '-', '', ''), strtolower(strip_tags($TitleData))), 0, 55, 'UTF-8');
				$NameData = preg_replace('/[^a-zA-Z0-9-]/i', '', iconv("UTF-8", "US-ASCII//TRANSLIT", $NameData));

				$NameExist = ORM::for_table('contents')->where('name', $NameData)->find_one();
				if ($NameExist) {
					$doubled++;
					$TitleData = $TitleData . ' [' . $doubled . ']';
					$NameData = $NameData . '-' . $doubled;
				}

				$contents->set('id', $MaxID);
				$contents->set('name', $NameData);
				$contents->set('title', $TitleData);
				$contents->set('createdby', $userID);
				$contents->set('modifiedby', $userID);
				$contents->set('route', $RouteVal);
				$contents->set('lat', $LatLonData[$RouteKey]['lat']);
				$contents->set('lng', $LatLonData[$RouteKey]['lon']);
				$contents->set('license', 2);
				$contents->set_expr('created', 'NOW()');
				$contents->set_expr('modified', 'NOW()');
				//print_r($contents);

				if ($contents->save()) {
					$contents->save();
					$succedd++;

					$CategoryIDs[] = $MaxID;

				} else {
					$Message = 'Imported document error on the row title: [' . $TitleData . '] id: [' . $MaxID . ']';
					MMessaging::add_error($Message);
					$failed++;
				}

			}

			$Message = $succedd . ' data imported to the selected category.';
			MMessaging::add_success($Message);

			if ($failed > 0) {
				$Message = $failed . ' not imported to the selected category because the data or ini file contains error.';
				MMessaging::add_error($Message);
			} else {
				$Message = 'All data imported to content table.';
				MMessaging::add_success($Message);
			}

			if (count($CategoryIDs) > 0) {
				$CurrentCat = ORM::for_table('categories')->select_many('contents')->where('name', $CatName)->find_one();

				$CategoryString = '{'.implode('};{', $CategoryIDs).'}';
				$category = ORM::for_table('categories')->where('name', $CatName)->find_one();

				if ($CurrentCat) {
					if (isset($CurrentCat['contents'])) {
						if (strlen($CurrentCat['contents']) > 3) {
							$CategoryString = $CurrentCat['contents'] . ';' . $CategoryString;

							$Message = 'The selected category [' . $CatName . '] is not empty. ' . $succedd . ' Imported data will be added to this category.';
							MMessaging::add_warning($Message);
						}
					}
				}
				$category->set('contents', $CategoryString);

				if ($category->save()) {
					$category->save();
					$Message = 'Selected category filled with saved data IDs.';
					MMessaging::add_success($Message);
				} else {
					$Message = 'Data cannot saved to the selected category name: ['.$result['catname'].']';
					MMessaging::add_error($Message);
				}
			}

			if ($savedmeta > 0) {
				$Message = $savedmeta . ' metadata saved to database.';
				MMessaging::add_success($Message);
			}

			if ($doubled > 0) {
				$Message = $doubled . ' imported content have same name and title. Maybe you have [' . $doubled . '] duplicated contents.';
				MMessaging::add_error($Message);
			}

			return $result;
		}

	}

	class CoordsConverter {

		var $ellipsoid = array("Airy" => array(6377563, 0.00667054), "Australian National" => array(6378160, 0.006694542),
													 "Bessel 1841" => array(6377397, 0.006674372),
													 "Bessel 1841 Nambia" => array(6377484, 0.006674372),
													 "Clarke 1866" => array(6378206, 0.006768658), "Clarke 1880" => array(6378249, 0.006803511),
													 "Everest" => array(6377276, 0.006637847),
													 "Fischer 1960 Mercury" => array(6378166, 0.006693422),
													 "Fischer 1968" => array(6378150, 0.006693422), "GRS 1967" => array(6378160, 0.006694605),
													 "GRS 1980" => array(6378137, 0.00669438), "Helmert 1906" => array(6378200, 0.006693422),
													 "Hough" => array(6378270, 0.00672267), "International" => array(6378388, 0.00672267),
													 "Krassovsky" => array(6378245, 0.006693422), "Modified Airy" => array(6377340, 0.00667054),
													 "Modified Everest" => array(6377304, 0.006637847),
													 "Modified Fischer 1960" => array(6378155, 0.006693422),
													 "South American 1969" => array(6378160, 0.006694542),
													 "WGS 60" => array(6378165, 0.006693422), "WGS 66" => array(6378145, 0.006694542),
													 "WGS 72" => array(6378135, 0.006694318), "WGS 84" => array(6378137, 0.00669438));

		var $a;
		var $e2;
		var $datum;
		var $Xp, $Yp;
		var $lat, $long;
		var $utmNorthing, $utmEasting, $utmZone;
		var $lccNorthing, $lccEasting;
		var $falseNorthing, $falseEasting;
		var $latOfOrigin;
		var $longOfOrigin;
		var $firstStdParallel;
		var $secondStdParallel;

		public function __construct($datum = 'WGS 84') {
			$this->a = $this->ellipsoid[$datum][0];
			$this->e2 = $this->ellipsoid[$datum][1];
			$this->datum = $datum;
		}

		function setUTM($easting, $northing, $zone = '') {
			$this->utmNorthing = $northing;
			$this->utmEasting = $easting;
			$this->utmZone = $zone;
		}

		function convertTMtoLL($LongOrigin = NULL) {
			$k0 = 0.9996;
			$e1 = (1 - sqrt(1 - $this->e2)) / (1 + sqrt(1 - $this->e2));
			$falseEasting = 0.0;
			$y = $this->utmNorthing;

			if (!$LongOrigin) { // It is a UTM coordinate we want to convert
				sscanf($this->utmZone, "%d%s", $ZoneNumber, $ZoneLetter);
				if ($ZoneLetter >= 'N') {
					$NorthernHemisphere = 1;
				} //point is in northern hemisphere
				else {
					$NorthernHemisphere = 0; //point is in southern hemisphere
					$y -= 10000000.0; //remove 10,000,000 meter offset used for southern hemisphere
				}
				$LongOrigin = ($ZoneNumber - 1) * 6 - 180 + 3; //+3 puts origin in middle of zone
				$falseEasting = 500000.0;
			}

			//		$y -= 10000000.0;	// Uncomment line to make LOCAL coordinates return southern hemesphere Lat/Long
			$x = $this->utmEasting - $falseEasting; //remove 500,000 meter offset for longitude

			$eccPrimeSquared = ($this->e2) / (1 - $this->e2);

			$M = $y / $k0;
			$mu = $M / ($this->a *
									(1 - $this->e2 / 4 - 3 * $this->e2 * $this->e2 / 64 - 5 * $this->e2 * $this->e2 * $this->e2 / 256));

			$phi1Rad = $mu + (3 * $e1 / 2 - 27 * $e1 * $e1 * $e1 / 32) * sin(2 * $mu) +
								 (21 * $e1 * $e1 / 16 - 55 * $e1 * $e1 * $e1 * $e1 / 32) * sin(4 * $mu) +
								 (151 * $e1 * $e1 * $e1 / 96) * sin(6 * $mu);
			$phi1 = rad2deg($phi1Rad);

			$N1 = $this->a / sqrt(1 - $this->e2 * sin($phi1Rad) * sin($phi1Rad));
			$T1 = tan($phi1Rad) * tan($phi1Rad);
			$C1 = $eccPrimeSquared * cos($phi1Rad) * cos($phi1Rad);
			$R1 = $this->a * (1 - $this->e2) / pow(1 - $this->e2 * sin($phi1Rad) * sin($phi1Rad), 1.5);
			$D = $x / ($N1 * $k0);

			$tlat = $phi1Rad - ($N1 * tan($phi1Rad) / $R1) * ($D * $D / 2 - (5 + 3 * $T1 + 10 * $C1 - 4 * $C1 * $C1 -
																																			 9 * $eccPrimeSquared) * $D * $D * $D * $D / 24 +
																												(61 + 90 * $T1 + 298 * $C1 + 45 * $T1 * $T1 -
																												 252 * $eccPrimeSquared - 3 * $C1 * $C1) * $D * $D * $D * $D *
																												$D * $D / 720); // fixed in 1.1
			$this->lat = rad2deg($tlat);

			$tlong = ($D - (1 + 2 * $T1 + $C1) * $D * $D * $D / 6 +
								(5 - 2 * $C1 + 28 * $T1 - 3 * $C1 * $C1 + 8 * $eccPrimeSquared + 24 * $T1 * $T1) * $D * $D * $D * $D *
								$D / 120) / cos($phi1Rad);
			$this->long = $LongOrigin + rad2deg($tlong);
		}
	}
