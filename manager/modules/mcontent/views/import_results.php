<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-import"></span> Import content</h3>
</div>

<?php 
		$crumbs = array(
				'contents'	=> array( 'title' => 'Contents', 'link' => 'index.php?module=mcontent&task=content_list' ),
				'content_add' => array( 'title' => 'Import content' )
		);
?>

<?php MHTML::breadcrumb( $crumbs ); ?>

<?php MMessaging::show(); ?>

<p class="text-muted">Click on content title to import.</p>
<div class="panel panel-default">
		<div class="panel-heading">
				<?php if ( isset( $data['header'] ) ) MPut::_html( $data['header'] ); ?>
				<?php if ( isset( $data['data'] ) ): ?>
						<span class="badge"><?php echo sizeof( $data['data'] ); ?></span>
				<?php endif; ?>
		</div>
		<input type="hidden" id="mapi_csrf" value="<?php MPut::_html_attr( mapi_csrf_value() ); ?>" />
  		<div class="panel-body">
  				<ul class="list-group">
		  				<?php if ( isset( $data['data'] ) && sizeof( $data['data'] ) > 0 ): ?>
		  						<?php foreach( $data['data'] as $record ): ?>
		  								<li class="list-group-item">
		  										<form method="post" action="index.php?module=mcontent&task=content_import">
		  												<input type="hidden" name="content_import" value="1" />
		  												<input type="hidden" name="content_type" value="<?php if ( isset( $data['type'] ) ) MPut::_html_attr( $data['type'] ); ?>" />
		  												<blockquote>
																<p style="margin-bottom: 0px;">
																		<a href="javascript:void(0);" onclick="$( '[name=mapi_csrf]' ).val( $( '#mapi_csrf' ).val() ); $(this).closest( 'form' ).submit(); ">
																				<?php if ( isset( $record['name'] ) ): ?>
																						<?php MPut::_html( $record['name'] ); ?>
																						<input type="hidden" name="content_title" value="<?php MPut::_html_attr( MPut::_html( $record['name'] ) ) ?>" />
																				<?php endif; ?>
																		</a>
																</p>
																<footer>
																		<?php if ( isset( $record['location'] ) ): ?>
																				<?php MPut::_html( $record['location'] ); ?>
																				<input type="hidden" name="content_address" value="<?php MPut::_html_attr( MPut::_html( $record['location'] ) ) ?>" />
																				<?php if ( isset( $record['lat'] ) ): ?>
																						<input type="hidden" name="content_lat" value="<?php MPut::_html_attr( MPut::_numeric( $record['lat'] ) ) ?>" />
																				<?php endif; ?>
																				<?php if ( isset( $record['lng'] ) ): ?>
																						<input type="hidden" name="content_lng" value="<?php MPut::_html_attr( MPut::_numeric( $record['lng'] ) ) ?>" />
																				<?php endif; ?>
																		<?php endif; ?>
																		<br />
																		<small>
																				&nbsp;
																				<?php if ( isset( $record['start_time'] ) ): ?>
																						<?php echo date_format( new DateTime( $record['start_time'] ), 'Y-m-d H:i:s' ); ?>
																						<input type="hidden" name="content_start" value="<?php echo date_format( new DateTime( $record['start_time'] ), 'Y-m-d H:i:s' ); ?>" />
																				<?php endif; ?>
																				&nbsp;
																				<?php if ( isset( $record['end_time'] ) ): ?>
																						->&nbsp;
																						<?php echo date_format( new DateTime( $record['end_time'] ), 'Y-m-d H:i:s' ); ?>
																						<input type="hidden" name="content_end" value="<?php echo date_format( new DateTime( $record['end_time'] ), 'Y-m-d H:i:s' ); ?>" />
																				<?php endif; ?>
																		</small>
																		<p style="margin-top: 12px;">
																				<?php if ( isset( $record['description'] ) ): ?>
																						<?php MPut::_html( $record['description'] ); ?>
																						<input type="hidden" name="content_text" value="<?php MPut::_html_attr( $record['description'] ); ?>" />
																				<?php endif; ?>
																		</p>
																</footer>
														</blockquote>
														<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="" />
		  										</form>
		  								</li>
		  						<?php endforeach; ?>
						<?php else: ?>
								<li class="list-group-item">No results found</li>
						<?php endif; ?>
				</ul>
  		</div>
</div>