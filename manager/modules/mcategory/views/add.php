<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-plus"></span> Add new category</h3>
</div>

<?php 
		$crumbs = array(
				'categories'		=> array( 'title' => 'Categories', 'link' => 'index.php?module=mcategory&task=category_list' ),
				'categories_add' 	=> array( 'title' => 'Add new category' )
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
												<input type="text" name="category_title" class="form-control" id="category_title" value="<?php MPut::_html_attr( $data->title ); ?>" />
										</div>

										<br />

										<div class="btn-group">
												<button type="submit" class="btn btn-primary" name="category_add">Add</button>
										</div>

								</div>
						</div>

				</div>
		</div>

		<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr( mapi_csrf_value() ); ?>" />

</form>