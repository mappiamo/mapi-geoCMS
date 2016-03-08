<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

define( 'APATH', dirname( __FILE__ ) );

$settings = APATH . '/settings.php';
$includes = APATH . '/includes.php';
$libraries = APATH . '/libraries.php';
$binaries = APATH . '/binaries.php';

if (!is_file($settings)) {
	$TheServerRoot = str_replace("/manager", "", rtrim(((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']), '/\\'));

	header("Location: " . $TheServerRoot . "/setup/index.php");
	die();
}


if ( ! is_file( $settings ) || ! is_readable( $settings ) ) die( 'M_ERROR (00110): A required file: settings.php is missing or not readable!' );
else include( $settings );

if ( is_file( $includes ) && is_readable( $includes ) ) include( $includes );
if ( ! class_exists( 'MINC' ) ) die( 'M_ERROR (00120): Includes loader is not reachable: File missing or not readable!' );

new MINC();

if ( is_file( $libraries ) && is_readable( $libraries ) ) include( $libraries );
if ( ! class_exists( 'MLIB' ) ) die( 'M_ERROR (00130): Library loader is not reachable: File missing or not readable!' );

new MLIB();

if ( is_file( $binaries ) && is_readable( $binaries ) ) include( $binaries );
if ( ! class_exists( 'MBIN' ) ) die( 'M_ERROR (00140): Binary loader is not reachable: File missing or not readable!' );

unset( $settings );
unset( $includes );
unset( $libraries );
unset( $binaries );

new MBIN();

$error_reporting = MObject::get( 'preference', 'force_php_errors_and_warnings' );
if ( 'yes' == $error_reporting->get_value() ) {
		error_reporting( E_ALL );
		ini_set( 'display_errors', 1 );
} else {
	ini_set( 'display_errors', 0 );
}

include( 'mappiamo.php' );

?>