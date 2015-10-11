<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MBIN {
    
        private $bins = array(
                'mbin.assets',
                'mbin.visit',
                'mbin.auth',
                'classes:class.routing',
                'classes:abs.class.extension',
                'classes:class.module',
                'classes:class.template',
                'classes:class.widget',
                'classes:abs.class.record',
                'classes:class.meta',
                'classes:class.post',
                'classes:class.place',
                'classes:class.event',
				'classes:class.route',
                'classes:class.url',
                'classes:class.category',
                'classes:class.user',
                'classes:class.menu',
                'classes:class.page',
                'classes:class.preferences',
                'mbin.object',
                'mbin.extension',
                'classes:class.language'
        );

        public function __construct() {

                if ( sizeof( $this->bins ) > 0 ) {

                        foreach ( $this->bins as $bin ) {
                                if ( $bin ) $load = $this->mapibin( $bin );   
                                if ( ! $load ) die( 'M_ERROR (00141): A required binary cannot be loaded: File missing or not readable!' );
                        }

                }
     
        }

        private function mapibin( $path ) {
                if ( ! mapi_include_abs_path( $path, 'bin' ) ) return null;

                return true;
        }
    
}

?>
