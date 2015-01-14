<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="robots" content="noindex, nofollow" />
		<meta name="description" content="#mappiamo manager" />
		<meta name="author" content="#mappiamo" />

		<title><?php MPut::_html($this->page_title ); ?></title>

		<?php $this->output_assets( 'css' ); ?>
		<link rel="stylesheet" href="<?php MPut::_link( $this->get_dir() ); ?>css/mappiamo-manager.css">

		<?php $this->output_assets( 'js' ); ?>
</head>