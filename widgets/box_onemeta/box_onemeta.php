<?php
	defined('DACCESS') or die;
	
	include_once('model/getonemeta.php');
	
	function mwidget_box_onemeta($name) {

		$id = $_GET["object"];
		$OneMeta = new getonemeta();
		$MetaResult = trim(strip_tags($OneMeta->getmetadata($id, $name)));

		if ($MetaResult) {

			$regex = '#\{([^{}]+)\}#';
			preg_match_all($regex, $MetaResult, $matches);

			if (count($matches[1]) > 0) {
				foreach ($matches[1] as $MatchKey => $SiteData) {
					list($SiteName, $SiteURL) = explode('|', $SiteData);
					$SiteURL = rtrim(trim($SiteURL), ';');
					if (strpos($SiteURL, 'http://') === FALSE) { $SiteURL = 'http://' . $SiteURL; }
					$TheLink = '<a href="' . $SiteURL . '" target="_blank">' . trim($SiteName) . '</a> ';
					$MetaResult = str_replace($matches[0][$MatchKey], $TheLink, $MetaResult);
				}
			}

			$name = str_replace('_', ' ', $name);
			echo '<p><div class="MetaTitle">' . $name . ':</div> ' . $MetaResult;
		}
	}
?>