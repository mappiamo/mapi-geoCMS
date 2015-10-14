<?php
/**
 * Created by PhpStorm.
 * User: Laca
 * Date: 2015.10.14.
 * Time: 14:08
 */

	defined( 'DACCESS' ) or die;
	$contents = $data;
	//print_r($data); die();

?>

<?PHP

	if (is_array($contents)) {

		//print_r($contents);

		foreach ($contents as $content) { ?>

			<div class="row main-header">
				<div class="row content-title">
					<div class="col-md-12">
						<h3><a href="index.php?module=content&object=<?php echo intval($content['id']); ?>"><?php echo($content['title']); ?></a></h3>
					</div>
				</div>
				<div class="row content-text">
					<div class="col-md-12">
						<p><?php echo mb_substr(strip_tags($content['text']), 0, 300, 'UTF-8'); ?>... </p>
					</div>
				</div>
				<!-- <div class="row content-text">
														<div class="col-md-12">
																<a href="index.php?module=content&object=<?php //echo intval( $content->get_id() ); ?>"><?php //__('Leggi tutto'); ?>&nbsp;&gt;</a>
														</div>
												</div> -->
			</div><hr>

		<?PHP }

	} else {
		echo $contents;
	}

?>