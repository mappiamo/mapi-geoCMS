<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MSettings{
    
	    static $sitename = 'Your Site Name';
	    static $domain = 'mappiamo.com';
	    static $location = 'address, zip, city';
	    	static $coords = array();

	    static $c_key = 'sadqasdgfasdgaf';
	    
	    static $db = 'account_mapi';
	    static $db_type = 'mysql';
	    static $db_host = 'localhost';
	    static $db_prefix = 'mapi';
	    static $db_user = 'accountuser';
	    static $db_pass = 'sdfasdf';

	    static $reg_email = '';
	    static $reg_email_user = '';
	    static $reg_email_pass = '';
	    static $reg_email_host = ''; 
	    
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
