<?php
/**
 * Created by PhpStorm.
 * User: Laca
 * Date: 2015.07.18.
 * Time: 17:03
 */

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