<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_language_switch( $id=null ) {

		?>
		<select class="languageswitch">
				<?php
				$lang = new M_Language;
				$language = $lang->getLanguage();
				?>
				<option value="hr" <?php if ( "hr" == $language ) echo 'selected="selected"'; ?>>Croatian</option>
				<option value="da" <?php if ( "da" == $language ) echo 'selected="selected"'; ?>>Danish</option>
				<option value="nl" <?php if ( "nl" == $language ) echo 'selected="selected"'; ?>>Dutch</option>
				<option value="en" <?php if ( "en" == $language ) echo 'selected="selected"'; ?>>English</option>
				<option value="fr" <?php if ( "fr" == $language ) echo 'selected="selected"'; ?>>French</option>
				<option value="de" <?php if ( "de" == $language ) echo 'selected="selected"'; ?>>German</option>
				<option value="gr" <?php if ( "gr" == $language ) echo 'selected="selected"'; ?>>Greece</option>
				<option value="hu" <?php if ( "hu" == $language ) echo 'selected="selected"'; ?>>Hungarian</option>
				<option value="it" <?php if ( "it" == $language || ! $language ) echo 'selected="selected"'; ?>>Italian</option>
				<option value="ru" <?php if ( "ru" == $language ) echo 'selected="selected"'; ?>>Russian</option>
				<option value="sr" <?php if ( "sr" == $language ) echo 'selected="selected"'; ?>>Serbian</option>
				<option value="si" <?php if ( "si" == $language ) echo 'selected="selected"'; ?>>Slovenian</option>
				<option value="sv" <?php if ( "sv" == $language ) echo 'selected="selected"'; ?>>Swedish</option>
				<option value="ar" <?php if ( "ar" == $language ) echo 'selected="selected"'; ?>>Arabian</option>
				<option value="zh" <?php if ( "zh" == $language ) echo 'selected="selected"'; ?>>Chinesse</option>
				<option value="es" <?php if ( "es" == $language ) echo 'selected="selected"'; ?>>Spanish</option>
				<option value="pt" <?php if ( "pt" == $language ) echo 'selected="selected"'; ?>>Portugese</option>
				<option value="ja" <?php if ( "ja" == $language ) echo 'selected="selected"'; ?>>Japanase</option>
				<option value="pl" <?php if ( "pl" == $language ) echo 'selected="selected"'; ?>>Polish</option>
				<option value="el" <?php if ( "el" == $language ) echo 'selected="selected"'; ?>>Greek</option>
				<option value="no" <?php if ( "no" == $language ) echo 'selected="selected"'; ?>>Norvegian</option>
				<option value="sk" <?php if ( "sk" == $language ) echo 'selected="selected"'; ?>>Slovak</option>
				<option value="ro" <?php if ( "ro" == $language ) echo 'selected="selected"'; ?>>Romanian</option>
		</select>
		
		<script>
		function setGetParameter(paramName, paramValue)
		{
				var url = window.location.href;
				if (url.indexOf(paramName + "=") >= 0)
				{
						var prefix = url.substring(0, url.indexOf(paramName));
						var suffix = url.substring(url.indexOf(paramName)).substring(url.indexOf("=") + 1);
						suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
						url = prefix + paramName + "=" + paramValue + suffix;
				}
				else
				{
						if (url.indexOf("?") < 0)
								url += "?" + paramName + "=" + paramValue;
						else
								url += "&" + paramName + "=" + paramValue;
				}
				window.location.href = url;
		}
		$(".languageswitch").on("change", function() {
				
				setGetParameter("lang",$(this).val());
		});
		</script>
		<?php
}

?>
