<?php

	abstract class M_Record {

		protected $id;
		protected $type;
		protected $name;
		protected $title;
		protected $address;
		protected $lat = 0;
		protected $lng = 0;
		protected $license = 1;
		protected $created;
		protected $createdby;
		protected $modified;
		protected $modifiedby;
		protected $hits = 0;
		protected $translation = 0;
		protected $enabled = 1;
		protected $parent;
		protected $import_id;
		protected $language;
		protected $route;

		public function get_id() {
			return $this->id;
		}

		public function get_type() {
			return $this->type;
		}

		public function get_name() {
			return $this->name;
		}

		public function get_title() {
			return $this->title;
		}

		public function get_address() {
			return $this->address;
		}

		public function get_lat() {
			return $this->lat;
		}

		public function get_route() {
			return $this->route;
		}

		public function get_importid() {
			return $this->import_id;
		}

		public function get_lng() {
			return $this->lng;
		}

		public function get_license() {
			return $this->license;
		}

		public function created() {
			$created = array('when' => $this->created, 'by' => $this->createdby);

			$user = MObject::get('user', $this->createdby);

			if ($user && $user->get_username()) {
				$created['by_user'] = $user->get_username();
			}
			if ($user && $user->get_email()) {
				$created['by_email'] = $user->get_email();
			}
			if ($user && $user->get_name()) {
				$created['by_name'] = $user->get_name();
			} else {
				$created['by_user'] = 'N/A';
			}

			return $created;
		}

		public function modified() {
			$modified = array('when' => $this->modified, 'by' => $this->modifiedby);

			$user = MObject::get('user', $this->modifiedby);
			if ($user && $user->get_username()) {
				$modified['by_user'] = $user->get_username();
			}
			if ($user && $user->get_name()) {
				$modified['by_name'] = $user->get_name();
			} else {
				$modified['by_user'] = 'N/A';
			}

			return $modified;
		}

		public function get_hits() {
			return $this->hits;
		}

		public function get_parent() {
			return $this->parent;
		}

		public function get_language() {
			return $this->language;
		}

		public function is_translation() {
			if (1 == $this->translation) {
				return TRUE;
			}

			return FALSE;
		}

		public function is_enabled() {
			if (1 == $this->enabled) {
				return TRUE;
			}

			return FALSE;
		}

		public function get_meta($name = NULL) {
			if (!$name || !strlen($name) > 0) {
				if ($this->id) {
					return mapi_list('content_meta',
													 array('external_id' => $this->id, 'orderby' => array('column' => 'id', 'desc' => FALSE)));
				} else {
					return array();
				}
			} else {
				return new M_Meta('contents', $this->id, $name);
			}
		}

		public function get_media($default = FALSE) {
			if (!$default) {
				if ($this->id) {
					return mapi_list('content_media', array('external_id' => $this->id, 'orderby' => array('column' => 'id')));
				} else {
					return array();
				}
			} else {
				$media =
				ORM::for_table('content_media')->where('external_id', intval($this->id))->where('default_media', 1)->find_one();

				return $media;
			}
		}

		public function get_categories() {
			if ($this->id) {
				return mapi_list_content_categories($this->id);
			} else {
				return array();
			}
		}

		public function permission() {
			if (!MAuth::is_auth()) {
				return FALSE;
			}

			if (MAuth::group_id() > 2) {
				if (MAuth::user_id() != $this->createdby) {
					return FALSE;
				}
			}

			if (MAuth::group_id() > 3) {
				return FALSE;
			}

			return TRUE;
		}

		public function set_id($value) {
			$this->id = intval($value);
		}

		public function set_title($value) {
			$this->title = strval($value);
			$this->set_name(mapi_convert_to_name($this->title));
		}

		public function set_name($value) {
			$this->name = strval($value);
		}

		public function set_address($value) {
			$this->address = strval($value);
		}

		public function set_route($value) {
			$this->route = strval($value);
		}

		public function set_importid($value) {
			$this->import_id = strval($value);
		}

		public function set_lat($value) {
			$this->lat = doubleval($value);
		}

		public function set_lng($value) {
			$this->lng = doubleval($value);
		}

		public function set_license($value) {
			$this->license = intval($value);
		}

		public function set_translation($translation) {
			if (0 == $translation || 1 == $translation) {
				$this->translation = $translation;
			}
		}

		public function set_enabled($enabled) {
			if (0 == $enabled || 1 == $enabled) {
				$this->enabled = $enabled;
			}
		}

		public function set_parent($parent) {
			$this->parent = $parent;
		}

		public function set_language($language) {
			$this->language = $language;
		}

		public function add_hit($value) {
			if ($hit = intval($value)) {
				$this->hits = $this->hits + $hit;
			}
		}

		public function add_meta($name, $value) {
			if (!$this->id) {
				return NULL;
			}

			if (!$this->permission()) {
				return mapi_report('No permission to edit this content');
			}

			$meta = new M_Meta();
			$meta->set_external('contents');
			$meta->set_external_id($this->id);
			$meta->set_name($name);
			$meta->set_value($value);
			$meta->add();
		}

		public function delete_meta($name) {
			if (!$this->id) {
				return NULL;
			}

			if (!$this->permission()) {
				return mapi_report('No permission to edit this content');
			}

			$meta = new M_Meta('contents', $this->id, $name);
			$meta->delete();
		}

		protected function add_record() {
			if (!MAuth::user_id()) {
				return NULL;
			}

			$record = ORM::for_table('contents')->create();

			if (!$record || !$this->setup_object($record, TRUE)) {
				return NULL;
			}

			$record->created = date_format(new DateTime('now'), 'Y-m-d H:i:s');
			$record->createdby = MAuth::user_id();
			$record->modified = $record->created;
			$record->modifiedby = $record->createdby;
			$record->route = MGet::string( 'content_route' );

			return $record;
		}

		protected function update_record() {
			if (!$this->permission()) {
				return mapi_report('No permission to edit this content');
			}

			$record = NULL;

			if ($this->id && MValidate::id($this->id)) {
				$record = ORM::for_table('contents')->find_one($this->id);
			}

			if (!$record || !$this->setup_object($record)) {
				return NULL;
			}

			$record->modified = date_format(new DateTime('now'), 'Y-m-d H:i:s');
			$record->modifiedby = MAuth::user_id();
			$record->route = MGet::string( 'content_route' );

			return $record;
		}

		protected function delete_record() {
			if (!$this->permission()) {
				return mapi_report('No permission to edit this content');
			}

			if ($this->id && MValidate::id($this->id)) {
				$record = ORM::for_table('contents')->find_one(intval($this->id));

				if ($record->delete()) {
					$this->wipe_meta();
					$this->wipe_media();
					return TRUE;
				}
			}

			return FALSE;
		}

		protected function read_record($id = NULL, $type = NULL) {
			if (!$id) {
				return NULL;
			}
			if (!$type) {
				return NULL;
			}

			$record = ORM::for_table('contents')->where('id', intval($id))->where('type', strval($type))->find_one();

			if (!$record) {
				return NULL;
			}

			if ($record->id) {
				$this->set_id($record->id);
			}
			//if ( $record->parent ) $this->set_parent( $record->parent );
			if ($record->category) {
				$this->set_category($record->category);
			}
			if ($record->name) {
				$this->set_name($record->name);
			}
			if ($record->title) {
				$this->set_title($record->title);
			}
			if ($record->address) {
				$this->set_address($record->address);
			}
			if ($record->lat) {
				$this->set_lat($record->lat);
			}
			if ($record->lng) {
				$this->set_lng($record->lng);
			}
			if ($record->route) {
				$this->set_route($record->route);
			}
			if ($record->import_id) {
				$this->set_importid($record->import_id);
			}
			if ($record->license) {
				$this->set_license($record->license);
			}
			if ($record->created) {
				$this->created = $record->created;
			}
			if ($record->createdby) {
				$this->createdby = $record->createdby;
			}
			if ($record->modified) {
				$this->modified = $record->modified;
			}
			if ($record->modifiedby) {
				$this->modifiedby = $record->modifiedby;
			}
			if ($record->child && 1 == $record->child) {
				$this->child = 1;
			}
			if ($record->translation && 1 == $record->translation) {
				$this->translation = 1;
			}
			if ($record->enabled && 1 == $record->enabled) {
				$this->enabled = 1;
			} else {
				$this->enabled = 0;
			}
			if ($record->language) {
				$this->language = $record->language;
			}
			if ($record->parent) {
				$this->parent = $record->parent;
			}

			return $record;
		}

		abstract protected function add();

		abstract protected function read($id);

		private function setup_object($record, $new = FALSE) {
			if (!$record || !is_object($record)) {
				return NULL;
			}

			//if ($this->title && MValidate::title($this->title)) {
			if ($this->title) {
				$record->title = $this->title;
			} else {
				return mapi_report_message('Not a valid content title: '.$this->title);
			}

			if ($this->license && MValidate::id($this->license) && in_array($this->license, mapi_available_ids('licenses'))) {
				$record->license = $this->license;
			} else {
				return mapi_report_message('Not a valid content license: '.$this->license);
			}

			$record->name = $this->name;

			if ($new) {
				if (!mapi_check_double('contents', 'name', $this->name)) {
					return mapi_report_message('Content with that name already exists: '.$this->name);
				}
			}

			if ($this->address && MValidate::address($this->address)) {
				$record->address = $this->address;
			} else {
				return mapi_report_message('Not a valid content address: '.$this->address);
			}

			if (isset($this->meta_name)) {
				if ($this->meta_name && MValidate::meta_name($this->meta_name)) {
					$record->meta_name = $this->meta_name;
				} else {
					return mapi_report_message('Not a valid meta name: '.$this->meta_name);
				}
			}

			if (isset($this->meta_value)) {
				//if ($this->meta_value && MValidate::meta_value($this->meta_value)) {
				if ($this->meta_value) {
					$record->meta_value = $this->meta_value;
				} else {
					return mapi_report_message('Not a valid meta value: '.$this->meta_value);
				}
			}


			if ($this->lat && MValidate::coord($this->lat)) {
				$record->lat = $this->lat;
			} else {
				return mapi_report_message('Not a valid latitude.');
			}

			if ($this->lng && MValidate::coord($this->lng)) {
				$record->lng = $this->lng;
			} else {
				return mapi_report_message('Not a valid longitude.');
			}

			if ($this->hits && $this->hits > 0) {
				$record->hits = intval($this->hits);
			}

			if ($this->parent) {
				$record->parent = intval($this->parent);
			}

			if ($this->language) {
				$record->language = strval($this->language);
			}

			if ($this->translation && 1 == $this->translation) {
				$record->translation = 1;
			}
			if ($this->enabled && 1 == $this->enabled) {
				$record->enabled = 1;
			} else {
				$record->enabled = 0;
			}

			return TRUE;
		}

		private function wipe_meta() {
			if (!$this->id) {
				return NULL;
			}

			$meta_records = ORM::for_table('content_meta')->where('external_id', intval($this->id))->find_many();
			if (sizeof($meta_records) > 0) {
				foreach ($meta_records as $meta) {
					$meta->delete();
				}
			}
		}

		private function wipe_media() {
			if (!$this->id) {
				return NULL;
			}

			$media_records = ORM::for_table('content_media')->where('external_id', intval($this->id))->find_many();
			if (sizeof($media_records) > 0) {
				foreach ($media_records as $media) {
					$media->delete();
				}
			}
		}

	}

?>