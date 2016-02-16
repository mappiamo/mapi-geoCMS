<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<body data-spy="scroll" data-target=".navbar">
		
<?php include( 'nav.php' ); ?>

<section class="content">		
		<div class="container">
				<div class="row">
						<div class="col-xs-12 hidden-lg hidden-md hidden-sm visible-xs" style="height:80px;"></div>
				</div>
				<div class="row" style="position: relative;">
						<div id="map-canvas">
								<div class="row map-menu" style="display: none;" id="map-menu-at-scroll">
										<div>
												<div class="col-xs-12">
														<div class="map-menu-buttons"><label><input type="checkbox" name="mmap_category[]" value="4" />&nbsp;Club</label></div>
														<div class="map-menu-buttons"><label><input type="checkbox" name="mmap_category[]" value="2" />&nbsp;Eventi</label></div>
                                                                                                                <div class="map-menu-buttons"><label><input type="checkbox" name="mmap_category[]" value="5" />&nbsp;Soccorso Aquila</label></div>
                                                                                                                <div class="map-menu-buttons"><label><input type="checkbox" name="mmap_category[]" value="3" />&nbsp;Dealer</label></div>
														<div class="map-menu-return"><span class="glyphicon glyphicon-remove" rel="tooltip" title="Chiudi mappa!"></span></div>
												</div>
												<div class="col-xs-12">
														<div class="map-menu-search">
                                                                                                                        <div class="input-group">
                                                                                                                                <input type="text" class="form-control" id="content_address" placeholder="Address, City, Country">
                                                                                                                                <span class="input-group-btn">
                                                                                                                                        <button class="btn btn-default" id="address_button" type="button">Go!</button>
                                                                                                                                </span>
                                                                                                                        </div>
															<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr( mapi_csrf_value() ); ?>" />
															<input type="hidden" name="mapi_mode" id="mapi_mode" value="ajax" />
                                                                                                                </div>
												</div>
										</div>
								</div>
							
								<?php $this->widget( 'map' ); ?>
						</div>
				
						<div id="map-shadow"></div>

						<div id="content" style="position: relative; top: 0px; z-index: 1000; ">
								<div class="row">
										<div class="col-md-2 hidden-sm hidden-xs"></div>
						
										<div class="col-md-8 col-sm-12 content-container">
<!--												<div id="exit-button">
														<span class="glyphicon glyphicon-remove" rel="tooltip" title="Vai alla mappa!"></span>
												</div>
-->												
												<div class="content-breadcrumbs">
														<?php $this->widget( 'breadcrumbs' ); ?>
												</div>
							
												<div class="content-text">
														<?php echo $this->content; ?>
												</div>

										</div>
						
										<div class="col-md-2 hidden-sm hidden-xs"></div>
						
								</div>
						</div>
				</div>

				<div class="row" id="box-images" style="margin-left: -14px;">
						<?php $this->widget( 'box', array( 'media/images/box_storia.jpg', 'TRADIZIONE', 'NOBLE DYNASTY FOR OVER 90 YEARS', 'http://www.motoguzzi.com/en/tradizione' ) ); ?>

						<?php $this->widget( 'box', array( 'media/images/box_garage.jpg', 'GARAGE', 'BORN WITH STYLE TO LIVE ON PASSION', 'http://www.motoguzzi.com/en/garage' ) ); ?>

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
		
		$( "#exit-button" ).click( function() {
				$( "#content" ).css( "visibility", "hidden" );
				$( ".introimage" ).slideToggle();
				$( "#map-shadow" ).css( "z-index", -900 );
				$( "#map-canvas" ).css( "z-index", 1000 );
				$( ".content-container" ).css( "height", '760px' );
				$( "#map-canvas" ).css( "height", '670px' );
				$( ".navbar-fixed-top" ).css( "z-index", 1500 );
				$( ".map-menu" ).slideToggle();

				mmap.map.invalidateSize( false );

				window.scrollTo( 0, 0 );
		} );
				
		$( ".map-menu-return" ).click( function() {
				$( ".map-menu" ).slideToggle();

				$( ".introimage" ).slideToggle(function() {
						$( ".content-container" ).css( "height", 'auto' );
						$( "#map-shadow" ).css( "z-index", 900 );
						$( "#map-canvas" ).css( "z-index", 500 );
						$( "#map-canvas" ).css( "height", '100%' );
						$( ".navbar-fixed-top" ).css("z-index", 1500 );
						$( "#content" ).css( "visibility", "visible" );
				} );
				
				mmap.map.invalidateSize( false );
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

				mmap.map.invalidateSize( false );
		} );

		$( "#menu-at-scroll" ).click( function() {
				var kell = $( "#content" ).css( "visibility" );
						
				if ( kell == "visible" ) {
						
				} else {
						$( "#map-menu-at-scroll" ).toggle();
				}
		} );
</script>

</body>
