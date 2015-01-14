<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function abc_( $text ) {
	
	$backtrace = debug_backtrace();

	$rel_path = str_replace(APATH, "", $backtrace[0]["file"] );
	
	$path_elements = explode(DIRECTORY_SEPARATOR, $rel_path);

	$path_array = array_filter( $path_elements );
	
	$ext_type = trim( reset( $path_array ) ); //extension type
	
	next($path_array);
	
	$ext_name = trim( current( $path_array ) ); //extension name
	
	$lang = new M_Language;
	$language = $lang->getLanguage();
	
	$lang_ini_file_path = $ext_type . "/" . $ext_name . "/lang/" . $language . ".ini";
	
	
	$translation_string = $lang->getTranslation( $text, $lang_ini_file_path );
	
	return $translation_string;

}


function __( $text ) {
	
	$backtrace = debug_backtrace();

	$rel_path = str_replace(APATH, "", $backtrace[0]["file"] );
	
	$path_elements = explode(DIRECTORY_SEPARATOR, $rel_path);

	$path_array = array_filter( $path_elements );
	
	$ext_type = trim( reset( $path_array ) ); //extension type
	
	next($path_array);
	
	$ext_name = trim( current( $path_array ) ); //extension name
	
	$lang = new M_Language;
	$language = $lang->getLanguage();
	
	$lang_ini_file_path = $ext_type . "/" . $ext_name . "/lang/" . $language . ".ini";
	
	
	$translation_string = $lang->getTranslation( $text, $lang_ini_file_path );
	
	echo $translation_string;
	
}



?>
