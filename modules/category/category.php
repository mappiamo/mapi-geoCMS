<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_Category extends M_Module {

		private $category;

		public function category() {
				$this->category = MObject::get( 'category', $this->get_object() );
				$id = $this->get_object();

				//if ( $this->category && $this->category->get_id() ) {
						$this->set_page_title( $this->category->get_title() );
						//$contents = $this->category->get_contents();
						//getting language
						$language = new M_Language;
						$lang = $language->getLanguage();

						$DataStart = 0;
						$DataLimit = 20;

						if (isset($_GET['st'])) {
								$DataStart = $_GET['st'];
						}

						$QueryString = NULL;
						$theplaces = ORM::for_table('categories')->select_many('contents', 'name')->where('id', $id)->where('enabled', '1')->find_one();

						if ($theplaces) {

							$PlacesString = str_replace(array('{', '}'), '', $theplaces['contents']);
							$PlacesArray = explode(';', $PlacesString);

							if (count($PlacesArray) > 0) {
								foreach ($PlacesArray as $ContentID) {
									if (is_numeric($ContentID)) {
										$QueryString .= '`id` = '.$ContentID.' OR ';
									}
								}

								$QueryString = '('.rtrim($QueryString, ' OR ').')';
								$PlaceData = ORM::for_table('contents')->select_many('type', 'title', 'id', 'lat', 'lng', 'text', 'created', 'start', 'end', 'address', 'language', 'modified')->where_raw($QueryString)->where('enabled', 1)->order_by_desc('modified')->limit($DataLimit)->offset($DataStart)->where('language', $lang)->find_array();
								$PlaceCount = ORM::for_table('contents')->select_many('id')->where_raw($QueryString)->where('enabled', 1)->where('language', $lang)->count();

								if (count($PlaceData) > 0) {
									$filtered_contents = array();
									$a = 0;
									$SchemaData = array();

									foreach ($PlaceData as $key => $content) {
										$time = strtotime($content['modified']);
										if ((!$time) || array_key_exists($time, $filtered_contents)) { $time = ++$a; }
										$filtered_contents[$time] = $content;

										$SchemaData[$time] = self::add_schema($content);

									}
									$this->view('default', array($filtered_contents, $this->category->get_title(), $PlaceCount, $DataLimit, $DataStart, $SchemaData));
								} else {
									$filtered_contents[1]['text'] = 'No content in this category with selected language. Try to select another language.';
									$this->view('default', array($filtered_contents, $this->category->get_title(), $PlaceCount, $DataLimit, $DataStart, NULL));
								}

							} else {
								header( 'Location: index.php?module=page404' );
								exit( 0 );
							}
						} else {
							header( 'Location: index.php?module=page404' );
							exit( 0 );
						}

						/*$filtered_contents = array();
						foreach ( $contents as $content ) {
								if ( $lang == $content->get_language() ) {
										$mod = $content->modified();
										$time = strtotime($mod['when']);
										if ((!$time) || array_key_exists($time, $filtered_contents)) { $time = ++$a; }
										$filtered_contents[$time] = $content;
								}
						}
						ksort( $filtered_contents );
						$descending = array_reverse( $filtered_contents );
						$this->view( 'default', array($descending, $this->category->get_title() ) ); */



				//} else {
						//header( 'Location: index.php?module=page404' );
						//exit( 0 );
				//}

		}

	static function add_schema( $data ) {

		$FullURL = rtrim(((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']), '/\\') . '/index.php?module=content&object=' . $data['id'];

		$schema_data['@context'] = 'http://schema.org';
		if ($data['type'] == 'post') {
			$schema_data['@type'] = 'blog';
			$LocationString = 'contentLocation';
		} else {
			$schema_data['@type'] = $data['type'];
			$LocationString = 'location';
		}

		$schema_data['name'] = $data['title'];
		$schema_data['url'] = $FullURL;

		if ($data['type'] == 'place') {
			$schema_data['address']['@type'] = 'Place';
			$schema_data['address'] = $data['address'];
			$schema_data['geo']['@type'] = 'GeoCoordinates';
			$schema_data['geo']['latitude'] = $data['lat'];
			$schema_data['geo']['longitude'] = $data['lng'];
		} else {
			$schema_data[$LocationString]['@type'] = 'Place';
			$schema_data[$LocationString]['address'] = $data['address'];
			$schema_data[$LocationString]['geo']['@type'] = 'GeoCoordinates';
			$schema_data[$LocationString]['geo']['latitude'] = $data['lat'];
			$schema_data[$LocationString]['geo']['longitude'] = $data['lng'];
		}

		$schema_data['description'] = mb_substr(str_replace('"', '', strip_tags($data['text'])), 0, 100, 'UTF-8');

		if ($data['type'] == 'event') {
			$schema_data['startDate'] = $data['start'];
			$schema_data['endDate'] = $data['end'];
			$schema_data[$LocationString]['name'] = $data['address'];
		} elseif ($data['type'] == 'post') {
			$schema_data['inLanguage'] = strtolower($data['language']) . '_' . strtoupper($data['language']);
			$schema_data['dateCreated'] = $data['created'];
			$schema_data['text'] = mb_substr(str_replace('"', '', strip_tags($data['text'])), 0, 200, 'UTF-8');
			//$schema_data['author'] = $data->created()['by_name'];
		}

		return $schema_data;

	}

}

?>