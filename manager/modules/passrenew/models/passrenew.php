<?php
	/**
	 * Created by PhpStorm.
	 * User: Laca
	 * Date: 2016.01.09.
	 * Time: 18:08
	 */

	defined( 'DACCESS' ) or die;

	class MModel_Passrenew {

		static function check_email() {
			if (isset($_POST['email'])) {
				$sender_email = $_POST['email'];
				$sender_email = filter_var($sender_email, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH);
				if (filter_var($sender_email, FILTER_VALIDATE_EMAIL)) {

					$UserData =	ORM::for_table('users')->select_many('email', 'username')
					->where('email', $sender_email)
					->where('enabled', 1)
					->where_null('activation')
					->find_one();

					if (strtolower($UserData['email']) == strtolower($sender_email)) {

						self::send_passrenew_email($sender_email, $UserData['username']);

						return TRUE;
					} else {
						return mapi_report('Invalid e-mail address, renew request cancelled.');
					}
				} else {
					return mapi_report('Invalid e-mail address, renew request cancelled.');
				}
			}
		}

		static private function send_passrenew_email($email, $name) {

			$random = substr(md5(rand()), 0, 12);

			$IsData =	ORM::for_table('users')
											->where('email', $email)
											->where('enabled', 1)
											->where_null('activation')
											->find_one();

			if ($IsData) {
				//$uuidcr = urlencode(MCrypt::encrypt($random));
				$uuidcr = urlencode(md5($random));
				$url = mapi_install_url().'manager/?module=passrenew&activate=1&d=' . $random;
				$from = MSettings::$reg_email;

				$body = "";
				$body .= "This is password renew request from " . MSettings::$domain . "\n\n";
				$body .= "To renew your old (forgotted) password click to this new password activation link:\n";
				$body .= $url . "\n\n";
				$body .= "Your oroginaly registered username on this system is:" . $name . "\n\n";
				$body .= "Sincerely\n";
				$body .= MSettings::$domain;

				$message = Swift_Message::newInstance();
				$message->setSubject('Password renew request from ' . MSettings::$sitename);
				$message->setFrom(array($from));
				$message->setTo(array($email => $name));
				$message->setBody($body);

				//$transport = Swift_SmtpTransport::newInstance( MSettings::$reg_email_host, 25 )->setUsername( MSettings::$reg_email_user )->setPassword( MSettings::$reg_email_pass );
				$transport = Swift_SmtpTransport::newInstance();
				$mailer = Swift_Mailer::newInstance($transport);

				if (!$mailer->send($message)) {
					MMessaging::clear();
					//die('There was a problem. Please try again later.');
					return mapi_report('There was a problem with e-mail sending. Please try again later.');
				} else {
					$IsData->set('activation', $uuidcr);
					$IsData->save();
					return mapi_report('E-mail for password renew process has been sent to the address.');
				}
				//die($url);
			} else {
				return mapi_report('This password renew request is invalid.');
				//die('This password renew request is invalid.');
			}
		}

		static function activate() {
			$activation = (MGet::string('d', 'GET'));
			//$uuiddcr = MCrypt::decrypt($activation);
			$uuiddcr = (md5($activation));
			if ($uuiddcr) {

				$UserPWData =	ORM::for_table('users')->select_many('email', 'username')
												->where('activation', $uuiddcr)
												->where('enabled', 1)
												->find_one();

				if ($UserPWData) {
					//echo $uuiddcr . ' -> ' . $UserPWData['email'] . ' -> ' . $UserPWData['username'];
					return $UserPWData;
				} else {
					//die('This password renew request is invalid.');
					return mapi_report('This password renew request is invalid.');
				}
			} else {
				//die('This password renew request is invalid.');
				return mapi_report('This password renew request is invalid.');
			}

		}

		static function renewprocess() {
			if ((isset($_POST['pass'])) && (isset($_POST['pass_repeat']))) {
				if ($_POST['pass'] == $_POST['pass_repeat']) {
					if (strlen($_POST['pass']) > 4) {
						$activation = (MGet::string('d', 'GET'));
						//$uuiddcr = MCrypt::decrypt($activation);
						$uuiddcr = (md5($activation));

						$UserPWData =	ORM::for_table('users')->select_many('email', 'username')
															->where('activation', $uuiddcr)
															->where('enabled', 1)
															->find_one();

						if ($UserPWData) {

							$NewPass = $_POST['pass'];

							$ChangeData =	ORM::for_table('users')
														->where('activation', $uuiddcr)
														->where('enabled', 1)
														->find_one();

							$ChangeData->set('activation', NULL);
							$ChangeData->password = md5($NewPass);
							$ChangeData->save();

							return TRUE;
						} else {
							//die('This password renew request is invalid.');
							return mapi_report('This password renew request is invalid.');
						}
					} else {
						//die('Password must be 5 character or more.');
						return mapi_report('Password must be 5 character or more.');
					}
				} else {
					return mapi_report('Passwords not identical.');
					//die('Passwords not identical.');
				}
			}
		}

	}