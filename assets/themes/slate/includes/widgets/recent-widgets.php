<?php
/*-----------------------------------------------------------------------------------*/
/* Okay Recent Widgets
/*-----------------------------------------------------------------------------------*/

add_action( 'widgets_init', 'load_okat_recent_widgets' );

function load_okat_recent_widgets() {
	register_widget( 'okay_recent_widgets' );
}

class okay_recent_widgets extends WP_Widget {

	function okay_recent_widgets() {
	$widget_ops = array( 'classname' => 'ok-recent-posts', 'description' => __('Okay Recent Posts Widget', 'ok-recent-posts') );
	$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ok-recent-widgets' );
	$this->WP_Widget( 'ok-recent-widgets', __('Okay Recent Posts Widget', 'ok-recent-widgets'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {

		extract( $args );
		$recentcount= $instance['recentcount'];
		$recentcount= $instance['popularcount'];
		$recentcount= $instance['commentcount'];
		
		echo $before_widget;
?>
		
		<!-- Okay Recent Posts Widget -->
		<div class="okay-recent-posts">
			<ul class="tab-wrapper tabs">
				<li><a class="current" href="#"><i class="icon-file-alt"></i></a></li>
				<li><a class="" href="#"></span><i class="icon-heart"></i></a></li>
				<li><a class="" href="#"><i class="icon-comment"></i></a></li>
				<li><a class="" href="#"><i class="icon-tag"></i></a></li>
				
			</ul>
			
			<div class="clear"></div>
			
			<div class="panes">
				<!-- Recent Posts -->
				<div class="pane">
					<ul class="recent-posts-widget">
						<?php query_posts('showposts='.$instance["recentcount"]); ?>
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
							<li class="recent-posts">	
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p><a href="<?php the_permalink(); ?>/#comments" title="comments"><?php comments_number(__('No Comments','okay'),__('1 Comment','okay'),__( '% Comments','okay') );?></a></p>
							</li>
						<?php endwhile; ?>
						<?php endif; wp_reset_postdata(); ?>
					</ul>
				</div><!-- recent posts pane -->
				
				<!-- Popular Posts -->
				<div class="pane">
					<ul class="recent-posts-widget">
						<?php $popular = new WP_Query('orderby=comment_count&posts_per_page='.$instance["popularcount"]); ?>
						<?php while ($popular->have_posts()) : $popular->the_post(); ?>
							<li class="recent-posts">	
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php comments_number(__('No Comments','okay'),__('1 Comment','okay'),__( '% Comments','okay') );?></a></p>
							</li>
						<?php endwhile; ?>
					</ul>
				</div><!-- popular posts -->
				
				<!-- Recent Comments -->
				<div class="pane">
					<ul class="recent-posts-widget">
						<?php $comments = get_comments('status=approve&number='.$instance["commentcount"]); foreach($comments as $comm) :?>
						<?php
							$url = '<a href="'. get_permalink($comm->comment_post_ID).'#comment-'.$comm->comment_ID .'" title="'.$comm->comment_author .' | '.get_the_title($comm->comment_post_ID).'">' . $comm->comment_author . '</a>';
							
							$length = 100; // adjust to needed length
							$thiscomment = $comm->comment_content;
							if ( strlen($thiscomment) > $length ) {
								$thiscomment = substr($thiscomment,0,$length);
								$thiscomment = $thiscomment .' ...';
							}
						?>
						<li class="recent-posts">
							<h3><?php echo $url; ?></h3>
							<p class="recent-comment-text"><a href="<?php echo get_permalink($comm->comment_post_ID);?>#comment-<?php echo $comm->comment_ID ?>"><?php echo ($thiscomment);?></a></p>
						</li>
						<?php endforeach;?>
					</ul>
				</div><!-- recent comments -->
				
				<!-- Tag Cloud -->
				<div class="pane">
					<div class="tagcloud">
						<?php wp_tag_cloud('largest=18'); ?>
					</div>
					<div class="clear"></div>
				</div><!-- tags pane -->
			</div><!-- panes -->
		</div><!-- recent post widget -->
		
		<?php wp_reset_query(); ?>			

<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['recentcount'] = $new_instance['recentcount'];
		$instance['commentcount'] = $new_instance['commentcount'];	
		$instance['popularcount'] = $new_instance['popularcount'];		
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'recenttitle' => '', 'recentcount' => '', 'commentcount' => '', 'popularcount' => '') );				
		$instance['recentcount'] = $instance['recentcount'];
		$instance['commentcount'] = $instance['commentcount'];
		$instance['popularcount'] = $instance['popularcount'];
?>

			<!--
			<p>
				<label for="<?php echo $this->get_field_id('recentcat'); ?>"><?php _e('Recent Posts Category','okay'); ?></label>
				<?php 
				  wp_dropdown_categories( array(
				    'name' => $this->get_field_name( 'recentcat' ),
				    'selected' => $instance["recentcat"],
				    ) );
				
				?>
			</p>
            -->
			
			<p>
				<label for="<?php echo $this->get_field_id('recentcount'); ?>"><?php _e('Recent Posts Count','okay'); ?>: 
				<input class="widefat" id="<?php echo $this->get_field_id('recentcount'); ?>" name="<?php echo $this->get_field_name('recentcount'); ?>" type="text" value="<?php echo $instance['recentcount']; ?>" /></label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('popularcount'); ?>"><?php _e('Popular Posts Count','okay'); ?>: 
				<input class="widefat" id="<?php echo $this->get_field_id('popularcount'); ?>" name="<?php echo $this->get_field_name('popularcount'); ?>" type="text" value="<?php echo $instance['popularcount']; ?>" /></label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('commentcount'); ?>"><?php _e('Latest Comment Count','okay'); ?>: 
				<input class="widefat" id="<?php echo $this->get_field_id('commentcount'); ?>" name="<?php echo $this->get_field_name('commentcount'); ?>" type="text" value="<?php echo $instance['commentcount']; ?>" /></label>
			</p>
              
  <?php
	}
}
?>
