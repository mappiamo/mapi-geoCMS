<?php
	// no direct access to this file
	defined('DACCESS') or die;

	function mwidget_map($zoom = 11, $cat_id = NULL) {
		global $content;
		global $coords;
		$GeomData = NULL;

		$lang = new M_Language;
		$language = $lang->getLanguage();

		if ((MValidate::coord($coords['lat']) && MValidate::coord($coords['lng'])) && (isset($_GET['module']) && $_GET['module'] != 'event')) {

			if ((isset($_GET['object'])) && ($_GET['module'] != 'category')) {
				$ContentID = $_GET['object'];
				$content = MObject::get('content', $ContentID);
				$GeomData = $content->get_route();
				$ContentType = $content->get_type();
			}

			if ((($coords['lat'] != 0) && ($coords['lng'] != 0)) && ($GeomData == NULL)) {
				$GeomData = 'POINT(' . $coords['lng'] . ' ' . $coords['lat'] . ')';

				?>
				<div id="mmap"></div>

				<script>
					var mmap = new MMap();
					mmap.set_zoom(<?php MPut::_numeric( $zoom ); ?>);
                    mmap.set_lat(<?php echo $coords['lat'];?>);
                    mmap.set_lng(<?php echo $coords['lng'];?>);
					mmap.create_map('mmap');

					mmap.address_search();
					var mmap_control = new MMapControl(mmap);

					<?php if ( $content ) { ?>

						var GeomData = '<?PHP echo $GeomData; ?>';
						var geoj = $.geo.WKT.parse(GeomData);

						<?PHP if ($language == 'en') { ?>
							var ReadAll = 'Read full content';
						<?PHP } else { ?>
							var ReadAll = 'Leggi tutto';
						<?PHP } ?>

						var GeomPoupString = '<div class="Scroller" onClick="ScrollTo(650);"><a href="<?php echo $_SERVER["REQUEST_URI"]; ?>">' + ReadAll + '</a></div>';

						var Geoms = L.geoJson(geoj).bindPopup(GeomPoupString);
						Geoms.addTo(map);
                        console.log(Geoms);
                        //map.panTo([<?php echo $coords['lat'].",".$coords['lng'];?>]);
						//map.fitBounds(Geoms.getBounds(), { padding: [5,5], maxZoom: 11 });

					<?php } else {
						if ((count(array_filter($_GET)) == 0) || array_key_exists('lang', $_GET)) {
						?>

						/* var Circle_Layer = new L.geoJson().addTo(map);

						<?PHP if ($language == 'en') { ?>
							var FirstPopup = '<div class="FirstPopup">Please select one of <strong>Routes,</strong> or <strong>Areas,</strong> or <strong>Point of interest</strong> from the top menu.</div>';
						<?PHP } else { ?>
							var FirstPopup = '<div class="FirstPopup">Si prega di selezionare o uno degli <strong>Itinerari,</strong> o una area da <strong>Comuni,</strong> o dei luoghi dai <strong>Punti di interesse.</strong></div>';
						<?PHP } ?>

						var Circle = L.circle([<?PHP echo $coords['lat']; ?>, <?PHP echo $coords['lng']; ?>], 40000, {
							color: 'red',
							fillColor: '#f03',
							fillOpacity: 0.3
						}).addTo(Circle_Layer).bindPopup(FirstPopup, {offset: new L.Point(0, -70)}); //Circle_Layer.openPopup(); */

					<?PHP }
					} ?>

					<?php //include 'widgets/map_controlpanel/panel.php'; ?>
					<?php //if ( $cat_id ) {echo 'mmap_control.auto_on( ' . intval( $cat_id ) . ' );'; } ?>

				</script>

		<?php
			} else {
				if (isset($_GET['object'])) {
					$ContentID = $_GET['object'];
					$content = MObject::get('content', $ContentID);
					$GeomData = $content->get_route();
					?>
					<div id="mmap"></div>

						<script>
							var mmap = new MMap();
							mmap.set_zoom(<?php MPut::_numeric( $zoom ); ?>);
							mmap.create_map('mmap');

							mmap.address_search();
							var mmap_control = new MMapControl(mmap);
						</script>

						<?PHP if ($ContentType == 'route') { ?>
							<script type="text/javascript" src="./assets/js/leaflet.rm.setting.js"></script>
							<script>
								$( document ).ready( function() {
									$(".leaflet-routing-container").show();
									$(".leaflet-routing-geocoders").hide();
								});
							</script>
						<?PHP } ?>

						<script>

						<?PHP if ($ContentType == 'route') {
							$Geomtype_SQL = "SELECT ST_GeometryType(ST_GeomFromText('$GeomData')) AS GEOMType";
							$Geomtype = ORM::for_table('contents')->raw_query($Geomtype_SQL)->find_one();

							if (strtoupper($Geomtype['GEOMType']) == 'GEOMETRYCOLLECTION') {
								$Geomnum_SQL = "SELECT ST_NumGeometries(ST_GeomFromText('$GeomData')) AS GEOMNum";
								$Geomnum = ORM::for_table('contents')->raw_query($Geomnum_SQL)->find_one();
								$NumberOFGeoms = $Geomnum['GEOMNum'];

								for ($x = 1; $x <= $NumberOFGeoms; $x++) {
									$Subcollection_SQL = "SELECT ST_AsText(ST_GeometryN(p_geom, $x)) As Sub_Geom FROM (SELECT ST_GeomFromText('$GeomData')  AS p_geom )  AS a";
									$Geomsub = ORM::for_table('contents')->raw_query($Subcollection_SQL)->find_one();
									$PointGeom = $Geomsub['Sub_Geom'];
									preg_match('/^([^\(]*)([\(]*)([^A-Za-z]*[^\)$])([\)]*[^,])$/', $PointGeom, $Match);
									$LanLotCoords = explode(' ', $Match[3]);

									?>
										Routearray.push(new L.LatLng('<?PHP echo $LanLotCoords[1]; ?>', '<?PHP echo $LanLotCoords[0]; ?>'));
									<?PHP

								}

								?>
									//routeControl.setWaypoints(Routearray);
									L.Routing.control({
										waypoints: Routearray,
										draggableWaypoints: false,
										addWaypoints: false
									}).addTo(map);
								<?PHP
							}
						?>

						<?PHP } else { ?>
							var GeomData = '<?PHP echo $GeomData; ?>';
							var geoj = $.geo.WKT.parse(GeomData);

							var routecolor = "#0000ff";
							var RouteStyle = {
								"color": routecolor,
								"weight": 3,
								"opacity": 1
							};

							<?PHP if ($language == 'en') { ?>
								var ReadAll = 'Read full content';
							<?PHP } else { ?>
								var ReadAll = 'Leggi tutto';
							<?PHP } ?>

							var GeomPoupString = '<div class="Scroller" onClick="ScrollTo(650);"><a href="<?php echo $_SERVER["REQUEST_URI"]; ?>">' + ReadAll + '</a></div>';

							var Geoms = L.geoJson(geoj, { style: RouteStyle }).bindPopup(GeomPoupString);
							Geoms.addTo(map);
							map.fitBounds(Geoms.getBounds(), { padding: [5,5], maxZoom: 11 });

						<?PHP } ?>

						<?php //if ( $cat_id ) {echo 'mmap_control.auto_on( ' . intval( $cat_id ) . ' );'; } ?>

					</script>
		<?PHP }
			}
		} else { ?>
			<div id="mmap"></div>

			<script>
				var mmap = new MMap();
				mmap.set_zoom(<?php MPut::_numeric( $zoom ); ?>);
				mmap.set_lat(<?php MPut::_numeric( $coords['lat'] ); ?>);
				mmap.set_lng(<?php MPut::_numeric( $coords['lng'] ); ?>);


				mmap.create_map('mmap');

				mmap.address_search();
				var mmap_control = new MMapControl(mmap);

				var Circle_Layer = new L.geoJson().addTo(map);

				<?PHP if ($language == 'en') { ?>
				var FirstPopup = '<div class="FirstPopup">Please select one of <strong>Routes,</strong> or <strong>Areas,</strong> or <strong>Point of interest</strong> from the top menu.</div>';
				<?PHP } else { ?>
				var FirstPopup = '<div class="FirstPopup">Si prega di selezionare o uno degli <strong>Itinerari,</strong> o una area da <strong>Comuni,</strong> o dei luoghi dai <strong>Punti di interesse.</strong></div>';
				<?PHP } ?>

				var Circle = L.circle([<?PHP echo $coords['lat']; ?>, <?PHP echo $coords['lng']; ?>], 40000, {
					color: 'red',
					fillColor: '#f03',
					fillOpacity: 0.3
				}).addTo(Circle_Layer).bindPopup(FirstPopup, {offset: new L.Point(0, -70)}); //Circle_Layer.openPopup();

			</script>

		<?PHP }
	}

?>
