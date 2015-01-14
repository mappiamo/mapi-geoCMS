<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-cog"></span> Preferences</h3>
</div>

<?php 
		$crumbs = array(
				'preferences'	=> array( 'title' => 'Preferences' )
		);
		$groups = mapi_list( 'user_groups' );
?>

<?php MHTML::breadcrumb( $crumbs ); ?>

<?php MMessaging::show(); ?>

<form method="post">

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
																				<input type="text" class="form-control" value="<?php MPut::_html_attr( $data->get_username() ); ?>" disabled="disabled" />
																				<small>(Usernames cannot be changed)</small>
																		</div>
																		
																		<div class="form-group">
																				<label>Email</label>
																				<input type="text" name="user_email" class="form-control" id="user_email" value="<?php MPut::_html_attr( $data->get_email() ); ?>" />
																		</div>

																		<div class="form-group">
																				<label>Name</label>
																				<input type="text" name="user_name" class="form-control" id="user_name" value="<?php MPut::_html_attr( $data->get_name() ); ?>" />
																		</div>
																</div>
														</div>

														<div class="btn-group">
														  		<button type="submit" class="btn btn-primary" name="profile_update">Update</button>
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