<?php

class M_Event extends M_Post {

		protected $type = 'event';
		protected $start = null;
		protected $end = null;

		public function __construct( $id = null ) {
				if ( $id ) $this->read( $id );
		}

		public function get_start() {
				return $this->start;
		} 

		public function get_end() {
				return $this->end;
		}

		public function set_start( $value ) {
				$this->start = strval( $value );
		}

		public function set_end( $value ) {
				$this->end = strval( $value );
		}

		protected function read( $id ) {
				if ( ! MValidate::id( $id ) ) return null;

				$event = $this->read_record( $id, $this->type );

				if ( $event && is_object( $event ) ) {
						if ( $event->text ) $this->set_text( $event->text );
						if ( $event->start ) $this->set_start( $event->start );
						if ( $event->end ) $this->set_end( $event->end );
				}
		}

		protected function set_vars( $event ) {
				if ( ! is_object( $event ) ) return null;

				if ( $this->text ) $event->text = MPurifier::clean( $this->text );
				else $event->text = null;

				if ( $this->start && MValidate::date( $this->start ) ) $event->start = $this->start;
				else return mapi_report_message( 'Not a valid start date.' );

				if ( $this->end && MValidate::date( $this->end ) ) $event->end = $this->end;
				else return mapi_report_message( 'Not a valid end date.' );

				$start = new DateTime( $event->start );
				$end = new DateTime( $event->end );
				if ( ! $end > $start ) return mapi_report_message( 'Event end is before it\'s starting time.' );

				return true;
		}

}

?>