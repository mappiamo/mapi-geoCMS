<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-edit"></span> <?php MPut::_title( $data->get_title() ); ?></h3>
</div>

<?php 
		$crumbs = array(
				'pages'		=> array( 'title' => 'Pages', 'link' => 'index.php?module=mpage&task=page_list' ),
				'page' 		=> array( 'title' => $data->get_title() )
		);
?>

<?php MHTML::breadcrumb( $crumbs ); ?>

<?php MMessaging::show(); ?>

<form method="post">

	<div class="alert alert-info">Are you sure you want to delete this page?<br />
			<div class="btn-group">
					<button type="submit" class="btn btn-danger" name="page_delete">Yes, delete it</button>
					<?php if( $data->get_id() ): ?>
							<button type="button" class="btn btn-default" onclick="location.href='index.php?module=mpage&task=page_edit&object=<?php MPut::_numeric( $data->get_id() ); ?>';">Cancel</button>
					<?php else: ?>
							<button type="button" class="btn btn-default" onclick="location.href='index.php?module=mpage&task=page_list';">Cancel</button>
					<?php endif; ?>
			</div>
	</div>

	<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr( mapi_csrf_value() ); ?>" />

</form>