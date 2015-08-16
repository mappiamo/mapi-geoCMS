<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MSettings{

	    static $sitename = '#mappiamo';
	    static $domain = 'mappiamo';
			static $location = 'Lecce, Italy';
			static $coords = array();

	    static $c_key = 'kanLQmVXLzxa';
	    
	    static $db = 'mappiamo_org006';
	    static $db_type = 'mysql';
	    static $db_host = 'localhost';
	    static $db_prefix = 'mapi';
	    static $db_user = 'mappiamo_org006';
	    static $db_pass = 'D0X1]zT?ifhr';

	    static $reg_email = 'registration@mappiamo.org';
	    static $reg_email_user = 'registration@mappiamo.org';
	    static $reg_email_pass = 'DbiVAdV]RLAS';
	    static $reg_email_host = 'mail.mappiamo.com';

			public function __construct() {
				$contents = ORM::for_table( 'preferences' )->find_array();
				//print_r($contents);
				$coords = array();
				foreach ($contents as $pkey => $pvalue) {
					if ($pvalue['name'] == 'DefaultLatitude') {
						$this::$coords['lat'] = $pvalue['value'];
					}
					if ($pvalue['name'] == 'DefaultLongitude') {
						$this::$coords['lng'] = $pvalue['value'];
					}
					if ($pvalue['name'] == 'location') {
						$this::$location = $pvalue['value'];
					}
				}
			}
}

?>