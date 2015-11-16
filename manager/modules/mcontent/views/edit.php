<?php

	// no direct access to this file
	defined('DACCESS') or die;

?>

<div class="m-content-header">
	<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-edit"></span> <?php MPut::_title($data->title); ?>
		<span class="badge"><?php MPut::_id($data->hits); ?></span></h3>
</div>

<?php
	$crumbs = array('contents' => array('title' => 'Contents', 'link' => 'index.php?module=mcontent&task=content_list'),
									'this_content' => array('title' => $data->title));

	$licenses = mapi_list('licenses', array('status' => 'enabled'));
	$categories = mapi_list('categories', array('status' => 'enabled'));
?>

<?php MHTML::breadcrumb($crumbs); ?>

<?php MMessaging::show(); ?>

<form method="post" action="index.php?module=mcontent&task=content_edit&object=<?php MPut::_numeric($data->id); ?>">

<input type="hidden" name="content_id" id="content_id" value="<?php MPut::_id($data->id); ?>"/>
<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr(mapi_csrf_value()); ?>"/>

<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

<ul class="nav nav-pills">
	<li><a href="#content" data-toggle="tab">Content</a></li>
	<li><a href="#geo" data-toggle="tab">Geo</a></li>
	<li><a href="#meta" data-toggle="tab">Meta</a></li>
	<li><a href="#images" data-toggle="tab">Images</a></li>
</ul>

<div class="tab-content">

<div class="tab-pane" id="content">

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">

			<br/>

			<div class="input-group">
				<span class="input-group-addon">Title</span>
				<input type="text" name="content_title" class="form-control" id="content_title"
							 value="<?php MPut::_html_attr($data->title); ?>"/>
			</div>

			<br/>
			<textarea name="content_text" class="mceditor" id="content_text"><?php MPut::_text($data->text); ?></textarea>

			<br/>

			<div class="form-group">
				<blockquote>
					<p>
						<span class="badge">Created</span> <?php MPut::_html($data->created['when']); ?>
						<small>by <?php MPut::_html($data->created['by_user']); ?></small>
					</p>

					<p>
						<span class="badge">Modified</span> <?php MPut::_html($data->modified['when']); ?>
						<small>by <?php MPut::_html($data->modified['by_user']); ?></small>
					</p>
				</blockquote>
			</div>

		</div>
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">

			<br/>
			<?php if ('event' == $data->type): ?>
				<div class="panel panel-default">
					<div class="panel-heading">Event</div>
					<div class="panel-body">
						<div class="form-group">
							<label>Starting at</label>
							<input type="text" name="content_start" class="form-control input-sm" id="content_start"
										 value="<?php MPut::_html_attr($data->start); ?>">
						</div>
						<div class="form-group">
							<label>Ending at</label>
							<input type="text" name="content_end" class="form-control input-sm" id="content_end"
										 value="<?php MPut::_html_attr($data->end); ?>">
						</div>
					</div>
				</div>
			<?php endif; ?>

			<div class="panel panel-default">
				<div class="panel-heading">Categories</div>
				<div class="panel-body">

					<?php if (sizeof($data->categories) > 0): ?>
						<ul class="list-group">
							<?php foreach ($data->categories as $category): ?>
								<li class="list-group-item">
									<?php MPut::_html($category->title); ?>
									<button type="button" class="btn btn-xs btn-action"
													onclick=<?php MPut::_js('new MContent().remove_category( \''.$category->id.
																									'\' );'); ?> style="float: right
									;">Remove</button>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<select name="content_category" class="form-control input-sm" id="content_category">
						<?php if (sizeof($categories) > 0): ?>
							<?php foreach ($categories as $category): ?>
								<option value="<?php MPut::_id($category->id); ?>"><?php MPut::_html($category->title); ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>

					<br/>

					<button type="button" class="btn btn-sm" onclick="new MContent().add_category();">Add</button>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">License</div>
				<div class="panel-body">
					<div class="form-group">
						<select name="content_license" class="form-control input-sm" id="content_license">
							<?php if (sizeof($licenses) > 0): ?>
								<?php foreach ($licenses as $license): ?>
									<?php if ($data->license == $license->id): ?>
										<option value="<?php MPut::_id($license->id); ?>"
														selected="selected"><?php MPut::_html($license->title); ?></option>
									<?php else: ?>
										<option value="<?php MPut::_id($license->id); ?>"><?php MPut::_html($license->title); ?></option>
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Status</div>
				<div class="panel-body">
					<input type="checkbox" name="content_enabled" id="content_enabled" <?php if (1 == $data->enabled) {
						echo 'checked="checked"';
					} ?> value="1"/>
					<label>Enabled</label>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Language</div>
				<div class="panel-body">
					<select name="content_language" class="form-control input-sm" id="content_add_translation">
						<option value="hr" <?php if ("hr" == $data->language) {
							echo 'selected="selected"';
						} ?>>Croatian
						</option>
						<option value="da" <?php if ("da" == $data->language) {
							echo 'selected="selected"';
						} ?>>Danish
						</option>
						<option value="nl" <?php if ("nl" == $data->language) {
							echo 'selected="selected"';
						} ?>>Dutch
						</option>
						<option value="en" <?php if ("en" == $data->language) {
							echo 'selected="selected"';
						} ?>>English
						</option>
						<option value="fr" <?php if ("fr" == $data->language) {
							echo 'selected="selected"';
						} ?>>French
						</option>
						<option value="de" <?php if ("de" == $data->language) {
							echo 'selected="selected"';
						} ?>>German
						</option>
						<option value="gr" <?php if ("gr" == $data->language) {
							echo 'selected="selected"';
						} ?>>Greece
						</option>
						<option value="hu" <?php if ("hu" == $data->language) {
							echo 'selected="selected"';
						} ?>>Hungarian
						</option>
						<option value="it" <?php if ("it" == $data->language) {
							echo 'selected="selected"';
						} ?>>Italian
						</option>
						<option value="ru" <?php if ("ru" == $data->language) {
							echo 'selected="selected"';
						} ?>>Russian
						</option>
						<option value="sr" <?php if ("sr" == $data->language) {
							echo 'selected="selected"';
						} ?>>Serbian
						</option>
						<option value="si" <?php if ("si" == $data->language) {
							echo 'selected="selected"';
						} ?>>Slovenian
						</option>
						<option value="sv" <?php if ("sv" == $data->language) {
							echo 'selected="selected"';
						} ?>>Swedish
						</option>
					</select>

					<br/>

					<button type="button"
									onclick="location.href='index.php?module=mcontent&task=content_add_translation&object=<?php MPut::_numeric($data->id); ?>&language='+document.getElementById('content_add_translation').options[document.getElementById('content_add_translation').selectedIndex].value;"
									class="btn btn-sm">Add (Edit) Translation
					</button>
				</div>
			</div>

		</div>
	</div>

</div>

<div class="tab-pane" id="geo">

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">

			<br/>

			<div class="input-group">
				<span class="input-group-addon">Address</span>
				<input type="text" name="content_address" class="form-control" id="content_address"
							 value="<?php MPut::_html_attr($data->address); ?>"/>
			</div>

			<br/>

			<div class="form-group">
				<div id="mmap" style="height: 450px; width: 100%;"></div>
			</div>

			<script type="text/javascript">
				var mmap = new MMap();
				mmap.set_lat(<?php MPut::_numeric( $data->lat ); ?>);
				mmap.set_lng(<?php MPut::_numeric( $data->lng ); ?>);
				mmap.create_map('mmap');
				mmap.create_marker(true);

				mmap.update_inputs();
				mmap.address_search();

			</script>

			<?PHP $record = ORM::for_table('contents')->find_one($data->id); ?>

			<?PHP if ($record['type'] == 'route') { ?>
				<script type="text/javascript" src="../assets/js/leaflet.rm.setting.js"></script>
				<script>
					$( document ).ready( function() {
						$(".leaflet-routing-container").show();
					});
				</script>

			<?PHP } else { ?>
				<script type="text/javascript" src="../assets/js/leaflet.draw.setting.js"></script>
			<?PHP } ?>

			<?PHP

				//print_r($record); die();

				if ($record['route']) {

					?>
					<script type="text/javascript">
						SubCollection = '';

						<?PHP
						$TheGEOMData = $record['route'];
						$Geomtype_SQL = "SELECT ST_GeometryType(ST_GeomFromText('$TheGEOMData')) AS GEOMType";
						$Geomtype = ORM::for_table('contents')->raw_query($Geomtype_SQL)->find_one();

						if (strtoupper($Geomtype['GEOMType']) == 'GEOMETRYCOLLECTION') {
							$Geomnum_SQL = "SELECT ST_NumGeometries(ST_GeomFromText('$TheGEOMData')) AS GEOMNum";
							$Geomnum = ORM::for_table('contents')->raw_query($Geomnum_SQL)->find_one();
							$NumberOFGeoms = $Geomnum['GEOMNum'];

							for ($x = 1; $x <= $NumberOFGeoms; $x++) {
								$Subcollection_SQL = "SELECT ST_AsText(ST_GeometryN(p_geom, $x)) As Sub_Geom FROM (SELECT ST_GeomFromText('$TheGEOMData')  AS p_geom )  AS a";
								$Geomsub = ORM::for_table('contents')->raw_query($Subcollection_SQL)->find_one();

								?>

								GeomData = '<?PHP echo $Geomsub['Sub_Geom']; ?>';

								<?PHP if ($record['type'] == 'route') {
									$PointGeom = $Geomsub['Sub_Geom'];
									preg_match('/^([^\(]*)([\(]*)([^A-Za-z]*[^\)$])([\)]*[^,])$/', $PointGeom, $Match);
									$LanLotCoords = explode(' ', $Match[3]);
								?>

								Routearray.push(new L.LatLng('<?PHP echo $LanLotCoords[1]; ?>', '<?PHP echo $LanLotCoords[0]; ?>'));

								<?PHP } else { ?>
						 			DrawSavedData(GeomData);
								<?PHP } ?>

						<?PHP
					}
				} else {
					?>

						GeomData = '<?PHP echo $TheGEOMData; ?>';

						<?PHP if ($record['type'] == 'route') { ?>

						<?PHP } else { ?>
							DrawSavedData(GeomData);
						<?PHP } ?>

					<?PHP
					}
					?>

						<?PHP if ($record['type'] == 'route') { ?>
							routeControl.setWaypoints(Routearray);

							$(document).ready(function() {
								document.getElementById("content_route").value = '<?PHP echo $record['route']; ?>';;
							});

						<?PHP } else { ?>
							if (ObjectCount > 1) {
								GeomDATA = 'GeometryCollection(' + SubCollection.slice(0, -1) + ')';
							} else {
								GeomDATA = SubCollection.slice(0, -1);
							}

							$(document).ready(function() {
								document.getElementById("content_route").value = GeomDATA;
							});
						<?PHP } ?>

					</script>
				<?PHP
				}
			?>

		</div>
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">

			<br/>

			<div class="panel panel-default">
				<div class="panel-heading">Coords</div>
				<div class="panel-body">
					<div class="form-group">
						<label>Latitude</label>
						<input type="text" name="content_lat" class="form-control input-sm" id="content_lat"
									 value="<?php MPut::_html_attr($data->lat); ?>"/>
					</div>
					<div class="form-group">
						<label>Longitude</label>
						<input type="text" name="content_lng" class="form-control input-sm" id="content_lng"
									 value="<?php MPut::_html_attr($data->lng); ?>"/>
					</div>
				</div>
			</div>

		</div>
	</div>

</div>

<div class="tab-pane" id="meta">

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">

			<br/>

			<?php
				MTable::init($data->meta, 'content_meta');
				MTable::columns(array('id', 'name', 'value'));
				MTable::actions(array('delete' => 'new MContent().remove_meta( \'*[name]\' );'));
				MTable::show();
			?>

			<?php if (sizeof($data->meta) > 0): ?>
				<script type="text/javascript">new MContent().setup_meta_table();</script>
			<?php endif; ?>

		</div>
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">

			<br/>

			<div class="panel panel-default">
				<div class="panel-heading">Add meta</div>
				<div class="panel-body" id="meta_panel">
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="meta_name" class="form-control input-sm" id="meta_name" value=""/>
					</div>
					<div class="form-group">
						<label>Value</label>
						<input type="text" name="meta_value" class="form-control input-sm" id="meta_value" value=""/>
					</div>

					<span id="FinalError" class="FinalError" style="none"></span>

					<div class="form-group">
						<button type="button" class="btn btn-primary" name="meta_add" id="meta_add"
										onclick="new MContent().add_meta();">Add
						</button>
					</div>
				</div>
			</div>

		</div>
	</div>

</div>

<div class="tab-pane" id="images">

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">

			<br/>

			<?php
				if (is_array($data->media) && sizeof($data->media) > 0) {
					foreach ($data->media as $media) {
						$media->text = '';
						$media->text .=	'<div style="float: left; margin-top: 12px; margin-bottom: 12px;"><img class="media-object" style="width: 80px;" src="'.
						$media->url.'" alt="" /></div>';
						$media->text .= '<div style="float: left; margin-top: 12px; margin-left: 12px;">';
						$media->text .= '<a href="'.$media->url.'" target="_blank"><h4>'.$media->title.'</h4></a>';
						if (1 == $media->default_media) {
							$media->text .= '<div><code class="green">Default</code></div>';
						}
						$media->text .= '</div>';
						$media->text .= '<div style="clear: both;"></div>';
					}

					MHTML::list_group($data->media, 'title',
														array('Set as default' => 'new MContent().default_media( \'*[id]\' );',
																	'Delete' => 'new MContent().remove_media( \'*[id]\' );'));
				} else {
					?>
					<div class="panel panel-default">
						<div class="panel-heading">&nbsp;</div>
						<div class="panel-body">
							Nothing to display
						</div>
					</div>
				<?php
				}


			?>

		</div>
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">

			<br/>

			<div class="panel panel-default">
				<div class="panel-heading">Upload</div>
				<div class="panel-body">
					<div id="dropzone-images" class="dropzone">
						<div class="fallback"><input name="content_image" type="file" multiple/></div>
					</div>
					<script type="text/javascript">
						new MContent().add_media(<?php MPut::_numeric( $data->id ); ?>);
					</script>
				</div>
			</div>

		</div>
	</div>

</div>

</div>

<div class="form-group">
	<input type="hidden" name="content_route" class="form-control input-sm" id="content_route" value=""/>
</div>

<div class="btn-group" style="position: absolute;">
	<button type="button" class="btn btn-default"
					onclick="location.href='index.php?module=mcontent&task=content_delete&object=<?php MPut::_numeric($data->id); ?>';">
		Delete
	</button>
	<button type="submit" class="btn btn-primary" name="content_save" id="MSaveButton">Save</button>
</div>

</div>

</div>

</form>
