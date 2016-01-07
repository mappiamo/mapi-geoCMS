<?php
	/**
	 * Created by PhpStorm.
	 * User: Laca
	 * Date: 2016.01.07.
	 * Time: 12:10
	 */

	defined('DACCESS') or die;

	function mwidget_website_title() {
		$TitleName = ORM::for_table('preferences')->select_many('value')->where('name', 'website_title')->find_one();
		echo $TitleName['value'];
	}