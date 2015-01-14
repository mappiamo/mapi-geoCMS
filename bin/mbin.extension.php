<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MExtension {

		static $types = array( 'module', 'template', 'widget' );

		static function get_extensions( $type ) {
				$extensions = array();

				if ( ! in_array( $type, self::$types ) ) return $extensions;

				switch ( $type ) {
						case 'module': $extensions = mapi_list( 'installed_modules', array( 'env' => 'frontend' ) ); break;
						case 'template': $extensions = mapi_list( 'installed_templates', array( 'env' => 'frontend' ) ); break;
						case 'widget': $extensions = mapi_list( 'installed_widgets', array( 'env' => 'frontend' ) ); break;
				}

				return $extensions;
		}

		static function check_extension( $type, $name ) {
				if ( ! $type || ! in_array( $type, self::$types ) ) return false;

				if ( ! MValidate::ext_name( $name ) ) return false;

				$pass = true;

				switch ( $type ) {
						case 'module': $pass = self::check_module( $name ); break;
						case 'template': $pass = self::check_template( $name ); break;
						case 'widget': $pass = self::check_widget( $name ); break;
				}

				return $pass;
		}

		static function check_module( $module ) {
				if ( ! MValidate::ext_name( $module ) ) return false;

				if ( ! mapi_include_abs_path( $module, 'modules/' . $module ) ) return false;

				$module_class = 'MModule_' . $module;

				if ( ! class_exists( $module_class ) ) return false;
				if ( ! method_exists( $module_class, $module ) ) return false;

				$markdown = self::markdown( 'module', $module );

				if ( ! isset( $markdown['title'] ) || ! strlen( $markdown['title'] ) > 1 ) return false;
				if ( ! isset( $markdown['version'] ) || ! strlen( $markdown['version'] ) > 0 ) return false;

				return true;
		}

		static function check_template( $template ) {
				if ( ! MValidate::ext_name( $template ) ) return false;

				if ( ! mapi_abs_path( $template . ':head', 'templates' ) ) return false;
				if ( ! mapi_abs_path( $template . ':body', 'templates' ) ) return false;
				if ( ! mapi_abs_path( $template . ':foot', 'templates' ) ) return false;

				$markdown = self::markdown( 'template', $template );

				if ( ! isset( $markdown['title'] ) || ! strlen( $markdown['title'] ) > 1 ) return false;
				if ( ! isset( $markdown['version'] ) || ! strlen( $markdown['version'] ) > 0 ) return false;

				return true;
		}

		static function check_widget( $widget ) {
				if ( ! MValidate::ext_name( $widget ) ) return false;

				if ( ! mapi_include_abs_path( $widget, 'widgets/' . $widget ) ) return false;

				$widget_function = 'mwidget_' . strtolower( $widget );

				if ( ! function_exists( $widget_function ) ) return false;

				$markdown = self::markdown( 'widget', $widget );

				if ( ! isset( $markdown['title'] ) || ! strlen( $markdown['title'] ) > 1 ) return false;
				if ( ! isset( $markdown['version'] ) || ! strlen( $markdown['version'] ) > 0 ) return false;

				return true;
		}

		static function markdown( $type, $name ) {
				$markdown = array();

				if ( ! in_array( $type, self::$types ) ) return $markdown;

				$path = APATH . '/' . $type . 's/' . $name . '/' . $name . '.md';

				if ( ! mapi_check_path( $path ) ) return $markdown;

				$result = Parsedown::instance()->parse( file_get_contents( $path ) );

				if ( ! strlen( $result ) ) return null;

				$title = mapi_html_elements_val( $result, 'h1' );
				if ( isset( $title[0] ) && strlen( $title[0] ) > 1 ) $markdown['title'] = $title[0];

				$version = mapi_html_elements_val( $result, 'h2' );
				if ( isset( $version[0] ) && strlen( $version[0] ) > 1 ) $markdown['version'] = $version[0];

				$description = mapi_html_elements_val( $result, 'p' );
				if ( isset( $description[0] ) && strlen( $description[0] ) > 0 ) $markdown['description'] = $description[0];

				return $markdown;
		}

		static function thumbnail( $template ) {
				$thumbnail = 'media/images/notfound.png';

				if ( ! defined( 'APATH' ) ) return $thumbnail;

				if ( realpath( APATH . '/templates/' . $template .'/' . $template . '.jpg' ) ) $thumbnail = 'templates/' . $template . '/' . $template . '.jpg';

				return $thumbnail;
		}
	
		static function calculate_missing( $type ) {
				$extensions = self::get_extensions( $type );

				$missing = 0;

				if ( $extensions && sizeof( $extensions ) > 0 ) {
						foreach ( $extensions as $extension ) {
								if ( ! self::check_extension( $type, $extension ) ) $missing++;
						}
				}

				return $missing;
		}

}

?>