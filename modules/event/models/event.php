<?php
/**
 * Created by PhpStorm.
 * User: Laca
 * Date: 2015.06.04.
 * Time: 12:40
 */


class MModel_Event {

	public function __construct() {

	}

	public static function GetEventTitle() {
		if (isset($_GET['pid'])) {
			$TID = $_GET['pid'];
			$PageTitle = ORM::for_table('pages')->select('title')->where('id', $TID)->find_array();
			if (isset($PageTitle[0]['title'])) {
				$PageTitle = $PageTitle[0]['title'];
			} else {
				$PageTitle = 'Title cannot be parsed...';
			}
		} else {
			$PageTitle = 'Title cannot be parsed...';
		}
		return $PageTitle;
	}

	public static function QueryURL() {

		if ($_GET['module'] == 'event') {

			if (isset($_GET['object'])) {
				$CatList = $_GET['object'];
				$CatList = ltrim($CatList, '{'); $CatList = rtrim($CatList, '}');
				if (strtolower($CatList) == 'all') {

					if (isset($_GET['address'])) {
						$TheAddress = '%' . $_GET['address'] . '%';
						$AllContents = ORM::for_table('contents')->select_many('id', 'title', 'address', 'text', 'start', 'end', 'created', 'modified', 'language', 'lat', 'lng')->where_like('address', $TheAddress)->where('enabled', 1)->where('type', 'event')->find_array();
					} else {
						$AllContents = ORM::for_table('contents')->select_many('id', 'title', 'address', 'text', 'start', 'end', 'created', 'modified', 'language', 'lat', 'lng')->where('enabled', 1)->where('type', 'event')->find_array();
					}

					foreach ($AllContents as $Content) {
						if (self::FilterContent($Content)) {
							$Events[] = self::FilterContent($Content);
						}
					}

					if (isset($Events)) {
						if (count($Events) > 0) {
							usort($Events, array('MModel_Event', "OrderContent"));
							return $Events;
						} else {
							return NULL;
						}
					} else {
						return NULL;
					}

				} elseif (strlen($CatList) > 0) {
					$CatListArray = explode(',', $CatList);
					if (is_array($CatListArray)) {

						return self::ParseContent($CatListArray);

					} else {
						return NULL;
					}
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

	public static function ParseContent($CatListArray) {

		$ContentIDI_List = NULL;
		$QueryString = NULL;
		$Events = array();

		foreach ($CatListArray as $key => $CategoryID) {

			$AllContentsID = ORM::for_table('categories')->select('title')->select('contents')->where('id', $CategoryID)->where('enabled', 1)->find_array();

			if (isset($AllContentsID[0]['contents'])) {
				$ContentIDI_List .= $AllContentsID[0]['contents'] . ';';
			}
		}

		$AllContentID = explode(';', $ContentIDI_List);
		foreach ($AllContentID as $OneCI) {
			$OneCI = ltrim($OneCI, '{'); $OneCI = rtrim($OneCI, '}');
			if (is_numeric($OneCI)) {
				$QueryString .= '`id` = ' .  $OneCI . ' OR ';
			}
		}

		$QueryString = '(' . rtrim($QueryString, ' OR ') . ')';

		if (isset($_GET['address'])) {
			$TheAddress = '%' . $_GET['address'] . '%';
			$category_contents = ORM::for_table('contents')->select_many('id', 'title', 'address', 'text', 'start', 'end', 'created', 'modified', 'language', 'lat', 'lng')->where_raw($QueryString)->where_like('address', $TheAddress)->where('enabled', 1)->where('type', 'event')->find_array();
		} else {
			$category_contents = ORM::for_table('contents')->select_many('id', 'title', 'address', 'text', 'start', 'end', 'created', 'modified', 'language', 'lat', 'lng')->where_raw($QueryString)->where('enabled', 1)->where('type', 'event')->find_array();
		}

		foreach ($category_contents as $Content) {
			if (self::FilterContent($Content)) {
				$Events[] = self::FilterContent($Content);
			}
		}

		if (count($Events) > 0) {
			usort($Events, array('MModel_Event', "OrderContent"));
			return $Events;
		} else {
			return NULL;
		}
	}

	public static function FilterBy($Content) {
		$ContentDate = array();
		if (isset($_GET['filterby'])) {
			if (strtolower($_GET['filterby']) == 'modified') {
				$ContentDate[0] = date("Y-m-d", strtotime(date($Content['modified'])));
			} elseif (strtolower($_GET['filterby']) == 'created') {
				$ContentDate[0] = date("Y-m-d", strtotime(date($Content['created'])));
			} elseif (strtolower($_GET['filterby']) == 'start') {
				$ContentDate[0] = date("Y-m-d", strtotime(date($Content['start'])));
			} elseif (strtolower($_GET['filterby']) == 'end') {
				$ContentDate[0] = date("Y-m-d", strtotime(date($Content['end'])));
			} else {
				$ContentDate[0] = date("Y-m-d", strtotime(date($Content['modified'])));
			}
		} else {
			$ContentDate[0] = date("Y-m-d", strtotime(date($Content['modified'])));
		}

		if (isset($_GET['filter'])) {
			if (strtolower($_GET['filter']) == 'inprogress') {
				$ContentDate[0] = date("Y-m-d", strtotime(date($Content['start'])));
				$ContentDate[1] = date("Y-m-d", strtotime(date($Content['end'])));
			}
		}

		return $ContentDate;
	}

	public static function FilterContent($Content) {
		$Events = NULL;

			if (isset($_GET['filter'])) {
				if ((strtolower($_GET['filter']) != 'all') || (strtolower($_GET['filter']) == 'inprogress')) {

					$ContentDate = self::FilterBy($Content);

					if (strtolower($_GET['filter']) != 'inprogress') {

						if (strtolower($_GET['filter']) == 'today') {
							$Current_day = (date("Y-m-d"));
							if ($Current_day == $ContentDate[0]) { $Events = $Content; }

						} elseif (strtolower($_GET['filter']) == 'week') {
							$Current_week = date("Y-W", strtotime(date("Y-m-d")));
							if ($Current_week == date("Y-W", strtotime($ContentDate[0]))) { $Events = $Content; }

						} elseif (strtolower($_GET['filter']) == 'month') {
							$Current_month = date("Y-m", strtotime(date("Y-m-d")));
							if ($Current_month == date("Y-m", strtotime($ContentDate[0]))) { $Events = $Content; }

						} elseif (strtolower($_GET['filter']) == 'quarter') {
							$Current_quarter = date("Y", strtotime(date("Y-m-d"))) . '-' . ceil(date('n', strtotime(date("Y-m-d")))/3);
							if ($Current_quarter == date("Y", strtotime($ContentDate[0])) . '-' . ceil(date('n', strtotime($ContentDate[0]))/3)) { $Events = $Content; }

						} elseif (strtolower($_GET['filter']) == 'year') {
							$Current_year = date("Y", strtotime(date("Y-m-d")));
							if ($Current_year == date("Y", strtotime($ContentDate[0]))) { $Events = $Content; }

						} else {
							$Events = $Content;
						}
					} else {
						$Current_day = (date("Y-m-d"));
						if (($Current_day >= $ContentDate[0]) AND ($Current_day <= $ContentDate[1])) {
							$Events = $Content;
						}
					}
				} else {
					$Events = $Content;
				}

			} else {
				if ((isset($_GET['filter_start'])) && (isset($_GET['filter_end']))) {
					$PeriodStart = date("Y-m-d", strtotime(date($_GET['filter_start'])));
					$PeriodEnd = date("Y-m-d", strtotime(date($_GET['filter_end'])));

					if ((preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $_GET['filter_start']) == 1) &&
							(preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $_GET['filter_end']) == 1)) {

						$ContentDate = self::FilterBy($Content);

						if (($ContentDate[0] >= $PeriodStart) AND ($ContentDate[0] <= $PeriodEnd)) {
							$Events = $Content;
						}
					} else {
						$Events = $Content;
					}

				} else {
					$Events = $Content;
				}
			}
			return $Events;

	}

	public static function OrderContent($a, $b)	{
		$QueryToField = array('created' => 'created',
													'modified' => 'modified',
													'start' => 'start',
													'end' => 'end',
													'title' => 'title',
													'address' => 'address');

		if (isset($_GET['sort'])) {
			$SortBy = $_GET['sort'];
			if (array_key_exists($SortBy, $QueryToField)) {
				$OrderBy = $QueryToField[$SortBy];
			} else {
				$OrderBy = 'modified';
			}
		} else {
			$OrderBy = 'modified';
		}

		if (isset($_GET['reverse_order'])) {
			if (strtolower($_GET['reverse_order']) == 'yes') {
				return strcmp(strtolower($b[$OrderBy]), strtolower($a[$OrderBy]));
			} else {
				return strcmp(strtolower($a[$OrderBy]), strtolower($b[$OrderBy]));
			}
		} else {
			return strcmp(strtolower($a[$OrderBy]), strtolower($b[$OrderBy]));
		}
	}

	public static function GetTemplateName() {
		$TemplateName = ORM::for_table('templates')->select('name')->where('manager', 0)->where('enabled', 1)->where('default_template', 1)->find_array();
		return $TemplateName[0]['name'];
	}

}