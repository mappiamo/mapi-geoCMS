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