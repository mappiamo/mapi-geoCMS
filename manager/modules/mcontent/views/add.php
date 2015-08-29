<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-plus"></span> Add new content</h3>
</div>

<?php 
		$crumbs = array(
				'contents'	=> array( 'title' => 'Contents', 'link' => 'index.php?module=mcontent&task=content_list' ),
				'content_add' => array( 'title' => 'Add new content' )
		);

		$licenses = mapi_list( 'licenses', array( 'status' => 'enabled' ) );
		$SysConf = new MSettings();
		if (isset($SysConf::$location)) {
			$DefaultLoc = $SysConf::$location;
		} else {
			$DefaultLoc = $data->address;
		}
?>

<?php MHTML::breadcrumb( $crumbs ); ?>

<?php MMessaging::show(); ?>

<form method="post">

	<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr( mapi_csrf_value() ); ?>" />
	<input type="hidden" name="content_type" id="content_type" value="post" />

	<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">

									<br />
									<div class="input-group">
											<span class="input-group-addon">Address</span>
											<input type="text" name="content_address" class="form-control" id="content_address" placeholder="Search for and address first" value="<?php MPut::_html_attr( $DefaultLoc ); ?>" />
									</div>

									<br />
									<div class="form-group">
											<div id="mmap" style="height: 450px; width: 100%;"></div>
									</div>

									<script type="text/javascript">
											<?php global $coords; ?>

											var mmap = new MMap();
											mmap.set_lat( <?php MPut::_numeric( $coords['lat'] ) ?> );
											mmap.set_lng( <?php MPut::_numeric( $coords['lng'] ) ?> );
											mmap.create_map( 'mmap' );
											mmap.create_marker( true );

 										  mmap.update_inputs();
										 	mmap.address_search();

											var draw_layer = L.featureGroup().addTo(map);
											map.addControl(new L.Control.Draw({
												draw: {
													polygon: {
														shapeOptions: {
															color: 'purple'
														},
														allowIntersection: false,
														drawError: {
															color: 'orange',
															timeout: 1000
														},
														showArea: true,
														metric: false,
														repeatMode: true
													},
													polyline: {
														shapeOptions: {
															color: 'red'
														},
														showArea: true,
														metric: false,
														repeatMode: true
													},
													rect: {
														shapeOptions: {
															color: 'green'
														},
														showArea: true,
														metric: false,
														repeatMode: true
													},
													/* circle: {
														shapeOptions: {
															color: 'steelblue'
														},
														showArea: true,
														metric: false,
														repeatMode: true
													}, */
													circle : false
												},
												edit: {
													featureGroup: draw_layer
												}
											}));

											var geojson_ed = null;
											var wkt_ed = null;
											var circle_radius = null;
											var shapes = {};
											var AddedID = null;
											var GeomDATA = null;
											var SubCollection = null;
											var ObjectCount = 0;

											map.on('draw:created', function(event) {
												var layer = event.layer;
												draw_layer.addLayer(layer);

												var geojson = event.layer.toGeoJSON();
												var wkt = Terraformer.WKT.convert(geojson.geometry);

												if (layer instanceof L.Circle) {
													circle_radius = layer.getRadius();
													wkt = wkt + ' | radius: ' + circle_radius;
												}

												AddedID = layer._leaflet_id;
												shapes[AddedID] = wkt;
												SubCollection = '';
												ObjectCount = 0;
												$.each (shapes, function(shindex, shname) {
													ObjectCount++;
													SubCollection = SubCollection + shname + ',';
													//alert(shindex + '->' + shname);
												});
												if (ObjectCount > 1) {
													GeomDATA = 'GeometryCollection(' + SubCollection.slice(0, -1) + ')';
												} else {
													GeomDATA = SubCollection.slice(0, -1);
												}
												//alert(GeomDATA);
												document.getElementById("content_route").value = GeomDATA;
											});

											map.on('draw:edited', function (event) {

												var layers = event.layers;

												layers.eachLayer(function (layer) {
													if (layer instanceof L.Circle) {
														geojson_ed = layer.toGeoJSON();
														circle_radius = layer.getRadius();
														wkt_ed = Terraformer.WKT.convert(geojson_ed.geometry) + ' | radius: ' + circle_radius;
														AddedID = layer._leaflet_id;
														shapes[AddedID] = wkt_ed;
														//alert(wkt_ed);
													}

													if (layer instanceof L.Polyline) {
														//shapes.push(layer.getLatLngs());
														geojson_ed = layer.toGeoJSON();
														wkt_ed = Terraformer.WKT.convert(geojson_ed.geometry);
														AddedID = layer._leaflet_id;
														shapes[AddedID] = wkt_ed;
														//alert(wkt_ed);
													}

													if (layer instanceof L.Marker) {
														geojson_ed = layer.toGeoJSON();
														wkt_ed = Terraformer.WKT.convert(geojson_ed.geometry);
														AddedID = layer._leaflet_id;
														shapes[AddedID] = wkt_ed;
														//alert(wkt_ed);
													}
												});
												SubCollection = '';
												ObjectCount = 0;
												$.each (shapes, function(shindex, shname) {
													ObjectCount++;
													SubCollection = SubCollection + shname + ',';
													//alert(shindex + '->' + shname);
												});
												if (ObjectCount > 1) {
													GeomDATA = 'GeometryCollection(' + SubCollection.slice(0, -1) + ')';
												} else {
													GeomDATA = SubCollection.slice(0, -1);
												}
												//alert(GeomDATA);
												document.getElementById("content_route").value = GeomDATA;
											});

											map.on('draw:deleted', function (event) {
												var layers = event.layers;
												layers.eachLayer(function (layer) {
													var AddedID = layer._leaflet_id;
													delete shapes[AddedID];
													//alert(AddedID);
												});
												SubCollection = '';
												ObjectCount = 0;
												$.each (shapes, function(shindex, shname) {
													ObjectCount++;
													SubCollection = SubCollection + shname + ',';
													//alert(shindex + '->' + shname);
												});
												if (ObjectCount > 1) {
													GeomDATA = 'GeometryCollection(' + SubCollection.slice(0, -1) + ')';
												} else {
													GeomDATA = SubCollection.slice(0, -1);
												}
												//alert(GeomDATA);
												document.getElementById("content_route").value = GeomDATA;
											});

									</script>

							</div>
							<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">

									<br />
									<ul class="nav nav-pills">
											<li><a href="#post" data-toggle="tab">Post</a></li>
											<li><a href="#place" data-toggle="tab">Place</a></li>
											<li><a href="#event" data-toggle="tab">Event</a></li>
									</ul>
									<br />

									<div class="tab-content">

											<div class="tab-pane" id="post">
													<div class="panel panel-default">
															<div class="panel-heading">New post</div>
															<div class="panel-body">
																	<div class="form-group">
																			<label>Title</label>
																			<input type="text" name="post_title" class="form-control input-sm" id="post_title" value="<?php MPut::_html_attr( $data->title ); ?>">
																	</div>
																	
																	<div class="form-group">
																			<label>Lincense</label>
																			<select name="post_license" class="form-control input-sm" id="post_license">
																					<?php if ( sizeof( $licenses ) > 0 ): ?>
																							<?php foreach ( $licenses as $license ): ?>
																									<?php if ( $data->license == $license->id ): ?>
																											<option value="<?php MPut::_id( $license->id ); ?>" selected="selected"><?php MPut::_html( $license->title ); ?></option>
																									<?php else: ?>
																											<option value="<?php MPut::_id( $license->id ); ?>"><?php MPut::_html( $license->title ); ?></option>
																									<?php endif; ?>
																							<?php endforeach; ?>
																					<?php endif; ?>
																			</select>
																	</div>
															</div>
													</div>
											</div>

											<div class="tab-pane" id="place">
													<div class="panel panel-default">
															<div class="panel-heading">New place</div>
															<div class="panel-body">
																	<div class="form-group">
																			<label>Title</label>
																			<input type="text" name="place_title" class="form-control input-sm" id="place_title" value="<?php MPut::_html_attr( $data->title ); ?>">
																	</div>
																	
																	<div class="form-group">
																			<label>Lincense</label>
																			<select name="place_license" class="form-control input-sm" id="place_license">
																					<?php if ( sizeof( $licenses ) > 0 ): ?>
																							<?php foreach ( $licenses as $license ): ?>
																									<?php if ( $data->license == $license->id ): ?>
																											<option value="<?php MPut::_id( $license->id ); ?>" selected="selected"><?php MPut::_html( $license->title ); ?></option>
																									<?php else: ?>
																											<option value="<?php MPut::_id( $license->id ); ?>"><?php MPut::_html( $license->title ); ?></option>
																									<?php endif; ?>
																							<?php endforeach; ?>
																					<?php endif; ?>
																			</select>
																	</div>
															</div>
													</div>
											</div>

											<div class="tab-pane" id="event">
													<div class="panel panel-default">
															<div class="panel-heading">New event</div>
															<div class="panel-body">
																	<div class="form-group">
																			<label>Title</label>
																			<input type="text" name="event_title" class="form-control input-sm" id="event_title" value="<?php MPut::_html_attr( $data->title ); ?>">
																	</div>

																	<div class="form-group">
																			<label>Starting at</label>
																			<input type="text" name="event_start" class="form-control input-sm" id="content_start" value="<?php MPut::_html_attr( $data->start ); ?>">
																	</div>
																	
																	<div class="form-group">
																			<label>Ending at</label>
																			<input type="text" name="event_end" class="form-control input-sm" id="content_end" value="<?php MPut::_html_attr( $data->end ); ?>">
																	</div>

																	<div class="form-group">
																			<label>Lincense</label>
																			<select name="event_license" class="form-control input-sm" id="event_license">
																					<?php if ( sizeof( $licenses ) > 0 ): ?>
																							<?php foreach ( $licenses as $license ): ?>
																									<?php if ( $data->license == $license->id ): ?>
																											<option value="<?php MPut::_id( $license->id ); ?>" selected="selected"><?php MPut::_html( $license->title ); ?></option>
																									<?php else: ?>
																											<option value="<?php MPut::_id( $license->id ); ?>"><?php MPut::_html( $license->title ); ?></option>
																									<?php endif; ?>
																							<?php endforeach; ?>
																					<?php endif; ?>
																			</select>
																	</div>
															</div>
													</div>
											</div>

									</div>

									<div class="panel panel-default">
											<div class="panel-heading">Coords</div>
											<div class="panel-body">
													<div class="form-group">
															<label>Latitude</label>
															<input type="text" name="content_lat" class="form-control input-sm" id="content_lat" value="<?php MPut::_html_attr( $coords['lat'] ); ?>" />
													</div>
													<div class="form-group">
															<label>Longitude</label>
															<input type="text" name="content_lng" class="form-control input-sm" id="content_lng" value="<?php MPut::_html_attr( $coords['lng'] ); ?>" />
													</div>
											</div>
									</div>

									<div class="form-group">
										<input type="hidden" name="content_route" class="form-control input-sm" id="content_route" value="" />
									</div>

									<div class="btn-group">
											<button type="submit" id="btn_add" class="btn btn-primary" name="content_add" onclick="new MContent().type_select();">Add</button>
									</div>

							</div>
					</div>

			</div>
	</div>

</form>