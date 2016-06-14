<?php

	// no direct access to this file
	defined('DACCESS') or die;

	function mwidget_box_instagram($HashTag = NULL) {

		//$hashtag = NULL;
		$id = $_GET["object"];
		$meta_hash = ORM::for_table('content_meta')->select_many('value')->where('name', 'hashtag-instagram')->where('external_id', $id)->find_one();

		if ($meta_hash) { $HashTag = $meta_hash['value']; }

		global $coords;
		$lat = $coords['lat'];
		$lng = $coords['lng'];

		$response = mapi_insta_get($HashTag, $lat, $lng);

		?>

		<link rel="stylesheet" href="widgets/box_instagram/css_js/instagram.css"/>
		<script type="text/javascript" src="widgets/box_instagram/css_js/instagram.js"></script>

		<div class="box">
			<div id="mapi_insta">
				<a href="http://instagram.com/" target="_blank" title="<?PHP echo MSettings::$sitename ?> on Instagram">
					<h3 class="color"><?PHP echo MSettings::$sitename ?> on Insta<span>gram</span></h3>
				</a>

				<?php if ($response && $items = json_decode($response)->data): ?>

					<?php $i = 1;
					$j = 1; ?>

					<div class="insta_page" id="insta_page<?php echo $j; ?>">
						<div class="insta_page_left" onclick="insta_pages('prev', '<?php echo $j; ?>');">&nbsp;</div>
						<div class="container">

							<?php for ($k = 0; $k < sizeof($items); $k++): ?>
								<?php $thumb = $items[$k]->images->thumbnail->url;
								$url = $items[$k]->link; ?>

								<a href="<?php echo $url; ?>" target="_blank">
									<img border="0" alt="" src="<?php echo $thumb; ?>"/>
								</a>

								<?php
								if (isset($items[$k + 1])) {
									if ($i == 6) {
										echo '<div class="insta_page_right" onclick="insta_pages(\'next\', \''.$j.'\');">&nbsp;</div>';
										echo '</div>';
										echo '</div>';
										$j++;
										echo '<div class="insta_page" id="insta_page'.$j.'" style="display: none;">';
										echo '<div class="insta_page_left" onclick="insta_pages(\'prev\', \''.$j.'\');">&nbsp;</div>';
										echo '<div class="container">';
										$i = 0;
									}
									$i++;
								} elseif ($i == 6) {
									echo '<div class="insta_page_right" onclick="insta_pages(\'next\', \''.$j.'\');">&nbsp;</div>';
									echo '</div>';
									echo '</div>';
								}
								?>

							<?php endfor; ?>

						</div>
						<div class="insta_page_right" onclick="insta_pages('next', '<?php echo $j; ?>');">&nbsp;</div>
					</div>

				<?php endif; ?>

			</div>
		</div>

		</div>
		</div>

	<?php
	}

	function mapi_insta_get($hashtag, $lat, $lng) {
		$insta_client = '2a6b9350a90d461d826bd6db7c2fd0ed';

		$url = NULL;

		if ($hashtag) {
			$url = "https://api.instagram.com/v1/tags/".$hashtag."/media/recent?client_id=".$insta_client;
		} else {
			$url = "https://api.instagram.com/v1/media/search?lat=".$lat."&lng=".$lng."&client_id=".$insta_client;
		}

		if (function_exists('curl_init')) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$output = curl_exec($ch);
			echo curl_error($ch);
			curl_close($ch);
			return $output;
		} else {
			return file_get_contents($url);
		}
	}

?>