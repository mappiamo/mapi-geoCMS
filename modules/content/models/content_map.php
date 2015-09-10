<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_Content_Map {

		static function add_category( $id ) {
				$contents = array();

				$category = MObject::get( 'category', $id );

				if ( $category && sizeof( $category->get_contents() ) > 0 ) {
						$i = 0;
						foreach ( $category->get_contents() as $content ) {
								$title = '';
								$title .= '<a href="index.php?module=content&object=' . MPut::id( $content->get_id() ) . '">' . MPut::html( $content->get_title() ) . '</a>';
								$title .= '<br />';
								$title .= '<small>(' . MPut::text( $content->get_address() ) . ')</small>';

								$contents[$i] = array(
										'title'		=> $title,
										'text'		=> substr( strip_tags( $content->get_text() ), 0, 100 ) .' ... <br /><br /><a href="index.php?module=content&object=' . intval( $content->get_id() ) . '"><small>read more &gt;&gt;</small></a>' ,
										'lat'		=> $content->get_lat(),
										'lng'		=> $content->get_lng(),
										//'route'		=> $content->get_route(),
										'category'	=> $category->get_name()
								);

								if ( 'event' == $content->get_type() ) {
										$contents[$i]['start'] = $content->get_start();
										$contents[$i]['end'] = $content->get_end();
								}

								$i++;
						}
				}

				return $contents;
		}
		
}

?>