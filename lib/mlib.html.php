<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

// !!! deprecated in future releases
class MHTML {

		static function breadcrumb( $crumbs ) {
				if ( ! is_array( $crumbs ) || ! sizeof( $crumbs ) > 0 ) return null;

				?>

						<div class="m-content-breadcrumb">
								<ol class="breadcrumb mapi-manager-breadcrumb">
										<?php if ( defined( 'ENV' ) && 'manager' == ENV ): ?>
												<li><a href="index.php">Dashboard</a></li>
										<?php else: ?>
												<li><a href="index.php">Home</a></li>
										<?php endif; ?>
										
										<?php foreach ( $crumbs as $crumb ): ?>
												<?php if ( isset( $crumb['title'] ) ): ?>
														<?php if ( isset( $crumb['link'] ) ): ?>
																<li><a href="<?php MPut::_link( $crumb['link'] ); ?>"><?php MPut::_html( $crumb['title'] ); ?></a></li>
														<?php else: ?>
																<li><?php MPut::_html( $crumb['title'] ); ?></li>
														<?php endif; ?>
												<?php endif; ?>
										<?php endforeach; ?>
								</ol>
						</div>

				<?php
		}

		static function list_group( $objects, $item, $actions = null ) {
				if ( ! is_array( $objects ) || ! sizeof( $objects ) > 0 ) return null;
				if ( ! $item || ! strlen( $item ) > 0 ) return null;

				echo '<ul class="list-group">';

				foreach ( $objects as $object ) {
						if ( isset( $object->{$item} ) ) {
								echo '<li class="list-group-item" >';
										if ( isset( $object->text ) ) echo '<h4 class="list-group-item-heading">';		

										echo MPut::text( $object->{$item} );
										if ( is_array( $actions ) && sizeof( $actions ) > 0 ) {
												foreach ( $actions as $key => $value ) {
														echo '<button type="button" class="btn btn-xs btn-action" onclick=' . MPut::js( self::action( $value, $object ) ) . ' style="float: right;">' . MPut::html( $key ) . '</button> ';
												}
										}

										if ( isset( $object->text ) ) echo '</h4>';	

										if ( isset( $object->text ) ) {
												echo '<p class="list-group-item-text">' . MPut::text( $object->text ) . '</p>';
										}
								echo '</li>';
						}
				}
				echo '</ul>';
		}

		static function link( $a, $link, $title = null, $onclick = null ) {
				$title = '';
				if ( $title && strlen( $title ) > 0 ) $title = ' title="' . MPut::html_attr( $title ) . '"';

				echo '<a href="' . MPut::link( $link ) . '"' . $title . '>' . MPut::html( $a ) . '</a>';
		}

		static function label( $title ) {
				echo '<label>' . MPut::html( $title ) . '</label>';
		}

		static function badge( $output ) {
				echo '<span class="badge">' . strip_tags( $output ) . '</span>';
		}

		static function binary( $output ) {
				if ( $output ) echo '<span style="display: none;">1</span><span class="glyphicon glyphicon-ok mapi-item-enabled"></span>';
				else echo '<span style="display: none;">0</span><span class="glyphicon glyphicon-remove mapi-item-disabled"></span>';
		}

		static function action( $command, $object ) {
				$action = 'return false';

				if ( ! strlen( $action ) ) return $action;
				if ( ! is_object( $object ) ) return $action;

				if ( method_exists( $object, 'as_array' ) ) $vars = $object->as_array();
				else $vars = get_object_vars( $object );

				if ( $vars ) {
						foreach ( $vars as $key => $value ) {
								$rep = '/\*\[' . $key . '\]/';
								if( preg_match( $rep, $command ) ) {
										$command = preg_replace( $rep , $value, $command );
								}
						}
				}

				return $command;
		}

}

?>