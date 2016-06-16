<?php

	// no direct access to this file
	defined('DACCESS') or die;

	function mwidget_homescreen($cat_id = NULL) {
		$screens = array();

		if ($cat_id) {

			$Categs = ORM::for_table('categories')->select_many('contents')->where_raw('(`enabled` = ? AND (`name` like ? OR `id` = ?))', array(1, $cat_id, $cat_id))
									 ->find_one();

			$ImageExtensions = array('.jpg', '.jpeg', '.png', '.gif');
			$ExtensionFilterQuery_0 = '(content_media.url LIKE \'%' . implode('\' OR content_media.url LIKE \'%', $ImageExtensions) . '\')';

			if ($Categs) {
				$matches = array();
				preg_match_all("/{([^}]*)}/", $Categs['contents'], $matches);
				$ContentList = $matches[1];

				$rand_key = array_rand($ContentList);
				$OneID = $ContentList[$rand_key];

				$ExtensionFilterQuery = $ExtensionFilterQuery_0 . ' AND external_id = ' .$OneID;

				$Contents = ORM::for_table('contents')->select_many('id', 'title')->where('id', $OneID)->where('enabled', 1)->find_one();
				$Image = ORM::for_table('content_media')->select_many('external_id', 'url')->where_raw($ExtensionFilterQuery)->find_one();
			}

			if (!$Image) {

				$Image_20 = ORM::for_table('content_media')->select_many('url', 'external_id')->where_raw($ExtensionFilterQuery_0)->where('default_media', 1)->group_by('url')->limit(20)->find_array();
				$rand_key = array_rand($Image_20);

				$Image['url'] = $Image_20[$rand_key]['url'];
				$Image['external_id'] = $Image_20[$rand_key]['external_id'];

				$OneID = $Image['external_id'];
				$Contents = ORM::for_table('contents')->select_many('id', 'title')->where('id', $OneID)->where('enabled', 1)->find_one();
			}
		}

		if (($Contents) && ($Image)) {	?>
			<div id="big-image"
					 style="background: #006699 url( '<?php echo strip_tags($Image['url']); ?>' ) center center; background-size: cover; cursor: pointer;"
					 onclick="location.href='index.php?module=content&object=<?php echo intval($Contents['id']); ?>'">
				<div class="caption"><?php echo strip_tags($Contents['title']); ?></div>
			</div>
			<?php
		} else {
			?>
			<div id="big-image"
					 style="background: #fff url( 'media/images/default_back.jpg' ) center center; background-size: cover;">
				<div class="caption"><?php //echo strip_tags( $back[0]->get_title() ); ?></div>
			</div>
			<?php
		}
	}

?>