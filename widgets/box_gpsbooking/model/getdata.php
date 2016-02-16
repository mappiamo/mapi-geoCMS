<?php

	class gpsbooking {

		function getbookingdata($lat, $lon, $CID) {

			$TheURL = 'http://resource.gpsbooking.com/?cid=' . $CID . '&lat=' . $lat . '&lng=' . $lon;
			$jsonData = json_decode(file_get_contents($TheURL));
			$TheGEOMData = 'POINT(' . $lon . ' ' . $lat . ')';

			if ((is_object($jsonData)) && count($jsonData) > 0) {

				foreach ($jsonData as $array_key => $OneJData) {

					if ((isset($OneJData->lng)) && ($OneJData->lat)) {
						$PlaceString = 'POINT('.$OneJData->lng.' '.$OneJData->lat.')';
						$distance_SQL =
						"SELECT ST_Distance(ST_GeomFromText('$TheGEOMData', 4326), ST_GeomFromText('$PlaceString', 4326)) * 111195 AS DistanceResult";
						$distance_DATA = ORM::for_table('contents')->raw_query($distance_SQL)->find_array();
						$OneJData->{"Distance"} = $distance_DATA[0]['DistanceResult'];
					} else {
						$OneJData->{"Distance"} = 'Unknown';
					}
					$jsonArray[$array_key] = $OneJData;
				}

				function cmp($a, $b) {
					return strnatcmp($a->Distance, $b->Distance);
				}

				usort($jsonArray, "cmp");
				$jsonData = (object)$jsonArray;

				return $jsonData;
			} else {
				return FALSE;
			}

		}

	}

	?>