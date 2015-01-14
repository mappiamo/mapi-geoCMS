<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-edit"></span> <?php MPut::_title( $data->title ); ?> <span class="badge"><?php MPut::_numeric( $data->content_count ); ?></span></h3>
</div>

<?php 
		$crumbs = array(
				'categories'	=> array( 'title' => 'Categories', 'link' => 'index.php?module=mcategory&task=category_list' ),
				'this_category' => array( 'title' => $data->title )
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

										<div class="well">

												<p class="text-info">Contents in this category:</p>

												<?php
														MTable::init( mapi_2stdclass( $data->contents, array( 'id' => 'get_id', 'title' => 'get_title', 'address' => 'get_address' ) ), 'category_contents' );
														MTable::columns( array( 'id', 'title', 'address' ) );
														MTable::links( array( 'title' => 'index.php?module=mcontent&task=content_edit&object=*[id]' ) );
														MTable::radio_select( 'id', $data->flagship );
														MTable::show();
												?>

												<?php if ( sizeof( $data->contents ) > 0 ): ?>
														<script type="text/javascript">
																new MContent().nosort_column( 'category_contents', 0 , 1 );
														</script>
												<?php endif; ?>
											
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
														<input type="checkbox" name="category_enabled" id="category_enabled" <?php if ( 1 == $data->enabled ) echo 'checked="checked"'; ?> value="1" />
														<label>Enabled</label>
												</div>
										</div>

								</div>
						</div>

				</div>
		</div>

		<div class="btn-group">
				<button type="button" class="btn btn-default" onclick="location.href='index.php?module=mcategory&task=category_delete&object=<?php MPut::_numeric( $data->id ); ?>';">Delete</button>
		  		<button type="submit" class="btn btn-primary" name="category_save">Save</button>
		</div>

		<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr( mapi_csrf_value() ); ?>" />

</form>