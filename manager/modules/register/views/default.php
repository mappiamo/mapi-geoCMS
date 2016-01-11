<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="container">

	    <form class="form-signin registration" method="post" role="form">
	    		<div class="message-signin">
						<?php MMessaging::show(); ?>
				</div>
				
	        	<h2 class="form-signin-heading">#mappiamo</h2>
	        	<input type="text" name="user" class="form-control" placeholder="Username" value="<?php MPut::_html_attr( MGet::string( 'user' ) ); ?>" autofocus>
	        	<input type="text" name="name" class="form-control" placeholder="Name" value="<?php MPut::_html_attr( MGet::string( 'name' ) ); ?>">
	        	<input type="text" name="email" class="form-control" placeholder="Email" value="<?php MPut::_html_attr( MGet::string( 'email' ) ); ?>" >
	        	<input type="password" name="pass" class="form-control" placeholder="Password">
	        	<input type="password" name="pass_repeat" class="form-control" placeholder="Repeat password">

	        	<script>
							var RecaptchaOptions = {
										theme : 'white'
							};
						</script>

	        	<?php echo recaptcha_get_html('6LeZNOUSAAAAALQAQuZXkMq-kI0ZOnaCb-YMP5z1'); ?>
	        	<br />
	        	<label>All fields are required</label>
	        	<input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr( mapi_csrf_value() ); ?>" />
	        	<button class="btn btn-primary btn-block" name="do-register" type="submit">Register</button>

	        	<br />
                <p>
									Already have an account? Login <a href="index.php?module=login">here</a>.<br>
									Forgot your password? Renew <a href="index.php?module=passrenew">here</a>.
                </p>
	    </form>

</div>