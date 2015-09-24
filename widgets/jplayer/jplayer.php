<?php
/**
 * Created by PhpStorm.
 * User: Laca
 * Date: 2015.09.12.
 * Time: 12:48
 */

	defined('DACCESS') or die;

	function mwidget_jplayer() {

		$lang = new M_Language;
		$language = $lang->getLanguage();
		$id = $_GET["object"];
		$ContentLang = ORM::for_table('contents')->select_many('language', 'parent')->where('id', $id)->find_one();

		if ($ContentLang['language'] != $language) {
			if ($ContentLang['parent']) {
				$id = $ContentLang['parent'];
			} else {
				$NewID = ORM::for_table('contents')->select_many('id')->where('parent', $id)->find_one();
				if ($NewID['id']) {
					$id = $NewID['id'];
				}
			}
		}

		$audurl = ORM::for_table('content_meta')->select('value')->where('external_id', $id)->where('name', 'audio')->find_one();
		if ($audurl['value']) {

		?>

		<script>

			//<![CDATA[
			$(document).ready(function(){

				$("#jquery_jplayer_1").jPlayer({
					ready: function (event) {
						$(this).jPlayer("setMedia", {
							title: "Audio content",
							m4a: "<?PHP echo $audurl['value']; ?>"
						});
					},
					swfPath: "../../dist/jplayer",
					supplied: "m4a, oga",
					wmode: "window",
					useStateClassSkin: true,
					autoBlur: false,
					smoothPlayBar: true,
					keyEnabled: true,
					remainingDuration: true,
					toggleDuration: true
				});
			});
			//]]>
		</script><br><br>

		<div id="jquery_jplayer_1" class="jp-jplayer"></div>

		<div id="jp_container_1" class="jp-audio" role="application" aria-label="media player">
			<div class="jp-type-single">
				<div class="jp-gui jp-interface">
					<div class="jp-controls">
						<button class="jp-play" role="button" tabindex="0">play</button>
						<button class="jp-stop" role="button" tabindex="0">stop</button>
					</div>
					<div class="jp-progress">
						<div class="jp-seek-bar">
							<div class="jp-play-bar"></div>
						</div>
					</div>
					<div class="jp-volume-controls">
						<button class="jp-mute" role="button" tabindex="0">mute</button>
						<button class="jp-volume-max" role="button" tabindex="0">max volume</button>
						<div class="jp-volume-bar">
							<div class="jp-volume-bar-value"></div>
						</div>
					</div>
					<div class="jp-time-holder">
						<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
						<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
						<div class="jp-toggles">
							<button class="jp-repeat" role="button" tabindex="0">repeat</button>
						</div>
					</div>
				</div>
				<div class="jp-details">
					<div class="jp-title" aria-label="title">&nbsp;</div>
				</div>
				<div class="jp-no-solution">
					<span>Update Required</span>
					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
				</div>
			</div>
		</div><br>

		<?PHP
		}
	}
?>