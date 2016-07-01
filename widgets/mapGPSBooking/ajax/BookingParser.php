<?php
	error_reporting( E_ALL );
	ini_set( 'display_errors', 0 );

	define( 'DACCESS', 1 );

	define( 'APATH', dirname( __FILE__ ) );

	$settings = APATH . '/../../../settings.php';
	$idiorm_lib = APATH . '/../../../lib/idiorm/idiorm.php';

	if ( ! is_file( $settings ) || ! is_readable( $settings ) ) die( 'M_ERROR (00110): A required file: settings.php is missing or not readable!' );
	else include( $settings );

	if ( ! is_file( $idiorm_lib ) || ! is_readable( $idiorm_lib ) ) die( 'M_ERROR (00111): A required file: idiorm.php is missing or not readable!' );
	else include( $idiorm_lib );

	ORM::configure('mysql:host=' . MSettings::$db_host . ';dbname=' . MSettings::$db);
	ORM::configure('username', MSettings::$db_user);
	ORM::configure('password', MSettings::$db_pass);
	ORM::configure('return_result_sets', true); // returns result sets
	ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

	$CID = $_POST["CID"];
	$lat = $_POST["lat"];
	$lon = $_POST["lon"];

	$TheURL = 'http://resource.gpsbooking.com/?cid=' . $CID . '&lat=' . $lat . '&lng=' . $lon;
	$jsonData = json_decode(file_get_contents($TheURL));
	//$TheGEOMData = 'POINT(' . $lon . ' ' . $lat . ')';

	if ((is_object($jsonData)) && count($jsonData) > 0) {

		foreach ($jsonData as $DataKey => $OneData) {
			if (isset($OneData->url)) {
				$HotelURL = parse_url($OneData->url);

				if (strpos(strtoupper($HotelURL['host']),'BOOKING') !== false) {
					$OneData->url = $OneData->url . '?aid=' . 1145912;
				}

				if (strpos(strtoupper($HotelURL['host']),'INITALIA') !== false) {
					parse_str(parse_url($OneData->url, PHP_URL_QUERY), $result_array);
					$result_array['ida'] = 1459;

					$QuerySTR = NULL;
					foreach ($result_array as $Key => $Value) {
						$QuerySTR .= $Key . '=' . $Value . '&';
					}
					$QuerySTR = rtrim($QuerySTR, '&');
					$OneData->url = $HotelURL['scheme'] . '://' . $HotelURL['host'] . $HotelURL['path'] . '?' . $QuerySTR;
				}
			}
			$jsonData->$DataKey->ParsedURL = $OneData->url;
		}

		//print_r($jsonData);
		echo json_encode($jsonData);
	} else {
		echo 'No return data from server.';
	}

	return;

	?>