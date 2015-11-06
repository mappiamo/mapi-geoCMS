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
				$config->set('Attr.EnableID', true);
				$config->set( 'URI.SafeIframeRegexp', '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%' );
				//$config->set( 'HTML.Allowed', 'textarea[id|cols|rows|class]');
				$config->set('HTML.AllowedElements', array('textarea', 'ul', 'ol', 'li', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'a', 'span', '', 'div', 'hr', 'br', 'img', 'p'));
				$config->set('HTML.Trusted', true);
				self::$purifier = new HTMLPurifier( $config );
			}
	}

	static function clean( $input ) {
			return self::$purifier->purify( $input );
	}

}

?>
