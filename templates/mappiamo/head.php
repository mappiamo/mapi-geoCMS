<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<!DOCTYPE html>
<html lang="it">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php $this->meta(); ?>
        
        <link rel="shortcut icon" href="favicon.png">

        <title><?php MPut::_html($this->page_title ); ?></title>

        <?php $this->output_assets( 'css' ); ?>
        <link href="<?php MPut::_link( $this->get_dir() ); ?>/css/mappiamo.css" rel="stylesheet">

        <?php $this->output_assets( 'js' ); ?>
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script src="<?php MPut::_link( $this->get_dir() ); ?>/js/holder.js"></script>

        <script type="text/javascript">
                function map_banner_size() {
                        $( '#mapbanner' ).css( 'height', $( window ).height() + 'px' );
                        if ( mmap.map !== 'undefined' ) {
                                mmap.map.invalidateSize( false );
                        }
                }

                $( window ).ready( map_banner_size );
                $( window ).resize( map_banner_size );
        </script>
</head>