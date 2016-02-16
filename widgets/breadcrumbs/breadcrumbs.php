<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

function mwidget_breadcrumbs() {

		$SchemaData = array();
		$SchemaKey = 0;
		
		?>
		<ol class="breadcrumb">
				<li><a href="index.php">Home</a></li>
		<?php
		$SchemaKey++;
		$SchemaData[$SchemaKey]['id'] = 'index.php'; $SchemaData[$SchemaKey]['name'] = 'Home';

		if ( 'category' == $_GET['module'] ) {
				//category oldal
				if ( ! empty( $_GET['object'] ) || ! is_numeric( $_GET['object'] )) {
						$category = new M_Category( intval( $_GET['object'] ) );
						?>
						<li><a href="index.php?module=category&object=<?php MPut::_html( $category->get_id() ); ?>"><?php MPut::_html( $category->get_title() ); ?></a></li>
						<?php
						$SchemaKey++;
						$SchemaData[$SchemaKey]['id'] = 'index.php?module=category&object=' . $category->get_id(); $SchemaData[$SchemaKey]['name'] = $category->get_title();
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
										$SchemaKey++;
										$SchemaData[$SchemaKey]['id'] = 'index.php?module=category&object=' . $cat->id; $SchemaData[$SchemaKey]['name'] = $cat->title;

										if ( $i < sizeof( $categories ) ) {
												echo ", ";
										}
										$i++;
								}
								?>
								</li>
								<li><a href="index.php?module=content&object=<?php MPut::_html( $content->get_id() ); ?>"><?php MPut::_html( $content->get_title() ); ?></a></li>
								<?php
								$SchemaKey++;
								$SchemaData[$SchemaKey]['id'] = 'index.php?module=content&object=' . $content->get_id(); $SchemaData[$SchemaKey]['name'] = $content->get_title();
						}
				}
		}

		?>
		</ol>
		<?php
		$FullURL = rtrim(((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']), '/\\') . '/';
		$pref = new M_Preference("website_title");
		$SiteName = $pref->get_value();
		?>

		<div class="microformat">
			<script type="application/ld+json">

			  {"@context" : "http://schema.org",
  			"@type" : "WebSite",
  			"name" : "<?PHP echo $SiteName; ?>",
  			"url" : "<?PHP echo $FullURL; ?>"}

			</script>

			<script type="application/ld+json">
				{"@context": "http://schema.org",
					"@type": "BreadcrumbList",
					"itemListElement": [
					<?PHP

					foreach ($SchemaData as $SKey => $SValue) { ?>

						{
							"@type": "ListItem",
							"position": <?PHP echo $SKey; ?>,
							"item": {
								"@id": "<?PHP echo $FullURL . $SValue['id']; ?>",
								"name": "<?PHP echo $SValue['name']; ?>"
						} }

						<?PHP if (count($SchemaData) > $SKey) { echo ','; } ?>

					<?PHP
					}
					?>
					]}
			</script>
		</div>

		<?PHP
}

?>