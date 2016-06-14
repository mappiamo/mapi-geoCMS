<?php

	defined('DACCESS') or die;

	function mwidget_licence() {

		$CID = $_GET['object'];

		$Licence = ORM::for_table('licenses')
								 ->raw_query('SELECT licenses.title AS title, licenses.description AS description, licenses.url AS url
									FROM licenses
									INNER JOIN contents
									ON licenses.id = contents.license
									WHERE licenses.enabled = 1
									AND contents.id = ' . $CID)->find_one(); ?>

		<div class="licence_block" style="z-index: 5000">
		<?PHP if (isset($Licence['url'])) { ?>

			Content licensed under<br><a href="<?PHP echo $Licence['url']; ?>" target="_blank">
				<img src="./widgets/licence/icons/<?PHP echo strtolower($Licence['title']) . '.png'; ?>" style="width: 88px">
			</a>

		<?PHP } else { ?>
			<img src="./widgets/licence/icons/<?PHP echo strtolower($Licence['title']) . '.png'; ?>" style="width: 88px">
		<?PHP } ?>

		</div>

	<?PHP
	}