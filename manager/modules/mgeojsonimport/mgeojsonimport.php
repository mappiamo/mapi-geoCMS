<?php

	defined( 'DACCESS' ) or die;

	class MModule_MGeojsonimport extends M_Module {

		public function mgeojsonimport() {
			error_reporting(1);
		}

		public function mgeo_preview() {

			if (!isset( $_FILES['geojson_file']) || !isset($_FILES['ini_file'])) {
				$this->mgeo_form();
				return;
			}

			if (!isset($_POST['category_name'])) {
				$message = 'Category must be created and selected before import process.';
				MMessaging::add_error($message);
				$this->mgeo_form();
				return;
			}

			$this->set_page_title('#mappiamo - SHP -> GeoJson Importer');

			if (!isset($_FILES['ini_file'])) {
				$message = 'INI file missing. [filename].ini required.';
				MMessaging::add_error($message);
				$this->mgeo_form();
				return;
			} else if (isset($_FILES['ini_file'])) {

				$inicommands = $this->model('parse_ini');

				if (!$inicommands) {
					$message = 'Invalid content in .ini file.';
					MMessaging::add_error($message);
					$this->mgeo_form();
					return;
				}
			}

			if (!isset($_FILES['geojson_file'])) {
				$message = 'GeoJson file missing. [filename].geojson required.';
				MMessaging::add_error($message);
				$this->mgeo_form();
				return;
			} else if (isset($_FILES['geojson_file'])) {
				$geojson = $this->model('parse_geojson');

				if (($geojson) && ($inicommands)) {

					if ((count($geojson['GeoType']) == $geojson['DataQTY']) && ($geojson['DataQTY'] > 0) && (count($geojson['DefaultCoords']) == $geojson['DataQTY']) && (count($geojson['WKTString']) == $geojson['DataQTY']) && (count($geojson['GeoProp']) == $geojson['DataQTY'])) {

						$ImportData['ini'] = $inicommands;
						$ImportData['geo'] = $geojson;

						$IsValidFiles = $this->model('geojson_ini_check', array($ImportData));

						if ($IsValidFiles) {
							$this->mgeo_import($ImportData);
						} else {
							$message = 'The GeoJson file, the database tables and the INI files are not compatible. Please check ini-file settings.';
							MMessaging::add_error($message);
							$this->mgeo_form();
							return;
						}

					} else {
						$message = 'GeoJson file contains invalid data structure.';
						MMessaging::add_error($message);
						$this->mgeo_form();
						return;
					}
				} else {
					$message = 'Invalid GeoJson file. GeoJson must be converted from .shp source by QGIS.';
					MMessaging::add_error($message);
					$this->mgeo_form();
					return;
				}
			}

		}

		public function mgeo_import($ImportData) {

			$this->set_page_title('#mappiamo - SHP -> GeoJson Importer report');

			$ImportData['geo']['CatName'] = $_POST['category_name'];
			$inserted = $this->model('import_content', array($ImportData));

			if ($inserted) {
				$this->view('process_import', $inserted);
			}
		}

		public function mgeo_form() {
			$this->set_page_title('#mappiamo - SHP -> GeoJson Importer');
			$Categories = $this->model('getallcategory');
			$this->view('default', $Categories);
		}
	}