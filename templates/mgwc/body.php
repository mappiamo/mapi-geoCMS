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

				<div class="row" id="box-images">
						<?php $this->widget( 'box', array( 'media/images/box_storia.jpg', 'TRADIZIONE', 'NOBLE DYNASTY FOR OVER 90 YEARS', 'http://www.motoguzzi.com/en/tradizione' ) ); ?>

						<?php $this->widget( 'box', array( 'media/images/box_garage.jpg', 'GARAGE', 'BORN WITH STYLE TO LIVE ON PASSION', 'http://www.motoguzzi.com/en/garage' ) ); ?>

						<?php $this->widget( 'box', array( 'media/images/box_v7.jpg', 'V7 SPECIAL', 'THE ESSENCE OF THE BIKE', 'http://www.motoguzzi.com/en/scuderia#v7special' ) ); ?>
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
