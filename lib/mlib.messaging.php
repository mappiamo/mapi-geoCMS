<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MMessaging {

		static $messenger = null;
		static $errors = array();
		static $warnings = array();
		static $success = array();
		static $available_elements = array( 'div', 'p', 'span' );

		public function __construct() { }

		static function init() {
				if ( ! self::$messenger ) {
						if ( isset( $_SESSION['m_messaging']['errors'] ) ) self::$errors = $_SESSION['m_messaging']['errors'];
						if ( isset( $_SESSION['m_messaging']['warnings'] ) ) self::$warnings = $_SESSION['m_messaging']['warnings'];
						if ( isset( $_SESSION['m_messaging']['success'] ) ) self::$success = $_SESSION['m_messaging']['success'];
						self::$messenger = array( self::$errors, self::$warnings, self::$success );
				}
		}

		static function add( $message, $type = 'errors' ) {
				switch ( $type ) {
						case 'errors': self::add_error( $message ); break;
						case 'warnings': self::add_warning( $message ); break;
						case 'success': self::add_success( $message ); break;
						default: self::add_error( $message ); break;
				}
		}

		static function add_error( $message ) {
				if ( $message ) self::$errors[] = strval( $message );
				self::save_to_session( );
		}

		static function add_warning( $message ) {
				if ( $message ) self::$warnings[] = strval( $message );
				self::save_to_session( );
		}

		static function add_success( $message ) {
				if ( $message ) self::$success[] = strval( $message );
				self::save_to_session( );
		}

		static function any( $detailed = false ) {
				if ( ! $detailed ) return sizeof( self::$errors ) + sizeof( self::$warnings ) + sizeof( self::$success );

				return array( 'errors' => sizeof( self::$errors ), 'warnings' => sizeof( self::$warnings ), 'success' => sizeof( self::$success ) );
		}

		static function any_errors() {
				return sizeof( self::$errors );
		}

		static function any_warnings() {
				return sizeof( self::$warnings );
		}

		static function any_success() {
				return sizeof( self::$success );
		}

		static function show( $type = 'all', $element = 'div' ) {
				if ( ! $element || ! in_array( $element , self::$available_elements ) ) $element = 'div';

				if ( ! self::any() > 0 ) return null;

				echo '<div class="m-messaging">';

				switch ( $type ) {
						case 'all':
								if ( self::any_errors() > 0 ) {
										foreach (self::$errors as $error) {
												echo '<' . $element . ' class="alert alert-danger">' . MPut::html( $error ) . '</' . $element . '>';
										}
								}
								if ( self::any_warnings() > 0 ) {
										foreach (self::$warnings as $warning) {
												echo '<' . $element . ' class="alert alert-warning">' . MPut::html( $warning ) . '</' . $element . '>';
										}
								}
								if ( self::any_success() > 0 ) {
										foreach (self::$success as $succ) {
												echo '<' . $element . ' class="alert alert-success">' . MPut::html( $succ ) . '</' . $element . '>';
										}
								}
								self::clear_from_session();
						break;
						
						case 'errors':
								if ( self::any_errors() > 0 ) {
										foreach (self::$errors as $error) {
												echo '<' . $element . ' class="alert alert-danger">' . MPut::html( $error ) . '</' . $element . '>';
										}
								}
								self::clear_from_session( 'errors' );
						break;
						
						case 'warnings':
								if ( self::any_warnings() > 0 ) {
										foreach (self::$warnings as $warning) {
												echo '<' . $element . ' class="alert alert-warning">' . MPut::html( $warning ) . '</' . $element . '>';
										}
								}
								self::clear_from_session( 'warnings' );
						break;
						
						case 'success':
								if ( self::any_success() > 0 ) {
										foreach (self::$success as $succ) {
												echo '<' . $element . ' class="alert alert-success">' . MPut::html( $succ ) . '</' . $element . '>';
										}
								}
								self::clear_from_session( 'success' );
						break;
				}

				echo '</div>';
		}

		static function save_to_session() {
				$_SESSION['m_messaging']['errors'] = self::$errors;
				$_SESSION['m_messaging']['warnings'] = self::$warnings;
				$_SESSION['m_messaging']['success'] = self::$success;
		}

		static function clear() {
				self::$errors = array();
				self::$warnings = array();
				self::$success = array();

				self::clear_from_session();
		}

		static function clear_from_session( $type = 'all' ) {
				switch ( $type ) {
						case 'all':
								unset( $_SESSION['m_messaging']['errors'] );
								unset( $_SESSION['m_messaging']['warnings'] );
								unset( $_SESSION['m_messaging']['success'] );
						break;
						case 'errors':
								unset( $_SESSION['m_messaging']['errors'] );
						break;
						case 'warnings':
								unset( $_SESSION['m_messaging']['warnings'] );
						break;
						case 'success':
								unset( $_SESSION['m_messaging']['success'] );
						break;
				}
		}

}

?>