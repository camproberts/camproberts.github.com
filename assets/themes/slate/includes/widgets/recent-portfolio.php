<?php

/**
 * Recent Portfolio Widget Class
 */
class okay_recent_portfolio extends WP_Widget {

    /** constructor */
    function okay_recent_portfolio() {
        parent::WP_Widget(false, $name = 'Okay Sidebar Portfolio Widget');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {	
        extract( $args );
		global $posttypes;
        $title 			= apply_filters('widget_title', $instance['title']);
        $number 		= apply_filters('widget_title', $instance['number']);
        ?>
		
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
					
		<div id="portfolio-sidebar" class="portfolio-sidebar flexslider">
			
			<ul class="slides">
            	<?php
					$args = array('post_type' => 'okay-portfolio', 'posts_per_page' => 5, 'paged' => $paged );
					
					$temp = $wp_query; 
					$wp_query = null; 
					$wp_query = new WP_Query(); 
					$wp_query->query( $args ); 
					
					while ($wp_query->have_posts()) : $wp_query->the_post(); 
				?>
                
				<li>					                    	
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="portfolio-small-image"><?php the_post_thumbnail( 'sidebar-image' ); ?></a>
				</li>

				<?php endwhile; ?>
				
				<?php 
				  $wp_query = null; 
				  $wp_query = $temp;  // Reset
				?>
            </ul>
		</div>			
					
					
		<?php echo $after_widget; ?>
        
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {		
		global $posttypes;
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = strip_tags($new_instance['number']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {	

		$posttypes = get_post_types('', 'objects');
	
        $title = esc_attr($instance['title']);
        $cat = esc_attr($instance['cat']);
        $number = esc_attr($instance['number']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'okay'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number to Show:', 'okay'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
        </p>
        <?php 
    }


} // class utopian_recent_portfolio
// register Recent Posts widget
add_action('widgets_init', create_function('', 'return register_widget("okay_recent_portfolio");'));

?>