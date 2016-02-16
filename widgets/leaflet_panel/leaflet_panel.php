<?php

	defined('DACCESS') or die;

	include_once('model/layermodels.php');

	function mwidget_leaflet_panel() {

		$TemplateName = new layermodels();
		$TemplateResult = $TemplateName->GetTemplateName();

		include_once('templates/' . $TemplateResult . '/address_search.php');
		include_once('templates/' . $TemplateResult . '/category_panel.php');
		include_once('templates/' . $TemplateResult . '/classified_panel.php');
		include_once('templates/' . $TemplateResult . '/pages_panel.php');

		?>

		<link href="assets/css/leaflet-easybutton/easy-button.css" rel="stylesheet">
		<script type="text/javascript" src="assets/js/leaflet-easybutton/easy-button.js"></script>

		<script>
			$(document).ready(function(){
				$("#SearchBox").hide();
				$("#CategoryBox").hide();
				$("#ClassifiedBox").hide();
				$("#PagesBox").hide();

				L.easyButton('glyphicon glyphicon-search', function() {
					MarkerSearch();
				}).addTo(map);

				L.easyButton('glyphicon glyphicon-wrench', function() {
					MarkerPages();
				}).addTo(map);

				L.easyButton('glyphicon glyphicon-refresh', function() {
					MarkerAds();
				}).addTo(map);

				L.easyButton('glyphicon glyphicon-home', function() {
					MarkerCats();
				}).addTo(map);
			});

			function MarkerSearch() {
				//alert('search function');
				if($('#SearchBox').is(':visible')) {
					$("#SearchBox").hide();
				} else {
					$("#SearchBox").show();
					$("#CategoryBox").hide();
					$("#ClassifiedBox").hide();
					$("#PagesBox").hide();
				}
			}

			function MarkerPages() {
				if($('#CategoryBox').is(':visible')) {
					$("#CategoryBox").hide();
				} else {
					$("#CategoryBox").show();
					$("#SearchBox").hide();
					$("#ClassifiedBox").hide();
					$("#PagesBox").hide();
				}
			}

			function MarkerAds() {
				if($('#ClassifiedBox').is(':visible')) {
					$("#ClassifiedBox").hide();
				} else {
					$("#ClassifiedBox").show();
					$("#SearchBox").hide();
					$("#CategoryBox").hide();
					$("#PagesBox").hide();
				}
			}

			function MarkerCats() {
				if($('#PagesBox').is(':visible')) {
					$("#PagesBox").hide();
				} else {
					$("#PagesBox").show();
					$("#SearchBox").hide();
					$("#CategoryBox").hide();
					$("#ClassifiedBox").hide();
				}
			}
		</script>

	<?PHP }