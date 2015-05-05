<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class M_Assets {

		static private $assets_manager = null;
		static private $assets_frontend = null;

		public function __construct() {

		}

		static function instance() {
				if ( ! self::$assets_manager ) {
						self::set_manager_assets();
				}
				if ( ! self::$assets_frontend ) {
						self::set_frontend_assets();
				}
		}

		static function get_manager_assets() {
				return self::$assets_manager;
		}

		static function get_frontend_assets() {
				return self::$assets_frontend;
		}

		static function set_manager_assets() {
				self::$assets_manager = array(
						'css'	=> array(
								'bootstrap/bootstrap.min', 
								'bootstrap/bootstrap-theme.min',
								'leaflet/leaflet',
								'datetimepicker/bootstrap-datetimepicker.min'
						),
						'js' 	=> array(
								'jquery/jquery-1.10.2.min',
								'jquery-cookie/jquery.cookie',
								'bootstrap/bootstrap.min',
								'bootstrap/bootstrap.tabs',
								'leaflet/leaflet',
								'asset.form',
								'asset.map',
								'pikaday/moment',
								'moment-with-locales',
								'datetimepicker/bootstrap-datetimepicker'
						)
				);
		}

		static function set_frontend_assets() {
				self::$assets_frontend = array(
						'css'	=> array(
								'bootstrap/bootstrap.min', 
								'bootstrap/bootstrap-theme.min',
								'leaflet/leaflet'
						),
						'js' 	=> array(
								'jquery/jquery-1.10.2.min',
								'bootstrap/bootstrap.min',
								'leaflet/leaflet',
								'asset.map',
								'asset.map.control'
						)
				);
		}

}

?>