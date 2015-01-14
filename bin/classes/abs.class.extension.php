<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

abstract class M_Extension{

		private $name;
		private $title;
		private $version;
		private $description;
		private $default = 0;
		private $enabled = 0;

		private $dir;
		private $wdir;

		protected $type = null;
		protected $page_title = null;
		protected $page_meta = null;
		protected $page_assets = null;
		protected $page_js = null;

		public function get_type() {
				return $this->type;
		}

		public function get_name() {
				return $this->name;
		}

		public function get_title() {
				return $this->title;
		}

		public function get_version() {
				return $this->version;
		}

		public function get_description() {
				return $this->description;
		}

		public function is_default() {
				if ( 1 == $this->default ) return true;

				return false;
		}

		public function is_enabled() {
				if ( 1 == $this->enabled ) return true;

				return false;
		}

		public function get_dir() {
				return $this->dir;
		}

		public function get_wdir() {
				return $this->wdir;
		}

		public function get_page_title() {
				return $this->page_title;
		}

		public function get_page_meta() {
				return $this->page_meta;
		}

		public function get_page_assets() {
				return $this->page_assets;
		}

		public function get_page_js() {
				return $this->page_js;
		}

		public function get_default() {
				if ( ! $this->type ) return null;

				$table = $this->type . 's';
				$default_type = 'default_' . $this->type;

				$extension = ORM::for_table( $table )->where( $default_type, 1 )->where( 'manager', 0 )->find_one();

				if ( $extension && $extension->name ) return $extension->name;

				return null;
		}

		public function set_page_title( $value ) {
				if ( $value && $page_title = strval( $value ) ) {
						$this->page_title = strip_tags( $page_title );
				} else {
						$this->page_title = '#mappiamo';
				}
		}

		public function add_page_asset( $type, $value ) {
				switch ( $type ) {
						case 'js':
								if ( ! isset( $this->page_assets['js'] ) ) $this->page_assets['js'] = array();
								if ( $value && $source = strval( $value ) ) $this->page_assets['js'][] = $source;
						break;
						case 'css':
								if ( ! isset( $this->page_assets['css'] ) ) $this->page_assets['css'] = array();
								if ( $value && $source = strval( $value ) ) $this->page_assets['css'][] = $source;
						break;
				}
		}

		public function add_page_meta( $name, $value ) {
				if ( ! is_array( $this->page_meta ) ) $this->page_meta = array();

				$this->page_meta[strval( $name )] = strval( $value );
		}

		public function add_page_js( $value ) {
				if ( ! is_array( $this->page_js ) ) $this->page_js = array();

				if ( $js = strval( $value ) ) $this->page_js[] = $js;
		}

		public function widget( $name = '', $parms = array() ) {
				if ( ! $name || ! strlen( $name ) > 0 ) return null;

				$widget = new M_Widget( $name, $parms );

				echo $widget->get_content();
		}

		private function get_store() {
				$table = null;

				switch ( $this->type ) {
					case 'module':
					case 'template':
					case 'widget':
							$table = $this->type . 's';
					break;
				}

				return $table;
		}

		private function get_availables() {
				$availables = array();

				$table = $this->get_store();

				if ( ! $table )  return $availables; 

				if ( 'manager' == ENV ) $extensions = ORM::for_table( $table )->where( 'manager', 1 )->where( 'enabled', 1 )->find_many();
				else $extensions = ORM::for_table( $table )->where( 'manager', 0 )->where( 'enabled', 1 )->find_many();

				if ( is_array( $extensions ) && sizeof( $extensions ) > 0 ) {
						foreach ( $extensions  as $extension ) {
								$availables[] = $extension->name;
						}
				}

				return $availables;
		}

		private function set_name( $value ) {
				if ( $name = strval( $value ) ) $this->name = $name;
		}

		private function set_title( $value ) {
				if ( $title = strval( $value ) ) $this->title = $title;
		}

		private function set_version( $value ) {
				if ( $version = strval( $value ) ) $this->version = $version;
		}

		private function set_description( $value ) {
				if ( $description = strval( $value ) ) $this->description = $value;
		}

		private function set_default( $value ) {
				if ( 1 == $value ) $this->default = 1;
		}

		private function set_enabled( $value ) {
				if ( 1 == $value ) $this->enabled = 1;
		}

		private function set_dir() {
				if ( ! $this->get_store() ) return null;

				$this->dir = $this->get_store() . '/' . $this->name . '/';
		}

		private function set_wdir() {
				if ( ! $this->get_store() ) return null;

				$path = $this->get_store() . '/' . $this->name;
				if ( 'manager' == ENV ) $this->wdir = 'manager/' . $path;
				else $this->wdir = $path;
		}

		protected function get_details( $name ) {
				if ( ! MValidate::ext_name( $name ) ) return false;

				$this->set_name( $name );

				if ( ! $this->name ) return false;

				$table = $this->get_store();

				if ( ! $table ) return false;

				$extension = ORM::for_table( $table )->where( 'name', strval( $this->name ) )->find_one();

				if ( ! $extension ) return false;

				if ( $extension->title ) $this->set_title( $extension->title );
				if ( $extension->version ) $this->set_version( $extension->version );
				if ( $extension->description ) $this->set_description( $extension->description );
				if ( $extension->default ) $this->set_default( $extension->default );
				if ( $extension->enabled ) $this->set_enabled( $extension->enabled );

				$this->set_dir();
				$this->set_wdir();

				return true;
		}

		protected function set_type() {
				switch( get_class( $this ) ) {
						case 'M_Module': $this->type = 'module'; break;
						case 'M_Template': $this->type = 'template'; break;
						case 'M_Widget': $this->type = 'widget'; break;
				}
		}

		protected function set_child_details( $child ) {
				if ( ! is_object( $child ) ) return null;

				$child->name = $this->get_name();
				$child->title = $this->get_title();
				$child->version = $this->get_version();
				$child->description = $this->get_description();
				$child->default = $this->is_default();
				$child->enabled = $this->is_enabled();
				$child->wdir = $this->get_wdir();
		}

		protected function prerun() {
				$assets = array();

				M_Assets::instance();
				if ( 'manager' == ENV ) $assets = M_Assets::get_manager_assets();
				else $assets = M_Assets::get_frontend_assets();

				foreach ( $assets as $key => $value ) {
						if ( is_array( $assets[$key] ) && sizeof( $assets[$key] ) > 0 ) {
								foreach ( $value as $asset ) $this->add_page_asset( $key, $asset );
						}
				}
		}

		protected function valid( $extension ) {
				$this->set_type();

				if ( ! $extension ) return false;
				if ( ! MValidate::ext_name( $extension ) ) return false;
				if ( ! in_array( $extension,  $this->get_availables() ) ) return false;

				return true;
		}

}

?>