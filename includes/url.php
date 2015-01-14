<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mapi_url_current() {
		$curr_url = array(
				'protocol' 	=> 'http', 
				'port' 		=> '80',
				'host'		=> '',
				'request'	=> ''
		);

 		if ( isset( $_SERVER['HTTPS'] ) && 'on' == $_SERVER['HTTPS'] ) $curr_url['protocol'] = 'https';

 		if ( '80' != $_SERVER['SERVER_PORT'] ) $curr_url['port'] = intval( $_SERVER['SERVER_PORT'] );

 		if ( isset( $_SERVER['SERVER_NAME'] ) ) $curr_url['host'] = strval( $_SERVER['SERVER_NAME'] );

 		if ( isset( $_SERVER['REQUEST_URI'] ) ) $curr_url['request'] = strval( $_SERVER['REQUEST_URI'] );

 		return $curr_url;
}

function mapi_install_url() {
		$mapi_install_url = '';

		$rpath = preg_replace( '/\/manager/', '', RPATH );

		$url = mapi_url_current();

		$mapi_install_url .= $url['protocol'] . '://';
		$mapi_install_url .= $url['host'] . '';
		if ( '80' != $url['port'] ) $mapi_install_url .= ':' . $url['port'];
		if ( strlen( $rpath ) > 0 ) $mapi_install_url .= $rpath;

		return $mapi_install_url . '/';
}

function mapi_request() {
		$curr_req = array(
				'module' 	=> '',
				'task'	 	=> '',
				'object'	=> ''
		);

		if ( isset( $_GET['module'] ) ) $curr_req['module'] = $_GET['module'];
		if ( isset( $_GET['task'] ) ) $curr_req['task'] = $_GET['task'];
		if ( isset( $_GET['object'] ) ) $curr_req['object'] = $_GET['object'];

		return $curr_req;
}

function mapi_sef_request() {
		$curr_req = array(
				'module' 	=> '',
				'task'	 	=> '',
				'object'	=> '',
				'file'		=> ''
		);

		if ( ! defined( 'RPATH' ) || ! isset( $_SERVER['REQUEST_URI'] ) ) return $curr_req;

		$request_uri = substr( $_SERVER['REQUEST_URI'] ,  strlen( RPATH ) );
		$request_uri = trim( $request_uri, '/' );

		if ( ! preg_match( '/\//' , $request_uri ) ) return $curr_req;

		$elements = explode( '/' , $request_uri );

		if ( isset( $elements[0] ) && preg_match( '/\./' ,  $elements[0] ) ) {
				$curr_req['file'] = $elements[0];
				array_splice( $elements, 0, 1);
		}

		if ( isset( $elements[0] ) ) $curr_req['module'] = $elements[0];
		if ( isset( $elements[1] ) ) $curr_req['task'] = $elements[1];
		if ( isset( $elements[2] ) ) $curr_req['object'] = $elements[2];

		return $curr_req;
}

?>