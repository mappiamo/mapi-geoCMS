<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_Category extends M_Module {

		private $category;

		public function category() {
				$this->category = MObject::get( 'category', $this->get_object() );
				$a = 0;

				if ( $this->category && $this->category->get_id() ) {
						$this->set_page_title( $this->category->get_title() );
						$contents = $this->category->get_contents();
						//getting language
						$language = new M_Language;
						$lang = $language->getLanguage();
						$filtered_contents = array();
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
						$this->view( 'default', array($descending, $this->category->get_title() ) );

				} else {
						header( 'Location: index.php?module=page404' );
						exit( 0 );
				}

		}

}

?>