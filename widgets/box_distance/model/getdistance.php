<?PHP
	defined( 'DACCESS' ) or die;

	class getdistance {

		function getdata($id, $language) {

			$content_data = ORM::for_table('contents')->select_many('address', 'name', 'type', 'title', 'lat', 'lng', 'route')->where('id', $id)->where('enabled', 1)->find_one();
			$get_similar_byaddress = array();
			$get_similar_byid = array();
			$AllContentID = array();
			$AddressID = array();

			if ((($content_data['type'] == 'place') || ($content_data['type'] == 'event')) && (($content_data['lat'] == 0) || ($content_data['lng'] == 0))) {
				$PointGeom = $content_data['route'];
				preg_match('/^([^\(]*)([\(]*)([^A-Za-z]*[^\)$])([\)]*[^,])$/', $PointGeom, $Match);
				$LanLotCoords = explode(' ', $Match[3]);
				$content_data['lat'] = $LanLotCoords[1];
				$content_data['lng'] = $LanLotCoords[0];
			}

			//print_r($content_data); die();

			if ($content_data) {
				if ($content_data['type'] == 'route') {
					$SeekTitle = $content_data['title'];
					$SeekName = $content_data['name'];
					$TheGEOMData = $content_data['route'];
					$Geomtype_SQL = "SELECT ST_GeometryType(ST_GeomFromText('$TheGEOMData')) AS GEOMType";
					$Geomtype = ORM::for_table('contents')->raw_query($Geomtype_SQL)->where('enabled', 1)->find_array();

					if ($Geomtype[0]['GEOMType'] == 'MULTIPOLYGON') {
						$PlacesArray = ORM::for_table('contents')->select_many('id', 'title', 'type', 'address', 'lat', 'lng', 'route')->where('type', 'place')->where('enabled', 1)->where('language', $language)->find_array();

						foreach ($PlacesArray as $PlaceKey => $PlaceVal) {
							if ($PlaceVal['route']) {
								$PlaceString = $PlaceVal['route'];
								$Filter_SQL =
								"SELECT ST_Contains(ST_GeomFromText('$TheGEOMData', 4326), ST_GeomFromText('$PlaceString', 4326)) AS FilterResult";
								$Filter_DATA = ORM::for_table('contents')->raw_query($Filter_SQL)->find_array();
								if ($Filter_DATA[0]['FilterResult'] == TRUE) {
									$get_similar_byaddress[] = $PlaceVal;
								}
							}
						}
					} else {
						$get_similar_byaddress = ORM::for_table('contents')->select_many('id', 'title', 'type', 'address')->where_like('address', '%' . $SeekTitle . '%')->where('type', 'place')->where('language', $language)->where('enabled', 1)->order_by_asc('title')->find_array();
						$get_similar_byid = ORM::for_table('categories')->select_many('id', 'contents', 'title')->where_like('name', '%' . $SeekName . '%')->find_array();
					}

					if (count($get_similar_byaddress) > 0) {
						foreach ($get_similar_byaddress as $OneByAddress) {
							$AddressID[] = $OneByAddress['id'];
						}
					}

				} else {
					//$get_similar_byid = ORM::for_table('categories')->select_many('id', 'contents', 'title')->where_like('contents', '%{' . $id . '}%')->find_array();
					$get_similar_byaddress = ORM::for_table('contents')
												->raw_query('SELECT id, title, type, address, (3959 * acos(cos(radians(:latitude)) * cos(radians(lat)) * cos(radians(lng) - radians(:longitude)) + sin(radians(:latitude))  * sin(radians(lat)))) * 1000 AS distance FROM contents WHERE type = \'place\' AND language = \'' . $language . '\' HAVING distance < :radius AND distance > 0 ORDER BY distance ASC LIMIT 6',
													array("latitude" => $content_data["lat"], "longitude" => $content_data["lng"], "radius" => 2000))->find_array();
				}

				if (count($get_similar_byid) > 0) {
					foreach ($get_similar_byid as $CatData) {
						$ContentsOnCat = $CatData['contents'];
						$ContentIDs = explode(';', $ContentsOnCat);

						foreach ($ContentIDs as $OneID) {
							$theID = str_replace(array('{', '}'), '', $OneID);
							if ((!in_array($theID, $AllContentID)) && ($theID != $id) && (!in_array($theID, $AddressID))) {
								$AllContentID[] = $theID;
							}
						}
					}

					$Content_where = '`id` = ' . implode(' OR `id` = ', $AllContentID);
					if ($content_data['type'] == 'event') {
						$Content_where = '(' . $Content_where . ') AND `type` = \'event\'';
					}
					$Content_where = '(' . $Content_where . ') AND `language` = \'' . $language . '\'';
					$get_similar_markers = ORM::for_table('contents')->select_many('id', 'title', 'type', 'address')->where_raw($Content_where)->where('type', 'place')->where('enabled', 1)->find_array();
				} else {
					$get_similar_markers = array();
				}

				if (is_array($get_similar_byaddress)) {
					$all_similar_markers = array_merge($get_similar_markers, $get_similar_byaddress);
				} else {
					$all_similar_markers = $get_similar_markers;
				}
			}
			//$meta_info = ORM::for_table('content_meta')->select_many('external_id', 'name', 'value')->where('external_id', $id)->find_array();

			//if (($content_data['type'] == 'place') || ($content_data['type'] == 'event')) {
			if (is_array($all_similar_markers)) {
				foreach ($all_similar_markers as $Key => $OneMarker) {
					$ContentID = $OneMarker['id'];
					$MarkerIcon = ORM::for_table('content_meta')->select_many('value')->where('external_id', $ContentID)->where('name', 'icon-file')->find_one();
					if ($MarkerIcon) {
						$all_similar_markers[$Key]['icondata'] = $MarkerIcon['value'];
					}
					$all_similar_markers[$Key]['selected_title'] = $content_data['title'];
				}
			}

			//echo $SeekThis; die();
			//print_r($all_similar_markers);
			//die();

			if ($all_similar_markers) {
				if (count($all_similar_markers) > 0) {
					return $all_similar_markers;
				} else {
					return FALSE;
				}
			} else {
				return FALSE;
			}
		}

	}
?>