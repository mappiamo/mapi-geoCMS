<?php

	// no direct access to this file
	defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
	<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-cog"></span> SHP -> GeoJson Importer</h3>
</div>

<?php
	$crumbs = array(
	'mgeojsonimport'	=> array( 'title' => 'SHP -> GeoJson Importer' )
	);

	//$groups = mapi_list( 'user_groups' );
?>

<?php MHTML::breadcrumb( $crumbs ); ?>

<?php MMessaging::show(); ?>

<form method="post" enctype="multipart/form-data">

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
			<br />
			<div class="input-group">
				<span class="input-group-addon">.geojson file</span>
				<input type="file" required name="geojson_file" class="form-control" id="geojson_file" value="">
			</div>
			<div class="input-group">
				<span class="input-group-addon">Zone shift:</span>
				<input type="text" name="zone_shift" class="form-control" id="zone_shift" value="32N">
			</div>
			<br />
			<div class="input-group">
				<span class="input-group-addon">.ini file</span>
				<input type="file" required name="ini_file" class="form-control" id="ini_file" value="">
			</div>
			<br />
			<div class="form-group">
				<label>Select category:</label>
				<select name="category_name" required id="category_name" class="form-control input-sm">
					<option value="" selected>Select category...</option>
					<?PHP foreach ($data as $OneCat) { ?>
						<option value="<?PHP echo $OneCat['name']; ?>"><?PHP echo $OneCat['title']; ?></option>
					<?PHP	} ?>
				</select>
			</div>
			<div class="btn-group">
				<button type="submit" class="btn btn-primary" name="import">Import</button>
			</div>
		</div>
	</div>

</form>