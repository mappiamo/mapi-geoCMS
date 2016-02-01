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

		<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

						<ul class="nav nav-pills">
								<li><a href="#site" data-toggle="tab">Site</a></li>
								<li><a href="#apis" data-toggle="tab">APIs</a></li>
						</ul>

						<div class="tab-content">

								<div class="tab-pane" id="site">

										<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">

														<br />
														<div class="form-group">
														    	<label for="website_title" class="control-label">Website title</label>
														    	<div>
														      			<input type="text" name="website_title" class="form-control" id="website_title" value="<?php MPut::_html_attr( $data['website_title'] ); ?>" />
														    	</div>
														</div>
														<div class="form-group">
														    	<label for="website_description" class="control-label">Website description</label>
														    	<div>
														      			<input type="text" name="website_description" class="form-control" id="website_description" value="<?php MPut::_html_attr( $data['website_description'] ); ?>" />
														    	</div>
														</div>
														<div class="form-group">
														    	<label for="website_email" class="control-label">Notification emails to <small>(for example when someone registers)</small></label>
														    	<div>
														      			<input type="text" name="website_email" class="form-control" id="website_email" value="<?php MPut::_html_attr( $data['website_email'] ); ?>" />
														    	</div>
														</div>

														<hr>

														<div class="form-group">
															<label for="website_name" class="control-label">Website name</label>
															<div>
																<input type="text" name="website_name" class="form-control" id="website_name" value="<?php if (isset($data['website_name'])) { MPut::_html_attr( $data['website_name'] ); } ?>" />
															</div>
														</div>

													<div class="form-group">
														<label for="website_name" class="control-label">Domain</label>
														<div>
															<input type="text" name="domain" class="form-control" id="domain" value="<?php if (isset($data['domain'])) { MPut::_html_attr( $data['domain'] ); } ?>" />
														</div>
													</div>

													<hr>

													<div class="form-group">
														<label for="website_name" class="control-label">Default location (Address, City, Country…)</label>
														<div>
															<input type="text" name="location" class="form-control" id="location" value="<?php if (isset($data['location'])) { MPut::_html_attr( $data['location'] ); } ?>" />
														</div>

														<script type="text/javascript">
															var mmap1 = new MMap();
															mmap1.address_search();
														</script>
													</div>

													<div class="form-group">
														<label for="website_name" class="control-label">Default Latitude</label>
														<div>
															<input type="text" name="DefaultLatitude" class="form-control" id="DefaultLatitude" value="<?php if (isset($data['DefaultLatitude'])) { MPut::_html_attr( $data['DefaultLatitude'] ); } ?>" />
														</div>
													</div>

													<div class="form-group">
														<label for="website_name" class="control-label">Default Longitude</label>
														<div>
															<input type="text" name="DefaultLongitude" class="form-control" id="DefaultLongitude" value="<?php if (isset($data['DefaultLongitude'])) { MPut::_html_attr( $data['DefaultLongitude'] ); } ?>" />
														</div>
													</div>

													<br />

														<h4>Registration</h4>
														<div class="radio">
		  														<label>
																	    <input type="radio" name="registration" id="registration" value="no" <?php if ( 'no' == $data['registration'] ) echo 'checked="checked"'; ?> />
																	    No
																</label>
														</div>
														<div class="radio">
																<label>
																	    <input type="radio" name="registration" id="registration" value="yes" <?php if ( 'yes' == $data['registration'] ) echo 'checked="checked"'; ?> />
																	    Yes <small>(Warning: $reg parameters must be set in settings.php, otherwise sending out registration emails will fail)</small>
																</label>
														</div>
														<div class="form-group">
														    	<label for="new_user_default_group" class="control-label">New user default group</label>
														    	<div>
														      			<select name="new_user_default_group" class="form-control" id="new_user_default_group">
														      					<?php foreach( $groups as $group ): ?>
														      							<?php if ( $group->id == $data['new_user_default_group'] ): ?>
														      									<option value="<?php MPut::_numeric( $group->id ); ?>" selected="selected"><?php MPut::_html( $group->title ); ?></option>
														      							<?php else: ?>
														      									<option value="<?php MPut::_numeric( $group->id ); ?>"><?php MPut::_html( $group->title ); ?></option>
														      							<?php endif; ?>
														      					<?php endforeach; ?>
														      			</select>
														    	</div>
														</div>

														<br />

														<br />
														<h4>Error reporting</h4>
														<div class="radio">
		  														<label>
																	    <input type="radio" name="force_php_errors_and_warnings" id="force_php_errors_and_warnings" value="no" <?php if ( 'no' == $data['force_php_errors_and_warnings'] ) echo 'checked="checked"'; ?> />
																	    No
																</label>
														</div>
														<div class="radio">
																<label>
																	    <input type="radio" name="force_php_errors_and_warnings" id="force_php_errors_and_warnings" value="yes" <?php if ( 'yes' == $data['force_php_errors_and_warnings'] ) echo 'checked="checked"'; ?> />
																	    Yes <small>(Warning: Select this only for debug, it is unsafe to display PHP errors)</small>
																</label>
														</div>
														
														<br />
														<h4>Permalinks</h4>
														<div class="radio">
		  														<label>
																	    <input type="radio" name="routing" id="routing" value="default" <?php if ( 'default' == $data['routing'] ) echo 'checked="chekced"'; ?>  />
																	    Default <small>(index.php?module=content&object_id=1)</small>
																</label>
														</div>
														<div class="radio">
																<label>
																	    <input type="radio" name="routing" id="routing" value="sef" <?php if ( 'sef' == $data['routing'] ) echo 'checked="chekced"'; ?>  />
																	    SEF <small>(index.php/contents/content-name)</small>
																</label>
														</div>

												</div>
										</div>
								</div>

								<div class="tab-pane" id="apis">
										
										<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">

														<br />
														<h4>Facebook</h4>
														<div class="form-group">
														    	<label for="facebook_app_id" class="control-label">App ID</small></label>
														    	<div>
														      			<input type="text" name="facebook_app_id" class="form-control" id="facebook_app_id" value="<?php MPut::_html_attr( $data['facebook_app_id'] ); ?>" />
														    	</div>
														</div>

														<div class="form-group">
														    	<label for="facebook_secret" class="control-label">Secret</label>
														    	<div>
														      			<input type="text" name="facebook_secret" class="form-control" id="facebook_secret" value="<?php MPut::_html_attr( $data['facebook_secret'] ); ?>" />
														    	</div>
														</div>

													<div class="form-group">
														<label for="DisqusName" class="control-label">Disqus sitename</label>
														<div>
															<input type="text" name="DisqusName" class="form-control" id="DisqusName" value="<?php if (isset($data['DisqusName'])) { MPut::_html_attr( $data['DisqusName'] ); } ?>" />
														</div>
													</div>

													<div class="form-group">
														<label for="Reacaptcha_key" class="control-label">ReCaptcha ID</label>
														<div>
															<input type="text" name="Reacaptcha_key" class="form-control" id="Reacaptcha_key" value="<?php if (isset($data['Reacaptcha_key'])) { MPut::_html_attr( $data['Reacaptcha_key'] ); } ?>" />
														</div>
													</div>

												</div>
										</div>

								</div>
								
						</div>

				</div>
		</div>

		<br /><br />

		<div class="btn-group">
				<button type="button" class="btn btn-default" onclick="location.href='index.php';">Cancel</button>
		  		<button type="submit" class="btn btn-primary" name="preferences_update">Save</button>
		</div>

		<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr( mapi_csrf_value() ); ?>" />

</form>