<?php
	/**
	 * Created by PhpStorm.
	 * User: Laca
	 * Date: 2016.01.24.
	 * Time: 11:32
	 */

	include('Database/Configuration.php');
	include('Database/Connection.php');
	include('Database/DatabaseHandler.php');

	use Database\Configuration as DatabaseConfig;
	use System\Configuration as SystemConfig;
	use Database\DatabaseHandler;

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$SiteRoot = str_replace("/setup", "", $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . dirname($_SERVER['PHP_SELF']));
		$setupfile_path = $SiteRoot . '/settings.php';

		if (file_exists($setupfile_path)) {
			echo 'Setup file already exist. Setup cancelled.';
		} else {

			$RequiredData = array("sitename", "db_user", "db_pass", "db", "db_host", "reg_email", "reg_email_user",	"reg_email_pass", "reg_email_host"); // adatellenőrzés ****

			if ((DataCheck($_POST, $RequiredData)) == TRUE) {

				$SysConf = new SystemConfig();

				$DataHandler =
				new DatabaseHandler(
				new	DatabaseConfig($SysConf::$DATABASE_NAME,
														$SysConf::$DATABASE_HOST,
														$SysConf::$DATABASE_PORT,
														$SysConf::$DATABASE_NAME,
														$SysConf::$DATABASE_USERNAME,
														$SysConf::$DATABASE_PASSWORD));

				$DataHandler->getConnection($SysConf::$DATABASE_NAME)->connect();

				//echo 'Database connection possible with these settings.<br>';

				if (file_exists('Database/setup.sql')) {
					$sql = file_get_contents('Database/setup.sql');
				} else {
					die('SQL file not available. Setup cancelled.');
				}

				$uSQL = "SHOW TABLES";
				$Result = $DataHandler->getConnection($SysConf::$DATABASE_NAME)->query($uSQL);

				if ($Result->rowCount() > 0) {
					die('Required database already contains tables. Setup process cancelled.');
				}

				$Result = $DataHandler->getConnection($SysConf::$DATABASE_NAME)->query($sql);

				if (!$Result) {
					die('Query contains errors, setup cannot create database tables.');
				} else {
					//echo 'SQL file imported to database.<br>';
				}

				$setup_template = file_get_contents('setup.template');
				$_POST['domain'] = $_SERVER['HTTP_HOST'];
				$_POST['c_key'] = substr(md5(rand()), 0, 15);

				foreach ($_POST as $setup_name => $setup_value) {
					if ($setup_value) {
						$pattern = '['.strtoupper($setup_name).']';
						$replacement = '$'.$setup_name.' = \''.$setup_value.'\'';
						//$setup_template = preg_replace($pattern, $replacement, $setup_template);
						$setup_template = str_replace($pattern, $replacement, $setup_template);
					}
				}

				$pattern = '/static \[([a-z_]*)\]\;/';
				$replacement = 'static \$$1 = \'\';';
				$setup_template = preg_replace($pattern, $replacement, $setup_template);

				//echo $setup_template; die();
				file_put_contents($setupfile_path, $setup_template);

				//echo 'Setup file written.';

				include('done.php');

			} else {
				echo 'Invalid input data on setup form. Setup aborted.';
			}
		}
	} else {
		echo 'Invalid request, setup cancelled.';
	}

	function DataCheck($Data, $Required) {

		if (!array_diff($Required, array_keys($Data))) {
			if (isset($Data['reg_email'])) {
				if (filter_var($Data['reg_email'], FILTER_VALIDATE_EMAIL)) {
					return TRUE;
				} else {
					return FALSE;
				}
			} else {
				return TRUE;
			}
		} else {
			return FALSE;
		}
	}