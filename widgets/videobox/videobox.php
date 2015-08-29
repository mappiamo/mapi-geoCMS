<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_videobox() {
	$id = $_GET["object"];

	$vidurl = ORM::for_table('content_meta')->select('value')->where('external_id', $id)->where('name', 'filmato')->find_one();

	if ($vidurl['value']) {
		parse_str(parse_url($vidurl['value'], PHP_URL_QUERY), $result_array);

		if ($result_array['v']) { ?>

			<div class="panoramabox">
				<iframe src="https://www.youtube-nocookie.com/embed/<?PHP echo $result_array['v']; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
			</div>

		<?PHP } else {
			//$url = $vidurl['value'];
			//$urlParts = explode("/", parse_url($url, PHP_URL_PATH));
			//$VimeoID = (int)$urlParts[count($urlParts)-1];

			$VimeoID = substr(parse_url($vidurl['value'], PHP_URL_PATH), 1);
			if (is_int($VimeoID)) {
			?>

			<div class="panoramabox">
				<iframe src="https://player.vimeo.com/video/<?PHP echo $VimeoID; ?>?title=0&byline=0&portrait=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			</div>

		<?PHP
			}
		}
	}
} ?>