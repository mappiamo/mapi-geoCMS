<?php

	error_reporting( E_ALL );
	ini_set( 'display_errors', 0 );

	define( 'DACCESS', 1 );

	define( 'APATH', dirname( __FILE__ ) );

	$settings = APATH . '/../../../../settings.php';
	$idiorm_lib = APATH . '/../../../../lib/idiorm/idiorm.php';

	if ( ! is_file( $settings ) || ! is_readable( $settings ) ) die( 'M_ERROR (00110): A required file: settings.php is missing or not readable!' );
	else include( $settings );

	if ( ! is_file( $idiorm_lib ) || ! is_readable( $idiorm_lib ) ) die( 'M_ERROR (00111): A required file: idiorm.php is missing or not readable!' );
	else include( $idiorm_lib );

	ORM::configure('mysql:host=' . MSettings::$db_host . ';dbname=' . MSettings::$db);
	ORM::configure('username', MSettings::$db_user);
	ORM::configure('password', MSettings::$db_pass);
	ORM::configure('return_result_sets', true); // returns result sets
	ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

	$string = strtolower($_GET["q"]);
	if (!$string) return;

	$TheData = ORM::for_table('contents')->distinct()->select('address')->where_like('address', '%'.$string.'%')->limit(20)->order_by_expr('CHAR_LENGTH(`address`)')->find_array();

	foreach ($TheData as $key => $value) {
		$cname = $value['address'];
		echo "$cname\n";
	}
?>