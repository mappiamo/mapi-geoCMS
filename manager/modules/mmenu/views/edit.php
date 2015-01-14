<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-edit"></span> <?php MPut::_title( $data->title ); ?> <span class="badge"><?php MPut::_numeric( $data->pages_count ); ?></span></h3>
</div>

<?php 
		$crumbs = array(
				'menus'	=> array( 'title' => 'Menus', 'link' => 'index.php?module=mmenu&task=menu_list' ),
				'menu' 	=> array( 'title' => $data->title )
		);
?>

<?php MHTML::breadcrumb( $crumbs ); ?>

<?php MMessaging::show(); ?>

<form method="post">

		<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

						<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">

										<br />
										<div class="input-group">
												<span class="input-group-addon">Title</span>
												<input type="text" name="menu_title" class="form-control" id="menu_title" value="<?php MPut::_html_attr( $data->title ); ?>" />
										</div>

										<br />
										<div class="well">

												<p class="text-info">Pages in this menu:</p>

												<?php
														MTable::init( mapi_2stdclass( $data->pages, array( 'id' => 'get_id', 'title' => 'get_title', 'url' => 'get_url' ) ), 'menu_pages' );
														MTable::columns( array( 'id', 'title', 'url' ) );
														MTable::links( array( 'title' => 'index.php?module=mpage&task=page_edit&object=*[id]' ) );
														MTable::show();
												?>

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
								<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">

										<br />
										<div class="panel panel-default">
												<div class="panel-heading">Status</div>
												<div class="panel-body">
														<input type="checkbox" name="menu_enabled" id="menu_enabled" <?php if ( 1 == $data->enabled ) echo 'checked="checked"'; ?> value="1" />
														<label>Enabled</label>
												</div>
										</div>

								</div>
						</div>

				</div>
		</div>

		<div class="btn-group">
				<button type="button" class="btn btn-default" onclick="location.href='index.php?module=mmenu&task=menu_delete&object=<?php MPut::_numeric( $data->id ); ?>';">Delete</button>
		  		<button type="submit" class="btn btn-primary" name="menu_save">Save</button>
		</div>

		<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr( mapi_csrf_value() ); ?>" />

</form>