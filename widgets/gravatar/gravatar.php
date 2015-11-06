<?php
	/**
	 * Created by PhpStorm.
	 * User: Laca
	 * Date: 2015.11.05.
	 * Time: 20:11
	 */

	defined('DACCESS') or die;

	include_once('model/Gravatar.php');
	include_once('model/Image.php');
	include_once('model/Profile.php');

	use forxer\Gravatar\Gravatar;

	function mwidget_gravatar($CreatorMail) {

		echo Gravatar::image($CreatorMail);

	}