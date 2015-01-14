<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<section class="nav">
		<div class="container leather-container-head">
				<div class="row">
						<div class="col-sm-4" style="margin: 6px 0px;display:inline-block;"><?php $this->widget( 'topmenu', 3 ); ?></div>
						<div class="col-sm-4" style="margin: 6px 0px;display:inline-block;">&nbsp;</div>
						<div class="col-sm-4" style="margin: 6px 0px;display:inline-block; text-align:right;">
						<?php $this->widget( 'language_switch' ); ?>
						</div>
				</div>

				<div class="row" id="header-space">
						<div class="col-sm-12" style="height: 30px;"></div>
				</div>

				<div class="row hidden-xs" id="header-menu">
						<?php $this->widget( 'dividedmenu', array( 1, 'col-sm-2', null ) ); ?>
						<div class="col-sm-4 menu-logo-guzzi"><a href="index.php" title="MotoGuzzi World Club"><div></div></a></div>
						<?php $this->widget( 'dividedmenu', array( 2, 'col-sm-2', null ) ); ?>
				</div>
				<script>
					$("#header-menu div a").each(function() {
						$(this).hover(function() {
							$(this).parent().children("div").css("display", "block");
							//alert("valami");
						}, function() {
							$(this).parent().children("div").css("display", "none");
						});
						$(this).parent().children("div").hover(function() {
							$(this).parent().children("div").css("display", "block");
						}, function() {
							$(this).parent().children("div").css("display", "none");
						});
					});
				</script>
				<div class="row visible-xs navbar-fixed-top">
						<div class="panel"  id="fixed-menu">
								<div class="panel-heading">
										<h4 class="panel-title">
												<a data-toggle="collapse" href="#collapseOne" id="menu-at-scroll"><img src="media/images/motoguzzilogo2.png" style="height: 50px;" /></a>
										</h4>
								</div>
								<div id="collapseOne" class="panel-collapse collapse" >
										<div class="panel-body">
												<div class="container">
														<div class="col-xs-12">
																<a href="index.php" title="Moto Guzzi World Club">Home</a>
														</div>
														<?php $this->widget( 'dividedmenu', array( 1, 'col-xs-12', null ) ); ?>
														<?php $this->widget( 'dividedmenu', array( 2, 'col-xs-12', null ) ); ?>
												</div>
										</div>
								</div>
						</div>
				</div>
			
				<div id="fixed-content-menu" class="container leather-container-head navbar-fixed-top">
						<div class="row hidden-xs" id="content-header-menu">
								<div class="col-md-8 col-sm-10 col-xs-12">
										<div class="row">
												<div class="col-sm-3 hidden-xs">
														<img src="media/images/motoguzzilogo2.png" style="width: 50%; cursor: pointer;" onclick="location.href='index.php'" />
												</div>
												<div class="col-sm-9 col-xs-12">
														<div class="row">
																<?php $this->widget( 'dividedmenu', array( 1, 'col-xs-3', null ) ); ?>
																<?php $this->widget( 'dividedmenu', array( 2, 'col-xs-3', null ) ); ?>
														</div>
												</div>
										</div>
								</div>
								<div class="col-md-4 col-sm-2"></div>
						</div>
				</div>
				<script>
				$("#content-header-menu div div div div div a").each(function(){
					$(this).hover(function(){
						$(this).parent().children("div")
							.css("display", "block")
							.css("top", "35px")
							.children("div").children("a").css("font-size", "9pt").css("margin", "4px 0");
						//$(this).parent().children("div").width( $(this).parent().children("div").children("ul").width() );
					}, function() {
						$(this).parent().children("div").css("display", "none");
					});
					$(this).parent().children("div").hover(function() {
						//hover
						$(this).parent().children("div")
							.css("display", "block");
					}, function() {
						//unhover
						$(this).parent().children("div").css("display", "none");
					});
				});
				</script>
		</div>
</section>
