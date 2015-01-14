<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-edit"></span> <?php MPut::_title( $data->username ); ?></h3>
</div>

<?php 
		$crumbs = array(
				'users'		=> array( 'title' => 'Users', 'link' => 'index.php?module=muser&task=user_list' ),
				'user' 		=> array( 'title' => $data->username )
		);

		$groups = mapi_list( 'user_groups' );

?>

<?php MHTML::breadcrumb( $crumbs ); ?>

<?php MMessaging::show(); ?>

<form method="post">

		<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

						<ul class="nav nav-pills">
								<li><a href="#user" data-toggle="tab">User data</a></li>
								<li><a href="#pass" data-toggle="tab">Change password</a></li>
						</ul>

						<div class="tab-content">

								<div class="tab-pane" id="user">

										<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">

														<br />

														<div class="panel panel-default">
																<div class="panel-body">
																		<div class="form-group">
																				<label>Username</label>
																				<input type="text" class="form-control" value="<?php MPut::_html_attr( $data->username ); ?>" disabled="disabled" />
																				<small>(Usernames cannot be changed)</small>
																		</div>

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
																				<label>Email</label>
																				<input type="text" name="user_email" class="form-control" id="user_email" value="<?php MPut::_html_attr( $data->email ); ?>" />
																		</div>

																		<div class="form-group">
																				<label>Name</label>
																				<input type="text" name="user_name" class="form-control" id="user_name" value="<?php MPut::_html_attr( $data->name ); ?>" />
																		</div>
																		
																		<div class="panel panel-default">
																				<div class="panel-body">
																						<input type="checkbox" name="user_enabled" id="user_enabled" <?php if ( 1 == $data->enabled ) echo 'checked="checked"'; ?> value="1" />
																						<label>Enabled</label>
																				</div>
																		</div>

																		<br />
																		<div class="form-group">
																				<blockquote>
																		  			<p>
																		  					<span class="badge">Created</span> <?php MPut::_html( $data->created['when'] ); ?>
																		  					<small>by <?php MPut::_html( $data->created['by_user'] ); ?></small>
																		  			</p>

																		  			<p>
																		  					<span class="badge">Modified</span> <?php MPut::_html( $data->modified['when'] ); ?>
																		  					<small>by <?php MPut::_html( $data->modified['by_user'] ); ?></small>
																		  			</p>
																				</blockquote>
																		</div>
																</div>
														</div>

														<div class="btn-group">
																<button type="button" class="btn btn-default" onclick="location.href='index.php?module=muser&task=user_delete&object=<?php MPut::_numeric( $data->id ); ?>';">Delete</button>
														  		<button type="submit" class="btn btn-primary" name="user_save">Save</button>
														</div>

												</div>
										</div>

								</div>

								<div class="tab-pane" id="pass">

										<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

														<br />

														<div class="panel panel-default">
																<div class="panel-body">
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

														<div class="btn-group">
																<button type="submit" class="btn btn-primary" name="change_password">Change</button>
														</div>

												</div>
										</div>

								</div>

						</div>

				</div>
		</div>

		<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr( mapi_csrf_value() ); ?>" />

</form>