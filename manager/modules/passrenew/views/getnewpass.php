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
		<h5>New password for:<br><?PHP print_r($data['username']); ?> => <?PHP print_r($data['email']); ?></h5>
		<input type="password" name="pass" class="form-control" placeholder="New password">
		<input type="password" name="pass_repeat" class="form-control" placeholder="Repeat new password">
		<br>

		<script>
			var RecaptchaOptions = {
				theme : 'white'
			};
		</script>
		<?php echo recaptcha_get_html('6LeZNOUSAAAAALQAQuZXkMq-kI0ZOnaCb-YMP5z1'); ?>
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
