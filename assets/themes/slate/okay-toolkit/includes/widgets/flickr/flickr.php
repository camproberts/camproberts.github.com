<?php

/*-----------------------------------------------------------------------------------*/
/* Okay Flickr Widget
/*-----------------------------------------------------------------------------------*/

add_action('widgets_init','load_okay_flickr_widget');

function load_okay_flickr_widget() {
	register_widget('okay_flickr_widget');
}

class okay_flickr_widget extends WP_Widget {
	function okay_flickr_widget() {
	    $widget_ops = array( 'classname' => 'flickr', 'description' => __('Grab your latest Flickr photos', 'okay') );
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ok-flickr-widget' );
		$this->WP_Widget('ok-flickr-widget', __('Okay Flickr Widget', 'okay'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
 		extract($args);

		$flickr_title = apply_filters('widget_title', $instance['flickr_title']);
		$flickr_id = $instance['flickr_id'];
		$flickr_count = $instance['flickr_count'];

		echo $before_widget; ?>
		<div class="flickr-widget">
			<?php if ( $flickr_title ) echo $before_title . $flickr_title . $after_title; ?>
					
			<ul id="flickr-<?php echo $args['widget_id']; ?>" class="flickr">

			<?php

			// If the user's set their flickr_id, grab their latest pics
			if ($flickr_id != ''){

				$images = array();
				$regx = "/<img(.+)\/>/";

				// Set up the flickr feed URL and retrieve it
				$rss_url = 'http://api.flickr.com/services/feeds/photos_public.gne?ids='.$flickr_id.'&lang=en-us&format=rss_200';
				$flickr_feed = simplexml_load_file( $rss_url );
				
				// Store images from the feed in an array
				foreach( $flickr_feed->channel->item as $item ) {
					preg_match( $regx, $item->description, $matches );
					
					$images[] = array(							  
							  'link' => $item->link,
							  'thumb' => $matches[ 0 ]
							);
				}

				// Loop through the images and display the number they wish to show
				$image_count = 0;
				if ( $flickr_count == '' ) $flickr_count = 5;

				foreach( $images as $img ) {
					if ($image_count < $flickr_count ){
						$img_tag = str_replace("_m", "_b", $img[ 'thumb' ] );
						echo '<li><a href="' . $img[ 'link' ] . '">' . $img_tag . '</a></li>';
						$image_count++;
					}
				}

			}//end if ($flickr_id)

			?>				
			</ul>
		</div>					
			
			<?php
		echo $after_widget;	
  }

	// Updating the widget
	function update($new_instance, $old_instance) {

		$instance = $old_instance;
		$instance['flickr_title'] = strip_tags( $new_instance['flickr_title']);
		$instance['flickr_id'] = strip_tags( $new_instance['flickr_id']);
		$instance['flickr_count'] = strip_tags( $new_instance['flickr_count']);

		return $instance;
	}

	function form( $instance ) {
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','okay'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('flickr_title'); ?>" name="<?php echo $this->get_field_name('flickr_title'); ?>" value="<?php if(isset($instance['flickr_title'])) echo $instance['flickr_title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('flickr_id'); ?>"><?php _e('Your Flickr User ID:','okay'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" value="<?php if(isset($instance['flickr_id'])) echo $instance['flickr_id']; ?>" />
	 		<small>Don't know your ID? Head on over to <a href="http://idgettr.com">idgettr</a> to find it.</small>
	 	</p>

	 	<p>
			<label for="<?php echo $this->get_field_id('flickr_count'); ?>"><?php _e('No. of Photos:','okay'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('flickr_count'); ?>" name="<?php echo $this->get_field_name('flickr_count'); ?>" value="<?php if(isset($instance['flickr_count'])) echo $instance['flickr_count']; ?>" />
		</p>
		
		<?php
	}
}

?>