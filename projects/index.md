---
layout: default
title: Projects & Experiments
tagline: Field explorations of humanitarian technology

---

<div class="container">
	<div class="content">
		
		{% for page in site.categories.project limit:6 %}
		<div id="post" class="post type-post status-publish format-standard hentry category-blog tag-design-2 tag-space blog-post clearfix"> 

			<a class="blog-image" href="{{page.url}}" title="{{page.title}}"><img width="{{page.postimg_w}}" height="{{page.postimg_h}}" src="{{ BASE_PATH }}/assets/{{page.postimg_src}}" class="attachment-blog-image wp-post-image" alt="{{page.postimg_alt}}" /></a>

			<div class="blog-text">

				<div class="title-meta">
				<h2><a href="{{page.url}}">{{page.title}}</a></h2>
				</div>

				<div class="blog-entry">
					<div class="blog-content">

						<!-- main content -->
						{{page.excerpt}}
						<!-- end main content -->

					</div><!-- end blog-content -->
				</div><!-- end blog-entry -->
			</div><!-- end blog-text -->

			<div class="blog-meta">

				<!-- metadata date/categories/tags -->
				<ul class="meta-links">
					<li>{{page.date | date_to_string }}</li>
					<li>{{page.author }}</li>
						<li><a href="{{page.url}}#disqus_thread" data-disqus-identifier="{{page.id}}"></a></li>
				</ul>

				<ul class="meta-links">
					<li class="share-title">Category:</li>
					<li> <a href="http://themes.okaythemes.com/slate/category/blog/" title="View all posts in Blog" rel="category tag">Blog</a></li>
					<li></li>
					<li class="share-title meta-tag-title">Tag:</li>
					<li> <a href="http://themes.okaythemes.com/slate/tag/design-2/" rel="tag">design</a><br />
						 <a href="http://themes.okaythemes.com/slate/tag/space/" rel="tag">space</a>
					</li>
				</ul>

				<!-- metadata sharing links -->
				<ul class="meta-links">
					<li class="share-title">Share:</li>
					<li class="twitter"> <a onclick="window.open('http://twitter.com/home?status=The Great Browser Experiment - http://themes.okaythemes.com/slate/2011/10/03/browser/','twitter','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;" href="http://twitter.com/home?status=The Great Browser Experiment - http://themes.okaythemes.com/slate/2011/10/03/browser/" title="The Great Browser Experiment" target="blank">Twitter</a></li>
					<li class="facebook"> <a
				onclick="window.open('http://www.facebook.com/share.php?u=http://themes.okaythemes.com/slate/2011/10/03/browser/','facebook','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;" href="http://www.facebook.com/share.php?u=http://themes.okaythemes.com/slate/2011/10/03/browser/" title="The Great Browser Experiment"  target="blank">Facebook</a></li>
					<li class="googleplus"> <a
				class="share-google" href="https://plus.google.com/share?url=http://themes.okaythemes.com/slate/2011/10/03/browser/" onclick="window.open('https://plus.google.com/share?url=http://themes.okaythemes.com/slate/2011/10/03/browser/','gplusshare','width=450,height=300,left='+(screen.availWidth/2-375)+',top='+(screen.availHeight/2-150)+'');return false;">Google+</a></li>
				</ul>
			</div><!-- end blog meta -->
		</div><!-- end post -->

		{% endfor %}

	</div><!-- end content -->
	
	<!-- ~^~ SIDEBAR ^~^~^~^~^~^~^~^~^~ -->


	<div id="sidebar">

		<div id="okay_recent_portfolio-2" class="widget widget_okay_recent_portfolio">
			<h2>See Also</h2>
			<p>See these resources also...</p>
		</div>

	</div>

	<div class="clear"> </div>
	
</div>


