<?PHP
	defined( 'DACCESS' ) or die;

	class getevents {

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
					$DateFilter = "`end` >= now()";
					$get_similar_byaddress = ORM::for_table('contents')->select_many('id', 'title', 'type', 'address', 'start', 'end')->where_like('address', '%' . $SeekTitle . '%')->where('type', 'event')->where_raw($DateFilter)->where('enabled', 1)->where('language', $language)->order_by_asc('end')->find_array();
					//$get_similar_byid = ORM::for_table('categories')->select_many('id', 'contents', 'title')->where_like('name', '%' . $SeekName . '%')->find_array();

					if (count($get_similar_byaddress) > 0) {
						foreach ($get_similar_byaddress as $OneByAddress) {
							$AddressID[] = $OneByAddress['id'];
						}
					} else {

						$TheGEOMData = $content_data['route'];
						$Geomtype_SQL = "SELECT ST_GeometryType(ST_GeomFromText('$TheGEOMData')) AS GEOMType";
						$Geomtype = ORM::for_table('contents')->raw_query($Geomtype_SQL)->where('enabled', 1)->find_one();

						if ($Geomtype['GEOMType'] == 'MULTILINESTRING') {

							function cmp($a, $b) {
								return $a['distance'] - $b['distance'];
							}

							$AllEvents = ORM::for_table('contents')->select_many('id', 'title', 'type', 'address', 'start', 'end', 'route')->where('enabled', 1)->where_raw($DateFilter)->where('type', 'event')->where('language', $language)->order_by_asc('end')->find_array();
							if (count($AllEvents) > 0) {
								foreach ($AllEvents as $OneEvent) {
									if ((isset($OneEvent['route'])) && ($OneEvent['route'])) {
										$PlaceString = $OneEvent['route'];
										$Filter_SQL = "SELECT ST_Distance(ST_GeomFromText('$TheGEOMData', 4326), ST_GeomFromText('$PlaceString', 4326)) * 111195 AS FilterResult";
										$Filter_DATA = ORM::for_table('contents')->raw_query($Filter_SQL)->find_array();
										if ($Filter_DATA[0]['FilterResult'] <= 1500) {
											$OneEvent['distance'] = $Filter_DATA[0]['FilterResult'];
											$get_similar_byaddress[] = $OneEvent;
										}
									}
								}
								//if (count($get_similar_byaddress) > 0) {
									//usort($get_similar_byaddress, "cmp");
								//}
							}
						}
					}

				} else {
					//$get_similar_byid = ORM::for_table('categories')->select_many('id', 'contents', 'title')->where_like('contents', '%{' . $id . '}%')->find_array();
					$get_similar_byaddress = ORM::for_table('contents')
												->raw_query('SELECT id, title, type, address, start, end, (3959 * acos(cos(radians(:latitude)) * cos(radians(lat)) * cos(radians(lng) - radians(:longitude)) + sin(radians(:latitude))  * sin(radians(lat)))) * 1000 AS distance FROM contents WHERE type = \'event\' AND end >= now() AND language = \'' . $language . '\' HAVING distance < :radius AND  distance > 0 ORDER BY end ASC LIMIT 6',
													array("latitude" => $content_data["lat"], "longitude" => $content_data["lng"], "radius" => 4000))->find_array();
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
					$get_similar_markers = ORM::for_table('contents')->select_many('id', 'title', 'type', 'address', 'start', 'end')->where_raw($Content_where)->where('type', 'event')->where_raw($DateFilter)->order_by_asc('end')->find_array();
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
				foreach ($all_similar_markers as $Key => $OneMarker) {
					$ContentID = $OneMarker['id'];
					$MarkerIcon = ORM::for_table('content_meta')->select_many('value')->where('external_id', $ContentID)->where('name', 'icon-file')->find_one();
					if ($MarkerIcon) {
						$all_similar_markers[$Key]['icondata'] = $MarkerIcon['value'];
					}
					$all_similar_markers[$Key]['selected_title'] = $content_data['title'];
				}
			//}

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