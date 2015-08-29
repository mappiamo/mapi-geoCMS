<?php
	// no direct access to this file
	defined('DACCESS') or die;

	function mwidget_map($zoom = 11, $cat_id = NULL) {
		global $content;
		global $coords;
		$GeomData = NULL;

		if (MValidate::coord($coords['lat']) && MValidate::coord($coords['lng'])) {

			$lang = new M_Language;
			$language = $lang->getLanguage();

			if (isset($_GET['object'])) {
				$ContentID = $_GET['object'];
				$content = MObject::get('content', $ContentID);
				$GeomData = $content->get_route();
			}

			if ((($coords['lat'] != 0) && ($coords['lng'] != 0)) && ($GeomData == NULL)) {
				$GeomData = 'POINT(' . $coords['lng'] . ' ' . $coords['lat'] . ')';

				?>
				<div id="mmap"></div>

				<script>
					var mmap = new MMap();
					mmap.set_zoom(<?php MPut::_numeric( $zoom ); ?>);
					mmap.create_map('mmap');

					mmap.address_search();
					var mmap_control = new MMapControl(mmap);

					<?php if ( $content ) { ?>

						var Inherited_Layer = new L.geoJson().addTo(map);
						var GeomData = '<?PHP echo $GeomData; ?>';
						var geoj = $.geo.WKT.parse(GeomData);

						<?PHP if ($language == 'en') { ?>
							var ReadAll = 'Read full content';
						<?PHP } else { ?>
							var ReadAll = 'Leggi tutto';
						<?PHP } ?>

						var GeomPoupString = '<div class="Scroller" onClick="ScrollTo(650);">' + ReadAll + '</div>';

						var Geoms = L.geoJson(geoj).bindPopup(GeomPoupString);
						Geoms.addTo(Inherited_Layer);
						map.fitBounds(Geoms.getBounds(), { padding: [0,0], maxZoom: 13 });

					<?php } else {
						if ((count(array_filter($_GET)) == 0) || array_key_exists('lang', $_GET)) {
						?>

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
					//echo $GeomData;
					//die();
					?>
					<div id="mmap"></div>

					<script>
						var mmap = new MMap();
						mmap.set_zoom(<?php MPut::_numeric( $zoom ); ?>);
						mmap.create_map('mmap');

						mmap.address_search();
						var mmap_control = new MMapControl(mmap);

						var Inherited_Layer = new L.geoJson().addTo(map);
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

						var GeomPoupString = '<div class="Scroller" onClick="ScrollTo(650);">' + ReadAll + '</div>';

						var Geoms = L.geoJson(geoj, { style: RouteStyle }).bindPopup(GeomPoupString);
						Geoms.addTo(Inherited_Layer);
						map.fitBounds(Geoms.getBounds(), { padding: [0,0], maxZoom: 13 });

						<?php //if ( $cat_id ) {echo 'mmap_control.auto_on( ' . intval( $cat_id ) . ' );'; } ?>

					</script>

		<?PHP	}
			}
		}

	}

?>
