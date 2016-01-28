<?php
	/**
	 * Created by PhpStorm.
	 * User: Laca
	 * Date: 2016.01.27.
	 * Time: 12:19
	 */

	if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
		die('Ajax method not possible.');
	}

	$SiteRoot = str_replace("/setup/ajax", "", $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . dirname($_SERVER['PHP_SELF']));
	$setupfile_path = $SiteRoot . '/settings.php';

	if (file_exists($setupfile_path)) {
		die('Setup file already exist. Setup cancelled.');
	}

	$MailData = $_POST['reg_email'];
	$MailData = strtolower(trim($MailData));
	$MailData = filter_var($MailData, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH);

	if (filter_var($MailData, FILTER_VALIDATE_EMAIL)) {
		list($username, $domain) = explode('@', $MailData, 2);
		if (!checkdnsrr($domain . '.', 'MX')) {
			die('Not valid e-mail or MX error on e-mail field.');
		}
	} else {
		die('Not valid e-mail or syntax error on e-mail field.');
	}

	if (!checkdnsrr($_POST['reg_email_host'] . '.', 'MX')) {
		die('Invalid data on SMTP fileld or SMTP service unavailable.');
	}

	include('../Database/Configuration.php');
	include('../Database/Connection.php');
	include('../Database/DatabaseHandler.php');

	use Database\Configuration as DatabaseConfig;
	use Database\DatabaseHandler;

	$DataHandler =
	new DatabaseHandler(
	new	DatabaseConfig('testconnection',
											$_POST['db_host'],
											"3306",
											$_POST['db'],
											$_POST['db_user'],
											$_POST['db_pass']));

	$uSQL = "SHOW TABLES";
	$Result = $DataHandler->getConnection('testconnection')->query($uSQL);

	if ($Result->rowCount() > 0) {
		die('Required database already contains tables. Setup process cancelled.');
	}

	$IsConnected = $DataHandler->getConnection('testconnection')->connect();
	if ($IsConnected) { die('PASSED'); }

	die('Unknown error.');
