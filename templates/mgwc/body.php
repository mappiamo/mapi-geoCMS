<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<body data-spy="scroll" data-target=".navbar">

<?php include( 'nav.php' ); ?>
		
<section class="hompage">
		<div class="container">
				<div class="row">
						<div class="col-sm-12">
								<div>
										<?php $this->widget( 'slider', 1 ); ?>
								</div>

						</div>
				</div>
		</div>

			<div class="container" id="banner" style="margin-top:15px;">
				<div class="row">
					<a href="http://www.mototurismo.it/offerta-esclusiva-tomtom-rider-400/"><img class="center-block" src="./media/images/banner_1080x180.jpg"></a>
				</div>
			</div>

		<div class="container">
				<div class="row" id="box-images">
						<?php $this->widget( 'box', array( 'media/images/box_storia.jpg', 'TRADIZIONE', 'NOBLE DYNASTY FOR OVER 90 YEARS', 'http://www.motoguzzi.com/en/tradizione' ) ); ?>

						<?php $this->widget( 'box', array( 'media/images/box_garage.jpg', 'GARAGE', 'BORN WITH STYLE TO LIVE ON PASSION', 'http://www.garagemotoguzzi.com/en/' ) ); ?>

						<?php $this->widget( 'box', array( 'media/images/literaryCorner.jpg', 'LIBRARY', 'LITERARY CORNER OF GUZZISTA' , 'http://motoguzziworldclub.it/mapi/index.php?module=category&object=9' ) ); ?>
				</div>

		</div>
</section>

<?php include( 'footer.php' ); ?>
		
<script>
		$( "div.enterleave" ).mouseenter( function() {
				$( this ).find( "div.img-caption" ).slideToggle( "fast" );
		} ).mouseleave( function() {
				$( this ).find( "div.img-caption" ).slideToggle( "fast" );
		} );

		$( "document" ).ready( function( $ ) {
				var nav = $( '#fixed-content-menu' );
						
				$( window ).scroll( function () {
						if ( $( this ).scrollTop() > 80 ) {
								nav.addClass( "showmenu" );
								nav.addClass( "movemenudown" );
						} else {
								nav.removeClass( "showmenu" );
						}
				} );
		} );
</script>

</body>
