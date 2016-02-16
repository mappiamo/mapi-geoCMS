<?php

	defined('DACCESS') or die;

	function mwidget_box_cookie() {

		if (isset($_COOKIE['accepted'])) {
			if ($_COOKIE['accepted'] == 'YES') {
				return;
			}
		}

		$lang = new M_Language;
		$language = $lang->getLanguage();

		$CookieContent = ORM::for_table('content_meta')->select_many('external_id', 'value')->where('name', 'cookie-box')->find_one();

		if ($CookieContent) {

			?>

			<div class="cookie-alert">
				<?PHP echo $CookieContent['value']; ?>
				<p>
				<a href="index.php?module=content&object=<?PHP echo $CookieContent['external_id']; ?>">Leggi tutto...</a>
				</p>
				<div class="cookie_button" id="Cookie_Button_OK">OK</div>
			</div>

			<script>

				$(document).ready(function() {
					$("#Cookie_Button_OK").click(function() {
						$(".cookie-alert").css("display", 'none');

						var pathname = 'widgets/box_cookie/ajax/';

						$.ajax({
							type: 'POST',
							url: pathname + 'check_cookie.php'
						});

					});
				});

			</script>

			<?PHP
		}
	}