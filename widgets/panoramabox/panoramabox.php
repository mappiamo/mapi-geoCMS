<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_panoramabox() {
		$id = $_GET["object"];
		$meta = ORM::for_table('content_meta')->select_many('value')->where('name', 'virtual_tour')->where('external_id', $id)->find_one();

		if (file_exists('./media/panorama/' . $meta['value']  . '.html')) {	?>

			<div class="panoramabox">
				<iframe src="./media/panorama/<?PHP echo $meta['value']; ?>.html" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			</div>

	<?PHP }
		}
?>