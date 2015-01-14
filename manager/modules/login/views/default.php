<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="container">

        <form class="form-signin" method="post" role="form">
        		<div class="message-signin">
    					<?php MMessaging::show(); ?>
    			</div>
    			
            	<h2 class="form-signin-heading">#mappiamo</h2>
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
                                No account? Please register <a href="index.php?module=register">here</a>.
                        </p>
                <?php endif; ?>
        </form>

</div>