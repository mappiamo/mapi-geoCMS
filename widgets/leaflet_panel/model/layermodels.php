<?php
/**
 * Created by PhpStorm.
 * User: Laca
 * Date: 2015.10.20.
 * Time: 10:46
 */

	class layermodels {

		public static function GetTemplateName() {
			$TemplateName = ORM::for_table('templates')->select('name')->where('manager', 0)->where('enabled', 1)->where('default_template', 1)->find_array();
			return $TemplateName[0]['name'];
		}

	}