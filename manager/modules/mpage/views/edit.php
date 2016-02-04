<?php

	// no direct access to this file
	defined('DACCESS') or die;

?>

<div class="m-content-header">
	<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-edit"></span> <?php MPut::_title($data->title); ?>
	</h3>
</div>

<?php

	$crumbs = array('pages' => array('title' => 'Pages', 'link' => 'index.php?module=mpage&task=page_list'),
									'this_page' => array('title' => $data->title));

	$contents = mapi_list('contents', array('status' => 'enabled'));
	$categories = mapi_list('categories', array('status' => 'enabled'));
	$modules = mapi_list('modules', array('status' => 'enabled', 'env' => 'frontend'));
	$menus = mapi_list('menus', array('status' => 'enabled'));

	$events = mapi_list('categories', array('status' => 'enabled'));
	$pages = mapi_list('pages', array('status' => 'enabled'));

	$real_events = array();
	foreach ($events as $eventkey => $event) {
		$matches = array();
		preg_match_all("/{([^}]*)}/", $event->contents, $matches);

		$valid_content_keys = NULL;
		if ((count($matches[1])) > 0) {
			foreach ($matches[1] as $ContentID) {
				$eventsoncontent = ORM::for_table('contents')->select('id')
															->where_raw('(`type` = ? AND `enabled` = ? AND `id` = ?)', array('event', 1, $ContentID))
															->count();
				if ($eventsoncontent > 0) {
					if (in_array($ContentID, $matches[1])) {
						$valid_content_keys .= '{'.$ContentID.'};';
					}
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

<?php MHTML::breadcrumb($crumbs); ?>

<?php MMessaging::show(); ?>

<form method="post">

	<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr(mapi_csrf_value()); ?>"/>
	<input type="hidden" name="page_id" id="page_id" value="<?php MPut::_id($data->id); ?>"/>
	<input type="hidden" name="page_type" id="page_type" value="url"/>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">

					<br/>

					<div class="input-group">
						<span class="input-group-addon">Title</span>
						<input type="text" name="page_title" class="form-control" id="page_title"
									 value="<?php MPut::_html_attr($data->title); ?>"/>
					</div>

					<br/>

					<div class="input-group">
						<span class="input-group-addon">URL</span>
						<input type="text" name="page_url" class="form-control" id="page_url"
									 value="<?php MPut::_html_attr($data->url); ?>"/>
					</div>

					<ul class="nav nav-pills">
						<li><a href="#" data-toggle="modal" data-target="#category-chooser"><span
								class="glyphicon glyphicon-list-alt"></span> Add category</a></li>
						<li><a href="#" data-toggle="modal" data-target="#content-chooser"><span
								class="glyphicon glyphicon-list"></span> Add content</a></li>
						<li><a href="#" data-toggle="modal" data-target="#module-chooser"><span
								class="glyphicon glyphicon-hdd"></span> Add module</a></li>
						<li><a href="#" data-toggle="modal" data-target="#event-chooser"><span
								class="glyphicon glyphicon-calendar"></span> Add event</a></li>
					</ul>

					<br/>

					<div class="row">

						<div class="col-xs-12 col-sm-12 col-md-12">

							<div class="panel panel-default">
								<div class="panel-heading">Select menu to page</div>
								<div class="panel-body">

									<ul class="list-group">
										<?php if (sizeof($data->menus) > 0) { ?>
											<?php foreach ($data->menus as $menu) { ?>
												<li class="list-group-item">
													<?php MPut::_html($menu->title); ?>
													<button type="button" class="btn btn-xs btn-action"
																	onclick=<?php MPut::_js('new MPage().remove_menu( \''.$menu->id.'\' );'); ?>
																	style="float:right;">Remove</button>
												</li>
											<?php } ?>
										<?PHP } ?>

										<?PHP
											$PageData = ORM::for_table('pages')->select_many('id')
																		 ->where_raw('(`enabled` = ? AND `id` = ?)', array(1, $data->id))
																		 ->find_one();

											if ($PageData) {
												if ($PageData->parent_id != NULL) {
													$MenuPath = $PageData->parent_id;
													$MenuPathArray = explode('|', $MenuPath);
													$MenuPathArray = array_filter($MenuPathArray);

													foreach ($MenuPathArray as $MenuPath) {
														$MenuArray = explode('_', $MenuPath);

														if (count($MenuArray) >= 2) {
															$MenuStructure = NULL;
															$MenuIDStructure = NULL;
															foreach ($MenuArray as $Key => $Value) {
																if ($Key == 0) {
																	$MenuTitle = ORM::for_table('menus')->select_many('id', 'title')
																								->where_raw('(`enabled` = ? AND `id` = ?)', array(1, $Value))
																								->find_one();

																	$MenuStructure = $MenuTitle->title . ' :: ';
																	$MenuIDStructure = $MenuTitle->id . '_';
																} else {
																	$SubmenuTitle = ORM::for_table('pages')->select_many('id', 'title')
																									->where_raw('(`enabled` = ? AND `id` = ?)', array(1, $Value))
																									->find_one();

																	$MenuStructure .= $SubmenuTitle->title . ' :: ';
																	$MenuIDStructure .= $SubmenuTitle->id . '_';
																}
															}
															$MenuStructure = rtrim($MenuStructure, ' :: ');
															$MenuIDStructure = rtrim($MenuIDStructure, '_');
															?>

															<li class="list-group-item">
																<?PHP echo $MenuStructure; ?>
																<button type="button" class="btn btn-xs btn-action"
																				onclick=<?php MPut::_js('new MPage().remove_menu( \'' . $MenuIDStructure . '\' );'); ?>
																				style="float:right;">Remove</button>
															</li>

														<?PHP
														}
													}
												}
											}
										?>

									</ul>

									<select name="page_menu" class="form-control input-sm" id="page_menu">
										<?php if (sizeof($menus) > 0) { ?>
											<?php foreach ($menus as $menu) { ?>
												<option value="<?php MPut::_id($menu->id); ?>"><?php MPut::_html($menu->title); ?></option>

												<?PHP
												$matches = array();
												preg_match_all("/{([^}]*)}/", $menu->pages, $matches);
												if ((count($matches[1])) > 0) {
													foreach ($matches[1] as $ContentID) {

														$PageData = ORM::for_table('pages')->select_many('id', 'title', 'parent_id')
														->where_raw('(`enabled` = ? AND `id` = ?)', array(1, $ContentID))
														->find_one();

														$SubID = $menu->id . '_' . $PageData->id;

														if ($PageData->parent_id == NULL || $PageData->parent_id == '') {
															$SubID_prev = $SubID;
															?>

															<option value="<?php echo $SubID; ?>"><?php MPut::_html($menu->title); ?> :: <?php MPut::_html($PageData->title); ?></option>

															<?PHP
														}
													}
												}
												?>

											<?php } ?>
										<?php } ?>
									</select>

									<br/>

									<button type="button" class="btn btn-sm" onclick="new MPage().add_menu();">Add</button>
								</div>
							</div>
						</div>

					</div>

					<br/>

					<div class="form-group">
						<blockquote>
							<p>
								<span class="badge">Created</span> <?php MPut::_html($data->created['when']); ?>
								<small>by <?php MPut::_html($data->created['by_user']); ?></small>
							</p>

							<p>
								<span class="badge">Modified</span> <?php MPut::_html($data->modified['when']); ?>
								<small>by <?php MPut::_html($data->modified['by_user']); ?></small>
							</p>
						</blockquote>
					</div>

					<br/>

					<div class="btn-group">
						<button type="button" class="btn btn-default"
										onclick="location.href='index.php?module=mpage&task=page_delete&object=<?php MPut::_numeric($data->id); ?>';">
							Delete
						</button>
						<button type="submit" class="btn btn-primary" name="page_save">Save</button>
					</div>

				</div>
				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">

					<br/>

					<div class="panel panel-default">
						<div class="panel-heading">Open</div>
						<div class="panel-body">
							<input type="checkbox" name="page_on_blank" id="page_on_blank" <?php if (1 == $data->blank) {
								echo 'checked="checked"';
							} ?> value="1"/>
							<label>Open in a blank page</label>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading">Status</div>
						<div class="panel-body">
							<input type="checkbox" name="page_enabled" id="page_enabled" <?php if (1 == $data->enabled) {
								echo 'checked="checked"';
							} ?> value="1"/>
							<label>Enabled</label>
						</div>
					</div>

				</div>
			</div>

		</div>
	</div>

	<?php include('modal.php'); ?>

</form>