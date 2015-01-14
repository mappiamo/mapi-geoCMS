<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="m-content-header">
		<h3 class="hidden-xs hidden-sm"><span class="glyphicon glyphicon-th-large"></span> Widgets list</h3>
</div>

<?php 
		$crumbs = array(
				'widgets'	=> array( 'title' => 'Widgets' )
		);
?>

<?php MHTML::breadcrumb( $crumbs ); ?>

<?php MMessaging::show(); ?>

<form method="post" action="index.php?module=mwidget&task=widget_uninstall">

		<?php

				$missing = MExtension::calculate_missing( 'widget' );

				if ( is_array( $data['installed'] ) && sizeof( $data['installed'] ) > 0 ) {
						foreach ( $data['installed'] as $widget ) {
								if ( is_object( $widget ) ) {
										$widget->text = '';
										if ( isset( $widget->version ) ) $widget->text .= '<div>Version: <code class="green">' . $widget->version . '</code></div>';
										if ( ! MExtension::check_extension( 'widget', $widget->name ) ) $widget->text .= '<div>Status: <code>Missing</code></div>';
										elseif ( 1 == $widget->enabled ) $widget->text .= '<div>Status: <code class="green">Enabled</code></div>';
										else $widget->text .= '<div>Status: <code>Disabled</code></div>';
										if ( isset( $widget->description ) ) $widget->text .= '<div><p>&nbsp;</p><p>' . $widget->description . '</p></div>';
								}
						}
				}

				$forinstalls = array();
				if ( is_array( $data['forinstall'] ) && sizeof( $data['forinstall'] ) > 0 ) {
						foreach ( $data['forinstall'] as $widget ) {
								$markdown = MExtension::markdown( 'widget', $widget );

								if ( $markdown && isset( $markdown['title'] ) ) {
										$forinstall = new stdClass();
										$forinstall->name = $widget;
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

		<button type="submit" class="btn btn-primary" name="widget_uninstall" style="float: right;">Uninstall missing widgets</button>

		<div style="clear: both;"></div>

		<?php if ( sizeof( $data['installed'] ) > 0 ): ?>

				<h4>Installed widgets</h4>

				<?php

						MHTML::list_group( $data['installed'], 'title', array( 'Disable' => 'new MWidget().disable( \'*[id]\' );', 'Enable' => 'new MWidget().enable( \'*[id]\' );' ) );

				?>

		<?php endif; ?>

		<?php if ( sizeof( $forinstalls ) > 0 ): ?>

				<h4>Awaiting for install</h4>

				<?php

						MHTML::list_group( $forinstalls, 'title', array( 'Install' => 'new MWidget().install( \'*[name]\' );' ) );

				?>

		<?php endif; ?>

		<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr( mapi_csrf_value() ); ?>" />

</form>