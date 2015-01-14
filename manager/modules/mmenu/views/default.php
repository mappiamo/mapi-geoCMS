<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-list"></span> Menus list <small>( <a href="index.php?module=mmenu&task=menu_add">Add new</a> )</small></h3>
</div>

<?php 
		$crumbs = array(
				'menus'		=> array( 'title' => 'Menus' )
		);
?>

<?php MHTML::breadcrumb( $crumbs ); ?>

<?php MMessaging::show(); ?>

<?php	
		if ( is_array( $data ) && sizeof( $data ) > 0 ) {
				foreach ( $data as $menu ) {
						if ( isset( $menu->pages ) ) {
								$pages_array = explode( ';', $menu->pages );
								$menu->objects = sizeof( $pages_array );
						} else {
								$menu->objects = 0;
						}
				}
		}

		MTable::init( $data, 'menus_list' );
		MTable::columns( array( 'id', 'title', 'objects', 'modified', 'enabled' ) );
		MTable::links( array( 'title' => 'index.php?module=mmenu&task=menu_edit&object=*[id]' ) );
		MTable::badges( array( 'objects' ) );
		MTable::binaries( array( 'enabled' ) );
		MTable::show();
?>

<script type="text/javascript">new MContent().setup_table( 'menus_list' );</script>