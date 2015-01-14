<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<body>

<div class="m-page">
		<div class="row">

				<div class="m-page-nav hidden-xs hidden-sm col-md-2 cold-lg-2">
						<div class="m-nav">
								<div class="m-logo">
										<a href="index.php" title="#mappiamo Dashboard"><img src="../media/images/mappiamo-geocms.png" alt="#mappiamo" /></a>
								</div>

								<?php include( 'nav.php' ); ?>
						</div>
				</div>

				<div class="m-page-content col-xs-12 cols-sm-12 col-md-10 col-lg-10">
						<div class="m-content">
								<?php echo $this->content; ?>
						</div>
				</div>

		</div>
</div>

</body>