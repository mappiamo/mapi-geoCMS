<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-plus"></span> Add a new menu</h3>
</div>

<?php 
		$crumbs = array(
				'menus'		=> array( 'title' => 'Menus', 'link' => 'index.php?module=mmenu&task=menu_list' ),
				'menu_add' 	=> array( 'title' => 'Add new menu' )
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

										<div class="btn-group">
												<button type="submit" class="btn btn-primary" name="menu_add">Add</button>
										</div>

								</div>
						</div>

				</div>
		</div>

		<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr( mapi_csrf_value() ); ?>" />

</form>