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
							'leaflet-draw/leaflet.draw',
							'datetimepicker/bootstrap-datetimepicker.min',
							'autocomplete/jquery.autocomplete'
						),
						'js' 	=> array(
							//'jquery/jquery-1.10.2.min',
							'jquery/jquery-1.8.0',
							'jquery-geo/jquery.geo.core',
							'jquery-cookie/jquery.cookie',
							'bootstrap/bootstrap.min',
							'bootstrap/bootstrap.tabs',
							'leaflet/leaflet',

							'leaflet/terraformer.min',
							'leaflet/terraformer-wkt-parser.min',

							'leaflet-draw/Leaflet.draw',
							'leaflet-draw/Toolbar',
							'leaflet-draw/Tooltip',
							'leaflet-draw/ext/GeometryUtil',
							'leaflet-draw/ext/LatLngUtil',
							'leaflet-draw/ext/LineUtil.Intersect',
							'leaflet-draw/ext/Polygon.Intersect',
							'leaflet-draw/ext/Polyline.Intersect',

							'leaflet-draw/draw/DrawToolbar',
							'leaflet-draw/draw/handler/Draw.Feature',
							'leaflet-draw/draw/handler/Draw.SimpleShape',
							'leaflet-draw/draw/handler/Draw.Polyline',
							'leaflet-draw/draw/handler/Draw.Circle',
							'leaflet-draw/draw/handler/Draw.Marker',
							'leaflet-draw/draw/handler/Draw.Polygon',
							'leaflet-draw/draw/handler/Draw.Rectangle',

							'leaflet-draw/edit/EditToolbar',
							'leaflet-draw/edit/handler/EditToolbar.Edit',
							'leaflet-draw/edit/handler/EditToolbar.Delete',

							'leaflet-draw/Control.Draw',

							'leaflet-draw/edit/handler/Edit.Poly',
							'leaflet-draw/edit/handler/Edit.SimpleShape',
							'leaflet-draw/edit/handler/Edit.Circle',
							'leaflet-draw/edit/handler/Edit.Rectangle',
							'leaflet-draw/edit/handler/Edit.Marker',

							'asset.form',
							'asset.map',
							'pikaday/moment',
							'moment-with-locales',
							'datetimepicker/bootstrap-datetimepicker',
							'autocomplete/jquery.autocomplete'
						)
				);
		}

		static function set_frontend_assets() {
				self::$assets_frontend = array(
						'css'	=> array(
								'bootstrap/bootstrap.min',
								'bootstrap/bootstrap-theme.min',
								'lightbox/lightbox',
								'slide/slide',
								'leaflet/leaflet',
								'jssor/jssor.slider',
								'leaflet-photomarker/leaflet.photomarker',
								'leaflet-groupedlayercontrol/leaflet.groupedlayercontrol',
								'box/box'
						),
						'js' 	=> array(
								//'jquery/jquery-1.10.2.min',
								'jquery/jquery-1.8.0',
								'jquery-geo/jquery.geo.core',
								'bootstrap/bootstrap.min',
								'leaflet/leaflet',
								'leaflet-photomarker/PhotoMarkerMatrix',
								'leaflet-photomarker/PhotoMarker',
								'leaflet-photomarker/PhotoIcon',
								'leaflet-weather/leaflet-weathericonslayer',
								'jssor/jssor',
								'jssor/jssor.slider',
								'lightbox/lightbox.min',
								'leaflet-groupedlayercontrol/leaflet.groupedlayercontrol',
								'asset.map',
								'asset.map.control',
								'custom_menu'
						)
				);
		}

}

?>