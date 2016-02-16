<?php

class M_Route extends M_Post {
	
		protected $type = 'route';
		protected $kind;

		public function __construct( $id = null ) {
				if ( $id ) $this->read( $id );
		}

}

?>