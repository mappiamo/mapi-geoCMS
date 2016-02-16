<?php

// no direct access to this file
	defined( 'DACCESS' ) or die;

	$contents = $data[0];
	$page_title = $data[1];
	$PlaceCount = $data[2];
	$DataLimit = $data[3];
	$DataStart = $data[4];
	$SchemaData = $data[5];

?>

<article>
	<div class="row main-title">
		<div class="col-xs-12">
						<h1 class="content-title"><span itemprop="name"><?php echo $page_title; ?></span></h1>
				</div>
		</div>

        <?php 
        		
				//var_dump($contents); die();
        		if ( sizeof( $contents ) > 0 ) {
        				foreach ( $contents as $content_key => $content ) {
        						$text_wrap = wordwrap( strip_tags( $content['text'], '<br>' ), 800, "%|%" );
        						$text_array = explode( '%|%', $text_wrap ); ?>

												<div class="microformat">
														<script type="application/ld+json">

															[<?PHP print_r(json_encode($SchemaData[$content_key])); ?>]

														</script>
												</div>
								
													<h3><a href="index.php?module=content&object=<?php echo intval( $content['id'] ); ?>"><?php echo $content['title']; ?></a></h3>
													<span class="glyphicon glyphicon-map-marker"></span><b> <?PHP echo $content['address']; ?></b>
													<?PHP if ($content['type'] == 'event') { ?>
														<br><span class="glyphicon glyphicon-circle-arrow-right"></span> <?PHP echo date('d-m-Y H:i', strtotime($content['start'])) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-circle-arrow-left"></span> <?PHP echo date('d-m-Y H:i', strtotime($content['end'])) ?>
													<?PHP } ?>
													<p><p><?php echo $text_array[0]; ?>... </p>
												<!-- <div class="row content-text">
														<div class="col-md-12">
																<a href="index.php?module=content&object=<?php //echo intval( $content->get_id() ); ?>"><?php //__('Leggi tutto'); ?>&nbsp;&gt;</a>
														</div>
												</div> -->
										<hr>
        						<?php
        				}

							if ($PlaceCount > $DataLimit) {
							?>

								<div class="pull-right">

									<div class="dataTables_paginate paging_bs_normal">
										<ul class="pagination">

											<li class="prev<?PHP if ($DataStart == 0) { ?> disabled<?PHP } ?>">
												<?PHP if ($DataStart > 0) { ?>
													<a href="index.php?module=category&object=<?PHP echo $_GET['object']; ?>"><span class="glyphicon glyphicon-chevron-left"></span>&nbsp;First</a>
												<?PHP } ?>
											</li>

											<?PHP for ($nyy = 1; 0 <= ($DataStart - ($DataLimit * $nyy));) { if (($nyy >= 5) || (($DataStart - ($nyy * $DataLimit)) <= 0)) { break; }
												if (($DataStart - ((5 - $nyy) * $DataLimit)) > 0) { ?>
												<li>
													<a href="index.php?module=category&object=<?PHP echo $_GET['object']; ?>&st=<?PHP echo ($DataStart - ((5 - $nyy) * $DataLimit)); ?>">
														<?PHP
															echo ($DataStart + 1 - ((5 - $nyy) * $DataLimit));
														?>
													</a>
												</li>
											<?PHP
												}
												$nyy++;
											}
											?>

												<li class="active">
													<a href="#"><?PHP echo ($DataStart + 1); ?></a>
												</li>

											<?PHP for ($nxx = 1; $PlaceCount >= (0 + ($DataLimit * $nxx));) { if (($nxx + $nyy >= 10) || (($DataStart + ($nxx * $DataLimit)) >= ($PlaceCount - $DataLimit))) { break; } ?>
												<li class="active-">
													<a href="index.php?module=category&object=<?PHP echo $_GET['object']; ?>&st=<?PHP echo ($DataStart + ($nxx * $DataLimit)); ?>">
														<?PHP
															echo ($DataStart + 1 + ($nxx * $DataLimit)); $nxx++;
														?>
													</a>
												</li>
											<?PHP } ?>

											<li class="next">
												<?PHP if ($DataStart != ($PlaceCount - $DataLimit)) { ?>
													<a href="index.php?module=category&object=<?PHP echo $_GET['object']; ?>&st=<?PHP echo ($PlaceCount - $DataLimit); ?>">Last&nbsp;<span class="glyphicon glyphicon-chevron-right"></span></a>
												<?PHP } ?>
											</li>

										</ul>
									</div>

								</div>

        		<?PHP }
							}
			else {
				?>
				<div class="row main-header">
						<div class="row content-title">
								<div class="col-md-12">
										<h3><?php __('Contenuto in lingua non trovato'); ?></h3>
								</div>
						</div>
				</div>
				<?php
			}
        ?>

</article>