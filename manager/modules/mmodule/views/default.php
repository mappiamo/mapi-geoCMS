<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-hdd"></span> Modules list</h3>
</div>

<?php 
		$crumbs = array(
				'modules'	=> array( 'title' => 'Modules' )
		);
?>

<?php MHTML::breadcrumb( $crumbs ); ?>

<?php MMessaging::show(); ?>

<form method="post" action="index.php?module=mmodule&task=module_uninstall">

		<?php

				$missing = MExtension::calculate_missing( 'module' );

				if ( is_array( $data['installed'] ) && sizeof( $data['installed'] ) > 0 ) {
						foreach ( $data['installed'] as $module ) {
								if ( is_object( $module ) ) {
										$module->text = '';
										if ( isset( $module->version ) ) $module->text .= '<div>Version: <code class="green">' . $module->version . '</code></div>';
										if ( ! MExtension::check_extension( 'module', $module->name ) ) $module->text .= '<div>Status: <code>Missing</code></div>';
										elseif ( 1 == $module->enabled ) $module->text .= '<div>Status: <code class="green">Enabled</code></div>';
										else $module->text .= '<div>Status: <code>Disabled</code></div>';
										if ( isset( $module->description ) ) $module->text .= '<div><p>&nbsp;</p><p>' . $module->description . '</p></div>';
								}
						}
				}

				$forinstalls = array();
				if ( is_array( $data['forinstall'] ) && sizeof( $data['forinstall'] ) > 0 ) {
						foreach ( $data['forinstall'] as $module ) {
								$markdown = MExtension::markdown( 'module', $module );

								if ( $markdown && isset( $markdown['title'] ) ) {
										$forinstall = new stdClass();
										$forinstall->name = $module;
										$forinstall->title = $markdown['title'];

										$forinstall->text = '';
										if ( isset( $markdown['version'] ) ) $forinstall->text .= '<div>Version: <code class="green">' . $markdown['version'] . '</code></div>';
										if ( isset( $markdown['description'] ) ) $forinstall->text .= '<div><p>&nbsp;</p><p>' . $markdown['description']. '</p></div>';

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

		<button type="submit" class="btn btn-primary" name="module_uninstall" style="float: right;">Uninstall missing modules</button>

		<div style="clear: both;"></div>

		<?php if ( sizeof( $data['installed'] ) > 0 ): ?>

				<h4>Installed modules</h4>

				<?php

						MHTML::list_group( $data['installed'], 'title', array( 'Disable' => 'new MModule().disable( \'*[id]\' );', 'Enable' => 'new MModule().enable( \'*[id]\' );' ) );

				?>

		<?php endif; ?>

		<?php if ( sizeof( $forinstalls ) > 0 ): ?>

				<h4>Awaiting for install</h4>

				<?php

						MHTML::list_group( $forinstalls, 'title', array( 'Install' => 'new MModule().install( \'*[name]\' );' ) );

				?>

		<?php endif; ?>

		<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr( mapi_csrf_value() ); ?>" />

</form>