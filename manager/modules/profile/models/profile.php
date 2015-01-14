<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_Profile {

		static function get_profile() {
				$profile = MObject::get( 'user', MAuth::user_id() );

				if ( $profile->get_id() ) return $profile;
				return null;
		}

		static function update_profile() {
				$profile = self::get_profile();

				if ( $profile ) {
						$profile->set_email( MGet::string( 'user_email' ) );
						$profile->set_name( MGet::string( 'user_name' ) );

						$profile->update();
				}
		}

		static function change_password() {
				if ( ! MGet::string( 'user_pass' ) ) return null;

				$profile = self::get_profile();

				if ( $profile ) {
						if ( MGet::string( 'user_pass' ) != MGet::string( 'user_pass_repeat' ) ) return mapi_report_message( 'Passwords do not match' );

						$profile->change_password( MGet::string( 'user_pass' ), false );
				}
		}

}

?>