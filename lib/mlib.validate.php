<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MValidate {
	
		static function id( $value ) {
				if ( ! ctype_digit( strval( $value ) ) ) return false;
				return MValidate::numeric( intval( $value ), 'POZITIVE_NOZERO' );
		}

		static function title( $value ) {
				if ( ! MValidate::string( $value ) ) return false;
				if ( preg_match( '/[^a-zA-Z0-9\'\"\-_!?.,:;(){}\[\]\@\#\$\%\&\*\/ ]/s', $value ) ) return false;

				return true;
		}

		static function address( $value ) {
				if ( ! MValidate::string( $value ) ) return false;
				if ( preg_match( '/[^a-zA-Z0-9\'\"\-.,:()\&\/ ]/s', $value ) ) return false;

				return true;
		}

		static function coord( $value ) {
				if ( ! MValidate::numeric( $value, 'NEGATIVE', 'BOTH' ) ) return false;
				if ( preg_match( '/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/' , $value ) ) return false;

				return true;
		}

		static function date( $value, $format = 'Y-m-d H:i:s' ) {
				if ( ! MValidate::string( $value ) ) return false;

				$date = DateTime::createFromFormat( $format, $value );
				
				if ( ! $date ) return false;
				if ( $date->format( $format ) != $value ) return false;

    			return true;
		}

		static function url( $value ) {
				if ( ! MValidate::string( $value ) ) return false;

				$domain = '([a-z]+([a-z0-9\-]*[a-z0-9])?\.)+[a-z]{2,}';
				$ip = '(?:(?:[01]?\d?\d|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d?\d|2[0-4]\d|25[0-5])';
				$host = '[a-z \:]+(?:[a-z0-9\-]*[a-z0-9]\.?|\.)*';

				if ( ! preg_match( '#^(https?://(' . $ip . '|' . $host . ')(?=/|$)|' . $domain . '(?=/|$)|/)#i', $value ) ) return false;

				return true;
		}

		static function sef_name( $value ) {
				if ( ! MValidate::string( $value ) && ! MValidate::id( $value ) ) return false;
				if ( preg_match( '/[^a-zA-Z0-9\-]/s', $value ) ) return false;

				return true;
		}

		static function meta_name( $value ) {
				if ( ! MValidate::string( $value ) ) return false;
				if ( preg_match( '/[^a-zA-Z0-9\'\"\-.,:()\&\/ ]/s', $value ) ) return false;

				return true;
		}

		static function meta_value( $value ) {
				if ( ! MValidate::string( $value ) ) return false;
				if ( preg_match( '/[^a-zA-Z0-9\'\"\-_!?.,:;(){}\[\]\@\#\$\%\&\*\/ ]/s', $value ) ) return false;

				return true;
		}

		static function pref_name( $value ) {
				if ( ! MValidate::string( $value ) ) return false;
				if ( preg_match( '/[^a-zA-Z0-9\-\_\.,:;]/s', $value ) ) return false;

				return true;
		}

		static function pref_value( $value ) {
				if ( ! MValidate::string( $value ) ) return false;
				if ( preg_match( '/[^a-zA-Z0-9\-\_\.,:;(){}\[\]\$\&\%\@\# ]/s', $value ) ) return false;

				return true;
		}

		static function ext_name( $value ) {
				if ( ! MValidate::string( $value ) ) return false;
				if ( preg_match( '/[^a-zA-Z0-9\-\_]/s', $value ) ) return false;

				return true;
		}

		static function task( $value ) {
				if ( ! MValidate::string( $value ) ) return false;
				if ( preg_match( '/[^a-zA-Z0-9\-\_]/s', $value ) ) return false;

				return true;
		}

		static function object( $value ) {
				if ( ! defined( 'ENV' ) ) return false;

				if ( 'manager' == ENV ) {
						return self::id( $value );
				} else {
						return self::sef_name( $value );
				}
		}

		static function varname( $value ) {
				if ( ! MValidate::string( $value ) ) return false;
				if ( ! preg_match( '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $value ) ) return false;

				return true;
		}

		static function username( $value ) {
				if ( ! MValidate::string( $value ) ) return false;
				if ( preg_match( '/[^a-zA-Z0-9\-\_\.\&]/s', $value ) ) return false;

				return true;
		}

		static function password( $value ) {
				if ( ! MValidate::string( $value ) ) return false;
				if ( ! strlen( $value ) >= 5 ) return false;
				if ( preg_match( '/[^a-zA-Z0-9\'\"\-_!?.,:;(){}\[\]\@\#\$\%\&\*\/ ]/s', $value ) ) return false;

				return true;
		}

		static function email( $value ) {
				if ( ! MValidate::string( $value ) ) return false;
				if ( ! preg_match( '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', $value ) ) return false;

				return true;
		}

		static function ip( $value ) {
				if ( ! MValidate::string( $value ) ) return false;

				$segments = explode( '.', $value );
				if ( sizeof( $segments ) != 4 ) return false;

				if ( $segments[0][0] == '0' ) return false;

				foreach ( $segments as $segment ) {
						if ( $segment == '' || strlen( $segment ) > 3 ) return false;
						if ( preg_match( '/[^0-9]/', $segment ) ) return false;
						if ( $segment > 255 ) return false;
				}

				return true;
		}

		static function string( $value ) {
				if ( ! isset( $value ) ) return false;
				if ( ! is_string( $value ) ) return false;
				
				return true;
		}

		static function numeric( $value, $neg = 'NEGATIVE', $type = 'INT' ) {
				if ( ! isset( $value ) ) return false;
				if ( ! is_numeric( $value ) ) return false;

				if ( 'BOTH' != $type )
						if ( 'INT' == $type && ! is_int( $value ) ) return false;
						if ( 'DOUBLE' == $type && ! is_double( $value ) ) return false;

				if ( 'POZITIVE_NOZERO' == $neg ) 
						if ( 1 > $value ) return false;
				if ( 'POZITIVE' == $neg )
						if ( 0 > $value ) return false ;
				if ( 'NEGATIVE_NOZERO' == $neg )
						if ( 0 == $value ) return false;

				return true;
		}

		static function between_numeric_range( $value, $start, $stop, $boundaries = 'ACCEPT_BOUNDARIES' ) {
				if ( ! isset( $value ) ) return false;
				if ( ! is_numeric( $value ) ) return false;

				if ( $start > $stop ) return false;

				if ( 'ACCEPT_BOUNDARIES' == $boundaries ) {
						if ( $start > $value || $stop < $value ) return false;
				} else {
						if ( $start >= $value || $stop <= $value ) return false;
				}

				return true;
		}

		static function oneof_this_numeric( $value, $collection ) {
				if ( ! isset( $value ) ) return false;
				if ( ! is_numeric( $value ) ) return false;

				if ( ! $collection || ! is_array( $collection ) || sizeof( $collection ) < 1 ) return false;

				foreach ( $collection as $item ) {
						if ( ! is_numeric( $item ) ) return false;
				}

				if ( ! in_array( $value, $collection ) ) return false;

				return true;
		}

		static function mime_type( $file, $allowed = array() ) {
				if ( ! is_file( $file ) ) return false;

				if ( 'image' == $allowed ) { 
						$requested = 'image';
						$allowed = array( 'image/jpeg', 'image/png', 'image/gif' );
				}

				if ( class_exists( 'finfo' ) ) {
						$finfo = new finfo( FILEINFO_MIME_TYPE );
						$mime = $finfo->file( $file );
				} elseif( 'image' == $requested ) {
						$imgs = getimagesize( $file );
						$mime = $imgs['mime'];
				} else {
						$mime = null;
				}

				if ( ! $mime ) return false;
			
				if ( ! in_array( $mime, $allowed ) ) return false;

				return true;
		}

		static function file_size( $value ) {
				if ( ! $size = intval( $value ) ) return false;

				if ( $size > '2097152' ) return false;

				return true;
		}

		static function is_ajax() {
				if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) return true;
				
				return false;
		}

}

?>