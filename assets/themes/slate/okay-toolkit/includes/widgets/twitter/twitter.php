<?php
/*
 * Plugin Name: Paulund Display Latest Tweets
 * Plugin URI: http://www.paulund.co.uk
 * Description: A widget that displays your latest tweets
 * Version: 1.0
 * Author: Paul Underwood
 * Author URI: http://www.paulund.co.uk
 * License: GPL2
    Copyright 2012  Paul Underwood
    This program is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License,
    version 2, as published by the Free Software Foundation.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/
/**
 * Register the Widget
 */
add_action( 'widgets_init', create_function( '', 'register_widget("pu_tweet_widget");' ) );
/**
 * Create the widget class and extend from the WP_Widget
 */
 class pu_tweet_widget extends WP_Widget {
	private $twitter_title = "My Tweets";
	private $twitter_username = "mikemcalister";
	private $twitter_postcount = "5";
	private $twitter_follow_text = "Follow Me On Twitter";
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'pu_tweet_widget',		// Base ID
			'Okay Twitter Widget',		// Name
			array(
				'classname'		=>	'pu_tweet_widget',
				'description'	=>	__('A widget that displays your latest tweets.', 'okay')
			)
		);
		// Load JavaScript and stylesheets
		$this->register_scripts_and_styles();
	} // end constructor
	/**
	 * Registers and enqueues stylesheets for the administration panel and the
	 * public facing site.
	 */
	public function register_scripts_and_styles() {
	} // end register_scripts_and_styles
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		/* Our variables from the widget settings. */
		$this->twitter_title = apply_filters('widget_title', $instance['title'] );
		$this->twitter_username = $instance['username'];
		$this->twitter_postcount = $instance['postcount'];
		$this->twitter_follow_text = $instance['tweettext'];
		$transName = 'list_tweets';
	    $cacheTime = 20;
	    if(false === ($twitterData = get_transient($transName) ) ){
	    	require_once 'twitteroauth/twitteroauth.php';
			$twitterConnection = new TwitterOAuth(
								'NgoY33NpMVXGagRwgtZWw',	// Consumer Key
								'NHZr8SWVBhwEXzi3eTOawql7x8SV9zU8NlG5YfnY',   	// Consumer secret
								'21642655-N9ejLZnpu4ktJhZP5nruRb0eAmSHTspSbGr91F6Io',       // Access token
								'hI0HVfFPuC02DqKF3qPonJw5HiyWww0Hgpt2JjjWAEw'    	// Access token secret
								);
			$twitterData = $twitterConnection->get(
					  'statuses/user_timeline',
					  array(
					    'screen_name' => $this->twitter_username,
						'count' => $this->twitter_post_count,
					    'exclude_replies' => false
					  )
					);
			if($twitterConnection->http_code != 200)
			{
				$twitterData = get_transient($transName);
			}
	        // Save our new transient.
	        set_transient($transName, $twitterData, 60 * $cacheTime);
	    }
		/* Before widget (defined by themes). */
		echo $before_widget;
		?>
<div class="twitter_box"><?php
		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $this->twitter_title )
			echo $before_title . $this->twitter_title . $after_title;
		/* Display Latest Tweets */
		 ?>
			
			
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            <?php
            	if(!empty($twitterData) || !isset($twitterData['error'])){
            		$i=0;
					$hyperlinks = true;
					$encode_utf8 = true;
					$twitter_users = true;
					$update = true;
					echo '
<ul class="chirp">';
		            foreach($twitterData as $item){
		                    $msg = $item->text;
		                    $permalink = 'http://twitter.com/#!/'. $this->twitter_username .'/status/'. $item->id_str;
		                    if($encode_utf8) $msg = utf8_encode($msg);
                                    $msg = $this->encode_tweet($msg);
		                    $link = $permalink;
		                     echo '
<li class="twitter-item">';
		                      if ($hyperlinks) {    $msg = $this->hyperlinks($msg); }
		                      if ($twitter_users)  { $msg = $this->twitter_users($msg); }
		                      echo $msg;
		                    if($update) {
		                      $time = strtotime($item->created_at);
		                      if ( ( abs( time() - $time) ) < 86400 )
		                        $h_time = sprintf( __('%s ago'), human_time_diff( $time ) );
		                      else
		                        $h_time = date(__('Y/m/d'), $time);
		                      echo sprintf( __('%s', 'twitter-for-wordpress'),' <span class="twitter-timestamp"><abbr title="' . date(__('Y/m/d H:i:s'), $time) . '">' . $h_time . '</abbr></span>' );
		                     }
		                    echo '</li>
';
		                    $i++;
		                    if ( $i >= $this->twitter_postcount ) break;
		            }
					echo '</ul>
';
            	}
            ?>
       		</div>
       		<a class="chirp-follow-text" href="https://twitter.com/<?php echo $this->twitter_username; ?>"><?php _e('Follow','okay'); ?> @<?php echo $this->twitter_username; ?></a>
		<?php
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		// Strip tags to remove HTML (important for text inputs)
		foreach($new_instance as $k => $v){
			$instance[$k] = strip_tags($v);
		}
		return $instance;
	}
	/**
	 * Create the form for the Widget admin
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults = array(
		'title' => $this->twitter_title,
		'username' => $this->twitter_username,
		'postcount' => $this->twitter_postcount,
		'tweettext' => $this->twitter_follow_text,
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<!-- Widget Title: Text Input -->

			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'okay') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		
		<!-- Username: Text Input -->

			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e('Twitter Username', 'okay') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" />
		
		<!-- Postcount: Text Input -->

			<label for="<?php echo $this->get_field_id( 'postcount' ); ?>"><?php _e('Number of tweets (max 10)', 'okay') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'postcount' ); ?>" name="<?php echo $this->get_field_name( 'postcount' ); ?>" value="<?php echo $instance['postcount']; ?>" />
		
		
		
	<?php
	}
	/**
	 * Find links and create the hyperlinks
	 */
	private function hyperlinks($text) {
	    $text = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\">$1</a>", $text);
	    $text = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $text);
	    // match name@address
	    $text = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i","<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $text);
	        //mach #trendingtopics. Props to Michael Voigt
	    $text = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $text);
	    return $text;
	}
	/**
	 * Find twitter usernames and link to them
	 */
	private function twitter_users($text) {
	       $text = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\">@$2</a>$3 ", $text);
	       return $text;
	}
        /**
         * Encode single quotes in your tweets
         */
        private function encode_tweet($text) {
                $text = mb_convert_encoding( $text, "HTML-ENTITIES", "UTF-8");
                return $text;
        }
 }
?>