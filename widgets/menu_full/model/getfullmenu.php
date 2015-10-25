<?php
/**
 * Created by PhpStorm.
 * User: Laca
 * Date: 2015.10.23.
 * Time: 11:39
 */

	defined( 'DACCESS' ) or die;

	class getfullmenu {
		function getmenudata($MenuName) {

			$MenuContent = ORM::for_table('menus')->select_many('id', 'title', 'pages')
											->where_raw('(`enabled` = ? AND (`name` like ? OR `id` = ?))', array(1, $MenuName, $MenuName))
											->find_one();

			$MenuTitle = $MenuContent->title;
			$MenuID = $MenuContent->id;
			$PagesInMenu = $MenuContent->pages;
			$PagesByID = array();
			$SubArraysTitles = array();
			$SubArraysURL = array();

			$matches = array();
			preg_match_all("/{([^}]*)}/", $PagesInMenu, $matches);
			$PagesList = $matches[1];

			sort($PagesList);

			if (count($PagesList) > 0) {
				$PageSearchQuery = '`enabled` = 1 AND (`id` = ' . implode(' OR `id` = ', $PagesList) . ')';

				$PagesListArray = ORM::for_table('pages')->select_many('id', 'title', 'parent_id', 'url')
													->where_raw($PageSearchQuery)
													->find_array();
			} else {
				$PagesListArray = array();
			}

			$PagesWithParent = ORM::for_table('pages')->select_many('id', 'title', 'parent_id', 'url')
														->where_raw('(`enabled` = ? AND `parent_id` like ?)', array(1, '%' . $MenuID . '_%'))
														->find_array();

			if (count($PagesWithParent) > 0) {
				foreach ($PagesWithParent as $OneParent) {
					$ParentIDs = $OneParent['parent_id'];
					$ParentIDsArray = explode('|', $ParentIDs);
					$PageID = $OneParent['id'];

					foreach ($ParentIDsArray as $ParentID) {
						$ParentArrays = explode('_', $ParentID);
						$ParentArrays = array_filter($ParentArrays);
						foreach ($ParentArrays as $PKey => $PVal) if (($ParentArrays[0] == $MenuID) && ($PKey > 0)) {
							$SubArraysTitles[$PVal][$PageID] = $OneParent['title'];

							if (filter_var($OneParent['url'], FILTER_VALIDATE_URL)) {
								if (strrpos($OneParent['url'], '/', 8)) {
									$TheLinkRoot = substr($OneParent['url'], 0, strrpos($OneParent['url'], '/', 8));
								} else {
									$TheLinkRoot = $OneParent['url'];
								}
								$TheServerRoot = str_replace("/manager", "", rtrim(((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']), '/\\'));
								$OneParent['url'] = str_replace($TheLinkRoot, $TheServerRoot, $OneParent['url']);
							}

							$SubArraysURL[$PVal][$PageID] = $OneParent['url'];
						}
					}
				}
			}

			foreach ($PagesListArray as $OnePageData) {
				$CurrPageID = $OnePageData['id'];
				$PagesByID[$CurrPageID]['title'] = $OnePageData['title'];

				if (filter_var($OnePageData['url'], FILTER_VALIDATE_URL)) {
						if (strrpos($OnePageData['url'], '/', 8)) {
						$TheLinkRoot = substr($OnePageData['url'], 0, strrpos($OnePageData['url'], '/', 8));
					} else {
						$TheLinkRoot = $OnePageData['url'];
					}
					$TheServerRoot = str_replace("/manager", "", rtrim(((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']), '/\\'));
					$OnePageData['url'] = str_replace($TheLinkRoot, $TheServerRoot, $OnePageData['url']);
				}

				$PagesByID[$CurrPageID]['url'] = $OnePageData['url'];
				if (array_key_exists($CurrPageID, $SubArraysTitles)) {
					$PagesByID[$CurrPageID]['subtitles'] = $SubArraysTitles[$CurrPageID];
					$PagesByID[$CurrPageID]['suburls'] = $SubArraysURL[$CurrPageID];
				}
			}

			if (count($PagesByID) > 0) {
				$PagesByID['data']['Maintitle'] = $MenuTitle;
				return $PagesByID;
			} else {
				return FALSE;
			}
		}
	}