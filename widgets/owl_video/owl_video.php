<?php
	/**
	 * Created by PhpStorm.
	 * User: Laca
	 * Date: 2015.11.08.
	 * Time: 10:55
	 */

	defined('DACCESS') or die;

	function mwidget_owl_video($OWL_Data, $Items) { ?>

		<?PHP if ((is_array($OWL_Data)) && count($OWL_Data) > 1) { ?>

			<link rel="stylesheet" href="widgets/owl_video/css_js/owl.carousel.css"/>
			<link rel="stylesheet" href="widgets/owl_video/css_js/owl.theme.css"/>
			<script type="text/javascript" src="widgets/owl_video/css_js/owl.carousel.min.js"></script>

			<div id="owl-movie" class="owl-carousel">

				<?PHP foreach($OWL_Data as $OneContent) { ?>
					<div><iframe width="320px" height="180px" src="https://www.youtube.com/embed/<?PHP echo $OneContent; ?>" frameborder="0" allowfullscreen></iframe></div>
				<?PHP } ?>

			</div>

			<script type="text/javascript">
				$(window).load(function () {
					$("#owl-movie").owlCarousel({
						items : <?PHP echo $Items; ?>,
						stopOnHover : true,
						navigation : false
					});
				});
			</script>

		<?PHP }
		} ?>


