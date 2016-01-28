<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_Register {

		static function register() {

			$CaptchaKey =	ORM::for_table('preferences')->select_many('value')
												->where('name', 'Reacaptcha_key')
												->find_one();

			if ($CaptchaKey) {
				$privatekey = $CaptchaKey['value'];
				$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"],
																			 $_POST["recaptcha_response_field"]);

				if (!$resp->is_valid) {
					return mapi_report('Captcha: '.$resp->error);
				}
			}

			if ( ! MValidate::password( MGet::string( 'pass' ) ) ) return mapi_report( 'Invalid password.' );
				if ( MGet::string( 'pass' ) !== MGet::string( 'pass_repeat' ) ) return mapi_report( 'Passwords do not match.' );

				$user = MObject::create( 'user' );
				$user->set_username( MGet::string( 'user' ) );
				$user->set_name( MGet::string( 'name' ) );
				$user->set_email( MGet::string( 'email' ) );

				$reg_group = MObject::get( 'preference', 'new_user_default_group' );

				$group = null;
				
				if ( ! $reg_group || $reg_group->get_value() ) $group = 3;
				if ( $reg_group->get_value() < 1 || $reg_group->get_value() > 3 ) $group = 3;

				if ( ! $group ) $group = $reg_group->get_value();

				$user->set_group_id( $group );

				$user->set_activation( urlencode( MCrypt::encrypt( mapi_random( 24 ) ) ) );
				$user->set_enabled( 0 );

				$user->add( MGet::string( 'pass' ) );

				if ( 0 == ( MMessaging::any_errors() + MMessaging::any_warnings() ) ) {
						self::send_reg_email( $user );
						$_POST['user'] = '';
						$_POST['name'] = '';
						$_POST['email'] = '';
				}
		}

		static function activate() {
				$availables = mapi_for_activation();

				if ( in_array( urlencode( MGet::string( 'c', 'GET' ) ), $availables ) ) $activation = urlencode( MGet::string( 'c', 'GET' ) );
				else return null;

				$user = ORM::for_table( 'users' )->where( 'enabled', 0 )->where( 'activation', $activation )->find_one();

				if ( $user ) {
						$user->enabled = 1;
						if ( $user->save() ) {
								mapi_report( 'Your account is successfully activated. You can login now.', 'success' );

								$user->activation = null;
								$user->save();

								header( 'Location: index.php?module=login' );
								exit( 0 );
						}
				}
		}

		static private function send_reg_email( $user ) {
				if ( ! is_object( $user ) ) return null;

				if ( MValidate::email( MSettings::$reg_email ) ) $from = MSettings::$reg_email;
				else return null;

				if ( MValidate::email( $user->get_email() ) ) $to = $user->get_email();
				else return null;

				if ( empty( MSettings::$domain ) ) return null;
				if ( empty( MSettings::$reg_email_user ) ) return null;
				if ( empty( MSettings::$reg_email_pass ) ) return null;
				if ( empty( MSettings::$reg_email_host ) ) return null;

				if ( ! strlen( $user->get_activation() ) > 0 ) return null;

				$url = mapi_install_url() . 'manager/?module=register&activate=1&c=' . $user->get_activation();

				$body = "";
				$body .= "Welcome to " . MSettings::$domain . "\n\n";
				$body .= "To access the #mappiamo backend, please activate your account by clicking on the link below:\n";
				$body .= $url . "\n\n";
				$body .= "If the registration is not done by You, please send us an abuse letter by replying to this mail.\n\n";
				$body .= "Sincerely\n";
				$body .= MSettings::$domain;

				$message = Swift_Message::newInstance();
  				$message->setSubject( 'Welcome to ' . MSettings::$sitename );
  				$message->setFrom( array( $from ) );
  				$message->setTo( array( $to => $user->get_name() ) );
  				$message->setBody( $body );

  				$transport = Swift_SmtpTransport::newInstance( MSettings::$reg_email_host, 25 )->setUsername( MSettings::$reg_email_user )->setPassword( MSettings::$reg_email_pass );
  				$mailer = Swift_Mailer::newInstance( $transport );

  				if ( ! $mailer->send( $message ) ) {
  						$user->delete();
  						MMessaging::clear();
  						mapi_report( 'There was a problem. Please try again later.' );
  				} else {
  						self::send_notification( $user );
  				}
		}

		static private function send_notification( $user ) {
				$body = "";
				$body .= "New registration at " . MSettings::$domain . "\n\n";
				$body .= "User details:\n";
				$body .= "-username: " . $user->get_username() . "\n";
				$body .= "-name: " . $user->get_name() . "\n";
				$body .= "-email: " . $user->get_email() . "\n";
				$body .= ".\n\n";
				$body .= "Sincerely\n";
				$body .= MSettings::$domain;

				if ( MValidate::email( MSettings::$reg_email ) ) $from = MSettings::$reg_email;
				else return null;

				if ( MValidate::email( MObject::get( 'preference', 'website_email' )->get_value() ) ) $to = MObject::get( 'preference', 'website_email' )->get_value();
				else return null;

				$message = Swift_Message::newInstance();
  				$message->setSubject( 'New registration at ' . MSettings::$sitename );
  				$message->setFrom( array( $from ) );
  				$message->setTo( array( $to ) );
  				$message->setBody( $body );

  				$transport = Swift_SmtpTransport::newInstance( MSettings::$reg_email_host, 25 )->setUsername( MSettings::$reg_email_user )->setPassword( MSettings::$reg_email_pass );
  				$mailer = Swift_Mailer::newInstance( $transport );

  				$mailer->send( $message );
		}

}

?>