<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MPurifier {

	static private $purifier = null;

	public function __construct() {
	}

	static function instance() {
			if ( ! self::$purifier ) {
				$config = HTMLPurifier_Config::createDefault();
				$config->set( 'CSS.AllowTricky', true );
				$config->set( 'Attr.AllowedFrameTargets', array( '_blank' ) ); 
				$config->set( 'HTML.SafeIframe', true );
				$config->set( 'URI.SafeIframeRegexp', '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%' );
				//$config->set( 'HTML.Allowed', 'a[href|target|title]' );
				self::$purifier = new HTMLPurifier( $config );
			}
	}

	static function clean( $input ) {
			return self::$purifier->purify( $input );
	}

}

?>
