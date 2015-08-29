<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-plus"></span> Add a new page</h3>
</div>

<?php 
		$crumbs = array(
				'pages'			=> array( 'title' => 'Pages', 'link' => 'index.php?module=mpage&task=page_list' ),
				'pages_add' 	=> array( 'title' => 'Add a new page' )
		);

		$contents = mapi_list( 'contents', array( 'status' => 'enabled' ) );
		$categories = mapi_list( 'categories', array( 'status' => 'enabled' ) );
		$modules = mapi_list( 'modules', array( 'status' => 'enabled', 'env' => 'frontend' ) );
		$events = mapi_list( 'categories', array( 'status' => 'enabled' ) );

		$real_events = array();
		foreach ( $events as $eventkey => $event ) {
			$matches = array();
			preg_match_all("/{([^}]*)}/", $event->contents, $matches);

			$valid_content_keys = NULL;
			if ((count($matches[1])) > 0) {
				foreach ($matches[1] as $ContentID) {
					$eventsoncontent = ORM::for_table('contents')->select('id')->where_raw('(`type` = ? AND `enabled` = ? AND `id` = ?)', array('event', 1, $ContentID))->count();
					if ($eventsoncontent > 0) {
						if (in_array($ContentID, $matches[1])) { $valid_content_keys .= '{' . $ContentID . '};'; }
					}
				}
			}

			if ($valid_content_keys) {
				$event->contents = rtrim($valid_content_keys, ';');
				$real_events[$eventkey] = $event;
			}
		}
		$events = $real_events;

?>

<?php MHTML::breadcrumb( $crumbs ); ?>

<?php MMessaging::show(); ?>

<form method="post">

		<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr( mapi_csrf_value() ); ?>" />
		<input type="hidden" name="page_type" id="page_type" value="url" />

		<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

						<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">

										<br />
										<div class="input-group">
												<span class="input-group-addon">Title</span>
												<input type="text" name="page_title" class="form-control" id="page_title" value="<?php MPut::_html_attr( $data->title ); ?>" />
										</div>

										<br />
										<div class="input-group">
												<span class="input-group-addon">URL</span>
												<input type="text" name="page_url" class="form-control" id="page_url" value="<?php MPut::_html_attr( $data->url ); ?>" />
										</div>

										<ul class="nav nav-pills">
												<li><a href="#" data-toggle="modal" data-target="#category-chooser"><span class="glyphicon glyphicon-list-alt"></span> Add category</a></li>
  											<li><a href="#" data-toggle="modal" data-target="#content-chooser"><span class="glyphicon glyphicon-list"></span> Add content</a></li>
  											<li><a href="#" data-toggle="modal" data-target="#module-chooser"><span class="glyphicon glyphicon-hdd"></span> Add module</a></li>
												<li><a href="#" data-toggle="modal" data-target="#event-chooser"><span class="glyphicon glyphicon-calendar"></span> Add event</a></li>
										</ul>

								</div>
								<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">

										<br />
										<div class="panel panel-default">
												<div class="panel-heading">Open</div>
												<div class="panel-body">
														<input type="checkbox" name="page_on_blank" id="page_on_blank" <?php if ( $data->blank ) echo 'checked="checked"'; ?> value="1" />
														<label>Open in a blank page</label>
												</div>
										</div>


								</div>
						</div>

						<br />
						<div class="btn-group">
								<button type="submit" class="btn btn-primary" name="page_add">Add</button>
						</div>

				</div>
		</div>

		<?php include( 'modal.php' ); ?>

</form>