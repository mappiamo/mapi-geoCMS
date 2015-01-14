<?php

class M_Place extends M_Post {
	
		protected $type = 'place';
		protected $kind;

		public function __construct( $id = null ) {
				if ( $id ) $this->read( $id );
		}

}

?>