<?php

class MObject {

		static $objects = array( 'category', 'content', 'menu', 'page', 'preference', 'user' );
		static $types = array( 'post', 'place', 'event' );
	
		static public function get( $object, $id ) {
				if ( ! in_array( $object, self::$objects ) ) return null;

				if ( ! $id ) return null;

				if ( 'content' != $object ) $class = 'M_' . ucfirst( $object );
				else $class = 'M_' . ucfirst( self::find_type( $id ) );

				if ( class_exists( $class ) ) return new $class( $id );
				else return null;
		}

		static public function create( $object ) {
				if ( ! in_array( $object, self::$objects ) && ! in_array( $object, self::$types ) ) return null;

				$class = 'M_' . ucfirst( $object );

				if ( class_exists( $class ) ) return new $class();
				return null;
		}

		static private function find_type( $id ) {
				$record = ORM::for_table( 'contents' )->select( 'type' )->find_one( intval( $id ) );

				if ( ! $record ) return null;

				return ucfirst( $record->type );
		}
	
}

?>