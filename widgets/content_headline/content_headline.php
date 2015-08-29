<?php
	defined('DACCESS') or die;
	function mwidget_content_headline() {
		$id = $_GET["object"];
		$type = $_GET["module"];

		$lang = new M_Language;
		$language = $lang->getLanguage();

		if ((!empty($id)) && ($type == "content")) {
			$content = ORM::for_table('contents')->select_many('type', 'title', 'start', 'end')->where('id', $id)->find_array();

			if (isset($content)) {

				if ($content[0]["type"] != "route") {
					$meta = ORM::for_table('content_meta')->select_many('name', 'value')->where('external_id', $id)->find_array();

					if (isset($meta)) {
						foreach ($meta as $data) {
							$metaorder[$data["name"]] = $data["value"];
						}

						if ((isset($metaorder["icon-file"])) && (strpos($metaorder["icon-file"], 'http') === FALSE)) {
							$metaorder["icon-file"] = "media/mapicons/".$metaorder["icon-file"];
						}
						?>

						<div class="content_headline_meta">

							<?php if (isset($metaorder["tipo_itine"])) { ?>
							<?PHP if ($language == 'en') { ?>
								<div class="itine">Route:
							<?PHP } else { ?>
								<div class="itine">Itinerario:
							<?PHP } ?>
									<?PHP echo $metaorder["tipo_itine"]; ?>
								</div>
							<?PHP } ?>

							<div class="metadata_table">
								<div class="sub_meta_left">

									<?php if (isset($metaorder["icon-file"])) { ?>
										<div class="cat_pic">
											<img src="<?php echo $metaorder["icon-file"]; ?>">
										</div>
									<?PHP } else { ?>
										<div class="cat_pic">&nbsp;</div>
									<?PHP } ?>

									<?php if (isset($metaorder["categoria"])) { ?>
										<div class="categoria">
											<?php	echo $metaorder["categoria"]; ?>
										</div>
									<?PHP } else { ?>
										<div class="categoria">&nbsp;</div>
									<?PHP } ?>

									<?php if (isset($metaorder["tipologia"])) { ?>
										<div id="tipologia">
											<?php	echo $metaorder["tipologia"]; ?>
										</div>
									<?PHP } else { ?>
										<div id="tipologia">&nbsp;</div>
									<?PHP } ?>

								</div>

								<div class="sub_meta_right">

									<?php if (isset($metaorder["epoca"])) { ?>
										<div class="epoca">
											<?php	echo $metaorder["epoca"]; ?>
										</div>
									<?PHP } else { ?>
										<div class="epoca">&nbsp;</div>
									<?PHP } ?>

									<?php if (isset($metaorder["data_periodo_costruzione"])) { ?>
										<div class="periodo">
											<?php echo $metaorder["data_periodo_costruzione"]; ?>
										</div>
									<?php } elseif ((isset($content[0]['start'])) && ($content[0]['end'])) { ?>
										<div class="periodo">
											<span class="glyphicon glyphicon-circle-arrow-right"></span> <?php echo ( date_format( new Datetime( $content[0]['start'] ), 'Y-m-d H:i' ) ); ?>&nbsp;
											<span class="glyphicon glyphicon-circle-arrow-left"></span> <?php echo ( date_format( new Datetime( $content[0]['end'] ), 'Y-m-d H:i' ) ); ?>
										</div>
									<?PHP } else { ?>
										<div class="periodo">&nbsp;</div>
									<?PHP } ?>

								</div>
							</div>
						</div>

					<?php
					}
				}
			}
		}
	}

?>