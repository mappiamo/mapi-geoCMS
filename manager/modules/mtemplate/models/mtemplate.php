<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_MTemplate {

		static function get_templates() {
				return mapi_list( 'templates', array( 'env' => 'frontend' ) );
		}

		static function get_template( $id ) {
				return ORM::for_table( 'templates' )->find_one( intval( $id ) );
		}

		static function get_forinstall() {
				if ( ! defined( 'APATH' ) ) return null;

				$installed = mapi_list( 'installed_templates', array( 'env' => 'frontend' ) );
				$for_install = array();

				$tdir = APATH . '/templates/';
				$tdir_content = scandir( $tdir );

				if ( sizeof( $tdir_content ) > 0 ) {
						foreach ( $tdir_content as $inst_candidate ) {
								if ( ! in_array( $inst_candidate, $installed ) && MExtension::check_template( $inst_candidate ) ) $for_install[] = $inst_candidate;
						}
				}

				return $for_install;
		}

		static function install_template( $name ) {
				if ( ! MExtension::check_template( $name ) ) return mapi_report_message( 'Not a valid template.' );

				$markdown = MExtension::markdown( 'template', $name );

				$template = ORM::for_table( 'templates' )->create();
				if ( $template ) {
						$template->name = strval( $name );
						$template->title = strval( $markdown['title'] );
						$template->version = strval( $markdown['version'] );
						if ( isset( $markdown['description'] ) ) $template->description = $markdown['description'];
						$template->enabled = 1;

						if ( $template->save() ) {
								return mapi_report_message( 'The template was sucessfully installed.', 'success' );
						} else {
								return mapi_report_message( 'There was an error installing your template.' );
						}
				}

				print_r( $module );
		}

		static function uninstall_templates() {
				$templates = self::get_templates();

				if ( sizeof( $templates ) > 0 ) {
						foreach ( $templates as $key => $value ) {
								$template = self::get_template( $key );

								if ( $template ) {
										if ( ! MExtension::check_extension( 'template', $template->name ) ) $template->delete();
								}
						}
				}
		}

		static function enable_template( $id ) {
				$template = self::get_template( $id );

				if ( $template ) {
						$template->enabled = 1;
						$template->save();
				}
		}

		static function disable_template( $id ) {
				$template = self::get_template( $id );
				
				if ( $template ) {
						$template->enabled = 0;
						$template->save();
				}
		}

}

?>