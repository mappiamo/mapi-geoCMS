<?php
/**
 * Created by PhpStorm.
 * User: Laca
 * Date: 2015.10.23.
 * Time: 11:37
 */

	defined('DACCESS') or die;

	include_once('model/getfullmenu.php');

	function mwidget_menu_full($MenuName, $MenuType, $TemplateNum, $LinkType) {

		GLOBAL $IsScriptLoaded;

		if ($MenuType == 'treemenu') {
			$AssetDir = 'treemenu';
			$ClassKeyword = 'TMM';
		} elseif ($MenuType == 'popmenu') {
			$AssetDir = 'popmenu';
			$ClassKeyword = 'PMM';
		}

		if (!$TemplateNum) { $TemplateNum = '01'; }

		$ClassID = rand(1000,9999);

			if (strpos($IsScriptLoaded, $AssetDir . '_' . $ClassKeyword . '-') === false) { ?>

				<link href="assets/css/<?PHP echo $AssetDir; ?>/p7<?PHP echo $ClassKeyword; ?><?PHP echo $TemplateNum; ?>.css" rel="stylesheet" media="all">
				<script type="text/javascript" src="assets/js/<?PHP echo $AssetDir; ?>/p7<?PHP echo $ClassKeyword; ?>scripts.js"></script>

			<?PHP
			}

		$IsScriptLoaded .= $AssetDir . '_' . $ClassKeyword . '-';

		$FullMenu = new getfullmenu();
		$FullMenuResult = $FullMenu->getmenudata($MenuName);

		//echo '<pre>' . print_r($FullMenuResult, 1) . '</pre>'; die();

		if ($FullMenuResult) {
		?>

		<div id="p7<?PHP echo $ClassKeyword; ?>_<?PHP echo $ClassID; ?>" class="p7<?PHP echo $ClassKeyword; ?><?PHP echo $TemplateNum; ?> fullmenu_box">
			<ul class="p7<?PHP echo $ClassKeyword; ?>">
				<li><a href="#"><?PHP echo $FullMenuResult['data']['Maintitle']; ?></a>
					<div><ul>

						<?PHP
							unset($FullMenuResult['data']);
							foreach ($FullMenuResult as $MenuKey => $MenuData) {

							if (array_key_exists('subtitles', $MenuData)) { ?>

								<?PHP if ($LinkType == 'link') { ?>
									<li><a href="<?PHP echo $MenuData['url']; ?>"><?PHP echo $MenuData['title']; ?></a>
								<?PHP } elseif ($LinkType == 'check') { ?>
									<?PHP if (filter_var($MenuData['url'], FILTER_VALIDATE_URL)) {
										$TheQuery = parse_url($MenuData['url'], PHP_URL_QUERY);
										parse_str($TheQuery, $outputID);
										?>

										<li><a href="#"><label class="checkbox-inline"><input type="checkbox" name="mmap_category[]" value="<?PHP echo $outputID['object'] ?>"> <?PHP echo $MenuData['title']; ?></label></a>
									<?PHP } else { ?>
										<li><a href="#"><?PHP echo $MenuData['title']; ?></a>
									<?PHP } ?>
								<?PHP } ?>

									<div><ul>

										<?PHP
											foreach ($MenuData['subtitles'] as $SubKey => $Subval) { ?>

												<?PHP if ($LinkType == 'link') { ?>
													<li><a href="<?PHP echo $MenuData['suburls'][$SubKey]; ?>"><?PHP echo $Subval; ?></a></li>
												<?PHP } elseif ($LinkType == 'check') { ?>
													<?PHP if (filter_var($MenuData['suburls'][$SubKey], FILTER_VALIDATE_URL)) {
														$TheQuery = parse_url($MenuData['suburls'][$SubKey], PHP_URL_QUERY);
														parse_str($TheQuery, $outputID);
														?>
														<li><a href="#"><label class="checkbox-inline"><input type="checkbox" name="mmap_category[]" value="<?PHP echo $outputID['object'] ?>"> <?PHP echo $Subval; ?></label></a></li>
													<?PHP } else { ?>
														<li><a href="#"><?PHP echo $Subval; ?></a></li>
													<?PHP } ?>
												<?PHP } ?>

											<?PHP
											}
										?>

									</ul></div>
								</li>
							<?PHP } else { ?>

								<?PHP if ($LinkType == 'link') { ?>
									<li><a href="<?PHP echo $MenuData['url']; ?>"><?PHP echo $MenuData['title']; ?></a></li>
								<?PHP } elseif ($LinkType == 'check') { ?>
									<?PHP if (filter_var($MenuData['url'], FILTER_VALIDATE_URL)) {
										$TheQuery = parse_url($MenuData['url'], PHP_URL_QUERY);
										parse_str($TheQuery, $outputID);
										?>
										<li><a href="#"><label class="checkbox-inline"><input type="checkbox" name="mmap_category[]" value="<?PHP echo $outputID['object'] ?>"> <?PHP echo $MenuData['title']; ?></label></a></li>
									<?PHP } else { ?>
										<li><a href="#"><?PHP echo $MenuData['title']; ?></a></li>
									<?PHP } ?>
								<?PHP } ?>

							<?PHP }
							}
						?>

					</ul></div>
				</li>
			</ul>

			<?PHP if ($ClassKeyword == 'TMM') { ?>
				<!--[if lte IE 6]>
				<style>.p7TMM<?PHP echo $TemplateNum; ?> .p7<?PHP echo $ClassKeyword; ?>, .p7TMM<?PHP echo $TemplateNum; ?> a, .p7TMM<?PHP echo $TemplateNum; ?> li {height:1%;}</style>
				<![endif]-->
				<!--[if IE 5]>
				<style>.p7TMM<?PHP echo $TemplateNum; ?> a, .p7TMM<?PHP echo $TemplateNum; ?> a {overflow: visible !important;}</style>
				<![endif]-->
			<?PHP } elseif ($ClassKeyword == 'PMM') { ?>
				<!--[if lte IE 6]>
				<style>.p7PMM<?PHP echo $TemplateNum; ?>, .p7PMM<?PHP echo $TemplateNum; ?> a, .p7PMM<?PHP echo $TemplateNum; ?> ul {height:1%;}.p7PMM<?PHP echo $TemplateNum; ?> li{float:left;clear:both;width:100%;}</style>
				<![endif]-->
				<!--[if IE 5.500]>
				<style>.p7PMM<?PHP echo $TemplateNum; ?> {position: relative; z-index: 9999999;}</style>
				<![endif]-->
				<!--[if IE 7]>
				<style>.p7PMM<?PHP echo $TemplateNum; ?>, .p7PMM<?PHP echo $TemplateNum; ?> a, .p7PMM<?PHP echo $TemplateNum; ?> ul {zoom: 1;}.p7PMM<?PHP echo $TemplateNum; ?> li{float:left;clear:both;width:100%;}</style>
				<![endif]-->
			<?PHP } ?>

			<script type="text/javascript">
				<!--
				<?PHP if ($ClassKeyword == 'TMM') { ?>
					P7_TMMop('p7TMM_<?PHP echo $ClassID; ?>',1,0,0,3,1,1,0,0,-1,150);
				<?PHP } elseif ($ClassKeyword == 'PMM') { ?>
					P7_PMMop('p7PMM_<?PHP echo $ClassID; ?>',0,3,0,0,0,0,0,1,0,3,0,0,0);
				<?PHP } ?>
				//-->
			</script>
		</div>

		<?PHP
		//die();
		} else {
			echo 'No valid return data for this setting.';
		}
	}
?>
