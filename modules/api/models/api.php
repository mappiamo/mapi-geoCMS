<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

class MModel_Api {
                
                static function search( $options ) {
                                if ( sizeof( $options ) < 1 ) return false;
                                $records = ORM::for_table( 'contents' )->raw_query('SELECT id, ( 3959 * acos( cos( radians( :latitude ) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians( :longitude ) ) + sin( radians( :latitude ) )  * sin( radians( lat ) ) ) )  AS distance FROM contents HAVING distance < :radius', array( "latitude" => $options["lat"], "longitude" => $options["lng"], "radius" => $options["radius"] ) )->find_many();
                                if ( sizeof( $records ) < 1 ) return false;
                                $contents = array();
                                if ( isset( $options["cat"] ) ) {
                                                $kategoria = MObject::get( 'category', $options["cat"] );
                                                $kat_contents = $kategoria->get_contents();
                                }
                                foreach( $records as $content ) {
                                                $content = MObject::get( 'content', $content->id );
                                                $metas = $content->get_meta();
                                                $meta = array();
                                                if ( sizeof( $metas ) > 0 ) {
                                                                foreach ( $metas as $m ) {
                                                                                $meta[] = array("name" => $m->name,
                                                                                                "value" => $m->value
                                                                                                );
                                                                }
                                                }
                                                $medias = $content->get_media();
                                                $media = array();
                                                if ( sizeof( $medias ) > 0 ) {
                                                                foreach ( $medias as $med ) {
                                                                                $media[] = array("title" => $med->title,
                                                                                                "url" => $med->url,
                                                                                                "default" => $med->default
                                                                                                );
                                                                }
                                                }
                                                $in = true;
                                                if ( isset( $options["cat"] ) ) {
                                                                if ( sizeof( $kat_contents ) < 1 ) return false;
                                                                
                                                                $in = false;
                                                                
                                                                foreach ( $kat_contents as $kat_content ) {
                                                                                if ( $content->get_id() == $kat_content->get_id()) {
                                                                                                $in = true;
                                                                                }
                                                                }
                                                }
                                                if ( $in ) {
                                                $createdraw = $content->created();
                                                $created = $createdraw["when"];
                                                $createdby = $createdraw["by"];
                                                $modifiedraw = $content->modified();
                                                $modified = $modifiedraw["when"];
                                                $modifiedby = $modifiedraw["by"];
                                                $contents[] = array(            "id" => $content->get_id(),
                                                                                "type" => $content->get_type(),
                                                                                "name" => $content->get_name(),
                                                                                "title" => $content->get_title(),
                                                                                "text" => $content->get_text(),
                                                                                "address" => $content->get_address(),
                                                                                "lat" => $content->get_lat(),
                                                                                "lng" => $content->get_lng(),
                                                                                "license" => $content->get_license(),
                                                                                "created" => $created,
                                                                                "modified" => $modified,
                                                                                "createdby" => $createdby,
                                                                                "modifiedby" => $modifiedby,
                                                                                "hits" => $content->get_hits(),
                                                                                "translation" => $content->is_translation(),
                                                                                "enabled" => $content->is_enabled(),
                                                                                "meta" => $meta,
                                                                                "media" => $media
                                                                );
                                                }
                                }
                                
                                return $contents;
                }
                
                static function category( $options ) {
                                if ( sizeof( $options ) < 1 ) return false;
                                $category = MObject::get( 'category', $options['object'] );
                                $cont =  $category->get_contents();
                                if ( sizeof( $cont ) < 1 ) return false;
                                $contents = array();
                                foreach ( $cont as $content ) {
                                                $metas = $content->get_meta();
                                                $meta = array();
                                                if ( sizeof( $metas ) > 0 ) {
                                                                foreach ( $metas as $m ) {
                                                                                $meta[] = array("name" => $m->name,
                                                                                                "value" => $m->value
                                                                                                );
                                                                }
                                                }
                                                $medias = $content->get_media();
                                                $media = array();
                                                if ( sizeof( $medias ) > 0 ) {
                                                                foreach ( $medias as $med ) {
                                                                                $media[] = array("title" => $med->title,
                                                                                                "url" => $med->url,
                                                                                                "default" => $med->default
                                                                                                );
                                                                }
                                                }
                                                $createdraw = $content->created();
                                                $created = $createdraw["when"];
                                                $createdby = $createdraw["by"];
                                                $modifiedraw = $content->modified();
                                                $modified = $modifiedraw["when"];
                                                $modifiedby = $modifiedraw["by"];
                                                $contents[] = array(            "id" => $content->get_id(),
                                                                                "type" => $content->get_type(),
                                                                                "name" => $content->get_name(),
                                                                                "title" => $content->get_title(),
                                                                                "text" => $content->get_text(),
                                                                                "address" => $content->get_address(),
                                                                                "lat" => $content->get_lat(),
                                                                                "lng" => $content->get_lng(),
                                                                                "license" => $content->get_license(),
                                                                                "created" => $created,
                                                                                "modified" => $modified,
                                                                                "createdby" => $createdby,
                                                                                "modifiedby" => $modifiedby,
                                                                                "hits" => $content->get_hits(),
                                                                                "translation" => $content->is_translation(),
                                                                                "enabled" => $content->is_enabled(),
                                                                                "meta" => $meta,
                                                                                "media" => $media
                                                                );
                                }

                                return  $contents;
                }
                
                static function content( $options ) {
                                if ( sizeof( $options ) < 1 ) return false;
                                
                                $content = MObject::get( 'content', $options['object'] );
                                $metas = $content->get_meta();
                                $meta = array();
                                if ( sizeof( $metas ) > 0 ) {
                                                foreach ( $metas as $m ) {
                                                                $meta[] = array("name" => $m->name,
                                                                                "value" => $m->value
                                                                                );
                                                }
                                }
                                $medias = $content->get_media();
                                $media = array();
                                if ( sizeof( $medias ) > 0 ) {
                                                foreach ( $medias as $med ) {
                                                                $media[] = array("title" => $med->title,
                                                                                "url" => $med->url,
                                                                                "default" => $med->default
                                                                                );
                                                }
                                }
                                
                                $contents = array(               "id" => $content->get_id(),
                                                                "type" => $content->get_type(),
                                                                "name" => $content->get_name(),
                                                                "title" => $content->get_title(),
                                                                "text" => $content->get_text(),
                                                                "address" => $content->get_address(),
                                                                "lat" => $content->get_lat(),
                                                                "lng" => $content->get_lng(),
                                                                "license" => $content->get_license(),
                                                                "created" => $content->created(),
                                                                "modified" => $content->modified(),
                                                                "hits" => $content->get_hits(),
                                                                "translation" => $content->is_translation(),
                                                                "enabled" => $content->is_enabled(),
                                                                "meta" => $meta,
                                                                "media" => $media
                                                );
                                return $contents;
                                
                }

                

}


?>
