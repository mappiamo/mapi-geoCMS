<link href="widgets/box_allmeta/box.css" rel="stylesheet">
<?php
	defined('DACCESS') or die;
	
	include_once('model/getevents.php');
	
	function mwidget_box_events() {

	$lang = new M_Language;
	$language = $lang->getLanguage();

	$id = $_GET["object"];
	$AllSameContents = new getevents();
	$SameResult = $AllSameContents->getdata($id, $language);

		if ($SameResult) {

			?>

			<div class="box_container">
				<?PHP if ($language == 'en') { ?>
					<span class="box_title">Nearest events</span>
				<?PHP } else { ?>
					<span class="box_title">Eventi nelle vicinanze</span>
				<?PHP } ?>
				<div class="scrollable">

				<?PHP
				if (isset($SameResult[0]['distance'])) { ?>

					<div class="DataTable">
					<div class="DataRow">
					<?PHP if ($language == 'en') { ?>
						<div class="DataCell nowrap">Start / End date</div>
					<?PHP } else { ?>
						<div class="DataCell nowrap">Inizio / Fine</div>
					<?PHP } ?>
					<div class="DataCell"></div>
					<?PHP if ($language == 'en') { ?>
						<div class="DataCell">Event / Address / Distance</div>
					<?PHP } else { ?>
						<div class="DataCell">Evento / Indirizzo / Distanza</div>
					<?PHP } ?>
					</div>

				<?PHP } else { ?>

					<div class="DataTable">
					<div class="DataRow">
					<?PHP if ($language == 'en') { ?>
						<div class="DataCell nowrap">Start / End date</div>
					<?PHP } else { ?>
						<div class="DataCell nowrap">Inizio / Fine</div>
					<?PHP } ?>
					<div class="DataCell"></div>
					<?PHP if ($language == 'en') { ?>
						<div class="DataCell">Event / Address</div>
					<?PHP } else { ?>
						<div class="DataCell">Evento / Indirizzo</div>
					<?PHP } ?>
					</div>

				<?PHP
					usort($SameResult, "title_sort");
					}

				foreach ($SameResult as $OneContent) if ((strlen($OneContent['title']) > 0) && ($OneContent['id'] != $id)) {
					if (isset($OneContent['distance'])) { ?>

						<div class="DataRow">
							<div class="DataCell nocap nowrap"><?PHP echo date("d/m/Y", strtotime($OneContent['start'])); ?>
							<?PHP if (date("d/m/Y", strtotime($OneContent['end'])) != date("d/m/Y", strtotime($OneContent['start']))) { ?>
							<br><?PHP echo date("d/m/Y", strtotime($OneContent['end'])); } ?></div>
							<div class="DataCell"><img src="templates/gal2/images/menuicons/<?PHP echo $OneContent['icondata']; ?>"></div>
							<div class="DataCell value"><a href="index.php?module=content&object=<?PHP echo $OneContent['id']; ?>" title="Distance from the selected marker: <?PHP echo round($OneContent['distance'], 0); ?> m."><?PHP echo $OneContent['title']; ?></a>
							<div class="cell_address"><?PHP echo $OneContent['address']; ?> (<?PHP echo round($OneContent['distance'], 0); ?> m)</div></div>
						</div>

					<?PHP } else { ?>

						<div class="DataRow">
							<div class="DataCell nocap nowrap"><?PHP echo date("d/m/Y", strtotime($OneContent['start'])); ?>
							<?PHP if (date("d/m/Y", strtotime($OneContent['end'])) != date("d/m/Y", strtotime($OneContent['start']))) { ?>
							<br><?PHP echo date("d/m/Y", strtotime($OneContent['end'])); } ?></div>
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