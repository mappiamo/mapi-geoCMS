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
				$UCID = $_GET['object'];

				if (count($PlacesArray) > 0) {
					foreach ($PlacesArray as $ContentID) {
						if (is_numeric($ContentID)) {
							if ($ContentID != $UCID) {
								$QueryString .= '`id` = '.$ContentID.' OR ';
							}
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

							$CID = $content['id'];
							$Image = ORM::for_table('content_media')->select_many('url')->where('external_id', $CID)->where('default_media', 1)->find_one();

							if ($Image) {
								$IMGCont = '<img src=" ' . $Image['url'] . '" class="popup_img">';
							} else {
								$IMGCont = NULL;
							}

							$meta_ranking = ORM::for_table('content_meta')->select_many('value')->where('name', 'PropertiesRanking')->where('external_id', $CID)->find_one();
							$meta_MinRate = ORM::for_table('content_meta')->select_many('value')->where('name', 'minrate')->where('external_id', $CID) ->find_one();

							if ($meta_MinRate) {
								$LowPrice = '&#8364; ' . $meta_MinRate['value'];
							} else {
								$LowPrice = NULL;
							}

							if ($meta_ranking && intval($meta_ranking['value']) > 0) {
								$RankingStars = '<div class="popup_stars">';
								$RankingValue = $meta_ranking['value'];
								for ($i = 1; $i <= $RankingValue; $i++) {
									$RankingStars .= '<img src="./widgets/booking/star.png" style="height: 12px">';
								}
								$RankingStars .= '</div>';
							} else {
								$RankingStars = NULL;
							}

							$title = '';
							$title .= '<a href="index.php?module=content&object=' . $content['id'] . '">' . $content['title'] . '</a> ' . $RankingStars . ' ' . $LowPrice;
							$title .= '<br />';
							$title .= '<small>(' . $content['address'] . ')</small>';

							$contents[$key] = array(
							'title'		=> $title,
							'text'		=> $IMGCont . substr( strip_tags( $content['text'], '<br>' ), 0, 100 ) .' ... <br /><br /><a href="index.php?module=content&object=' . $content['id'] . '"><small>read more &gt;&gt;</small></a>' ,
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