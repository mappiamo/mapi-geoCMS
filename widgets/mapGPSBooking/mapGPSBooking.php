<?php

	defined('DACCESS') or die;

	function mwidget_mapGPSBooking() {

		global $coords;
		if (!isset($_GET["object"])) { return; }

		if ((MValidate::coord($coords['lat']) && MValidate::coord($coords['lng'])) && (($coords['lat'] != 0) && ($coords['lng'] != 0)) && (isset($_GET['module']) && $_GET['module'] == 'content')) {
			$lat = $coords['lat'];
			$lon = $coords['lng'];
			$CID = 2002;
		} else {
			return;
		}

		?>

		<input type="checkbox" name="booking" id="boking" value="booking">Found hotels

		<script>
			$(document).ready(function() {

				var pathname = 'widgets/mapGPSBooking/ajax/';

				var category = null;
				var LAT = 0;
				var LON = 0;
				var GeomData = null;
				var GeomPoupString = null;
				var geoj = null;
				var Geoms = null;
				var marker = null;
				var HotelURL = null;
				var ratstars = null;
				//var Marker_layer = new L.geoJson().addTo(map).L.MarkerClusterGroup();
				var Marker_layer = new L.MarkerClusterGroup();

				$("#boking").change(function () {

					if ($("#boking").is(':checked')) {

						$.ajax({
							type: 'POST',
							url: pathname + 'BookingParser.php',
							data: {
								CID: '<?PHP echo $CID; ?>',
								lat: '<?PHP echo $lat; ?>',
								lon: '<?PHP echo $lon; ?>'
							},
							success: function (data) {
								//alert(data); return;
								if (data.length > 0) {

									var MapData = data;
									MapData = $.parseJSON(MapData);

									$.each(MapData, function(ContentID, PlaceData) {

										if ((PlaceData['lat'] != undefined) && (PlaceData['lng'] != undefined)) {
											LAT = Number(PlaceData['lat']);
											LON = Number(PlaceData['lng']);
											GeomData = 'POINT(' + LON + ' ' + LAT + ')';

											var CustomIconOBJ = L.Icon.extend({
												options: {
													iconUrl: 'media/mapicons/bookinghotels.png',
													iconAnchor: [13, 27],
													popupAnchor: [-5, -40],
													iconSize: [32, 37]
												}
											});
											var IconOBJECT = new CustomIconOBJ();

											if (PlaceData.hasOwnProperty('ParsedURL')) {
												HotelURL = PlaceData['ParsedURL'];
											} else {
												HotelURL = PlaceData['url'];
											}

											ratstars = '';
											if (PlaceData.hasOwnProperty('rating')) {
												for (var i = 0; i < Number(PlaceData['rating']); i++) {
													ratstars += '*';
												}
											}

											GeomPoupString = '';
											GeomPoupString += '<a href="' + HotelURL + '" target="_blank">' + PlaceData["name"] + '</a> ' + ratstars;
											GeomPoupString += '<br />';
											GeomPoupString += '<small>(' + PlaceData["address"] + ', ' + PlaceData["city"] + ', ' + PlaceData["country"] + ')</small><br>';
											GeomPoupString += 'Price from: ' + PlaceData['currency'] + ' ' + PlaceData['price'] + '<br><br>';
											GeomPoupString += 'Reserve now:<br>';
											GeomPoupString += '<a href="' + HotelURL + '" target="_blank">' + '<img class="provider_logo" src="' + PlaceData["logo"] + '"></a>';

											//geoj = $.geo.WKT.parse(GeomData);
											//Geoms = L.geoJson(geoj).bindPopup(GeomPoupString);
											//Geoms.addTo(map);
											marker = L.marker([LAT, LON], {icon: IconOBJECT}).bindPopup(GeomPoupString);
											marker.addTo(Marker_layer);

											//alert(LAT + ' - ' + LON);
										}

									});
									map.addLayer(Marker_layer);
								} else {
									alert('No return data from server.');
								}

							}, error: function(request, status, error){
								alert('Ajax problem: ' + request.responseText + ' ' + status + ' ' + error);
							}

						});

					} else {
						if (map.hasLayer(Marker_layer)) { Marker_layer.clearLayers(); }
					}

				});
			});
		</script>

	<?PHP
	}