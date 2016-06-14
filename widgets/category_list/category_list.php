<?php

	// no direct access to this file
	defined('DACCESS') or die;

	function mwidget_category_list($CatName, $Limit = 5, $BoxTitle = NULL, $BoxType = 'list') {

		$Categs = ORM::for_table('categories')->select_many('contents', 'title')->where_raw('(`enabled` = ? AND (`name` like ? OR `id` = ?))', array(1, $CatName, $CatName))
																					->find_one();

		if (!$BoxTitle) { $BoxTitle = $Categs['title']; }

		if ($Categs) {
			$matches = array();
			preg_match_all("/{([^}]*)}/", $Categs['contents'], $matches);
			$ContentList = $matches[1];

			sort($ContentList);

			if (count($ContentList) > 0) {

				$lang = new M_Language;
				$language = $lang->getLanguage();

				$ContentWhere = '(' . implode(', ', $ContentList) . ')';
				//echo $ContentWhere; die();
				$Contents = ORM::for_table('contents')->select_many('id', 'title')->where_raw('id IN ' . $ContentWhere)->where('language', $language)->where('enabled', 1)->where_null('parent')->limit($Limit)->find_array();
				if (count($Contents) > 0) { ?>

					<?PHP if ($BoxType == 'list') { ?>
						<div class="col-sm-4">
						<span><?PHP echo $BoxTitle; ?></span>
					<?PHP } elseif ($BoxType == 'box') { ?>
						<div class="col-md-4">
						<div class="tabs-block">
						<div class="tabs-block-head">
							<span class="glyphicon glyphicon-tags"></span> <span class="title"><?PHP echo $BoxTitle; ?></span>
						</div>
						<div class="tabs-block-body">
					<?PHP } ?>

						<?PHP foreach($Contents as $Result) { ?>

							<?PHP if ($BoxType == 'box') { ?><div><?PHP } ?>
								<a href="index.php?module=content&object=<?php echo intval($Result['id']); ?>" title="<?PHP echo $Result['title']; ?>"><?PHP echo $Result['title']; ?></a><br>
							<?PHP if ($BoxType == 'box') { ?></div><?PHP } ?>

						<?PHP } ?>
						</div>

						<?PHP if ($BoxType == 'box') { ?>
							</div></div>
						<?PHP
					}
				}
			}
		}
	}

?>