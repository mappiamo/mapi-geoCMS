<?php

	defined( 'DACCESS' ) or die;

	$TitleName = ORM::for_table('preferences')->select_many('value')->where('name', 'website_title')->find_one();

?>

<div class="container">

	<form class="form-signin registration" method="post" role="form">
		<div class="message-signin">
			<?php MMessaging::show(); ?>
		</div>

		<h2 class="form-signin-heading"><?PHP echo $TitleName['value']; ?></h2>
		<input type="text" name="email" class="form-control" placeholder="Email" value="<?php MPut::_html_attr( MGet::string( 'email' ) ); ?>" >
		<br>

		<script>
			var RecaptchaOptions = {
				theme : 'white'
			};
		</script>
		<?php
			$CaptchaKey =	ORM::for_table('preferences')->select_many('value')
												->where('name', 'Reacaptcha_key')
												->find_one();

			if (($CaptchaKey) && (strlen($CaptchaKey['value']) > 3)) {
				echo recaptcha_get_html($CaptchaKey['value']);
			}
		?>
		<br />
		<label>All fields are required</label>
		<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr( mapi_csrf_value() ); ?>" />
		<button class="btn btn-primary btn-block" name="do-register" type="submit">Renew password</button>

		<br />
		<p>
			Already have an account? Login <a href="index.php?module=login">here</a>.
		</p>
		<hr><p style="text-align: center"><img src="../media/images/mappiamo.png" style="width: 200px"><br>Powered by mappiamo</p>
	</form>

</div>
