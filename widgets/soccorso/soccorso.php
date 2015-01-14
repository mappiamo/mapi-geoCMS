<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_soccorso() {
	global $content;

	if ( ! is_numeric( $content->get_id() ) ) return null;

	$cfound = false;
	$categories = $content->get_categories();
	if ( ! sizeof( $categories ) > 0 ) return null;
	foreach( $categories as $category ) {
		if ( isset( $category->id ) && 5 == $category->id ) $cfound = true;
	}

	if ( ! $cfound ) return null;

	$message = array( 'any' => false, 'type' => '', 'text' => '' );
	if ( isset( $_POST['sa_send'] ) ) {
		$message = array( 'any' => true, 'type' => 'success', 'text' => 'Your contact information is sent. Please wait for the member to contact You.' );

		if ( empty( $_POST['sa_email'] ) && empty( $_POST['sa_phone'] ) )
			$message = array( 'any' => true, 'type' => 'warning', 'text' => 'Your email address or your phone number is required.' );

		if ( empty( $_POST['sa_name'] ) )
                        $message = array( 'any' => true, 'type' => 'warning', 'text' => 'Please fill in Your name.' );

	}

	?>
		<div class="soccorso">
			<a 
				href="javascript:void();" 
				onclick="if ( 'none' == $( '#sa_contact' ).css( 'display' ) ) { $( '#sa_contact' ).show(); mmap.map.invalidateSize( false ); } else { $( '#sa_contact' ).hide(); mmap.map.invalidateSize( false ); }"
				title="Contact me"
			>
				<img src="media/images/soccorso.png" alt="" style="height: 105px;" />
			</a>

			<?php if ( $message['any'] ): ?>
				<div class="message">
					<span class="label label-<?php echo $message['type']; ?>"><?php echo $message['text']; ?></span>
				</div>
				<?php 
					$message = array( 'any' => false, 'type' => '', 'text' => '' );
				?>
			<?php endif; ?>

			<div class="panel panel-default" id="sa_contact"<?php if ( ! $message['any'] ) echo ' style="display: none;"'; ?>>
  				<div class="panel-heading">
					Contact me<br />
					<small>( Please fill in your contact information so the Soccorsso Aquila member can reach you by phone or email )</small>
				</div>
 	 			<div class="panel-body">
					<form method="post">
						<div class="form-group">
                                                	<input type="text" class="form-control" name="sa_name" id="sa_name" placeholder="Your name"<?php if ( isset( $_POST['sa_name'] ) ) echo ' value="' . strip_tags( $_POST['sa_name'] )  .'"';  ?>>
                                        	</div>
    						<div class="form-group">
    							<input type="email" class="form-control" name="sa_email" id="email" placeholder="Email address"<?php if ( isset( $_POST['sa_email'] ) ) echo ' value="' . strip_tags( $_POST['sa_email'] ) . '"'; ?>>
  						</div>
						<div class="form-group">
                                                	<input type="text" class="form-control" name="sa_phone" id="sa_phone" placeholder="Phone number"<?php if ( isset( $_POST['sa_phone'] ) ) echo ' value="' . strip_tags( $_POST['sa_phone'] ) . '"'; ?>>
                                        	</div>
						<div clas="form-group">
							<textarea class="form-control" name="sa_text" rows="3"><?php if ( isset( $_POST['sa_text'] ) ) { echo strip_tags( $_POST['sa_text'] ); } else { echo 'Message'; } ?></textarea>
						</div>
						<br />
						<input type="submit" name="sa_send" class="btn btn-primary" value="Send">
					</form>
  				</div>
			</div>
		</div>
	<?php
}

?>
