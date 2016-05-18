<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-list"></span> Contents list <small>( <a href="index.php?module=mcontent&task=content_add">Add new</a> )</small></h3>
</div>

<?php 
		$crumbs = array(
				'contents'	=> array( 'title' => 'Contents' )
		);
?>

<?php MHTML::breadcrumb( $crumbs ); ?>

<?php MMessaging::show(); ?>

		<hr><h3>You have <u>&Sigma; <?PHP echo $data['count']; ?></u> rows on content table.<br>
		With current search criteria you have <u>&Sigma; <?PHP echo $data['search_count']; ?></u> data.</h3>

		<form action="" method="POST" class="form-inline" id="contentlist_form">

			<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr( mapi_csrf_value() ); ?>" />
			<input type="hidden" name="content_type" id="content_type" value="post" />

			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-filter" title="Select type filter"></span></span>
				<select name="type" class="form-control">
					<option value="">Type...</option>

					<?PHP foreach ($data['TypeList'] as $OneType) {

						if (isset($_POST['type']) && $_POST['type'] == $OneType['type']) {
							$SelectedString = ' SELECTED';
						} else {
							$SelectedString = NULL;
						}

						?>

						<option value="<?PHP echo $OneType['type']; ?>"<?PHP echo $SelectedString; ?>><?PHP echo $OneType['type']; ?></option>

					<?PHP } ?>

				</select>
			</div>

			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-search" title="Search by this keyword on title, text, and address"></span></span>
				<input type="text" name="keyword" id="inputKeyword" placeholder="Keyword" class="form-control" <?PHP if (isset($_POST['keyword'])) { echo 'value="' . $_POST['keyword'] . '"'; } ?>>
			</div>

			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-map-marker" title="Define location for search"></span></span>
				<input type="text" name="location" id="inputAddress" placeholder="Location" class="form-control" <?PHP if (isset($_POST['location'])) { echo 'value="' . $_POST['location'] . '"'; } ?>>
			</div>

			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-dashboard" title="Define radius from location as distance"></span></span>
				<select name="radius" class="form-control">
					<option value="1000"<?PHP if (isset($_POST['radius']) && $_POST['radius'] == 1000) { echo ' selected'; } ?>>1 km</option>
					<option value="2000"<?PHP if (isset($_POST['radius']) && $_POST['radius'] == 2000) { echo ' selected'; } ?>>2 km</option>
					<option value="5000"<?PHP if (isset($_POST['radius']) && $_POST['radius'] == 5000) { echo ' selected'; } ?>>5 km</option>
					<option value="10000"<?PHP if (isset($_POST['radius']) && $_POST['radius'] == 10000) { echo ' selected'; } ?>>10 km</option>
					<option value="20000"<?PHP if (isset($_POST['radius']) && $_POST['radius'] == 20000) { echo ' selected'; } ?>>20 km</option>
					<option value="50000"<?PHP if (isset($_POST['radius']) && $_POST['radius'] == 50000) { echo ' selected'; } ?>>50 km</option>
					<option value="100000"<?PHP if (isset($_POST['radius']) && $_POST['radius'] == 100000) { echo ' selected'; } ?>>100 km</option>
				</select>
			</div>

			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-globe" title="Select language filter"></span></span>
				<select name="language" class="form-control">
					<option value="">Language...</option>

					<?PHP foreach ($data['LangList'] as $OneLang) {

						if (isset($_POST['language']) && $_POST['language'] == $OneLang['language']) {
							$SelectedString = ' SELECTED';
						} else {
							$SelectedString = NULL;
						}

					?>

					<option value="<?PHP echo $OneLang['language']; ?>"<?PHP echo $SelectedString; ?>><?PHP echo $OneLang['language']; ?></option>

					<?PHP } ?>

				</select>
			</div>

			<input type="hidden" id="content_listfilter_lat" name="lat" value="">
			<input type="hidden" id="content_listfilter_lon" name="lon" value="">

			<h3>Result limited to

				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-list" title="Define the limit of list"></span></span>
					<input type="number" min="10" step="10" max="2000" required name="limit_value" id="limit_value" placeholder="Limit" class="form-control" <?PHP if (isset($_POST['limit_value'])) { echo 'value=' . $_POST['limit_value'] . ''; } else { echo 'value=250'; } ?> style="width: 80px;">
				</div>

				rows, the list start from row:

			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-pushpin" title="Define the first row from the result list"></span></span>
				<input type="number" min="1" step="1" max="<?PHP echo (($data['count']) - 10); ?>" required name="limit_start" id="limit_start" placeholder="Start" class="form-control" <?PHP if (isset($_POST['limit_start'])) { echo 'value=' . $_POST['limit_start'] . ''; } else { echo 'value=1'; } ?> style="width: 80px;">
			</div>

			<button type="submit" id="content_table_search" class="btn btn-primary">Show data</button></h3>

		</form><hr>

<?php	
		MTable::init($data['table'], 'content_list');
		MTable::columns( array( 'id', 'title', 'type', 'hits', 'address', 'modified', 'language', 'enabled' ) );
		MTable::links( array( 'title' => 'index.php?module=mcontent&task=content_edit&object=*[id]' ) );
		MTable::badges( array( 'hits' ) );
		MTable::binaries( array( 'enabled' ) );
		MTable::show();
?>

<script type="text/javascript">new MContent().setup_table( 'content_list' );</script>