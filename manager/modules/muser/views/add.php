<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-plus"></span> Add a new user</h3>
</div>

<?php 
		$crumbs = array(
				'users'		=> array( 'title' => 'Users', 'link' => 'index.php?module=muser&task=user_list' ),
				'user_add' 	=> array( 'title' => 'Add new user' )
		);

		$groups = mapi_list( 'user_groups' );
?>

<?php MHTML::breadcrumb( $crumbs ); ?>

<?php MMessaging::show(); ?>

<form method="post">

		<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

						<br />

						<div class="panel panel-default">
								<div class="panel-body">
										<div class="form-group">
												<label>Group</label>
												<select name="user_group_id" class="form-control" id="user_group_id">
														<?php if ( sizeof( $groups ) > 0 ): ?>
																<?php foreach ( $groups as $group ): ?>
																		<?php if ( $data->group == $group->id ): ?>
																				<option value="<?php MPut::_id( $group->id ); ?>" selected="selected"><?php MPut::_html( $group->title ); ?></option>
																		<?php else: ?>
																				<option value="<?php MPut::_id( $group->id ); ?>"><?php MPut::_html( $group->title ); ?></option>
																		<?php endif; ?>
																<?php endforeach; ?>
														<?php endif; ?>
												</select>
										</div>

										<div class="form-group">
												<label>Username</label>
												<input type="text" name="user_username" class="form-control" id="user_username" value="<?php MPut::_html_attr( $data->username ); ?>" />
										</div>

										<div class="form-group">
												<label>Email</label>
												<input type="text" name="user_email" class="form-control" id="user_email" value="<?php MPut::_html_attr( $data->email ); ?>" />
										</div>

										<div class="form-group">
												<label>Name</label>
												<input type="text" name="user_name" class="form-control" id="user_name" value="<?php MPut::_html_attr( $data->name ); ?>" />
										</div>

										<br />
										
										<div class="form-group">
												<label>Password</label>
												<input type="password" name="user_pass" class="form-control" id="user_pass" />
										</div>

										<div class="form-group">
												<label>Repeat</label>
												<input type="password" name="user_pass_repeat" class="form-control" id="user_pass_repeat" />
										</div>
								</div>
						</div>
				</div>
		</div>

		<div class="btn-group">
				<button type="submit" class="btn btn-primary" name="user_add">Add</button>
		</div>

		<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr( mapi_csrf_value() ); ?>" />

</form>