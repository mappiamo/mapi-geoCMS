<link href="widgets/box_allmeta/box.css" rel="stylesheet">
<?php
	defined('DACCESS') or die;

	include_once('model/getdistance.php');
	
	function mwidget_box_distance() {

		$lang = new M_Language;
		$language = $lang->getLanguage();

		$id = $_GET["object"];
		$AllSameContents = new getdistance();
		$SameResult = $AllSameContents->getdata($id, $language);

		function title_sort($a, $b) {
			return strcmp($a['title'], $b['title']);
		}

		if ($SameResult) {
			?>

			<div class="box_container">
				<?PHP if ($language == 'en') { ?>
					<span class="box_title">Related Point of interest</span>
				<?PHP } else { ?>
					<span class="box_title">Punti di interesse correlati</span>
				<?PHP } ?>
				<div class="scrollable">

				<?PHP if (isset($SameResult[0]['distance'])) { ?>

					<div class="DataTable">
					<div class="DataRow">
						<?PHP if ($language == 'en') { ?>
							<div class="DataCell nowrap">Distance from:</div>
						<?PHP } else { ?>
							<div class="DataCell nowrap">Vicino a:</div>
						<?PHP } ?>
					<div class="DataCell"></div>
					<div class="DataCell"><?PHP echo $SameResult[0]['selected_title']; ?></div>
					</div>

				<?PHP } else {
					usort($SameResult, "title_sort");
					?>
					<div class="DataTable">
				<?PHP }

				foreach ($SameResult as $OneContent) if ((strlen($OneContent['title']) > 0) && ($OneContent['id'] != $id)) {
					if (isset($OneContent['distance'])) { ?>

						<div class="DataRow">
							<div class="DataCell name nocap"><?PHP echo round($OneContent['distance'], 0); ?>&nbsp;m</div>
							<div class="DataCell"><img src="templates/gal2/images/menuicons/<?PHP echo $OneContent['icondata']; ?>"></div>
							<div class="DataCell value"><a href="index.php?module=content&object=<?PHP echo $OneContent['id']; ?>" title="Distance from the selected marker: <?PHP echo round($OneContent['distance'], 0); ?> m."><?PHP echo $OneContent['title']; ?></a>
							<div class="cell_address"><?PHP echo $OneContent['address']; ?></div></div>
						</div>

					<?PHP } else { ?>

						<div class="DataRow">
							<div class="DataCell"><img src="templates/gal2/images/menuicons/<?PHP echo $OneContent['icondata']; ?>"></div>
							<div class="DataCell value"><a href="index.php?module=content&object=<?PHP echo $OneContent['id']; ?>"><?PHP echo $OneContent['title']; ?></a>
							<div class="cell_address"><?PHP echo $OneContent['address']; ?></div></div>
						</div>

					<?PHP }
						} ?>

				</div>
			</div>
			</div>

		<?PHP
		}
	}
?>