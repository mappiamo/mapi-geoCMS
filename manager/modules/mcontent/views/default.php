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

<?php	
		MTable::init( $data, 'content_list' );
		MTable::columns( array( 'id', 'title', 'type', 'hits', 'address', 'modified', 'language', 'enabled' ) );
		MTable::links( array( 'title' => 'index.php?module=mcontent&task=content_edit&object=*[id]' ) );
		MTable::badges( array( 'hits' ) );
		MTable::binaries( array( 'enabled' ) );
		MTable::show();
?>

<script type="text/javascript">new MContent().setup_table( 'content_list' );</script>