---
layout: default
title: Blog
tagline: Humanitarian Field Experiments @ Camp Roberts

---

{% include JB/setup %}

<div class="container">
	<div class="content">
		
		{% for page in site.categories.blog limit:6 %}
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
						<li><a href="{{page.url}}#disqus_thread" data-disqus-identifier="{{page.id}}"> </a></li>
				</ul>
				
				<ul class="meta-links">
					<li class="share-title meta-tag-title">Tag:</li>
					<li> <a href="http://themes.okaythemes.com/slate/tag/design-2/" rel="tag">design</a><br />
						 <a href="http://themes.okaythemes.com/slate/tag/space/" rel="tag">space</a>
					</li>
				</ul>

				<!-- metadata sharing links -->

			</div><!-- end blog meta -->
		</div><!-- end post -->

		{% endfor %}

	</div><!-- end content -->
	
	<!-- ~^~ SIDEBAR ^~^~^~^~^~^~^~^~^~ -->


	<div id="sidebar">

		<div id="okay_recent_portfolio-2" class="widget widget_okay_recent_portfolio">
			<h2>Twitter Dialogue</h2>
			<p>See these resources also...</p>		</div>

	</div>

	<div class="clear"> </div>
	
</div>


