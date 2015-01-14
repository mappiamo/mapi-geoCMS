<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_MWidget {

		static function get_widgets() {
				return mapi_list( 'widgets', array( 'env' => 'frontend' ) );
		}

		static function get_widget( $id ) {
				return ORM::for_table( 'widgets' )->find_one( intval( $id ) );
		}

		static function get_forinstall() {
				if ( ! defined( 'APATH' ) ) return null;

				$installed = mapi_list( 'installed_widgets', array( 'env' => 'frontend' ) );
				$for_install = array();

				$wdir = APATH . '/widgets/';
				$wdir_content = scandir( $wdir );

				if ( sizeof( $wdir_content ) > 0 ) {
						foreach ( $wdir_content as $inst_candidate ) {
								if ( ! in_array( $inst_candidate, $installed ) && MExtension::check_widget( $inst_candidate ) ) $for_install[] = $inst_candidate;
						}
				}

				return $for_install;
		}

		static function install_widget( $name ) {
				if ( ! MExtension::check_widget( $name ) ) return mapi_report_message( 'Not a valid widget.' );

				$markdown = MExtension::markdown( 'widget', $name );

				$widget = ORM::for_table( 'widgets' )->create();
				if ( $widget ) {
						$widget->name = strval( $name );
						$widget->title = strval( $markdown['title'] );
						$widget->version = strval( $markdown['version'] );
						if ( isset( $markdown['description'] ) ) $widget->description = $markdown['description'];
						$widget->enabled = 1;

						if ( $widget->save() ) {
								return mapi_report_message( 'Widget sucessfully installed.', 'success' );
						} else {
								return mapi_report_message( 'There was an error installing your widget.' );
						}
				}
		}

		static function uninstall_widgets() {
				$widgets = self::get_widgets();

				print "Widgets:<br />";
				print_r( $widgets );

				if ( sizeof( $widgets ) > 0 ) {
						foreach ( $widgets as $key => $value ) {
								$wid = self::get_widget( $key );

								if ( $wid ) {
										if ( ! MExtension::check_extension( 'widget', $wid->name ) ) $wid->delete();
								}
						}
				}
		}

		static function enable_widget( $id ) {
				$widget = self::get_widget( $id );

				if ( $widget ) {
						$widget->enabled = 1;
						$widget->save();
				}
		}

		static function disable_widget( $id ) {
				$widget = self::get_widget( $id );
				
				if ( $widget ) {
						$widget->enabled = 0;
						$widget->save();
				}
		}

}

?>