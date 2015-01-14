<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mapi_include_abs_path( $path, $prefix = null ) {
        $path = mapi_abs_path( $path, $prefix );

        if ( ! $path ) return null;

        if ( ! is_file( $path ) ) return null;

        if ( ! is_readable( $path ) ) return null;

        include_once( $path );

        return true;
}

function mapi_abs_path( $path, $prefix = null ) {
        if ( ! $path ) return null;

       	$path = stripslashes( preg_replace( '/\//', '', $path ) );
       	$path = preg_replace( '/\:/' , '/', $path );

        if ( $prefix && strlen( $prefix ) > 0 ) $path = APATH . '/' . $prefix . '/' . $path . '.php';
        else $path = APATH . '/' . $path . '.php';

        $path = realpath( $path );

        if ( mapi_check_path( $path ) ) return $path;
        else return null;
}

function mapi_check_path( $path ) {
        if ( ! defined( 'APATH' ) ) return false;

        $path = realpath( $path );

        if ( strpos( $path, APATH ) === false ) return false;
        else return true;
}

?>