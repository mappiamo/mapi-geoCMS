<?php

	defined('DACCESS') or die;

	include_once('model/layermodels.php');

	function mwidget_leaflet_panel($Panel_names, $Panel_icons) {

		$TemplateName = new layermodels();
		$TemplateResult = $TemplateName->GetTemplateName();

		foreach ($Panel_names as $PanelName) {
			include_once('templates/' . $TemplateResult . '/' . $PanelName . '.php');
		}

		?>

		<link href="assets/css/leaflet-easybutton/easy-button.css" rel="stylesheet">
		<script type="text/javascript" src="assets/js/leaflet-easybutton/easy-button.js"></script>

		<script>
			$(document).ready(function(){

				<?PHP
				foreach ($Panel_names as $Panel) {
				  $PanelID = '#' . $Panel;
					?>
					$("<?PHP echo $PanelID; ?>").hide();
				<?PHP } ?>

				<?PHP
					foreach ($Panel_names as $key => $Panel) {
					$FunctionName = 'Marker' . $Panel;
					$PanelID = '#' . $Panel;

					?>

					L.easyButton('glyphicon glyphicon-<?PHP echo $Panel_icons[$key]; ?>', function() {
						<?PHP echo $FunctionName; ?>();
					}).addTo(map);

					function <?PHP echo $FunctionName; ?>() {
						//alert('<?PHP echo $PanelID; ?> function');

						if($('<?PHP echo $PanelID; ?>').is(':visible')) {
							$("<?PHP echo $PanelID; ?>").hide();
						} else {
							$(".PanelOnTheMAP").hide();
							$("<?PHP echo $PanelID; ?>").show();
						}
					}

				<?PHP } ?>
			});

		</script>

	<?PHP }