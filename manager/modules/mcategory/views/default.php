<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-list"></span> Categories list <small>( <a href="index.php?module=mcategory&task=category_add">Add new</a> )</small></h3>
</div>

<?php 
		$crumbs = array(
				'categories'	=> array( 'title' => 'Categories' )
		);
?>

<?php MHTML::breadcrumb( $crumbs ); ?>

<?php MMessaging::show(); ?>

<?php	

		if ( is_array( $data ) && sizeof( $data ) > 0 ) {
				foreach ( $data as $category ) {
						if ( isset( $category->contents ) ) {
								$contents_array = explode( ';', $category->contents );
								$category->objects = sizeof( $contents_array );
						} else {
								$category->objects = 0;
						}
				}
		}

		MTable::init( $data, 'categories_list' );
		MTable::columns( array( 'id', 'title', 'objects', 'modified', 'enabled' ) );
		MTable::links( array( 'title' => 'index.php?module=mcategory&task=category_edit&object=*[id]' ) );
		MTable::badges( array( 'objects' ) );
		MTable::binaries( array( 'enabled' ) );
		MTable::show();
?>

<script type="text/javascript">new MContent().setup_table( 'categories_list' );</script>