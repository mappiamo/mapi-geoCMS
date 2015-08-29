<?php
	defined('DACCESS') or die;
	
	include_once('model/getallmeta.php');
	
	function mwidget_box_allmeta() {

	$id = $_GET["object"];
	$AllMeta = new getallmeta();
	$MetaResult = $AllMeta->getmetadata($id);

		if ($MetaResult) {
			$DisabledMeta = array('vincoli', 'parent_id', 'route-color', 'creazione', 'modifica', 'utilizzo_attuale', 'notizie_storiche', 'epoca', 'bibliografia', 'bibliografia_fonti', 'x', 'y', 'tipologia', 'categoria', 'tipo_itine', 'icon-file');
			?>

			<div class="box_container">
				<span class="box_title">Info</span>
				<div class="scrollable">
					<div class="DataTable">

					<?PHP
					foreach ($MetaResult as $OneMeta) if ((strlen($OneMeta['value']) > 0) && (!in_array($OneMeta['name'], $DisabledMeta))) {
						$TheName = str_replace('_', ' ', $OneMeta['name']);
						$TheVal = trim(strip_tags($OneMeta['value']));

						$regex = '#\{([^{}]+)\}#';
						preg_match_all($regex, $TheVal, $matches);

						if (count($matches[1]) > 0) {
							//print_r($matches[1]); die();
							$TheVal = '';
							foreach ($matches[1] as $SiteData) {
								list($SiteName, $SiteURL) = explode('|', $SiteData);
								$SiteURL = rtrim(trim($SiteURL), ';');
								if (strpos($SiteURL, 'http://') === FALSE) { $SiteURL = 'http://' . $SiteURL; }
								$TheVal .= '<a href="' . $SiteURL . '" target="_blank">' . trim($SiteName) . '</a>; ';
							}
							$TheVal = rtrim($TheVal, '; ');
						}

						if ($TheName == 'roadbook') {
							$TheVal = '<a href="' . $TheVal . '" target="_blank">' . $TheVal . '</a>';
						}

						?>

						<div class="DataRow">
							<div class="DataCell name"><?PHP echo $TheName; ?>:</div>
							<div class="DataCell value"><?PHP echo $TheVal; ?></div>
						</div>

					<?PHP
					}
					?>

					</div>
				</div>
			</div>

		<?PHP
		}
	}
?>