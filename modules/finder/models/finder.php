<?php

	defined( 'DACCESS' ) or die;

	class MModel_Finder {

		static function search($key) {

			$searchstring = $key;
			if (strlen($searchstring) >= 3) {

				$searchstring = str_replace(array('\'', '`'), array('\\\'', '\\`'), $searchstring);

				$language = new M_Language;
				$contentlang = $language->getLanguage();

				$PlaceSearch_category = array();

				$SearchQueryArray = explode(' ', $searchstring);
				$SearchQuery = '((`text` LIKE \'%' . implode('%\' AND `text` LIKE \'%', $SearchQueryArray) . '%\')';
				$SearchQuery .= ' OR ';
				$SearchQuery .= '(`title` LIKE \'%' . implode('%\' AND `title` LIKE \'%', $SearchQueryArray) . '%\'))';
				$SearchQuery .= ' AND (`type` = \'place\' OR `type` = \'event\' OR `type` = \'route\')';

				$CatSearchQuery = '((`name` LIKE \'%' . implode('%\' AND `name` LIKE \'%', $SearchQueryArray) . '%\')';
				$CatSearchQuery .= ' OR ';
				$CatSearchQuery .= '(`title` LIKE \'%' . implode('%\' AND `title` LIKE \'%', $SearchQueryArray) . '%\'))';

				$PlaceSearch_content = ORM::for_table('contents')->select('title')->select('route', 'point')->select('id')->select('lat')->select('lng')->select('start')->select('end')->select('address')->select('text')->where_raw($SearchQuery)->where('enabled', 1)->where('language', $contentlang)->find_array();
				$CatSearch = ORM::for_table('categories')->select_many('contents', 'title', 'id')->where_raw($CatSearchQuery)->where('enabled', 1)->find_array();

				if (is_array($CatSearch)) {
					if (count($CatSearch) > 0) {
						$QueryString = NULL;
						foreach ($CatSearch as $OneCategory) {
							$PlacesString = $OneCategory['contents'];
							if (strlen(trim($PlacesString)) > 0) {
								$PlacesString = str_replace(array('{', '}'), '', $PlacesString);
								$PlacesArray = explode(';', $PlacesString);
								$PlacesArray = array_filter($PlacesArray);

								if (count($PlacesArray) > 0) {
									foreach ($PlacesArray as $ContentID) {
										if (is_numeric($ContentID)) {
											$QueryString .= '`id` = ' .  $ContentID . ' OR ';
										}
									}

									$QueryString = '(' . rtrim($QueryString, ' OR ') . ')';
									$PlaceSearch_category = ORM::for_table('contents')->select('title')->select('route', 'point')->select('id')->select('lat')->select('lng')->select('start')->select('end')->select('address')->select('text')->where_raw($QueryString)->where('enabled', 1)->where('language', $contentlang)->find_array();

								}
							}
						}
					}
				}

				$SearchResult = array_merge($PlaceSearch_category, $PlaceSearch_content);

				if (is_array($SearchResult)) {
					if (count($SearchResult) > 0) {
						return $SearchResult;
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
	}