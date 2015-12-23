<?php

	class M_Place extends M_Post {

		protected $type = 'place';
		protected $kind;
		protected $start = NULL;
		protected $end = NULL;

		public function __construct($id = NULL) {
			if ($id) {
				$this->read($id);
			}
		}

		public function get_start() {
			return $this->start;
		}

		public function get_end() {
			return $this->end;
		}

		public function set_start($value) {
			$this->start = strval($value);
		}

		public function set_end($value) {
			$this->end = strval($value);
		}
	}

?>