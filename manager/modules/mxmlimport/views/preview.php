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


<form method="post">

		

		<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
						<br />
						<h4>Data preview: </h4><br />
						
								<?php
								
								?>
								
								<?php
								$i = 1;
								foreach ( $data["xml"] as $place ) {
										echo "Content #" . $i . "<br />";
										foreach ( $place as $key => $value ) {
												echo $key . ": <b>" . $value . "</b><br />";
										}
										echo "<br /><br />";
										$i++;
								}
								?>

						<h4>Config: </h4><br />
						<?php
						echo "Category: " . $data["ini"]["category"] . "<br />";
						echo "Include into description: <b>" . $data["ini"]["description"] . "</b><br /><br />";
						foreach ( $data["ini"] as $key => $value ) {
								if ( $key != "category" && $key != "description" ) {
										echo $key . ": <b>" . $value . "</b><br />";
								}
						}
						
						?>
						
						<br /><br />
				</div>
		</div>
		<input type="hidden" name="mxml_json_data" value="<?php  echo (base64_encode(json_encode($data))); ?>" />
		<div class="btn-group">
				<input type="submit" class="btn btn-primary" name="process_import" value="Confirm import" />
		</div>

</form>