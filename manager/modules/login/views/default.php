<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

	$TitleName = ORM::for_table('preferences')->select_many('value')->where('name', 'website_title')->find_one();

?>

<div class="container">

        <form class="form-signin" method="post" role="form">
        		<div class="message-signin">
    					<?php MMessaging::show(); ?>
    			</div>
    			
            	<h2 class="form-signin-heading"><?PHP echo $TitleName['value']; ?></h2>
            	<input type="text" name="user" class="form-control" placeholder="Username" autofocus>
            	<input type="password" name="pass" class="form-control" placeholder="Password">
            	<label class="checkbox">
              			<input type="checkbox" name="remember" value="remember-me"> Remember me
            	</label>
                <input type="hidden" name="mapi_csrf" id="mapi_csrf" value="<?php MPut::_html_attr( mapi_csrf_value() ); ?>" />
            	<button class="btn btn-primary btn-block" name="do-login" type="submit">Sign in</button>

                <?php if ( 'yes' == MObject::get( 'preference', 'registration' )->get_value() ): ?>
                        <br />
                        <p>
													No account? Please register <a href="index.php?module=register">here</a>.<br>
													Forgot your password? Renew <a href="index.php?module=passrenew">here</a>.
                        </p>
                <?php endif; ?>
					<hr><p style="text-align: center"><img src="../media/images/mappiamo.png" style="width: 200px"><br>Powered by mappiamo</p>
        </form>
</div>