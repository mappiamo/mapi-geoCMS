<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MGet{

		static function int( $input, $method = null ) {
				$value = MGet::get( $input, $method );

				if ( $result = intval( $value ) ) return $result;
				else return null;
		}

		static function double( $input, $method = null ) {
				$value = MGet::get( $input, $method );

				if ( $result = doubleval( $value ) ) return $result;
				else return null;
		}

		static function string( $input, $method = null ) {
				$value = strval( MGet::get( $input, $method ) );

				if ( ! $value ) return null;

				$clean = MGet::remove_invisible( $value );

				if ( ! $clean ) return null;

				$forced_clean = MGet::force_utf8( $clean );

				if ( ! $forced_clean ) return null;

				return stripslashes( $forced_clean );
		}

		static function file() {
				if ( ! isset( $_FILES['file']['error'] ) || is_array( $_FILES['file']['error'] ) ) return null;

				if ( UPLOAD_ERR_OK != $_FILES['file']['error'] ) return null;

				$file = array();

				$file['name'] = self::sanitize_file( $_FILES['file']['name'] );
				$file['tmp'] = self::sanitize_file( $_FILES['file']['tmp_name'] );

				$file['size'] = $_FILES['file']['size'];

				return $file;
		}
	
		static function get( $input, $method = null ) {
				$value = null;

				if ( $method ) $method = strtoupper( $method );

				if ( $method && 'GET' == $method ) $value = $_GET[$input];
				if ( $method && 'POST' == $method ) $value = $_POST[$input];

				if ( ! $method ) {
					if ( isset( $_GET[$input] ) ) $value = $_GET[$input];
					if ( isset( $_POST[$input] ) ) $value = $_POST[$input];
				}

				return $value;
		}

		static function force_utf8( $value ) {
				if ( function_exists('iconv') ) return iconv( 'UTF-8', 'UTF-8//IGNORE', $value );
				else return $value;
		}

		static function remove_invisible( $value ) {
				return preg_replace( '#[\x00-\x08\x0B\x0C\x0E-\x1F]#', '', $value );
		}

		static function sanitize_file( $value ) {
				$removables = array(
						'../',
						'<!--',
						'-->',
						'<',
						'>',
						'\'',
						'"',
						'&',
						'$',
						'#',
						'{',
						'}',
						'[',
						']',
						'=',
						';',
						'?',
						"%20",
						"%22",
						"%3c",
						"%253c",
						"%3e",
						"%0e",
						"%28",
						"%29",
						"%2528",
						"%26",
						"%24",
						"%3f",
						"%3b",
						"%3d"
				);

				$file = self::remove_invisible( $value );
				return stripslashes( str_replace( $removables, '', $file ) );
		}

}

?>