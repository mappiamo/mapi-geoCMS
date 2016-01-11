<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MCrypt{

    static function encrypt( $input, $base64 = true ) {
    		if ( ! $input || ! strlen( $input ) > 0 ) return null;
    		if ( ! ( $td = mcrypt_module_open( 'rijndael-256', '', 'ctr', '' ) ) ) return null;
    		if ( ! ( $iv = mcrypt_create_iv( 32, MCRYPT_RAND ) ) ) return null;
         
            $content = serialize($input);
         
            if ( mcrypt_generic_init( $td, MSettings::$c_key, $iv ) !== 0 ) return null;
         
            $content = mcrypt_generic( $td, $content );
            $content = $iv . $content;
            
            $mac = self::pbkdf2( $content, MSettings::$c_key, 1000, 32 );
            
            $content .= $mac;
         
            mcrypt_generic_deinit( $td );
            mcrypt_module_close( $td );
         
            if ( $base64 ) $content = base64_encode( $content );
         
            return $content;
    }
     
    static function decrypt( $input, $base64 = true ) {
    		if ( ! $input || ! strlen( $input ) > 0 ) return null;
    		if ( ! ( $td = mcrypt_module_open( 'rijndael-256', '', 'ctr', '' ) ) ) return null;

            if ( $base64 ) $content = base64_decode( $input );
            else $content = $input;

            $iv = substr( $content, 0, 32 );
            $extract = substr( $content, ( strlen( $content ) - 32 ) );
            $content = substr( $content, 32, strlen( $content ) - 64 );
            $mac = self::pbkdf2( $iv . $content, MSettings::$c_key, 1000, 32 );
         
            if ( $extract !== $mac ) return null;
         
            if ( mcrypt_generic_init( $td, MSettings::$c_key, $iv ) !== 0 ) return null;
         
            $content = mdecrypt_generic( $td, $content );
            $content = unserialize( $content );
         
            mcrypt_generic_deinit( $td );
            mcrypt_module_close( $td );
         
            return $content;
    }
     
    static private function pbkdf2( $p, $s, $c, $kl, $a = 'sha256' ) {
	        $hl = strlen( hash( $a, null, true ) );
	        $kb = ceil( $kl / $hl );
	        $dk = '';
        
        	for( $block = 1; $block <= $kb; $block++ ) {
            		$ib = $b = hash_hmac( $a, $s . pack( 'N', $block ), $p, true );
     
            		for( $i = 1; $i < $c; $i++ ) $ib ^= ( $b = hash_hmac( $a, $b, $p, true ) );
     
            		$dk .= $ib; 
        	}
     
        	return substr( $dk, 0, $kl );
    }
    
}

?>