<?php

function mapi_report( $message = null, $type = 'warning' ) {
		mapi_report_message( $message, $type );
} 

function mapi_report_message( $message = null, $type = 'warning' ) {
        if ( ! $message ) return null;

        switch ( $type ) {
                case 'error': MMessaging::add_error( $message ); break;
                case 'warning': MMessaging::add_warning( $message ); break;
                case 'success': MMessaging::add_success( $message ); break;
        }

        return null;
}

function mapi_short_description( $content, $words_aprox = 5 ) {
		$short_description = '';

		$sentences = mapi_break_into_sentences( $content );

		if ( 1 == sizeof( $sentences ) ) return $sentences[0];

		$i = 0;
		$word_count = 0;
		$stop = false;
		while ( ! $stop || ! isset( $sentences[$i] ) ) {
				$words = mapi_break_into_words( $sentences[$i] );
				
				if ( is_array( $words ) || sizeof( $words ) > 0 ) {
						foreach ( $words as $word ) {
								$word_count++;
						}
				}

				$short_description .= $sentences[$i];

				if ( ( $words_aprox - 1 ) == $word_count ) $stop = true;
				if ( $words_aprox < $word_count ) $stop = true;

				$i++;
		}

		return $short_description;
}

function mapi_break_into_words( $input ) {
		$text = trim( strip_tags( $input ) );
		$words = explode( ' ', $text );

		return $words;
}

function mapi_break_into_sentences( $input ) {
		$text = trim( strip_tags( $input ) );
		$text_array = explode( '.' , $text );

		$sentences = array();
		$sentence = '';

		if ( sizeof( $text_array ) < 1 ) return $text;

		for ( $i=0; $i<sizeof( $text_array ); $i++ ) {
				$fos_uppercase = false;
				if ( isset( $text_array[$i+1] ) ) {
						if ( ctype_upper( substr( $text_array[$i+1], 0, 1 ) ) ) $fos_uppercase = true;
						if ( ctype_upper( substr( $text_array[$i+1], 1, 1 ) ) ) $fos_uppercase = true;
				} else {
						$fos_uppercase = true;
				}

				$sentence .= $text_array[$i] . '.';

				if ( $fos_uppercase ) {
						$sentences[] = $sentence;
						$sentence = '';
				}
		}

		return $sentences;
}

function mapi_available_ids( $ofwhat, $env_check = false ) {
		$ids = array();
		$table = null;

		if ( ! $ofwhat ) return $ids;

		switch ( $ofwhat ) {
			 	case 'licenses':
			 	case 'modules':
			 	case 'templates':
			 	case 'contents':
			 			$table = $ofwhat;
			 	break;
		}

		if ( ! $table ) return $ids;

		if ( $env_check && defined( 'ENV' ) && 'manager' == ENV ) {
				$result_set = ORM::for_table( $table )->select( 'id' )->where( 'enabled', 1 )->where( 'manager', 1 )->find_many();
		} else {
				$result_set = ORM::for_table( $table )->select( 'id' )->where( 'enabled', 1 )->find_many();
		}

		if ( ! $result_set ) return $ids;

		foreach ( $result_set as $result ) {
				if ( $result->id ) $ids[] = intval( $result->id );
		}

		return $ids;
}

function mapi_id_exists( $id, $ofwhat, $env_check = false ) {
		$ids = mapi_available_ids( $ofwhat, $env_check );

		if ( sizeof( $ids ) > 0 && in_array( $id, $ids ) ) return true;

		return false; 
}

function mapi_csrf_value() {
		session_regenerate_id();

		$csrf = mapi_random( 24 );
		$_SESSION['mapi_csrf'] = $csrf;

		return $csrf;
}

function mapi_csrf_check( $value ) {
		if ( $_SESSION['mapi_csrf'] == $value ) return true;
		else return false;
}

function mapi_random( $length = 12, $cs = 'ALL' ) {
		if ( ! $length || ! is_numeric( $length ) || $length <= 0 ) $length = 12;

		$ch_set_1 = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
		$ch_set_2 = array( 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z' );
		$ch_set_3 = array( 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' );
		$ch_set_4 = array( '!', '@', '#', '$', '%', '^', '&', '*', '(', ')' );

		$ch_set = array();
		switch ( $cs ) {
				case 'NUM': $ch_set = $ch_set_1; break;
				case 'LCASE': $ch_set = $ch_set_2; break;
				case 'UCASE': $ch_set = $ch_set_3; break;
				case 'NUMLCASE': $ch_set = array_merge( $ch_set_1, $ch_set_2 ); break;
				case 'NUMUCASE': $ch_set = array_merge( $ch_set_1, $ch_set_3 ); break;
				case 'BCASES': $ch_set = array_merge( $ch_set_2, $ch_set_3 ); break;
				case 'BCASESPEC': $ch_set = array_merge( $ch_set_2, $ch_set_3, $ch_set_4 ); break;
				default: $ch_set = array_merge( $ch_set_1, $ch_set_2, $ch_set_3, $ch_set_4 ); break;
		}

		$random = '';
		for ( $i=0; $i<$length; $i++ ) {
				$rkey = array_rand( $ch_set );
				$random .= $ch_set[$rkey];

				shuffle( $ch_set );
		}

		return $random;
}

function mapi_check_double( $where, $what, $value ) {
		if ( ! strlen( $value ) > 0 ) return true;

		$a_where = array( 'contents', 'categories', 'users', 'modules', 'templates', 'widgets', 'menus', 'pages', 'prefences' );
		$a_what = array( 'name', 'username' );

		if ( ! in_array( $where , $a_where ) ) return true;
		if ( ! in_array( $what , $a_what ) ) return true;

		$found = ORM::for_table( $where )->where( $what, strval( $value ) )->find_one();

		if ( $found ) return false;
		else return true;
}

function mapi_convert_to_name( $title ) {
		$name = preg_replace( '/[^a-zA-Z0-9\-_ ]/s', '', $title );
		return strtolower( preg_replace( '/ /' , '-', substr( $name, 0, 255 ) ) );
} 

function mapi_html_elements_val( $content, $element ) {
		$values = array();

		if ( ! $content || ! $element ) return $values;
		if ( ! strlen( $content ) > 0 || ! strlen( $content ) > 0 ) return $values;

		$dom = new DOMDocument();
		$dom->loadHTML( $content );

		$results = $dom->getElementsByTagName( $element );
		if ( $results->length > 0 ) {
				foreach ( $results as $result ) {
						if ( $result->nodeValue ) {
								$values[] = $result->nodeValue;
						}
				}
		}

		return $values;
}

?>