<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_MModule {

		static function get_modules() {
				return mapi_list( 'modules', array( 'env' => 'frontend' ) );
		}

		static function get_module( $id ) {
				return ORM::for_table( 'modules' )->find_one( intval( $id ) );
		}

		static function get_forinstall() {
				if ( ! defined( 'APATH' ) ) return null;

				$installed = mapi_list( 'installed_modules', array( 'env' => 'frontend' ) );
				$for_install = array();

				$mdir = APATH . '/modules/';
				$mdir_content = scandir( $mdir );

				if ( sizeof( $mdir_content ) > 0 ) {
						foreach ( $mdir_content as $inst_candidate ) {
								if ( ! in_array( $inst_candidate, $installed ) && MExtension::check_module( $inst_candidate ) ) $for_install[] = $inst_candidate;
						}
				}

				return $for_install;
		}

		static function install_module( $name ) {
				if ( ! MExtension::check_module( $name ) ) return mapi_report_message( 'Not a valid module.' );

				$markdown = MExtension::markdown( 'module', $name );

				$module = ORM::for_table( 'modules' )->create();
				if ( $module ) {
						$module->name = strval( $name );
						$module->title = strval( $markdown['title'] );
						$module->version = strval( $markdown['version'] );
						if ( isset( $markdown['description'] ) ) $module->description = $markdown['description'];
						$module->enabled = 1;

						if ( $module->save() ) {
								return mapi_report_message( 'Module sucessfully installed.', 'success' );
						} else {
								return mapi_report_message( 'There was an error installing your module.' );
						}
				}

				print_r( $module );
		}

		static function uninstall_modules() {
				$modules = self::get_modules();

				if ( sizeof( $modules ) > 0 ) {
						foreach ( $modules as $key => $value ) {
								$mod = self::get_module( $key );

								if ( $mod ) {
										if ( ! MExtension::check_extension( 'module', $mod->name ) ) $mod->delete();
								}
						}
				}
		}

		static function enable_module( $id ) {
				$module = self::get_module( $id );

				if ( $module ) {
						$module->enabled = 1;
						$module->save();
				}
		}

		static function disable_module( $id ) {
				$module = self::get_module( $id );
				
				if ( $module ) {
						$module->enabled = 0;
						$module->save();
				}
		}

}

?>