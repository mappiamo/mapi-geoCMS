<?php
	/**
	 * Created by PhpStorm.
	 * User: Laca
	 * Date: 2016.02.01.
	 * Time: 10:01
	 */

	defined( 'DACCESS' ) or die;

		function mwidget_disqus() {
			$DisqusName =	ORM::for_table('preferences')->select_many('value')
												->where('name', 'DisqusName')
												->find_one();

			if ($DisqusName) {
				$DisqusKey = $DisqusName['value']; ?>

				<h1>Comments</h1>

				<div id="disqus_thread"></div>
				<script>
					/**
					 *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
					 *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
					 */
					/*
					 var disqus_config = function () {
					 this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
					 this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
					 };
					 */
					(function() {  // DON'T EDIT BELOW THIS LINE
						var d = document, s = d.createElement('script');

						s.src = '//<?PHP echo $DisqusKey; ?>.disqus.com/embed.js';

						s.setAttribute('data-timestamp', +new Date());
						(d.head || d.body).appendChild(s);
					})();
				</script>
				<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>

			<?PHP
			} else { ?>
				Register your site if you want to use Disqus comment engine <a href="https://disqus.com/admin/create/" target="_blank">from here</a>
			<?PHP
			}
		}

?>