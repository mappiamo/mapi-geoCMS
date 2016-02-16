<?php

	defined('DACCESS') or die;

	function mwidget_weather() {
		?>

		<script>
			var WeatherLayer = new Object();
			var weather = new L.WeatherIconsLayer();

			$(document).ready(function() {
				$('#Submenu').delegate('div.sub_item', 'click', function() {
					var submenu = $(this).attr("id");
					if (submenu == 'meteo') {

						if (map.hasLayer(weather)) {
							map.removeLayer(weather);
						} else {
							map.addLayer(weather);
						}

					}
				});
			});

		</script>


	<?PHP } ?>