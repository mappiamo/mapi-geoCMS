<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<article>
		<?php 
				switch ( $data->get_type() ) {
						case 'event': $this->model( 'display_event', $data ); break;
						case 'place': $this->model( 'display_place', $data ); break;
						default: $this->model( 'display_post', $data ); break;
				}
		?>
		<div class="content-image">
				<?php $this->widget( 'content_image', $data->get_id() ); ?>
		</div>
</article>