<?php

	defined('DACCESS') or die;

	function mwidget_owl_video($OWL_Data, $Items) { ?>

		<?PHP if ((is_array($OWL_Data)) && count($OWL_Data) > 1) { ?>

			<div id="owl-movie" class="owl-carousel">

				<?PHP foreach($OWL_Data as $OneContent) { ?>
					<div class="VideoBox"><iframe width="320px" height="180px" src="https://www.youtube.com/embed/<?PHP echo $OneContent; ?>" frameborder="0" allowfullscreen></iframe></div>
				<?PHP } ?>

			</div>

			<script>
				$( document ).ready(function() {
					$("#owl-movie").owlCarousel({
						items : <?PHP echo $Items; ?>,
						lazyLoad: true,
						center: true,
						merge:true,
						loop: true,
						stopOnHover : true,
						navigation : false
					});
				});
			</script>

		<?PHP }
		} ?>


