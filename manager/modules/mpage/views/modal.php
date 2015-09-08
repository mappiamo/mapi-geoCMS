<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="modal fade" id="content-chooser" tabindex="-1" role="dialog" aria-labelledby="content-chooser" aria-hidden="true">
	  	<div class="modal-dialog">
	    		<div class="modal-content">

			      		<div class="modal-header">
			        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        			<h4 class="modal-title">URL editor</h4>
			      		</div>
			      		
			      		<div class="modal-body">
			      				<p class="text-info">Choose a content:</p>

			        			<?php	
										MTable::init( $contents, 'content_list' );
										MTable::columns( array( 'id', 'title', 'hits', 'address' ) );
										MTable::badges( array( 'hits' ) );
										MTable::radio_select( 'id', null );
										MTable::show();
								?>
								<?php if ( sizeof( $contents ) > 0 ): ?>
										<script type="text/javascript">
												new MContent().nosort_column( 'content_list', 0 , 1 );
										</script>
								<?php endif; ?>
			      		</div>
			      		
			      		<div class="modal-footer">
			        			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        			<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="page = new MPage(); page.base_url = '<?php echo mapi_install_url(); ?>'; page.add_content_url();">Add</button>
			      		</div>

	    		</div>
	  	</div>
</div>

<div class="modal fade" id="category-chooser" tabindex="-1" role="dialog" aria-labelledby="category-chooser" aria-hidden="true">
	  	<div class="modal-dialog">
	    		<div class="modal-content">

			      		<div class="modal-header">
			        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        			<h4 class="modal-title">URL editor</h4>
			      		</div>
			      		
			      		<div class="modal-body">
			      				<p class="text-info">Choose a category:</p>

			        			<?php	
			        					if ( sizeof( $categories ) > 0 ) {
												foreach ( $categories as $category ) {
														if ( isset( $category->contents ) ) {
																$contents_array = explode( ';', $category->contents );
																$category->objects = sizeof( $contents_array );
														} else {
																$category->objects = 0;
														}
												}
										}

										MTable::init( $categories, 'category_list' );
										MTable::columns( array( 'id', 'title', 'objects' ) );
										MTable::badges( array( 'objects' ) );
										MTable::radio_select( 'id', null );
										MTable::show();
								?>
								<?php if ( sizeof( $categories ) > 0 ): ?>
										<script type="text/javascript">
												new MContent().nosort_column( 'category_list', 0 , 1 );
										</script>
								<?php endif; ?>
			      		</div>
			      		
			      		<div class="modal-footer">
			        			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        			<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="page = new MPage(); page.base_url = '<?php echo mapi_install_url(); ?>'; page.add_category_url();">Add</button>
			      		</div>

	    		</div>
	  	</div>
</div>

<div class="modal fade" id="module-chooser" tabindex="-1" role="dialog" aria-labelledby="module-chooser" aria-hidden="true">
	  	<div class="modal-dialog">
	    		<div class="modal-content">

			      		<div class="modal-header">
			        			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        			<h4 class="modal-title">URL editor</h4>
			      		</div>
			      		
			      		<div class="modal-body">
			      				<p class="text-info">Choose module:</p>

			      				<label>Module</label>
								<select name="module_name" class="form-control input-sm">
										<?php if ( sizeof( $modules ) > 0 ): ?>
												<?php foreach ( $modules as $module ): ?>
														<option value="<?php MPut::_html_attr( $module->name ); ?>"><?php MPut::_html( $module->title ); ?></option>
												<?php endforeach; ?>
										<?php endif; ?>
								</select>

								<br />

								<label>Task</label>
								<input type="text" name="module_task" class="form-control input-sm" />
			        			
			      		</div>
			      		
			      		<div class="modal-footer">
			        			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        			<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="page = new MPage(); page.base_url = '<?php echo mapi_install_url(); ?>'; page.add_module_url();">Add</button>
			      		</div>

	    		</div>
	  	</div>
</div>

<div class="modal fade" id="event-chooser" tabindex="-1" role="dialog" aria-labelledby="event-chooser" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">URL editor</h4>
			</div>

			<div class="modal-body">

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="panel panel-default">
					<div class="panel-heading">Sort and filter events</div>
						<div class="panel-body">

							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

								<div class="panel panel-default">

									<div class="panel-heading">Filter events by date:</div>
									<div class="panel-body">

										<select name="filter_type" id="filter_type" class="form-control">
											<option value="active" selected>Active filter</option>
											<option value="fix">Filter by fix dates</option>
										</select>

										<div id="active_filters">
											<br>Show by event period:
											<select name="filter" id="filter" class="form-control">
												<option value="all" selected>Show all</option>
												<option value="today">Today only</option>
												<option value="week">This week only</option>
												<option value="month">This month only</option>
												<option value="quarter">This quarter only</option>
												<option value="year">Full year</option>
												<option value="inprogress">Event in progress</option>
											</select>

											<br>If events expired, show:
											<select name="expired" id="expired" class="form-control">
												<option value="blank" selected>Blank page</option>
												<option value="all">All events</option>
												<option value="remove">Remove menu</option>
											</select>

										</div>

										<div id="fix_filters">

											<br><div class="form-group">
												<label>Start date:</label>
												<input value="<?PHP echo date('Y-m-d', strtotime('-1 Week')); ?>" type="text" name="filter_start" class="form-control input-sm" id="filter_start">
											</div>

											<div class="form-group">
												<label>End date:</label>
												<input type="text" value="<?PHP echo date('Y-m-d', strtotime('+1 Week')); ?>" name="filter_end" class="form-control input-sm" id="filter_end">
											</div>

										</div>

										<br>Filter by date:
										<select name="filterby" id="filterby" class="form-control">
											<option value="modified" selected>Modified date</option>
											<option value="created">Creation date</option>
											<option value="start">Start date</option>
											<option value="end">End date</option>
										</select>

										<br><input type="checkbox" name="user_filter" value="yes" checked>
										<label>User can modify this filter</label>

									</div>
								</div>
							</div>

							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

								<div class="panel panel-default">
									<div class="panel-heading">Sort order</div>
									<div class="panel-body">
										<select name="sort" id="sort" class="form-control">
											<option value="modified" selected>Modified date</option>
											<option value="created">Creation date</option>
											<option value="start">Start date</option>
											<option value="end">End date</option>
											<option value="title">Title</option>
											<option value="address">Address</option>
										</select>
										<br><input type="checkbox" name="reverse_order" value="yes">
										<label>Reverse order</label>
									</div>
								</div>

								<div class="panel panel-default">
									<div class="panel-heading">Filter events by address:</div>
									<div class="panel-body">
										<label>Address (city, country, street)</label>
										<input type="text" name="address" class="form-control input-sm" id="address">
										<br><label>Search radius (km)</label>
										<input type="number" min="1" step="5" max="100" name="filter_radius" class="form-control input-sm" id="filter_radius">
									</div>
								</div>

							</div>

							</div>
						</div>
					</div>
				</div>

				<p class="text-info">Choose events:</p>

				<?php
					if ( sizeof( $events ) > 0 ) {
						foreach ( $events as $event ) {
							if ( isset( $event->contents ) ) {
								$event_array = explode( ';', $event->contents );
								$event->objects = sizeof( $event_array );
							} else {
								$event->objects = 0;
							}
						}
					}

					MTable::init( $events, 'event_list' );
					MTable::columns( array( 'id', 'title', 'objects' ) );
					MTable::badges( array( 'objects' ) );
					MTable::checkbox_select( 'id', null );
					MTable::show();
				?>
				<?php if ( sizeof( $events ) > 0 ): ?>
					<script type="text/javascript">
						new MContent().nosort_column( 'event_list', 0 , 1 );
					</script>
				<?php endif; ?>

			<?PHP
				$SavedURL = parse_url($data->url);
				if (!isset($SavedURL['query'])) {
					$NextPID = ORM::for_table('pages')->raw_query("SHOW TABLE STATUS LIKE 'pages'")->find_one();
					$PID = $NextPID['Auto_increment'];
				} else {
					$ThePageQuery = $SavedURL['query'];
					$URLAsArray = explode('&', $ThePageQuery);
					foreach($URLAsArray as $DaraName) {
						list($name, $value) = explode('=', $DaraName, 2);
						if ($name == 'pid') { $PID = $value; }
					}
				}
			?>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="page = new MPage(); page.base_url = '<?php echo mapi_install_url(); ?>'; page.add_event_url(<?PHP echo $PID; ?>);">Add</button>
			</div>

		</div>
	</div>
</div>