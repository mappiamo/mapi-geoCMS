<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MVisit {

		static private $visitor = array();

		private function __construct () {

		}

		static function init() {
				if ( ! sizeof( self::$visitor ) > 0 ) {
						self::test_cookie();

						self::get_ip();
						self::get_browser();
						self::get_referrer();
				}
		}

		static function details() {
				return self::$visitor;
		}

		static function cookie_support() {
				if ( isset( self::$visitor['cookies'] ) ) return self::$visitor['cookies'];

				return false;
		}

		static private function get_ip() {
				$ip = null;

				if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) $ip = $_SERVER['HTTP_CLIENT_IP'];
				elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				else $ip = $_SERVER['REMOTE_ADDR'];

				if ( ! MValidate::ip( $ip ) ) $ip = null;

				self::$visitor['ip'] = $ip;
		}

		static private function get_browser() {
				$browser = null;

				if ( ! empty( $_SERVER['HTTP_USER_AGENT'] ) ) $browser = $_SERVER['HTTP_USER_AGENT'];

				self::$visitor['browser'] = MPut::text( $browser );
		}

		static private function get_referrer() {
				$referrer = null;

				if ( ! empty( $_SERVER['HTTP_REFERER'] ) ) $referrer = $_SERVER['HTTP_REFERER'];

				self::$visitor['referrer'] = $referrer;
		}

		static private function test_cookie() {
				self::$visitor['cookies'] = false;

				if ( ! empty( $_COOKIE['mapi_test'] ) && '#mappiamo' == $_COOKIE['mapi_test'] ) self::$visitor['cookies'] = true;
				else setcookie( 'mapi_test', '#mappiamo', time() + 3600 );
		}

}

?>