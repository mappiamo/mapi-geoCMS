<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_Event extends M_Module {

		private $category;

		public function event() {

			$AllEvents = $this->model('QueryURL');
			$PageTitle = $this->model('GetEventTitle');
			$TemplateName = $this->model('GetTemplateName');

			//print_r($TemplateName);
			//die();

			/* echo '<font size=1 face="arial">';
			if ($AllEvents) {
				echo 'Results: ' . count($AllEvents) . '<hr>';
				foreach ($AllEvents as $Event) {
					echo 'ID: ' . $Event['id'] . ' -> ';
					echo 'Title: ' . $Event['title'] . ' -> ';
					echo 'Address: ' . $Event['address'] . ' -> ';
					echo 'Start: ' . $Event['start'] . ' -> ';
					echo 'End: ' . $Event['end'] . ' -> ';
					echo 'Created: ' . $Event['created'] . ' -> ';
					echo 'Modified: ' . $Event['modified'] . ' -> ';
					echo 'Lang: ' . $Event['language'];
					echo '<hr>';
				}
			} else {
				echo 'No result.....';
			}
			echo '</font>'; */

			if ($AllEvents) {
				$this->view( 'default', array($AllEvents, $PageTitle, $TemplateName));
			} else {
				$this->view( 'default', array(array(), $PageTitle, $TemplateName));
				//echo 'No data.......';
				//exit( 0 );
			}

			die();
				
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