<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_Mxmlimport {

		static function parse_xml() {
				$xml = $_FILES["xml_file"];
				
				$xml = simplexml_load_file($_FILES["xml_file"]["tmp_name"]);
				
				$elements = array();
				foreach ( $xml->dealer as $element ) {
						$geo = self::geocode($element->address . ", " . $element->zip . ", " . $element->city);
						$element->lat = $geo["lat"];
						$element->lng = $geo["lng"];
						$elements[] = $element;
				}
				
				return $elements;
		}

		static function parse_ini() {
				
				$ini = parse_ini_file($_FILES["ini_file"]["tmp_name"]);
				
				return $ini;
		}

		static function geocode( $address = null) {
				$result = array( 'status' => 'FAIL', 'lat' => null, 'lng' => null );


				if ( ! MValidate::address( $address ) ) return $result;

				global $geocoder;

				try {
						$geocode = $geocoder->geocode( $address );
						$result['status'] = 'OK';
						$result['lat'] = $geocode->getLatitude();
						$result['lng'] = $geocode->getLongitude();
				} catch( Exception $e ) {
						return $result;
				}

				return $result;

		}
		
		static function import_content( $data ) {
				$encdata = json_decode( base64_decode( $data ) );
				
				$config = $encdata->ini;
				
				$cat = $config->category;

				$category = new M_Category( $cat );
				//$category->set_title( $cat );
				//$category->add();
				
				
				$desc_data = explode( ",", $config->description );
				
				foreach( $encdata->xml as $place ) {
						$content = MObject::create( 'place' );
						$content->set_title( $place->companyname );
						$content->set_address( $place->address . ", " . $place->cap . ", " . $place->city );
						$content->set_lat( $place->lat );
						$content->set_lng( $place->lng );
						$content->set_license( 2 );
						$text = "";
						foreach ( $desc_data as $desc ) {
								if ( "NL" == substr( $desc, -2 ) ) {
										$newline = "<br />";
								}
								else {
										$newline = ", ";
								}
								$attr = array_search( trim($desc,"NL"), (array)$config );
								$pre_text = $place->$attr;
								if ( is_string( $pre_text ) ) {
									$text .= trim($desc,"NL") . ": " . $pre_text . $newline;
								}
						}
						
						$content->set_text( $text );
						
						$content->add();
						
						foreach( (array)$place as $key => $value ) {
								if ( is_string($key) && ( is_string($value) || is_numeric($value)) ) {
										$transformedkey = $config->$key;
										$content->add_meta( $transformedkey, $value );
								}
						}
						

						$category->add_content( $content->get_id() );
//echo $content->get_id();
//var_dump( $category );
						
				}
				
				$category->update();
//var_dump($category);
				//echo "<pre>";
				//print_r( (array)$config );
				//echo "</pre>";

				
				
				return true;
		}

}

?>
