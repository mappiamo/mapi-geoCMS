<!DOCTYPE html>
<html lang="it">
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php MPut::_html($this->page_title ); ?></title>
		<?php $this->meta(); ?>

		

		<?php $this->output_assets( 'css' ); ?>
        <link href='http://fonts.googleapis.com/css?family=Courgette&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link href="<?php MPut::_link( $this->get_dir() ); ?>/css/style.css" rel="stylesheet">
        <link href="<?php MPut::_link( $this->get_dir() ); ?>/css/responsive.css" rel="stylesheet">

        <?php $this->output_assets( 'js' ); ?>

		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>