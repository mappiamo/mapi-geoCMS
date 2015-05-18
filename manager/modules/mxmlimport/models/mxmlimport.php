<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_Mxmlimport {

		static function parse_xml($data) {
				$xml = $_FILES["xml_file"];

				$xml = simplexml_load_file($_FILES["xml_file"]["tmp_name"]);
				$ini = parse_ini_file($_FILES["ini_file"]["tmp_name"]);

				$XML_objects = array();
				foreach ($xml->children() as $child) {
					$XML_objects[] = $child->getName();
				}

				$XML_objects = array_unique($XML_objects);

				$elements = array();
				$x = 0;
				foreach ( $xml->$XML_objects[0] as $element ) {
					//$geo = self::geocode($element[$x++]->Address . ", " . $element[$x]->ZIP . ", " . $element[$x]->City);
					$geo = self::geocode($element->$ini['Address'] . ", " . $element->$ini['ZIP'] . ", " . $element->$ini['City']);
					$element->lat = $geo["lat"];
					$element->lng = $geo["lng"];
					$elements[] = $element;
				}
				
				return $elements;
		}

		public function parse_ini() {
				
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
				$TitleName = $config->Title;
				$AddressName = $config->Address;
				$ZipName = $config->ZIP;
				$CityName = $config->City;

				$category = new M_Category( $cat );
				$category->set_title( $cat );
				$category->add();

				$desc_data = explode( ",", $config->description );

				$t = 0;
				foreach( $encdata->xml as $place ) {
						$content = MObject::create( 'place' );
						$TheTitle =  $place->$TitleName;
						if (empty($TheTitle)) { $TheTitle =  $place->{'@attributes'}->$TitleName; }
						if (empty($TheTitle)) { $TheTitle = 'Empty title ' . ++$t; }
						$content->set_title( $TheTitle );
						$content->set_address( $place->$AddressName . ", " . $place->$ZipName . ", " . $place->$CityName );
						$content->set_lat( $place->lat );
						$content->set_lng( $place->lng );
						$content->set_license( 2 );
						$text = "";
						foreach ( $desc_data as $desc ) {
								if ( "NL" == substr( $desc, -2 ) ) {
										$newline = "<br />";
								} else {
										$newline = ", ";
								}

								$attr = array_search( strtolower(rtrim($desc, 'NL')), array_map('strtolower',(array)$config ));
								if (!empty($attr)) {
									$pre_text = $place->$attr;
									if ( is_string( $pre_text ) ) {
										$text .= rtrim($desc, 'NL') . ": " . $pre_text . $newline;
									} else {
										if (strtolower($desc) == 'desc_only') {
											$text .= $place->desc_only;
										}
									}
								} else {

								}
						}

						$content->set_text( $text );
						$content->add();

						$MetaArray = (array)$place;
						$MetaArray = array_filter($MetaArray);

						foreach( $config as $key => $value ) {
								$key = trim($key); $value = trim($value);
								if ((isset($MetaArray[$value])) && ($value != 'desc_only')) {
										$DescVal = trim($MetaArray[$value]);
										if ((!empty($DescVal)) && (!empty($key))) {
												$content->add_meta( $key, $DescVal );
										}
								}
						}

						$category->add_content( $content->get_id() );
				}
				
				$category->update();
				return true;
		}

}

?>
