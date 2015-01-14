<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MAuth extends MVisit {

		static private $auth = false;
		static private $user;
		static private $user_id;
		static private $group;
		static private $group_id;
		static private $msession;

		static $remember = false;

		static private $perms;

		private function __construct() {

		}

		static function init() {
				parent::init();

				self::check_auth();
				self::setup_perms();
		}

		static function user() {
				return self::$user;
		}

		static function user_id() {
				return self::$user_id;
		}

		static function group() {
				return self::$group;
		}

		static function group_id() {
				return self::$group_id;
		}

		static function is_auth() {
				return self::$auth;	
		}

		static function do_login() {
				if ( ! self::cookie_support() ) return null;

				$current_visitor = self::details();
				if ( ! isset( $current_visitor['ip'] ) || ! isset( $current_visitor['browser'] ) ) return null;

				$user = new M_User( MGet::string( 'user' ), true );

				if ( $user && $user->is_enabled() && $user->compare_pass( MGet::string( 'pass' ) ) ) {
						if ( strlen( $user->get_username() ) > 0 ) $username = $user->get_username();
						else return null;

						$msession = mapi_random( 24 );
						
						$time = date_format( new DateTime( 'now' ), 'Y-m-d H:i:s' );
						$rand = $username . ' ' . $msession;

						self::send_auth_cookie( $rand, $time, $current_visitor['browser'] );

						$user->update_lastlogin( $rand, $time, $current_visitor['browser'] );

						header( 'Location: ' . $_SERVER['REQUEST_URI'] );
						exit( 0 );
				}

				mapi_report_message( 'Invalid username/password.', 'error' );
		}

		static function do_logout() {
				self::$auth = false;
				self::$user = null;
				self::$user_id = null;
				self::$group = null;
				self::$group_id = null;
				self::$msession = null;

				setcookie( 'mpmi_r', '', time() - 3600 );
				setcookie( 'mpmi_t', '', time() - 3600 );
				setcookie( 'mpmi_b', '', time() - 3600 );
		}

		static private function send_auth_cookie( $rand, $time = '', $browser = '') {
				if ( empty( $time ) || empty( $browser ) ) return false;

				if ( self::$remember ) $timeout = 60 * 60 * 24 * 7;
				else $timeout = 60 * 60;

				$cookie_of_rand = MCrypt::encrypt( $rand );
				$cookie_of_time = MCrypt::encrypt( $time );
				$cookie_of_browser = MCrypt::encrypt( $browser );

				setcookie( 'mpmi_r', $cookie_of_rand, time() + $timeout );
				setcookie( 'mpmi_t', $cookie_of_time, time() + $timeout );
				setcookie( 'mpmi_b', $cookie_of_browser, time() + $timeout );
		}

		static private function check_auth() {
				if ( ! sizeof( $_COOKIE ) > 0 ) return null;

				if ( ! isset( $_COOKIE['mpmi_r'] ) ) return null;
				if ( ! isset( $_COOKIE['mpmi_t'] ) ) return null;
				if ( ! isset( $_COOKIE['mpmi_b'] ) ) return null ;

				$cookie_of_rand = MCrypt::decrypt( $_COOKIE['mpmi_r'] );
				$cookie_of_time = MCrypt::decrypt( $_COOKIE['mpmi_t'] );
				$cookie_of_browser = MCrypt::decrypt( $_COOKIE['mpmi_b'] );

				$rand_array = explode( ' ', $cookie_of_rand );

				$user = new M_User( $rand_array[0], true );

				if ( $user ) {
						if ( $user->compare_lastlogin( $cookie_of_rand, $cookie_of_time, $cookie_of_browser ) ) {
								self::$auth = true;
								self::$user = $user->get_username();
								self::$user_id = $user->get_id();
								self::$group_id = $user->get_group_id();
						}
				}
		}

		static function check_perm( $module, $task = null ) {
				$permitted = true;

				if ( ! self::$group_id ) return false;

				if ( ! isset( self::$perms[$module] ) ) return $permitted;

				if ( ! isset( self::$perms[$module]['min'] ) ) return $permitted;

				if ( self::$group_id > self::$perms[$module]['min'] ) $permitted = false;

				if ( $task && isset( self::$perms[$module]['tasks'][$task] ) ) {
						if ( self::$group_id > self::$perms[$module]['tasks'][$task] ) $permitted = false;
				}

				return $permitted;
		}

		static private function setup_perms() {
				self::$perms = array(
						'dashboard'	=> array(
								'min' => 3
						),
						'mcontent' 	=> array(
								'min' => 3
						),
						'mcategory' => array(
								'min' => 3
						),
						'mpage' => array(
								'min' => 2
						),
						'mmenu' => array(
								'min' => 2
						),
						'mmodule' => array(
								'min' => 1
						),
						'mtemplate' => array(
								'min' => 1
						),
						'mwidget' => array(
								'min' => 1
						),
						'muser' => array(
								'min' => 1
						),
						'preferences' => array(
								'min' => 1
						),
						'majax' => array(
								'min' => 3
						)
				);
		}
}

?>