<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<section class="footer">
		<div class="container leather-container-foot footer-container">
				<div class="row">
						<div class="col-md-4 newsletter-menu">
								<div  style="margin-bottom: 4px;">Newsletter: Keep updated with Moto Guzzi World Club</div>
								<form class="form-inline" role="form" action="#" >
										<input type="text" class="form-control email" id="newsletter" name="email" placeholder="Enter your email address">
										<button type="submit" class="btn btn-default">Submit</button>
								</form>
						</div>

						<div class="col-md-4 col-md-push-4 text-right social-menu">
								<div  style="margin-bottom: 4px;">Follow Moto Guzzi World Club on:</div>
								<a class="social-icon facebook" href="https://www.facebook.com/groups/MotoGuzziWorldClub/"></a>
								<a class="social-icon instagram" href="http://instagram.com/moto_guzzi_official"></a>
								<a class="social-icon twitter" href="https://www.twitter.com/@MotoGuzziClub"></a>
								<a class="social-icon pinterest" href="http://www.pinterest.com/motoguzziclub/"></a>
								<a class="social-icon youtube" href="https://www.youtube.com/user/motoguzziofficial"></a>
								<a class="social-icon g-plus" href="https://plus.google.com/113047581209640116052/"></a>
						</div>

						<div class="col-md-4 col-md-pull-4">
								<div style="text-align: center;">
										<p>
												© 2014 Moto Guzzi World Club <br /> The content is released under CC-BY-SA licence
												<br />
												<?php $this->widget( 'bottommenu', 4 ); ?>
										</p>
								</div>
						</div>
				</div>
				<div class="row">
						<div class="visible-xs col-xs-12" style="text-align:center;">
							<?php $this->widget( 'language_switch' ); ?>
						</div>
				</div>
		</div>
</section>
