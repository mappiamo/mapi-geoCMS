<?php
/**
* @package	#mappiamo
* @version	0.0.6
* @author	Berross s.r.o. <hello@mappiamo.com>
* @copyright    Copyright (C) 2015 Berross s.r.o. All rights reserved.
* @license      GNU/GPL, see LICENSE
*
* #mappiamo is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT for copyright notices and CREDITS for credits details.
*/

header('Content-type: text/html; charset=utf-8');

session_start();

$rpath = substr( dirname( __FILE__ ), strlen( $_SERVER['DOCUMENT_ROOT'] ) );

// Defines
define( 'DACCESS', 1 );
define( 'RPATH', $rpath );
define( 'ENV', 'frontend' );

$geocoder = null;
$coords = array( 'lat' => 0, 'lng' => 0 );
$content = null;

if ( ! is_file( 'mappiamo.php' ) || ! is_readable( 'mappiamo.php' ) ) die;

if ( ! is_file( 'load.php' ) || ! is_readable( 'load.php' ) ) die( 'M_ERROR (00101): A required file: load.php is missing or not readable!' );
else include( 'load.php' );

?>
