<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class M_Route {

	private $router;
	private $module = null;
	private $task = null;
	private $object = null;

	public function __construct() {
			if ( defined( 'ENV' ) && 'manager' == ENV ) $this->route( 'manager' );
			elseif ( defined( 'ENV' ) && 'frontend' == ENV ) $this->route( 'frontend' );
	}

	public function get_module() {
			return $this->module;
	}

	public function get_task() {
			return $this->task;
	}

	public function get_object() {
			return $this->object;
	}

	private function route( $env ) {
			$request = mapi_request();

			switch ( $env ) {
					case 'manager':
							if ( isset( $request['module'] ) ) $this->set_module( MGet::string( 'module' ) );
							if ( isset( $request['task'] ) ) $this->set_task( MGet::string( 'task' ) );
							if ( isset( $request['object'] ) ) $this->set_num_object_id( MGet::string( 'object' ) );
					break;
					case 'frontend':
							$routing = 'default';
							$pref = MObject::get( 'preference', 'routing' );
							
							if ( $pref && is_object( $pref ) && 'sef' == $pref->get_value() ) $routing = 'sef';

							// sef routing here
							if ( isset( $request['module'] ) ) $this->set_module( MGet::string( 'module' ) );
							if ( isset( $request['task'] ) ) $this->set_task( MGet::string( 'task' ) );
							if ( isset( $request['object'] ) ) $this->set_num_object_id( MGet::string( 'object' ) );
					break;
			}

			MAuth::init();

			if ( 'manager' == $env ) {
					if ( 'register' != $this->module ) {
							if ( 'login' != $this->module && ! MAuth::is_auth() ) 
									$this->reset_to( 'login' );
							elseif( 'login' == $this->module && MAuth::is_auth() && ! isset( $_POST['do-logout'] ) ) 
									$this->reset_to( 'dashboard' );
					} else {
							if ( MAuth::is_auth() ) $this->reset_to( 'dashboard' );
					}

					if ( 'login' != $this->module && 'register' != $this->module ) { 
							if ( ! MAuth::check_perm( self::$this->module, $this->task ) ) $this->reset_to( 'denied' );
					}
			}

	}

	private function set_module( $value ) {
			if ( $module = strval( $value ) ) $this->module = $module;
	}

	private function set_task( $value ) {
			if ( $task = strval( $value ) ) $this->task = $task;
	}

	private function set_num_object_id( $value ) {
			if ( $object = intval( $value ) ) $this->object = $object;
	}

	private function set_str_object_name( $value ) {
			if ( $object = strval( $value ) ) $this->object = $object;
	}

	private function reset_to( $what ) {
			$this->module = null;
			$this->task = null;
			$this->object = null;

			$this->set_module( $what );
	}

}

?>