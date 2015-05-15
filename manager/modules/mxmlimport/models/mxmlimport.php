<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_Mxmlimport {

		static function parse_xml() {
				$xml = $_FILES["xml_file"];

				$xml = simplexml_load_file($_FILES["xml_file"]["tmp_name"]);

				$XML_objects = array();
				foreach ($xml->children() as $child) {
					$XML_objects[] = $child->getName();
				}

				$XML_objects = array_unique($XML_objects);

				$elements = array();
				$x = 0;
				foreach ( $xml->$XML_objects[0] as $element ) {
					//$geo = self::geocode($element[$x++]->Address . ", " . $element[$x]->ZIP . ", " . $element[$x]->City);
					$geo = self::geocode($element->Address . ", " . $element->ZIP . ", " . $element->City);
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
				//print_r($config);

				$cat = $config->category;

				$category = new M_Category( $cat );
				$category->set_title( $cat );
				$category->add();
				
				
				$desc_data = explode( ",", $config->description );
				//print_r($desc_data);
				//print_r($encdata->xml); die();

				$t = 0;
				foreach( $encdata->xml as $place ) {
						//echo $place->{'@attributes'}->nomeufficio; die();
						$content = MObject::create( 'place' );
						//$TheTitle =  $place->{'@attributes'}->nomeufficio;
						//$TheTitle =  $place->Title;
						//$TheTitle =  $place->legalName;
						//$TheTitle = $place->Ragione_Sociale;
						$TheTitle =  $place->legalname;
						if (empty($TheTitle)) { $TheTitle = 'Empty title ' . ++$t; }
						$content->set_title( $TheTitle );
						$content->set_address( $place->Address . ", " . $place->ZIP . ", " . $place->City );
						$content->set_lat( $place->lat );
						$content->set_lng( $place->lng );
						$content->set_license( 2 );
						$text = "";
						//print_r($desc_data); die();
						//print_r($place);
						//print_r((array)$config);
						foreach ( $desc_data as $desc ) {
								//echo $desc . ' -> ';
								if ( "NL" == substr( $desc, -2 ) ) {
										$newline = "<br />";
								} else {
										$newline = ", ";
								}

								$attr = array_search( strtolower(rtrim($desc, 'NL')), array_map('strtolower',(array)$config ));
								//print_r(strtolower(rtrim($desc, 'NL'))); echo ' -> ';
								//print_r($attr); echo ' -> ';
								//print_r($place->$attr); echo PHP_EOL;
								if (!empty($attr)) {
									$pre_text = $place->$attr;
									//echo $pre_text . '->' . PHP_EOL;
									if ( is_string( $pre_text ) ) {
										$text .= rtrim($desc, 'NL') . ": " . $pre_text . $newline;
									} else {
										if (strtolower($desc) == 'desc_only') {
											$text .= $place->desc_only;
										}
									}
								} else {

								}
								//echo $text . '<br>';
						}

						//echo $text; die();

						$content->set_text( $text );
						$content->add();

						$MetaArray = (array)$place;
						$MetaArray = array_filter($MetaArray);

						//print_r($config);
						//print_r($MetaArray);

						foreach( $config as $key => $value ) {
								$key = trim($key); $value = trim($value);
								if ((isset($MetaArray[$value])) && ($value != 'desc_only')) {
										$DescVal = trim($MetaArray[$value]);
										if ((!empty($DescVal)) && (!empty($key))) {
												$content->add_meta( $key, $DescVal );
										}
								}
						}

						//die();
						
						/* foreach( $MetaArray as $key => $value ) {
								$key = trim($key); $value = trim($value);
								if ((!empty($key)) && (!empty($value)) && (strtolower($key) != 'desc_only')) {
									if ( is_string($key) && ( is_string($value) || is_numeric($value)) ) {
											$transformedkey = trim($config->$key);
											if (!empty($transformedkey)) {
												$content->add_meta( $transformedkey, $value );
											}
									}
								}
						} */

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
