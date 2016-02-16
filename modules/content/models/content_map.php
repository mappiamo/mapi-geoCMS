<?php

	// no direct access to this file
	defined( 'DACCESS' ) or die;

	class MModel_Content_Map {

		static function add_category( $id ) {

			//return print_r($_POST, 1);

			$contents = array();
			$QueryString = NULL;

			$lang = new M_Language;
			$language = $lang->getLanguage();

			//$category = MObject::get( 'category', $id );
			$theplaces = ORM::for_table('categories')->select_many('contents', 'name')->where('id', $id)->where('enabled', '1')->find_one();

			if ($theplaces) {

				$PlacesString = str_replace(array('{', '}'), '', $theplaces['contents']);
				$PlacesArray = explode(';', $PlacesString);

				if (count($PlacesArray) > 0) {
					foreach ($PlacesArray as $ContentID) {
						if (is_numeric($ContentID)) {
							$QueryString .= '`id` = '.$ContentID.' OR ';
						}
					}

					$QueryString = '(' . rtrim($QueryString, ' OR ') . ')';
					if (isset($_POST['CornersData'])) {
						$Corners = $_POST['CornersData'];
						$QueryString .= ' AND (lat <= ' . $Corners["NE_lat"] . ' AND lat >= ' . $Corners["SE_lat"] . ' AND lng <= ' . $Corners["NE_lng"] . ' AND lng >= ' . $Corners["SE_lng"] . ')';
					}

					//return print_r($QueryString, 1);

					$PlaceData = ORM::for_table('contents')->select_many('type', 'title', 'id', 'lat', 'lng', 'text', 'start', 'end', 'address')->where_raw($QueryString)->where('enabled', 1)->where('language', $language)->find_array();

					if (count($PlaceData) > 0) {

						foreach ($PlaceData as $key => $content) {
							$title = '';
							$title .= '<a href="index.php?module=content&object=' . $content['id'] . '">' . $content['title'] . '</a>';
							$title .= '<br />';
							$title .= '<small>(' . $content['address'] . ')</small>';

							$contents[$key] = array(
							'title'		=> $title,
							'text'		=> substr( strip_tags( $content['text'], '<br>' ), 0, 100 ) .' ... <br /><br /><a href="index.php?module=content&object=' . $content['id'] . '"><small>read more &gt;&gt;</small></a>' ,
							'lat'		=> $content['lat'],
							'lng'		=> $content['lng'],
							//'route'		=> $content->get_route(),
							'category'	=> $theplaces['name']
							);
						}

						//return print_r($PlaceData, 1);
						return $contents;

					} else {
						return NULL;
					}

				} else {
					return NULL;
				}

			} else {
				return NULL;
			}
		}

	}

?>