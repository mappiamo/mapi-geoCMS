<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-eye-open"></span> Templates list</h3>
</div>

<?php 
		$crumbs = array(
				'modules'	=> array( 'title' => 'Templates' )
		);
?>

<?php MHTML::breadcrumb( $crumbs ); ?>

<?php MMessaging::show(); ?>

<form method="post" action="index.php?module=mtemplate&task=template_uninstall">

		<?php

				$missing = MExtension::calculate_missing( 'template' );

				if ( is_array( $data['installed'] ) && sizeof( $data['installed'] ) > 0 ) {
						foreach ( $data['installed'] as $template ) {
								if ( is_object( $template ) ) {
										$template->text = '';
										$template->text .= '<div style="float: left; margin-top: 12px; margin-bottom: 12px;"><img class="media-object" style="height: 120px; width: 180px;" src="../' . MExtension::thumbnail( $template->name ) . '" alt="" /></div>';
										$template->text .= '<div style="float: left; margin-top: 12px; margin-left: 12px;">';
												if ( isset( $template->version ) ) $template->text .= '<div>Version: <code class="green">' . $template->version . '</code></div>';
												if ( ! MExtension::check_extension( 'template', $template->name ) ) $template->text .= '<div>Status: <code>Missing</code></div>';
												elseif ( 1 == $template->enabled ) $template->text .= '<div>Status: <code class="green">Enabled</code></div>';
												else $template->text .= '<div>Status: <code>Disabled</code></div>';
												if ( isset( $template->description ) ) $template->text .= '<div><p>&nbsp;</p><p>' . $template->description . '</p></div>';
										$template->text .= '</div>';
										$template->text .= '<div style="clear: both;"></div>';
								}
						}
				}

				$forinstalls = array();
				if ( is_array( $data['forinstall'] ) && sizeof( $data['forinstall'] ) > 0 ) {
						foreach ( $data['forinstall'] as $template ) {
								$markdown = MExtension::markdown( 'template', $template );

								if ( $markdown && isset( $markdown['title'] ) ) {
										$forinstall = new stdClass();
										$forinstall->name = $template;
										$forinstall->title = $markdown['title'];

										$forinstall->text = '';
										$forinstall->text .= '<div style="float: left; margin-top: 12px; margin-bottom: 12px;"><img class="media-object" style="height: 120px; width: 180px;" src="../' . MExtension::thumbnail( $forinstall->name ) . '" alt="" /></div>';
										$forinstall->text .= '<div style="float: left; margin-top: 12px; margin-left: 12px;">';
												if ( isset( $markdown['version'] ) ) $forinstall->text .= '<div>Version: <code class="green">' . $markdown['version'] . '</code></div>';
												if ( isset( $markdown['description'] ) ) $forinstall->text .= '<div><p>&nbsp;</p><p>' . $markdown['description']. '</p></div>';
										$forinstall->text .= '</div>';
										$forinstall->text .= '<div style="clear: both;"></div>';

										$forinstalls[] = $forinstall;
								}
						}
				}

		?>

		<div style="float: left;"> 
				Installed: <span class="badge"><?php echo intval( ( sizeof( $data['installed'] ) - $missing ) ); ?></span> / 
				Awaiting for install: <span class="badge"><?php echo sizeof( $forinstalls ); ?></span> / 
				Missing: <span class="badge"><?php echo intval( $missing ); ?></span>
		</div>

		<button type="submit" class="btn btn-primary" name="template_uninstall" style="float: right;">Uninstall missing templates</button>

		<div style="clear: both;"></div>

		<?php if ( sizeof( $data['installed'] ) > 0 ): ?>

				<h4>Installed templates</h4>

				<?php

						MHTML::list_group( $data['installed'], 'title', array( 'Disable' => 'new MTemplate().disable( \'*[id]\' );', 'Enable' => 'new MTemplate().enable( \'*[id]\' );' ) );

				?>

		<?php endif; ?>

		<?php if ( sizeof( $forinstalls ) > 0 ): ?>

				<h4>Awaiting for install</h4>

				<?php

						MHTML::list_group( $forinstalls, 'title', array( 'Install' => 'new MTemplate().install( \'*[name]\' );' ) );

				?>

		<?php endif; ?>

		<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr( mapi_csrf_value() ); ?>" />

</form>