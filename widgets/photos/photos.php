<?php

	// no direct access to this file
	defined('DACCESS') or die;

	function mwidget_photos($cat_id = NULL) {

		if ($cat_id) {

		} else {

			if ((isset($_GET['module'])) && (isset($_GET['object']))) {
				if ($_GET['module'] == 'content') {

					$id = intval($_GET['object']);
					$content_data = ORM::for_table('contents')->select_many('address', 'name', 'type', 'title', 'lat', 'lng', 'route')->where('id', $id)->find_one();

					if (($content_data['lat'] == 0) || ($content_data['lng'] == 0)) {
						$PointGeom = $content_data['route'];
						preg_match('/^([^\(]*)([\(]*)([^A-Za-z]*[^\)$])([\)]*[^,])$/', $PointGeom, $Match);
						$LanLotCoords = explode(' ', $Match[3]);
						$content_data['lat'] = $LanLotCoords[1];
						$content_data['lng'] = $LanLotCoords[0];
					}

					if ($content_data) {
						if ($content_data['type'] != 'route') {

							$lang = new M_Language;
							$language = $lang->getLanguage();

							$images = ORM::for_table('contents')
												->raw_query('SELECT contents.id AS external_id, content_media.url AS url, contents.title AS title, (3959 * acos(cos(radians(:latitude)) * cos(radians(lat)) * cos(radians(lng) - radians(:longitude)) + sin(radians(:latitude))  * sin(radians(lat)))) * 1000 AS distance
												FROM contents
												INNER JOIN content_media
												ON content_media.external_id = contents.id
												WHERE contents.parent IS NULL
												AND content_media.default_media = 1
												AND content_media.external_id != ' . $id . '
												AND contents.language = \'' . $language . '\'
												HAVING distance < :radius AND distance > 0
												ORDER BY distance ASC LIMIT 15',
												array("latitude" => $content_data["lat"], "longitude" => $content_data["lng"], "radius" => 20000))->find_array();

							if (count($images) == 0) {
								$images = ORM::for_table('content_media')->select_many('url', 'external_id')->where('default_media', 1)->group_by('url')->limit(15)->find_array();
							}

						} else {
							$images = ORM::for_table('content_media')->select_many('url', 'external_id')->where('default_media', 1)->group_by('url')->limit(15)->find_array();
						}
					}

				} else {
					$images = ORM::for_table('content_media')->select_many('url', 'external_id')->where('default_media', 1)->group_by('url')->limit(15)->find_array();
				}
			} else {
				$images = ORM::for_table('content_media')->select_many('url', 'external_id')->where('default_media', 1)->group_by('url')->limit(15)->find_array();
			}
		}

		if (count($images) > 0) { ?>

			<div class="col-md-4">
				<div class="tabs-block">
					<div class="tabs-block-head">
						<span class="glyphicon glyphicon-camera"></span> <span class="title">Foto d’intorni</span>
					</div>
					<div class="thumbnail-list">

						<?php
							foreach ($images as $OneImage) { ?>
									<a href="index.php?module=content&object=<?php echo intval($OneImage['external_id']); ?>" <?PHP if (isset($OneImage['distance'])) { ?> title="~<?PHP echo round($OneImage['distance'], 0);?>m: <?PHP echo $OneImage['title']; ?>" <?PHP } ?>>
									<img src="lib/php-thumb/phpThumb.php?w=200&src=<?php echo $OneImage['url']; ?>" style="cursor: pointer;"<?PHP if (isset($OneImage['distance'])) { ?> alt="~<?PHP echo round($OneImage['distance'], 0);?>m: <?PHP echo $OneImage['title']; ?>" <?PHP } ?>>
									</a>
								<?php
							}
						?>
					</div>
				</div>
			</div>
			<?php
		}

	}

?>