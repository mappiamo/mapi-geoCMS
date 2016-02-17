<?php

	defined( 'DACCESS' ) or die;

	$TitleName = ORM::for_table('preferences')->select_many('value')->where('name', 'website_title')->find_one();

?>

<div class="container">
	<div class="form-signin registration">
		<h2 class="form-signin-heading"><?PHP echo $TitleName['value']; ?></h2>

		Your new password saved. Please use login page.

		<br /><br />
		<p>
			Already have an account? Login <a href="index.php?module=login">here</a>.
		</p>
		<hr><p style="text-align: center"><img src="../media/images/mappiamo.png" style="width: 200px"><br>Powered by mappiamo</p>
	</div>
</div>
