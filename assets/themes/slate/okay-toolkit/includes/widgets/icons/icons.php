<?php

/*-----------------------------------------------------------------------------------*/
/* Okay Social Icons Widget
/*-----------------------------------------------------------------------------------*/

add_action('widgets_init','load_okay_icons_widget');

function load_okay_icons_widget() {
	register_widget('okay_icons_widget');
}

class okay_icons_widget extends WP_Widget {
	function okay_icons_widget() {
	    $widget_ops = array( 'classname' => 'icons', 'description' => __('Show social icon links', 'okay') );
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ok-icons-widget' );
		$this->WP_Widget('ok-icons-widget', __('Okay Social Icons Widget', 'okay'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
 		extract($args);

		$icons_title = apply_filters('widget_title', $instance['icons_title']);
		$icons_shape = $instance['icons_shape'];
		$twitter_icon = $instance['twitter_icon'];
		$dribbble_icon = $instance['dribbble_icon'];
		$facebook_icon = $instance['facebook_icon'];
		$vimeo_icon = $instance['vimeo_icon'];
		$tumblr_icon = $instance['tumblr_icon'];
		$linkedin_icon = $instance['linkedin_icon'];
		$flickr_icon = $instance['flickr_icon'];
		$google_icon = $instance['google_icon'];
		$feed_icon = $instance['feed_icon'];
		$youtube_icon = $instance['youtube_icon'];
		$pinterest_icon = $instance['pinterest_icon'];
		$wordpress_icon = $instance['wordpress_icon'];

		echo $before_widget; ?>
		
		<?php $okaysocial_options = get_option('okaysocial_options'); ?>
		
		<div class="icons-widget">
			<?php if ( $icons_title ) echo $before_title . $icons_title . $after_title; ?>
					
			<div id="icons" class="<?php if ($okaysocial_options['icon_shape'] == 'round') { ?>round-icons<?php } ?> <?php if ($okaysocial_options['icon_size'] == 'small') { ?>small-icons<?php } ?> <?php if ($okaysocial_options['icon_size'] == 'large') { ?>large-icons<?php } ?>">
				<?php if ( $twitter_icon ) { ?>								
					<a href="<?php echo $instance['twitter_icon']; ?>" class="twitter-icon" title="Twitter"></a>
				<?php } ?>
				
				<?php if ( $dribbble_icon ) { ?>								
					<a href="<?php echo $instance['dribbble_icon']; ?>" class="dribbble-icon" title="Dribbble"></a>
				<?php } ?>
				
				<?php if ( $facebook_icon ) { ?>								
					<a href="<?php echo $instance['facebook_icon']; ?>" class="facebook-icon" title="Facebook"></a>
				<?php } ?>
				
				<?php if ( $vimeo_icon ) { ?>								
					<a href="<?php echo $instance['vimeo_icon']; ?>" class="vimeo-icon" title="Vimeo"></a>
				<?php } ?>
				
				<?php if ( $tumblr_icon ) { ?>								
					<a href="<?php echo $instance['tumblr_icon']; ?>" class="tumblr-icon" title="Tumblr"></a>
				<?php } ?>
				
				<?php if ( $linkedin_icon ) { ?>								
					<a href="<?php echo $instance['linkedin_icon']; ?>" class="linkedin-icon" title="LinkedIn"></a>
				<?php } ?>
				
				<?php if ( $flickr_icon ) { ?>								
					<a href="<?php echo $instance['flickr_icon']; ?>" class="flickr-icon" title="Flickr"><span class="cyan"></span><span class="magenta"></span></a>
				<?php } ?>
				
				<?php if ( $google_icon ) { ?>								
					<a href="<?php echo $instance['google_icon']; ?>" class="google-icon" title="Google"></a>
				<?php } ?>
				
				<?php if ( $feed_icon ) { ?>								
					<a href="<?php echo $instance['feed_icon']; ?>" class="feed-icon" title="RSS Feed"></a>
				<?php } ?>
				
				<?php if ( $youtube_icon ) { ?>								
					<a href="<?php echo $instance['youtube_icon']; ?>" class="youtube-icon" title="YouTube"></a>
				<?php } ?>
				
				<?php if ( $pinterest_icon ) { ?>								
					<a href="<?php echo $instance['pinterest_icon']; ?>" class="pinterest-icon" title="Pinterest"></a>
				<?php } ?>
				
				<?php if ( $wordpress_icon ) { ?>								
					<a href="<?php echo $instance['wordpress_icon']; ?>" class="wordpress-icon" title="WordPress"></a>
				<?php } ?>
			</div>		
		</div>			
			
			<?php
		echo $after_widget;	
  }

	// Updating the widget
	function update($new_instance, $old_instance) {

		$instance = $old_instance;
		$instance['icons_title'] = strip_tags( $new_instance['icons_title']);
		$instance['icons_shape'] = strip_tags( $new_instance['icons_shape']);
		$instance['twitter_icon'] = strip_tags( $new_instance['twitter_icon']);
		$instance['dribbble_icon'] = strip_tags( $new_instance['dribbble_icon']);
		$instance['facebook_icon'] = strip_tags( $new_instance['facebook_icon']);
		$instance['vimeo_icon'] = strip_tags( $new_instance['vimeo_icon']);
		$instance['tumblr_icon'] = strip_tags( $new_instance['tumblr_icon']);
		$instance['linkedin_icon'] = strip_tags( $new_instance['linkedin_icon']);
		$instance['flickr_icon'] = strip_tags( $new_instance['flickr_icon']);
		$instance['google_icon'] = strip_tags( $new_instance['google_icon']);
		$instance['feed_icon'] = strip_tags( $new_instance['feed_icon']);
		$instance['youtube_icon'] = strip_tags( $new_instance['youtube_icon']);
		$instance['pinterest_icon'] = strip_tags( $new_instance['pinterest_icon']);
		$instance['wordpress_icon'] = strip_tags( $new_instance['wordpress_icon']);

		return $instance;
	}

	function form( $instance ) {
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','okay'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('icons_title'); ?>" name="<?php echo $this->get_field_name('icons_title'); ?>" value="<?php if(isset($instance['icons_title'])) echo $instance['icons_title']; ?>" />
		</p>		

		<p>
			<label for="<?php echo $this->get_field_id('twitter_icon'); ?>"><?php _e('Twitter Link','okay'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('twitter_icon'); ?>" name="<?php echo $this->get_field_name('twitter_icon'); ?>" value="<?php if(isset($instance['twitter_icon'])) echo $instance['twitter_icon']; ?>" />
	 	</p>
	 	
	 	<p>
			<label for="<?php echo $this->get_field_id('dribbble_icon'); ?>"><?php _e('Dribbble Link','okay'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('dribbble_icon'); ?>" name="<?php echo $this->get_field_name('dribbble_icon'); ?>" value="<?php if(isset($instance['dribbble_icon'])) echo $instance['dribbble_icon']; ?>" />
	 	</p>
	 	
	 	<p>
			<label for="<?php echo $this->get_field_id('facebook_icon'); ?>"><?php _e('Facebook Link','okay'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('facebook_icon'); ?>" name="<?php echo $this->get_field_name('facebook_icon'); ?>" value="<?php if(isset($instance['facebook_icon'])) echo $instance['facebook_icon']; ?>" />
	 	</p>
	 	
	 	<p>
			<label for="<?php echo $this->get_field_id('vimeo_icon'); ?>"><?php _e('Vimeo Link','okay'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('vimeo_icon'); ?>" name="<?php echo $this->get_field_name('vimeo_icon'); ?>" value="<?php if(isset($instance['vimeo_icon'])) echo $instance['vimeo_icon']; ?>" />
	 	</p>
	 	
	 	<p>
			<label for="<?php echo $this->get_field_id('tumblr_icon'); ?>"><?php _e('Tumblr Link','okay'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('tumblr_icon'); ?>" name="<?php echo $this->get_field_name('tumblr_icon'); ?>" value="<?php if(isset($instance['tumblr_icon'])) echo $instance['tumblr_icon']; ?>" />
	 	</p>
	 	
	 	<p>
			<label for="<?php echo $this->get_field_id('linkedin_icon'); ?>"><?php _e('LinkedIn Link','okay'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('linkedin_icon'); ?>" name="<?php echo $this->get_field_name('linkedin_icon'); ?>" value="<?php if(isset($instance['linkedin_icon'])) echo $instance['linkedin_icon']; ?>" />
	 	</p>
	 	
	 	<p>
			<label for="<?php echo $this->get_field_id('flickr_icon'); ?>"><?php _e('Flickr Link','okay'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('flickr_icon'); ?>" name="<?php echo $this->get_field_name('flickr_icon'); ?>" value="<?php if(isset($instance['flickr_icon'])) echo $instance['flickr_icon']; ?>" />
	 	</p>
	 	
	 	<p>
			<label for="<?php echo $this->get_field_id('google_icon'); ?>"><?php _e('Google Link','okay'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('google_icon'); ?>" name="<?php echo $this->get_field_name('google_icon'); ?>" value="<?php if(isset($instance['google_icon'])) echo $instance['google_icon']; ?>" />
	 	</p>
	 	
	 	<p>
			<label for="<?php echo $this->get_field_id('feed_icon'); ?>"><?php _e('RSS Feed Link','okay'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('feed_icon'); ?>" name="<?php echo $this->get_field_name('feed_icon'); ?>" value="<?php if(isset($instance['feed_icon'])) echo $instance['feed_icon']; ?>" />
	 	</p>
	 	
	 	<p>
			<label for="<?php echo $this->get_field_id('youtube_icon'); ?>"><?php _e('YouTube Link','okay'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('youtube_icon'); ?>" name="<?php echo $this->get_field_name('youtube_icon'); ?>" value="<?php if(isset($instance['youtube_icon'])) echo $instance['youtube_icon']; ?>" />
	 	</p>
	 	
	 	<p>
			<label for="<?php echo $this->get_field_id('pinterest_icon'); ?>"><?php _e('Pinterest Link','okay'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('pinterest_icon'); ?>" name="<?php echo $this->get_field_name('pinterest_icon'); ?>" value="<?php if(isset($instance['pinterest_icon'])) echo $instance['pinterest_icon']; ?>" />
	 	</p>
	 	
	 	<p>
			<label for="<?php echo $this->get_field_id('wordpress_icon'); ?>"><?php _e('WordPress Link','okay'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('wordpress_icon'); ?>" name="<?php echo $this->get_field_name('wordpress_icon'); ?>" value="<?php if(isset($instance['wordpress_icon'])) echo $instance['wordpress_icon']; ?>" />
	 	</p>
		
		<?php
	}
}

?>