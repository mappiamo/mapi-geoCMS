<?php
	/**
	 * Created by PhpStorm.
	 * User: Laca
	 * Date: 2015.11.05.
	 * Time: 17:29
	 */

	defined('DACCESS') or die;

	include_once('model/getcollab.php');

	function mwidget_box_collabrators($Max = 5) {

		if (!isset($_GET["object"])) { return; }

		$id = $_GET["object"];
		$AllCollab = new getcollab();
		$CollabArticlesResult = $AllCollab->getcollabadata($id, $Max);

		//print_r($CollabArticlesResult); die();

		if ($CollabArticlesResult) {
			if ((is_array($CollabArticlesResult)) && (count($CollabArticlesResult) > 0)) { ?>

			<div class="collab-box">

				<h3 class="color"><span class="glyphicon glyphicon-book"></span> Articoli correlati</h3>

				<?PHP foreach ($CollabArticlesResult as $One_Content) { ?>

						<a href="index.php?module=content&object=<?PHP echo $One_Content['id']; ?>"
							 title="<?PHP echo $One_Content['title']; ?>"><h3 class="color"><?PHP echo $One_Content['title']; ?></h3>
						</a>

						<div>

							<?PHP
								$ExtID = $One_Content['id'];
								$image_url = ORM::for_table('content_media')->select_many('title', 'url')->where('external_id', $ExtID)
																->where('default_media', 1)->limit(1)->find_one();
								if ($image_url) {
									?>

									<div class="collab-image">
										<img src="<?PHP echo $image_url['url']; ?>" alt="<?PHP echo $image_url['title']; ?>"/>
									</div>

								<?PHP } ?>

							<div class="latest-content">
									<?PHP echo mb_substr(strip_tags($One_Content['text']), 0, 120, 'UTF-8'); ?>...<br/>
									<a href="index.php?module=content&object=<?PHP echo $One_Content['id']; ?>"
										 title="<?PHP echo $One_Content['title']; ?>" class="readmore">Leggi tutto &gt;</a>
								</p>
							</div>
							<div style="clear: both;"></div>
						</div>

					<div class="separator"></div>

				<?PHP }
				echo '</div>';
			}
		}
	}