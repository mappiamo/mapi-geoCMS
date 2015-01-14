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

		$facebook_instance = $this->model( 'facebook_init', null, 'mcontent_import' );
		$facebook_login_link = $this->model( 'facebook_login_link', null, 'mcontent_import' ); 

		$appid = MObject::get( 'preference', 'facebook_app_id' )->get_value();
		$secret = MObject::get( 'preference', 'facebook_secret' )->get_value();
?>

<?php MHTML::breadcrumb( $crumbs ); ?>

<?php MMessaging::show(); ?>

<ul class="list-group">
		<li class="list-group-item">
				<h4 class="list-group-item-heading">Facebook events</h4>
				<p class="list-group-item-text">
						<form id="import_facebook_form" method="post">
								<input type="hidden" name="import_begin" value="1" />
								<input type="hidden" name="import_what" value="facebook" />
								<?php if ( empty( $appid ) || empty( $secret ) ): ?>
										<a href="javascript:void(0)"><span style="text-decoration: line-through;">Import</span></a>
										&nbsp;<small>(Please set facebook appid and secret in <a href="index.php?module=preferences">preferences</a>)</small>
								<?php elseif ( $facebook_instance->getUser() ): ?>
										<a href="javascript:void(0)" onclick="$( '#import_facebook_form' ).submit();">Import</a>
								<?php else: ?>
										<a href="javascript:void(0)"><span style="text-decoration: line-through;">Import</span></a>
										&nbsp;<small>(Please login to Your <a href="<?php MPut::_link( $facebook_login_link ); ?>">facebook account</a> first)</small>
								<?php endif; ?>
						</fomr>
				</p>
		</li>
</ul>