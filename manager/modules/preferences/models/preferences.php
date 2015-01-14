<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_Preferences {

		static function get_preferences() {
				$preferences = array();

				$records = ORM::for_table( 'preferences' )->find_many();

				foreach ( $records as $record ) {
						$preferences[$record->name] = self::setup_preference( $record );
				}

				return $preferences;
		}

		static function setup_preference( $preference ) {
				$value = null;

				if ( ! isset( $preference->name ) ) return $result;

				switch ( $preference->name ) {
						case 'registration':
						case 'force_php_errors_and_warnings':
								if ( isset( $preference->value ) && ( 'yes' == $preference->value || 'no' == $preference->value ) ) $value = $preference->value;
								else $value = 0;
						break;
						case 'new_user_default_group':
								if ( isset( $preference->value ) && ( $preference->value > 0 && $preference->value < 5 ) ) $value = $preference->value;
								else $value = 3;
						break;
						case 'routing':
								if ( isset( $preference->value ) && ( 'default' == $preference->value || 'sef' == $preference->value ) ) $value = $preference->value;
								else $value = 'default';
						break;
						default:
								$value = $preference->value;
						break;
				}

				return $value;
		}

		static function update_preferences() {
				$preference_keys = array(
						'force_php_errors_and_warnings',
						'routing',
						'website_title',
						'website_description',
						'website_email',
						'registration',
						'new_user_default_group',
						'facebook_app_id',
						'facebook_secret'
				);

				foreach ( $preference_keys as $key ) {
						$pref = new M_Preference( $key );
						$pref->set_value( MGet::string( $key ) );
						
						if ( ! $pref->update() ) mapi_report( 'Preference: ' . $key . ' is not updated' );
				}

				if ( 0 == ( MMessaging::any_errors() + MMessaging::any_warnings() ) ) mapi_report( 'Preferences successfully updated.', 'success' );
		}

}

?>