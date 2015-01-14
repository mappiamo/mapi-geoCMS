<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-list"></span> Pages list <small>( <a href="index.php?module=mpage&task=page_add">Add new</a> )</small></h3>
</div>

<?php 
		$crumbs = array(
				'pages'		=> array( 'title' => 'Pages' )
		);
?>

<?php MHTML::breadcrumb( $crumbs ); ?>

<?php MMessaging::show(); ?>

<?php	

		MTable::init( $data, 'pages_list' );
		MTable::columns( array( 'id', 'title', 'type', 'modified', 'enabled' ) );
		MTable::links( array( 'title' => 'index.php?module=mpage&task=page_edit&object=*[id]' ) );
		MTable::binaries( array( 'enabled' ) );
		MTable::show();
?>

<script type="text/javascript">new MContent().setup_table( 'pages_list' );</script>