<?php
	/**
	 * Created by PhpStorm.
	 * User: Laca
	 * Date: 2015.11.08.
	 * Time: 10:55
	 */

	defined('DACCESS') or die;

	function mwidget_owl_image($Type, $Items, $Source) {

		if ($Type == 'path') {

			if ($Source) {
				if (is_dir($Source)) {
					$ThisPHPver = version_compare(phpversion(), "5.3");

					if ($ThisPHPver >= 1) {
						$GalleryImages = glob($Source . '/*.{jpg,JPG,gif,GIF,png,PNG,jpeg,JPEG,svg,SVG}', GLOB_BRACE);
					} else {
						$GalleryImages = glob($Source . '/*.jpg');
					}

					sort($GalleryImages, SORT_NATURAL | SORT_FLAG_CASE);

				}
			}
		?>

		<div id="owl-images" class="owl-carousel">

			<?PHP foreach($GalleryImages as $OneContent) {

				$FileName = pathinfo($OneContent, PATHINFO_FILENAME);
				$FileExtension = pathinfo($OneContent, PATHINFO_EXTENSION);

				if ((preg_match("/_b$/", $FileName)) || (preg_match("/_c$/", $FileName))) {
					$ColoredFile = str_replace('_b', '_c', $FileName);
					if (file_exists($Source . '/' . $ColoredFile . '.' . $FileExtension)) {

						if (preg_match("/_b$/", $FileName)) {
							?>

							<div class="ImageBox">
								<img src="<?PHP echo $OneContent; ?>"
										 onmouseover="this.src='<?PHP echo $Source; ?>/<?PHP echo $ColoredFile . '.' . $FileExtension; ?>'"
										 onmouseout="this.src='<?PHP echo $OneContent; ?>'">
							</div>

					<?PHP }
					} else { ?>

							<div class="ImageBox"><img src="<?PHP echo $OneContent; ?>"></div>

					<?PHP
					}
					//die($Source . '/' . $ColoredFile . '.' . $FileExtension);

				} else { ?>
					<div class="ImageBox"><img src="<?PHP echo $OneContent; ?>"></div>
				<?PHP
				}

				?>

			<?PHP } ?>
		</div>

			<script type="text/javascript">
				$( document ).ready(function() {
					$("#owl-images").owlCarousel({
						items : <?PHP echo $Items; ?>,
						stopOnHover: true,
						lazyLoad: true,
						center: true,
						merge:true,
						loop: true,
						autoPlay: 4000,
						navigation : false
					});
				});
			</script>

		<?PHP
		} elseif ($Type == 'category') {

			$CatContent = ORM::for_table('categories')->select_many('contents')
			->where_raw('(`enabled` = ? AND (`name` like ? OR `id` = ?))', array(1, $Source, $Source))
			->find_one();

			$matches = array();
			preg_match_all("/{([^}]*)}/", $CatContent['contents'], $matches);
			$ContentList = $matches[1];

			sort($ContentList);

			if (count($ContentList) > 0) {

				$lang = new M_Language;
				$language = $lang->getLanguage();

				$ContentSearchQuery = '`enabled` = 1 AND (`id` = ' . implode(' OR `id` = ', $ContentList) . ')';

				$ContentListArray = ORM::for_table('contents')->select_many('id', 'title')
														 ->where_raw($ContentSearchQuery)->where('language', $language)
														 ->find_array();
			} else {
				$ContentListArray = array();
			}

			if (count($ContentListArray) > 0) { ?>

				<div id="owl-cat-images" class="owl-carousel">

				<?PHP
					foreach ($ContentListArray as $CKey => $Content) {
					$CID = $Content['id'];

					$ImagePath = ORM::for_table('content_media')->select_many('url')
												->where('external_id', $CID)->where('default_media', 1)->find_one();

					if ($ImagePath) { ?>
						<div class="ImageBoxWTitle">
							<a href="./index.php?module=content&object=<?PHP echo $CID; ?>"><img src="<?PHP echo $ImagePath['url']; ?>"></a>
							<span>
								<a href="./index.php?module=content&object=<?PHP echo $CID; ?>"><?PHP echo mb_substr(strip_tags($Content['title']), 0, 50, 'UTF-8'); ?><?PHP if (strlen($Content['title']) > 50) { echo '...'; } ?></a>
							</span>
						</div>
					<?PHP
					}
				} ?>

				</div>

				<script type="text/javascript">
					$( document ).ready(function() {
						$('#owl-cat-images').owlCarousel({
							items : <?PHP echo $Items; ?>,
							stopOnHover : true,
							center: true,
							lazyLoad: true,
							merge:true,
							loop: true,
							autoPlay: 4000,
							navigation : false
						});
					});
				</script>

			<?PHP
				}

		}
	} ?>


