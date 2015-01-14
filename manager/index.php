<?php

header('Content-type: text/html; charset=utf-8');

session_start();

$rpath = substr( dirname( __FILE__ ), strlen( $_SERVER['DOCUMENT_ROOT'] ) );

// Defines
define( 'DACCESS', 1 );
define( 'RPATH', $rpath );
define( 'ENV', 'manager' );

$geocoder = null;
$coords = array( 'lat' => 40.36329, 'lng' => 18.17278 );

if ( ! is_file( 'mappiamo.php' ) || ! is_readable( 'mappiamo.php' ) ) die;

if ( ! is_file( '../load.php' ) || ! is_readable( '../load.php' ) ) die( 'M_ERROR (00101): A required file: load.php is missing or not readable!' );
else include( '../load.php' );

?>