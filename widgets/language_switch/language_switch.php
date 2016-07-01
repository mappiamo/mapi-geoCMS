<?php

	// no direct access to this file
	defined('DACCESS') or die;

	function mwidget_language_switch($id = NULL) {

		$LangNames = array(
			'ar' => 'Arabian',
			'zh' => 'Chinesse',
			'hr' => 'Croatian',
			'da' => 'Danish',
			'nl' => 'Dutch',
			'en' => 'English',

			'fr' => 'French',
			'el' => 'Greek',
			'hu' => 'Hungarian',
			'it' => 'Italian',
			'ja' => 'Japanase',
			'no' => 'Norvegian',

			'pl' => 'Polish',
			'pt' => 'Portugese',
			'ro' => 'Romanian',
			'ru' => 'Russian',
			'sr' => 'Serbian',
			'sk' => 'Slovak',

			'si' => 'Slovenian',
			'es' => 'Spanish',
			'sv' => 'Swedish'

		);

		$lang = new M_Language;
		$language = $lang->getLanguage();
		$lang_list = $lang->getValidLangList();

		if ($lang_list && is_array($lang_list) && count($lang_list) > 1) {

			echo '<select class="languageswitch">';

			foreach ($lang_list as $ValidLang) {
				$CurrentLang = strtolower($ValidLang['language']); ?>

				<option value="<?PHP echo $CurrentLang; ?>" <?php if (strtolower($CurrentLang) == strtolower($language)) { echo 'selected="selected"'; } ?>><?PHP echo $LangNames[$CurrentLang]; ?>

			<?PHP }

			echo '</select>';

		} elseif  ($lang_list && is_array($lang_list) && count($lang_list) <= 1) {

		} else {

	?>
		<select class="languageswitch">

			<?PHP
				foreach ($LangNames as $Sign => $Name) { ?>
					<option value="<?PHP echo $Sign; ?>" <?php if (strtolower($Sign) == strtolower($language)) { echo 'selected="selected"'; } ?>><?PHP echo $Name; ?>
				<?PHP } ?>

		</select>

	<?PHP } ?>

	<script>
		function setGetParameter(paramName, paramValue) {
			var url = window.location.href;
			if (url.indexOf(paramName + "=") >= 0) {
				var prefix = url.substring(0, url.indexOf(paramName));
				var suffix = url.substring(url.indexOf(paramName)).substring(url.indexOf("=") + 1);
				suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
				url = prefix + paramName + "=" + paramValue + suffix;
			}
			else {
				if (url.indexOf("?") < 0)
					url += "?" + paramName + "=" + paramValue;
				else
					url += "&" + paramName + "=" + paramValue;
			}
			window.location.href = url;
		}
		$(".languageswitch").on("change", function () {

			setGetParameter("lang", $(this).val());
		});
	</script>
<?php
	}

?>
