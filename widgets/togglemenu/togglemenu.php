<?php

	defined('DACCESS') or die;

	function mwidget_togglemenu() {

		$lang = new M_Language;
		$language = $lang->getLanguage();

		?>

		<div class="Accordion" id="Accordion">
			<div class="OpenCloseAccordion"><img src="templates/gal2/images/menuicons/close.png"></div>

			<?PHP
				$TMenuPath = 'templates/gal2/togglemenu-' . $language . '.php';
				INCLUDE($TMenuPath);
			?>


		</div>

	<?PHP
	}
?>