<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MINC {
    
        private $incs = array(
                'include',
                'url',
                'listings',
                'helper',
                'lang'
        );

        public function __construct() {

                if ( sizeof( $this->incs ) > 0 ) {

                        foreach ( $this->incs as $path ) {
                                if ( $path ) $load = $this->inc( $path );   
                                if ( ! $load ) die( 'M_ERROR (00121): A required file cannot be included: File missing or not readable!' );
                        }

                }
     
        }

        private function inc( $path ) {
                if ( ! defined( 'APATH' ) ) return false;

                $path = APATH . '/includes/' . $path . '.php';
                
                if ( is_file( $path ) && is_readable( $path ) ) {
                        if ( include( $path ) ) return true;
                        else return false;
                }

                return false;
        }
    
}

?>
