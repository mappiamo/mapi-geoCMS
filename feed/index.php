<?php

//header('Content-type: application/xml; charset=utf-8');

// Error reporting
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

define( 'DACCESS', 1 );
define( 'ENV', 'frontend' );

$settings = '../settings.php';
$feed_lib = '../lib/feedwritter/FeedTypes.php';
$idiorm_lib = '../lib/idiorm/idiorm.php';

if ( '80' != $_SERVER['SERVER_PORT'] ) $url = 'http://' . $_SERVER['HTTP_HOST'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'] ;
else $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ;

$content_url = substr( $url, 0, strpos( $url, '/feed') ) . '/index.php?module=content&object=';

if ( is_file( $settings ) && is_readable( $settings ) ) include( $settings );
else die( 'no settngs' );

if ( is_file( $feed_lib ) && is_readable( $feed_lib ) ) include( $feed_lib );
else die( 'no feed lib' );

if ( ! idiorm( $idiorm_lib ) ) die( 'Idiorm error' );

$feed = new RSS2FeedWriter();
$feed->setTitle( MSettings::$sitename );
$feed->setLink( $url );
$feed->setDescription( '' );
//Image title and link must match with the 'title' and 'link' channel elements for RSS 2.0
//$feed->setImage('Testing the RSS writer class','http://www.ajaxray.com/projects/rss','http://www.rightbrainsolution.com/_resources/img/logo.png');
$feed->setChannelElement( 'language', 'en-us' );
$feed->setChannelElement( 'pubDate', date( DATE_RSS, time() ) );

$contents = ORM::for_table( 'contents' )->where( 'enabled', 1 )->find_many();

if ( sizeof( $contents ) > 0 ) {
		foreach ( $contents as $content ) {
				$item = $feed->createNewItem();

				$item->setTitle( $content->title );
  				$item->setLink( $content_url . $content->id );
  				$item->setDate( strtotime( $content->created ) );
  				$item->setDescription( strip_tags( $content->text ) );
  				//$item->addElement('author', 'admin@ajaxray.com (Anis uddin Ahmad)');
  
  				$feed->addItem($item);
		}
}

$feed->generateFeed();

function idiorm( $path ) {
		if ( is_file( $path ) && is_readable( $path ) ) include( $path );
		else return false;

        if ( ! isset( MSettings::$db_host ) || ! strlen( MSettings::$db_host ) > 0 ) return false;
        if ( ! isset( MSettings::$db ) || ! strlen( MSettings::$db ) > 0 ) return false;
        if ( ! isset( MSettings::$db_user ) || ! strlen( MSettings::$db_user ) > 0 ) return false;
        if ( ! isset( MSettings::$db_pass ) || ! strlen( MSettings::$db_pass ) > 0 ) return false;

        try {

                ORM::configure( 'mysql:host=' . MSettings::$db_host . ';dbname=' . MSettings::$db );
                ORM::configure( 'username', MSettings::$db_user );
                ORM::configure( 'password', MSettings::$db_pass );
                ORM::configure( 'driver_options', array( PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' ) );

                $test = ORM::for_table( 'preferences' )->create();

        		if ( $test ) return true;
        	    else return false;

        } catch( PDOException $e ) {
        		return false;
        }
}

?>