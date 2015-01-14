<?php

class M_Language {
	
		private $langs = array( "en", "it", "hu", "sr", "de", "ru", "fr", "nl", "gr", "da", "sv", "hr", "si" );
		
		public function getLanguage() {
				
				
				if ( empty( $_GET["lang"] ) ) {
						if ( !isset( $_SESSION["lang"] ) ) {
								$language = $this->getDefaultLanguage();
						}
						else if ( in_array( $_SESSION["lang"], $this->langs ) ) {
								$language = $_SESSION["lang"];
						}
						else {
								$language = $this->getDefaultLanguage();
						}
						
				}
				else if ( in_array( $_GET["lang"], $this->langs ) ) {
						$language = $_GET["lang"];
				}
				else {
						$language = $this->getDefaultLanguage();
				}
				
				$this->setSessionLanguage($language);
				
				return $language;
		}
		
		public function getTranslation( $text, $lang_ini_file_path ) {
				if ( file_exists( $lang_ini_file_path ) && is_readable( $lang_ini_file_path ) ) {
						$translation = file_get_contents( $lang_ini_file_path );
						$translation_array = explode( "\n", $translation );
						$translation_collection = array();
						foreach ( $translation_array as $translation_record ) {
								$record = explode( "=", $translation_record );
								$translation_collection[trim( $record[0] )] = trim( $record[1] );
						}
						
						if ( array_key_exists( trim( $text ), $translation_collection ) ) {
								return $translation_collection[$text];
						}
						else {
								return trim( $text );
						}
						
				}
				else {
						return trim( $text );
				}
		}
		
		private function setSessionLanguage( $lang ) {
				$_SESSION["lang"] = $lang;
		}
		
		private function getDefaultLanguage() {
				
				$pref = new M_Preference("default_language");
				$language = $pref->get_value();
				
				return $language;
		}

}

?>
