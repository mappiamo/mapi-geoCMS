<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_breadcrumbs() {
		
		?>
		<ol class="breadcrumb">
				<li><a href="index.php">Home</a></li>
		<?php
		if ( 'category' == $_GET['module'] ) {
				//category oldal
				if ( ! empty( $_GET['object'] ) || ! is_numeric( $_GET['object'] )) {
						$category = new M_Category( intval( $_GET['object'] ) );
						?>
						<li><a href="index.php?module=category&object=<?php MPut::_html( $category->get_id() ); ?>"><?php MPut::_html( $category->get_title() ); ?></a></li>
						<?php
				}
		}

		else if ( 'content' == $_GET['module'] ) {
				//content oldal
				if ( ! empty( $_GET['object'] ) || ! is_numeric( $_GET['object'] )) {
						$content = MObject::get( 'content', intval( $_GET['object'] ) );
						if ( $content && $content->get_id() ) {
								$categories = ORM::for_table('categories')->where_like('contents', '%{' . intval( $_GET['object'] ) . '}%')->find_many();
								?>
								<li>
								<?php
								$i = 1;
								foreach ($categories as $cat) {
										?>
										<a href="index.php?module=category&object=<?php MPut::_html( $cat->id ); ?>"><?php MPut::_html( $cat->title ); ?></a>
										<?php
										if ( $i < sizeof( $categories ) ) {
												echo ", ";
										}
										$i++;
								}
								?>
								</li>
								<li><a href="index.php?module=content&object=<?php MPut::_html( $content->get_id() ); ?>"><?php MPut::_html( $content->get_title() ); ?></a></li>
								<?php
						}
				}
		}

		?>
		</ol>
		<?php
}

?>