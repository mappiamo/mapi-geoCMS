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

	$username = $_POST["recipient"];
	$sender_name = $_POST["name"];
	$sender_email = $_POST["email"];
	$sender_message = $_POST["message"];

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
				$subject = 'Form message from the site.';

				$headers = 'From: ' . $sender_email . PHP_EOL .
									 'Reply-To: ' . $sender_email . PHP_EOL .
									 'MIME-Version: 1.0' . PHP_EOL .
									 'Content-Type: text/plain; charset=utf-8' . PHP_EOL .
									 'Content-Transfer-Encoding: quoted-printable' . PHP_EOL .
									 'X-Mailer: PHP/' . phpversion();

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