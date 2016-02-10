<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<div class="jumbotron">
		<h1>Welcome to #mappiamo</h1>
		<p>For a quick start add some new content right now!</p>
		<p><a href="index.php?module=mcontent&task=content_add" class="btn btn-primary btn-lg" role="button">Add content</a></p>
</div>

<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<div class="panel panel-default">
					  	<div class="panel-heading">Stats & info</div>
					  	<div class="panel-body">
					   			<blockquote>
									   	<p>#mappiamo version: <strong>0.0.6</strong></p>
										<small>by <a href="http://www.mappiamo.org" target="_blank">mappiamo.org</a></small>
								</blockquote>
								<blockquote>
									   	<p>Quick stats</p>
										<small>contents: <?php echo mapi_stat( 'contents' ); ?></small>
										<small>categories: <?php echo mapi_stat( 'categories' ); ?></small>
										<small>modules: <?php echo mapi_stat( 'modules' ); ?></small>
										<small>users: <?php echo mapi_stat( 'users' ); ?></small>
								</blockquote>
					  	</div>
				</div>

			<div class="panel panel-default">
				<div class="panel-heading">#mappiamo links:</div>
				<div class="panel-body">
					<blockquote>
						<p>Public repository</p>
						<small><a href="https://github.com/mappiamo/">https://github.com/mappiamo/</a></small>
						<small>mapi-geocms (main repo of CMS)</small>
						<small>mapi-app (hybrid application for iOS, android, winphone)</small>
						<small>mapi-wikitude (mobile app based on augmented reality plugin: wikitude)</small>
					</blockquote>
					<blockquote>
						<p>Private repository</p>
						<small><a href="https://bitbucket.com/mappiamo/">https://bitbucket.com/mappiamo/</a></small>
						<small>v2 roadmap</small>
					</blockquote>
					<blockquote>
						<p>helpdesk for #mappiamo user</p>
						<small><a href="https://www.facebook.com/groups/mappiamo/">https://www.facebook.com/groups/mappiamo/</a></small>
					</blockquote>
					<blockquote>
						<p>Developers list</p>
						<small><a href="http://mail.mappiamo.org/mailman/listinfo">http://mail.mappiamo.org/mailman/listinfo</a></small>
						<small>mapi-dev (this list)</small>
					</blockquote>
					<blockquote>
						<p>#mappiamo G+ community</p>
						<small><a href="https://plus.google.com/communities/115601965828994469496">https://plus.google.com/communities/115601965828994469496</a></small>
					</blockquote>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">Changelog</div>
				<div class="panel-body">
					<blockquote>

						<?PHP
							$ChangeLogSource = 'https://raw.githubusercontent.com/mappiamo/mapi-geoCMS/master/CHANGELOG.txt';

							$file_headers = @get_headers($ChangeLogSource);
							if($file_headers[0] != 'HTTP/1.1 404 Not Found') {
								$CLCuntent = file_get_contents($ChangeLogSource);
								echo '<pre>'.$CLCuntent.'</pre>';
							} else {
								echo '<pre>Changelog not accesible. Please visit GIT repo.</pre>';
							}
						?>

					</blockquote>
				</div>
			</div>

		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<div class="panel panel-default">
					  	<div class="panel-heading">Quick links</div>
					  	<div class="panel-body">
					  			<div class="row">
					  					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									   			<blockquote>
									   					<p><a href="index.php?module=mcategory&task=category_list">Categories</a></p>
												  		<small><a href="index.php?module=mcategory&task=category_add">Add a new category</a></small>
												</blockquote>
												<blockquote>
									   					<p><a href="javascript:void(0);">Extensions</a></p>
												  		<small><a href="index.php?module=mmodule&task=module_list">Modules</a></small>
												  		<small><a href="index.php?module=mtemplate&task=template_list">Templates</a></small>
												  		<small><a href="index.php?module=mwidget&task=widget_list">Widgets</a></small>
												</blockquote>
												<div style="height: 16px;">&nbsp;</div>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
												<blockquote>
									   					<p><a href="index.php?module=mcontent&task=content_list">Contents</a></p>
												  		<small><a href="index.php?module=mcontent&task=content_add">Add new content</a></small>
												  		<small><a href="index.php?module=mpage&task=page_add">Add a new page</a></small>
												  		<small><a href="index.php?module=mmenu&task=menu_add">Add a new menu</a></small>
												</blockquote>
										</div>
								</div>
					  	</div>
				</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<div class="panel panel-default">
					  	<div class="panel-heading">@mappiamo</div>
					  	<div class="panel-body">
								<a class="twitter-timeline" href="https://twitter.com/mappiamo" data-widget-id="430423227303604225">Tweets by @mappiamo</a>
								<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					  	</div>
				</div>
		</div>
</div>