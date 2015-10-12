<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MLIB {
    
        private $libs = array(
                'mapilib'       => 'mlib.crypt;mlib.messaging;mlib.purifier;mlib.validate;mlib.get;mlib.put;mlib.html;mlib.table',
                'htmlpurifier'  => 'htmlpurifier:library:HTMLPurifier.auto',
                'idiorm'        => 'idiorm:idiorm',
                'geocoder'      => 'geocoder:autoload',
                'swift'         => 'swift:lib:swift_required',
                'parsedown'     => 'parsedown:Parsedown',
                'facebook'      => 'facebook:facebook',
                'recaptcha'     => 'recaptcha:recaptchalib'
        );

        public function __construct() {

                if ( sizeof( $this->libs ) > 0 ) {

                        foreach ( $this->libs as $key => $value ) {
                                $paths = explode( ';', $value );
                                foreach ( $paths as $path ) {
                                        if ( $key && $value ) $load = $this->$key( $path );   
                                        if ( ! $load ) die( 'M_ERROR (00131): A required library cannot be loaded: File missing or not readable!' );
                                }
                        }

                }
     
        }

        private function mapilib( $path ) {
                if ( ! mapi_include_abs_path( $path, 'lib' ) ) return null;

                return true;
        }

        private function htmlpurifier( $path ) {
                if ( ! mapi_include_abs_path( $path, 'lib' ) ) return null;

                MPurifier::instance();

                return true;
        }

        private function idiorm( $path ) {
                
                if ( ! mapi_include_abs_path( $path, 'lib' ) ) return null;
                
                if ( ! isset( MSettings::$db_host ) || ! strlen( MSettings::$db_host ) > 0 ) return false;
                if ( ! isset( MSettings::$db ) || ! strlen( MSettings::$db ) > 0 ) return false;
                if ( ! isset( MSettings::$db_user ) || ! strlen( MSettings::$db_user ) > 0 ) return false;
                if ( ! isset( MSettings::$db_pass ) || ! strlen( MSettings::$db_pass ) > 0 ) return false;

                try {
                        
                        ORM::configure( 'mysql:host=' . MSettings::$db_host . ';dbname=' . MSettings::$db );
                        ORM::configure( 'username', MSettings::$db_user );
                        ORM::configure( 'password', MSettings::$db_pass );
                        
                        ORM::configure( 'driver_options', array( PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' ) );

                        $test = ORM::for_table( 'preferences' )->create();
                        
                        if ( $test ) return true;
                        else die( 'M_ERROR (00133): Cannot create a preferences instance, have you installed the database?' );

                } catch( PDOException $e ) {
                        die( 'M_ERROR (00132): Cannot connect to MySQL, please check the configuration in settings.php!' );
                }
        }

        private function geocoder( $path ) {
                global $geocoder;

                if ( ! mapi_include_abs_path( $path, 'lib' ) ) return null;

                $adapter = new \Geocoder\HttpAdapter\CurlHttpAdapter();
                $chain = new \Geocoder\Provider\ChainProvider( 
                        array(
                                new \Geocoder\Provider\NominatimProvider( $adapter, 'nominatim.openstreetmap.org', 'en-GB' ),
                                new \Geocoder\Provider\GoogleMapsProvider( $adapter )
                        )
                );
                $geocoder = new \Geocoder\Geocoder();
                $geocoder->registerProvider( $chain );

                return true;
        }

        private function swift( $path ) {
                if ( ! mapi_include_abs_path( $path, 'lib' ) ) return false;

                return true;
        }

        private function parsedown( $path ) {
                if ( ! mapi_include_abs_path( $path, 'lib' ) ) return false;

                return true;
        }

        private function facebook( $path ) {
                if ( ! mapi_include_abs_path( $path, 'lib' ) ) return false;

                return true;
        }

        private function recaptcha( $path ) {
                if ( ! mapi_include_abs_path( $path, 'lib' ) ) return false;

                return true;
        }
    
}

?>
