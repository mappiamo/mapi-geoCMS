<?php
	/**
	 * Created by PhpStorm.
	 * User: Laca
	 * Date: 2015.11.08.
	 * Time: 10:55
	 */

	defined('DACCESS') or die;

	function mwidget_owl_image($Type, $Items, $Source) {

		?>

		<?PHP if ($Type == 'path') {

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
				$(window).load(function () {
					$("#owl-images").owlCarousel({
						items : <?PHP echo $Items; ?>,
						stopOnHover : true,
						autoPlay: 4000,
						navigation : false
					});
				});
			</script>

		<?PHP }
		} ?>


