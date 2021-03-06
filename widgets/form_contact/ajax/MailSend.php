<?php
	error_reporting( E_ALL );
	ini_set( 'display_errors', 0 );

	define( 'DACCESS', 1 );

	define( 'APATH', dirname( __FILE__ ) );

	$settings = APATH . '/../../../settings.php';
	$idiorm_lib = APATH . '/../../../lib/idiorm/idiorm.php';
	$IPLists = APATH . '/../../../widgets/form_contact/ip_list';

	if ( ! is_file( $settings ) || ! is_readable( $settings ) ) die( 'M_ERROR (00110): A required file: settings.php is missing or not readable!' );
	else include( $settings );

	if ( ! is_file( $idiorm_lib ) || ! is_readable( $idiorm_lib ) ) die( 'M_ERROR (00111): A required file: idiorm.php is missing or not readable!' );
	else include( $idiorm_lib );

	ORM::configure('mysql:host=' . MSettings::$db_host . ';dbname=' . MSettings::$db);
	ORM::configure('username', MSettings::$db_user);
	ORM::configure('password', MSettings::$db_pass);
	ORM::configure('return_result_sets', true); // returns result sets
	ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

	$username = $_POST["recipient"];
	$sender_name = $_POST["name"];
	$sender_email = $_POST["email"];
	$sender_message = $_POST["message"];
	$sent_from = $_POST["sentfrom"];

	if ((!$username) || ($username == '')) {
		echo 'Invalid recipient.';
		return;
	}

	$Recipient = NULL;

	$username = filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH);
	if (filter_var($username, FILTER_VALIDATE_EMAIL)) {

		$Recipient = $username;

	} else {

		$UserData =
		ORM::for_table('users')->select_many('email')->where_raw('(`enabled` = ? AND `username` = ?)', array(1, $username))
			 ->find_one();

		if ($UserData) {
			$Recipient = $UserData['email'];
		}
	}

	if ($Recipient) {
		$sender_email = filter_var($sender_email, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH);
		if (filter_var($sender_email, FILTER_VALIDATE_EMAIL)) {
			list($username, $domain) = explode('@', $sender_email);
			if (checkdnsrr($domain . '.', 'MX')) { // Ha valoban letezik az email cim

				$ClientIP = $_SERVER['REMOTE_ADDR'];
				if (file_exists($IPLists)) {
					$Addresses = file($IPLists, FILE_IGNORE_NEW_LINES);

					if (in_array($ClientIP, $Addresses)) {
						echo 'From this IP address cannot send new message again.';
						return;
					} else {
						$IPLimit = array_slice($Addresses, 0, 4);
						file_put_contents($IPLists, $ClientIP . PHP_EOL . implode(PHP_EOL, $IPLimit));
					}
				} else {
					file_put_contents($IPLists, $ClientIP);
				}

				$subject = 'Message from ' . MSettings::$domain;

				$SiteDesc = ORM::for_table('preferences')->select_many('value')->where('name', 'website_description')->find_one();

				$headers = 'From: ' . $sender_email . PHP_EOL .
									 'Reply-To: ' . $sender_email . PHP_EOL .
									 'MIME-Version: 1.0' . PHP_EOL .
									 'Content-Type: text/plain; charset=utf-8' . PHP_EOL .
									 'Content-Transfer-Encoding: 8bit' . PHP_EOL .
									 'X-Mailer: PHP/' . phpversion();

				$Recipient .= ', ' . $sender_email;
				$sender_message .= PHP_EOL . PHP_EOL . $sender_name;
				$sender_message .= PHP_EOL . PHP_EOL . '==== Message from ====';
				$sender_message .= PHP_EOL . MSettings::$sitename . ' - ' . $SiteDesc['value'];
				$sender_message .= PHP_EOL . $sent_from;

				mail($Recipient, '=?UTF-8?B?'.base64_encode($subject).'?=', $sender_message, $headers);

				echo 'sent';
				return;

			} else {
				echo 'Invalid e-mail, cannot send message.';
				return;
			}

		} else {
			echo 'Syntax error on the e-mail field.';
			return;
		}

	} else {
		echo 'No recipient on the user database.';
		return;
	}

	?>