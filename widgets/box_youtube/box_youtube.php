<?php

	// no direct access to this file
	defined('DACCESS') or die;

	include_once('google/Google_Client.php');
	include_once('google/contrib/Google_YouTubeService.php');

	function mwidget_box_youtube($DevKey, $CHId, $MaxRes = 5) {

		$client = new Google_Client();
		$client->setDeveloperKey($DevKey);
		$channel_id = $CHId;
		$youtube = new Google_YoutubeService($client);

		try {

			$videos = $youtube->search->listSearch('id', array('channelId' => $channel_id, 'maxResults' => $MaxRes));

			?>

			<link rel="stylesheet" href="widgets/box_youtube/css_js/youtube.css" />
			<script type="text/javascript" src="widgets/box_youtube/css_js/youtube.js"></script>

			<div class="box">
				<div id="mapi_youtube">

					<a href="https://www.youtube.com/channel/<?PHP echo $CHId; ?>/videos" target="_blank"
						 title="<?PHP echo MSettings::$sitename ?> on Youtube">
						<h3 class="color">You<span>Tube</span></h3>
					</a>

					<?php if ($videos && is_array($videos['items']) && sizeof($videos['items']) > 0): ?>
						<?php $j = 1; ?>

						<?php
						foreach ($videos['items'] as $video) {
							if (isset($video['id']['videoId'])) {
								$video_id = $video['id']['videoId'];
								$playables = $youtube->videos->listVideos('snippet', array('id' => $video_id));

								if ($playables && is_array($playables['items']) && sizeof($playables['items']) > 0) {
									for ($i = 0; $i < sizeof($playables['items']); $i++) {
										if (isset($playables['items'][$i]['snippet']['thumbnails']['medium'])) {
											$video_tumbnail = $playables['items'][$i]['snippet']['thumbnails']['medium']['url'];
											$video_title = $playables['items'][$i]['snippet']['title'];
											?>
											<div id="youtube_page<?php echo $j; ?>" <?php if ($j > 1) {
												echo 'style="display: none;"';
											} ?> class="youtube_page">
												<div class="youtube_page_left" onclick="youtube_pages('prev', '<?php echo $j; ?>');">
													&nbsp;</div>
												<div class="container">
													<a href="http://www.youtube.com/watch?v=<?php echo $video_id; ?>"
														 title="<?php echo $video_title; ?>" target="_blank">
														<img src="<?php echo $video_tumbnail; ?>" alt="<?php echo $video_title; ?>"/>
													</a>
												</div>
												<div class="youtube_page_right" onclick="youtube_pages('next', '<?php echo $j; ?>');">
													&nbsp;</div>
											</div>
											<?php
											$j++;
										}
									}
								}

							}
						}

						?>
					<?php endif; ?>

				</div>
			</div>


		<?php

		} catch (Google_ServiceException $e) {
		} catch (Google_Exception $e) {
		}
	}

?>