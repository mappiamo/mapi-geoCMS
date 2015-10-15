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
<article>
	<div class="row main-title">
		<div class="col-xs-12">
			<!-- <h1 class="content-title"><span itemprop="name"><?php //MPut::_html( $page_title ); ?></span></h1> -->
		</div>
	</div>

<?PHP

	if (is_array($contents)) {

		//print_r($contents);

		foreach ($contents as $content) { ?>

						<h3><a href="index.php?module=content&object=<?php echo intval($content['id']); ?>"><?php echo($content['title']); ?></a></h3>
						<p><?php echo mb_substr(strip_tags($content['text']), 0, 300, 'UTF-8'); ?>... </p>
				<!-- <div class="row content-text">
														<div class="col-md-12">
																<a href="index.php?module=content&object=<?php //echo intval( $content->get_id() ); ?>"><?php //__('Leggi tutto'); ?>&nbsp;&gt;</a>
														</div>
												</div> -->
			<hr>

		<?PHP }

	} else {
		echo $contents;
	}
?>
	</article>