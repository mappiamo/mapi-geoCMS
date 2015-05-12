<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_MXmlimport extends M_Module {

		public function mxmlimport() {
				error_reporting(1);
		
		}
		
		public function mxml_preview() {
				
				if (!empty($_POST["process_import"])) { $this->mxml_import(); return; }
				
				$this->set_page_title( '#mappiamo - Importer' );
				if ( !isset( $_FILES['xml_file'] ) || !isset( $_FILES['ini_file'] ) ) {
						$this->mxml_form();
				}
				
				else if ( isset( $_FILES['xml_file'] ) && isset( $_FILES['ini_file'] ) ) {

						$xml = $this->model( 'parse_xml');
						$ini = $this->model( 'parse_ini' );

						$data = array( "xml" => $xml, "ini" => $ini );
						$this->view( 'preview', $data );

				}
		}
		
		public function mxml_import() {
				$this->set_page_title( '#mappiamo - Importer report' );
				
				$data = $_POST["mxml_json_data"];
				$inserted = $this->model( 'import_content', $data );
				
				if ( $inserted ) {
						$this->view( 'process_import' );
				}
				
		}
		
		public function mxml_form() {
				$this->set_page_title( '#mappiamo - Importer' );
				
				$this->view( 'default' );
				
		}
		
}

?>
