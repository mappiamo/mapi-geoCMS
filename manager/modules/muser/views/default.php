<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-user"></span> Users list <small>( <a href="index.php?module=muser&task=user_add">Add new</a> )</small></h3>
</div>

<?php 
		$crumbs = array(
				'users'	=> array( 'title' => 'Users' )
		);

		$groups = mapi_list( 'user_groups' );
?>

<?php MHTML::breadcrumb( $crumbs ); ?>

<?php MMessaging::show(); ?>

<?php	
		if ( sizeof( $data ) > 0 && sizeof( $groups ) > 0 ) {
				foreach ( $data as $user ) {
						if ( $user->group_id ) {
								foreach ( $groups as $group ) {
										if ( $user->group_id == $group->id ) $user->group = $group->title;
								}
						}
				}
		}

		MTable::init( $data, 'user_list' );
		MTable::columns( array( 'id', 'username', 'group', 'email', 'name', 'modified', 'enabled' ) );
		MTable::links( array( 'username' => 'index.php?module=muser&task=user_edit&object=*[id]' ) );
		MTable::binaries( array( 'enabled' ) );
		MTable::show();
?>

<script type="text/javascript">new MContent().setup_table( 'user_list' );</script>