<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MPut {

		static function numeric( $input ) {
				if ( is_numeric( self::preproc( $input ) ) ) return $input;
				else return 0;
		}

		static function _numeric( $input ) {
				echo self::numeric( $input );
		}

		static function id( $input ) {
				return self::numeric( $input );
		}

		static function _id( $input ) {
				echo self::id( $input );
		}

		static function title( $input ) {
				if ( ! $input ) return '';

				$output = self::preproc( $input );
				$output = preg_replace( '/[^a-zA-Z0-9\'\"\-_!?.,:;(){}\[\]\@\#\$\%\&\*\/ ]/s', '', $output );
				return htmlspecialchars( $output, ENT_COMPAT, 'UTF-8' );
		}

		static function _title( $input ) {
				echo self::title( $input );
		}

		static function address( $input ) {
				if ( ! $input ) return '';

				$output = self::preproc( $input );
				$output = preg_replace( '/[^a-zA-Z0-9\'\"\-.,:()\&\/ ]/s', '', $output );
				return htmlspecialchars( $output, ENT_COMPAT, 'UTF-8' );
		}

		static function _address( $input ) {
				echo self::address( $input );
		}

		static function text( $input ) {
				if ( ! $input ) return '';

				$output = self::preproc( $input );
				return MPurifier::clean( $output );
		}

		static function _text( $input ) {
				echo self::text( $input );
		}

		static function content( $input ) {
				return self::text( $input );
		}

		static function _content( $input ) {
				echo self::content( $input );
		}

		static function date_time( $input ) {
				if ( ! $input ) return '';

				$output = self::preproc( $input );
				$output = preg_replace( '/[^0-9\-\:]/s', '', $output );
				return htmlspecialchars( $output, ENT_COMPAT, 'UTF-8' );
		}

		static function _date_time( $input ) {
				echo self::date_time( $input );
		}

		static function sef_name( $input ) {
				if ( ! $input ) return '';

				$output = self::preproc( $input );
				$output = preg_replace( '/[^a-zA-Z0-9\-]/s', '', $output );
				return htmlspecialchars( $output, ENT_COMPAT, 'UTF-8' );
		}

		static function _sef_name( $input ) {
				echo self::sef_name( $input );
		}

		static function html( $input ) {
				if ( ! $input ) return '';

				$output = self::preproc( $input );
				return htmlspecialchars( $output, ENT_COMPAT, 'UTF-8' );
		}

		static function _html( $input ) {
				echo self::html( $input );
		}

		static function html_name( $input ) {
				if ( ! $input ) return '';

				$output = self::preproc( $input );
				$output = preg_replace( '/[^A-Za-z0-9_-]/', '', $output );
				return htmlspecialchars( $output, ENT_COMPAT, 'UTF-8' );
		}

		static function _html_name( $input ) {
				echo self::html_name( $input );
		}

		static function html_class( $input ) {
				return self::html_name( $input );
		}

		static function _html_class( $input ) {
				echo self::html_class( $input );
		}

		static function html_id( $input ) {
				return self::html_class( $input );
		}

		static function _html_id( $input ) {
				echo self::html_id( $input );
		}

		static function html_attr( $input ) {
				if ( ! $input ) return '';

				$output = self::preproc( $input );
				$output = strip_tags( $output );
				return htmlspecialchars( $output, ENT_COMPAT, 'UTF-8' );
		}

		static function _html_attr( $input ) {
				echo self::html_attr( $input );
		}

		static function css( $input ) {
				// to be implemented
				return $input;
		}

		static function _css( $input ) {
				echo self::css( $input );
		}

		static function js( $input ) {
				if ( ! $input ) return '';

				$output = self::preproc( $input );
				$output = preg_replace( '/&#(x)?0*(?(1)27|39);?/i', '', stripslashes( $output ) );
				$output = str_replace( "\r", '', $output );
				$output = str_replace( "\n", '\\n', $output );

				return json_encode( $output );
		}

		static function _js( $input ) {
				echo self::js( $input );
		}

		static function link( $input ) {
				return self::html( $input );
		}

		static function _link( $input ) {
				echo self::link( $input );
		}

		static function url( $input ) {
				return rawurlencode( $input );
		}

		static function _url( $input ) {
				echo self::url( $input );
		}

		static function preproc( $input ) {
				if ( ! $input ) return '';
				
				$output = self::remove_invisible( $input );
				return self::force_utf8( $output );
		}

		static function remove_invisible( $input ) {
				return MGet::remove_invisible( $input );
		}

		static function force_utf8( $input ) {
				return MGet::force_utf8( $input );
		}

}

?>