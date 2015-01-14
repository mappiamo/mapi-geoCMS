<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-cog"></span>XML Importer</h3>
</div>

<?php 
		$crumbs = array(
				'mxmlimport'	=> array( 'title' => 'XML Importer' )
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
								<span class="input-group-addon">.xml file</span>
								<input type="file" name="xml_file" class="form-control" id="xml_file" value="">
						</div>
						<br />
						<div class="input-group">
								<span class="input-group-addon">.ini file</span>
								<input type="file" name="ini_file" class="form-control" id="ini_file" value="">
						</div>
						<br />
						<div class="btn-group">
								<button type="submit" class="btn btn-primary" name="import">Import</button>
						</div>
				</div>
		</div>

		

</form>