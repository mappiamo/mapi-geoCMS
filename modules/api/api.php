<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModule_Api extends M_Module {

		public function api() {
				$task = $this->get_task();
				
				if ( !$task ) return false;
				$options = array();
				switch ( $task ) {
						case "search":
								
								if ( isset( $_GET["lat"] ) ) { $options["lat"] = $_GET["lat"]; } else return false; //mandatory
								if ( isset( $_GET["lng"] ) ) { $options["lng"] = $_GET["lng"]; } else return false; //mandatory
								if ( isset( $_GET["radius"] ) ) { $options["radius"] = $_GET["radius"]; } else return false; //mandatory
								if ( isset( $_GET["cat"] ) ) {
										if ( is_numeric( $_GET["cat"] ) ) { 
												$options["cat"] = intval( $_GET["cat"] );
										}
										else {
												$options["cat"] = $_GET["cat"];
										}
								}
								$contents = $this->model ( 'search', array( $options ) );
								break;
						case "category":
								
								if ( is_numeric( $_GET["object"] ) ) { 
										$options["object"] = intval( $_GET["object"] );
								}
								else {
										$options["object"] = $_GET["object"];
								}
								
								$contents = $this->model ( 'category', array( $options ) );
								break;
						case "content":
								if ( ! isset( $_GET["object"] ) ) return false;
								
								if ( is_numeric( $_GET["object"] ) ) { 
										$options["object"] = intval( $_GET["object"] );
								}
								else {
										$options["object"] = $_GET["object"];
								}
								
								$contents = $this->model ( 'content', array( $options ) );
								break;
						default:
								return false;
								break;
				}
				
				echo json_encode( $contents );
		}


}

?>
