<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<article>
	<?php if ($this->widget( 'content_image', $data->get_id() )) { ?>
		<div class="content-image">
			<?php $this->widget( 'content_image', $data->get_id() ); ?>
			<div class="data_wrapper">
				<span class="title"><?PHP MPut::_html($data->get_title()); ?></span>
				<span class="address"><?PHP MPut::_html($data->get_address()); ?></span>
			</div>
		</div>
	<?PHP } ?>

		<?php
				switch ( $data->get_type() ) {
						case 'event': $this->model( 'display_event', $data ); break;
						case 'place': $this->model( 'display_place', $data ); break;
						//case 'route': $this->model( 'display_route', $data ); break;
						default: $this->model( 'display_post', $data ); break;
				}
		?>
</article>