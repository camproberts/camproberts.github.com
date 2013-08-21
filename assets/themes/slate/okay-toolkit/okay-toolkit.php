<?php


/*
Plugin Name: Okay Toolkit
Plugin URI: http://okaythemes.com
Description: Various social widgets and elements for your WordPress site.
Version: 1.9
Author: Mike McAlister
Author URI: http://www.okaythemes.com
*/


// -------------- Setup action and filter hooks -------------- //
register_uninstall_hook(__FILE__, 'okaysocial_delete_plugin_options');
add_action('admin_init', 'okaysocial_init' );
add_action('admin_menu', 'okaysocial_add_options_page');


// -------------- Localization -------------- //
function okaysocial_load_textdomain() {
	load_plugin_textdomain( 'okay', false, dirname( plugin_basename( __FILE__ ) ) . '/includes/languages/' );
}
add_action('init', 'okaysocial_load_textdomain');

// -------------- Delete options upon deactivation and delete -------------- //
function okaysocial_delete_plugin_options() {
	delete_option('okaysocial_options');
}

// -------------- Register plugin options -------------- //
function okaysocial_init(){
	register_setting( 'okaysocial_plugin_options', 'okaysocial_options', 'okaysocial_validate_options' );
}

// -------------- Add menu page -------------- //
function okaysocial_add_options_page() {
	global $okaysocial_options;
	$okaysocial_options = add_options_page('Okay Toolkit Options', 'Okay Toolkit', 'manage_options', __FILE__, 'okaysocial_render_form');
}

// -------------- Enqueue admin scripts -------------- //
function okaysocial_load_admin_scripts($hook) {
	global $okaysocial_options;
	
	if( $hook != $okaysocial_options )
		return;
	
	//Register and enqueue custom admin scripts	
	wp_register_script('okaysocial_admin_js', plugin_dir_url(__FILE__) . 'includes/js/admin/okaysocial-admin.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('okaysocial_admin_js');

	//Register and enqueue custom admin stylesheet
	wp_register_style( 'okaysocial_admin_css', plugin_dir_url(__FILE__) . 'includes/css/admin-style.css', false, '1.0.0' );
	wp_enqueue_style( 'okaysocial_admin_css' );

}
add_action('admin_enqueue_scripts', 'okaysocial_load_admin_scripts');


// -------------- Enqueue front-end scripts and styles into footer -------------- //
function okaysocial_plugin_style() {
	$okaysocial_options = get_option('okaysocial_options');
	
	wp_register_style( 'okaysocial_style', plugin_dir_url(__FILE__) . 'includes/css/social-style.css', false, '1.0.0' );
	wp_enqueue_style( 'okaysocial_style' );
	
	if ($okaysocial_options['enable_icons'] == 'disabled') { } else {
		wp_register_style( 'okaysocial_icon_style', plugin_dir_url(__FILE__) . 'includes/css/social-icons.css', false, '1.0.0' );
		wp_enqueue_style( 'okaysocial_icon_style' );
	}
}
add_action('wp_footer', 'okaysocial_plugin_style');


// -------------- Load specific scripts into the header -------------- //
function okaysocial_header_js() {
	$okaysocial_options = get_option('okaysocial_options');
	
	//Load Twitter script if widget enabled
	if ($okaysocial_options['enable_twitter'] == 'disabled') { } else {
		wp_enqueue_script('chirp_js', plugin_dir_url( __FILE__ ) . 'includes/js/chirp/chirp.min.js');
	}
}
add_action('wp_enqueue_scripts', 'okaysocial_header_js');


// -------------- Build the options form -------------- //
function okaysocial_render_form() { ?>
	
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2><?php _e('Okay Toolkit Options','okay'); ?></h2>

		<form method="post" action="options.php">
			<?php settings_fields('okaysocial_plugin_options'); ?>
			<?php $okaysocial_options = get_option('okaysocial_options'); ?>

			<!-- Settings navigation -->
			<ul class="radar-nav">
				<li><a id="nav-general" href="#"><?php _e('Settings','okay'); ?></a></li>
				<li><a id="nav-help" href="#"><?php _e('FAQ','okay'); ?></a></li>
			</ul>
			
			<div class="radar-admin">
				<div id="radar-options">
					
					<!-- General Settings -->
					<div class="box visible">
						<p class="settings-intro"><?php _e('Enable widgets and change a few of the general settings.','okay'); ?></p>
						
						<!-- Activate Twitter -->
						<div class="setting">
							<strong><?php _e('Enable Twitter Widget','okay'); ?></strong>
							
							<div class="options">
								<select name='okaysocial_options[enable_twitter]'>
									<option value='disabled' <?php selected('disabled', $okaysocial_options['enable_twitter']); ?>><?php _e('Disable','okay'); ?></option>
									<option value='enabled' <?php selected('enabled', $okaysocial_options['enable_twitter']); ?>><?php _e('Enable','okay'); ?></option>
								</select>	
							</div>
						</div><!-- setting -->
						
						<!-- Activate Dribbble -->
						<div class="setting">
							<strong><?php _e('Enable Dribbble Widget','okay'); ?></strong>
							
							<div class="options">
								<select name='okaysocial_options[enable_dribbble]'>
									<option value='disabled' <?php selected('disabled', $okaysocial_options['enable_dribbble']); ?>><?php _e('Disable','okay'); ?></option>
									<option value='enabled' <?php selected('enabled', $okaysocial_options['enable_dribbble']); ?>><?php _e('Enable','okay'); ?></option>
								</select>	
							</div>
						</div><!-- setting -->
						
						<!-- Activate Flickr -->
						<div class="setting">
							<strong><?php _e('Enable Flickr Widget','okay'); ?></strong>
							
							<div class="options">
								<select name='okaysocial_options[enable_flickr]'>
									<option value='disabled' <?php selected('disabled', $okaysocial_options['enable_flickr']); ?>><?php _e('Disable','okay'); ?></option>
									<option value='enabled' <?php selected('enabled', $okaysocial_options['enable_flickr']); ?>><?php _e('Enable','okay'); ?></option>
								</select>	
							</div>
						</div><!-- setting -->
						
						<!-- Activate Icons -->
						<div class="setting">
							<strong><?php _e('Enable Social Icons','okay'); ?></strong>
							
							<div class="options">
								<select id="icons-toggle" name='okaysocial_options[enable_icons]'>
									<option value='disabled' <?php selected('disabled', $okaysocial_options['enable_icons']); ?>><?php _e('Disable','okay'); ?></option>
									<option value='enabled' <?php selected('enabled', $okaysocial_options['enable_icons']); ?>><?php _e('Enable','okay'); ?></option>
								</select>	
							</div>
						</div><!-- setting -->
						
						<div id="show_icons">
							<!-- Icon Shape -->
							<div class="setting">
								<strong><?php _e('Square or Round Icons','okay'); ?></strong>
								
								<div class="options">
									<select name='okaysocial_options[icon_shape]'>
										<option value='square' <?php selected('square', $okaysocial_options['icon_shape']); ?>><?php _e('Square','okay'); ?></option>
										<option value='round' <?php selected('round', $okaysocial_options['icon_shape']); ?>><?php _e('Round','okay'); ?></option>
									</select>	
								</div>
							</div><!-- setting -->

							<!-- Icon Size -->
							<div class="setting">
								<strong><?php _e('Icon Size','okay'); ?></strong>
								
								<div class="options">
									<select name='okaysocial_options[icon_size]'>
										<option value='normal' <?php selected('normal', $okaysocial_options['icon_size']); ?>><?php _e('Normal','okay'); ?></option>
										<option value='small' <?php selected('small', $okaysocial_options['icon_size']); ?>><?php _e('Small','okay'); ?></option>
										<option value='large' <?php selected('large', $okaysocial_options['icon_size']); ?>><?php _e('Large','okay'); ?></option>
									</select>	
								</div>
							</div><!-- setting -->
						</div><!-- show icons -->
					</div><!-- general settings -->
				
					<!-- Support Info -->
					<div class="box">
						<p class="settings-intro"><?php _e('A few resources to get you started with the Okay Toolkit.','okay'); ?></p>
						
						<div class="radar-help">
							<div class="setting">
								<h3><?php _e('What is this plugin and why do I need it?','okay'); ?></h3>
								<p><?php _e('The Okay Toolkit provides extra functionality to the collection of Okay Themes. The toolkit adds Twitter, Flickr, Dribbble and social icon widgets for you to use in your theme. The plugin is not a requirement to use Okay themes, but it will extend the themes to function as you see them in the demos.', 'okay'); ?></p>
							</div>
							
							<div class="setting">
								<h3><?php _e('Can I enable and disable individual widgets?','okay'); ?></h3>
								<p><?php _e('Yes, if you would like to deactivate certain widgets, you can do so in the Settings tab. Disabling a widget will also deactivate any scripts associated with the widget.', 'okay'); ?></p>
							</div>
							
							<div class="setting">
								<h3><?php _e('Why are the Portfolio and Gallery available in one of my Okay themes but not the other?','okay'); ?></h3>
								<p><?php _e('The Toolkit plugin only shows Portfolio and Gallery options for themes that support it. If your theme does not support either feature, their settings will not be shown.', 'okay'); ?></p>
							</div>
							
							<div class="setting">
								<h3><?php _e('I do not see the option to enable or disable the gallery or portfolio like in the theme install video.','okay'); ?></h3>
								<p><?php _e('As of version 1.7, you no longer have to manually enable or disable the portfolio items or gallery. If your theme supports them, they will be enabled automatically and available for use in your theme by default.', 'okay'); ?></p>
							</div>			

							<div class="setting">
								<h3><?php _e('Can I use this plugin with other themes?','okay'); ?></h3>
								<p><?php _e('The Okay Toolkit was developed to extend the functionality of Okay Themes, however some parts of the plugin, such as the widgets, may be used in other themes. Advanced features like the Portfolio and Gallery will only work with Okay Themes.', 'okay'); ?></p>
							</div>
							
							<div class="setting">
								<h3><?php _e('This plugin is pretty decent. Where can I find some more decent things by Okay Themes?','okay'); ?></h3>
								<p><?php _e('That&rsquo;s a great question! I sell nifty WordPress themes over at <a target="blank" href="http://okaythemes.com/" title="okay themes">Okay Themes</a> and <a target="blank" href="http://themeforest.net/user/mikemcalister/portfolio?ref=mikemcalister" title="okay themes on themeforest">ThemeForest</a>.', 'okay'); ?></p>
							</div>
						</div><!-- toolkit help -->
					</div><!-- Support -->
				</div><!-- toolkit options -->
			</div><!-- toolkit admin -->
			
			<div id="submit-options">
				<div class="restore">
				</div>
				
				<?php echo submit_button('Save Changes'); ?>
			</div>
		</form>
	</div><!-- wrap -->
	<?php	
}


// -------------- Sanitize output -------------- //
function okaysocial_validate_options($input) {
	return $input;
}


// -------------- Include Social Widgets -------------- //
$okaysocial_options = get_option('okaysocial_options');

// Twitter
if ( isset($okaysocial_options['enable_twitter']) && $okaysocial_options['enable_twitter'] == 'enabled') {
	include_once 'includes/widgets/twitter/twitter.php';
}

// Dribbble
if ( isset($okaysocial_options['enable_dribbble']) && $okaysocial_options['enable_dribbble'] == 'enabled') {
	include_once 'includes/widgets/dribbble/dribbble.php';
}

// Flickr
if ( isset($okaysocial_options['enable_flickr']) && $okaysocial_options['enable_flickr'] == 'enabled') {
	include_once 'includes/widgets/flickr/flickr.php';
}

// Icons
if ( isset($okaysocial_options['enable_icons']) && $okaysocial_options['enable_icons'] == 'enabled') {
	include_once 'includes/widgets/icons/icons.php';
}


// -------------- Register Portfolio Post Type -------------- //
add_action( 'init', 'okay_themes_create_portfolio_post_type' );
function okay_themes_create_portfolio_post_type() {

	global $okaysocial_options;

	if ( ( current_theme_supports('okay_themes_portfolio_support') ) ) {
		register_post_type( 'okay-portfolio',
			array(
				'labels' => array(
					'name' => __( 'Portfolio Items' ),
					'singular_name' => __( 'Portfolio' )
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'portfolio-item'),
				'supports' => array('title','editor','author','thumbnail','excerpt','category','custom-fields','post-formats'),
			)
		);	
	}
}


// -------------- Register Portfolio Taxonomy -------------- //

add_action( 'init', 'build_taxonomies', 0 );

function build_taxonomies() {
    register_taxonomy( 'categories', 'okay-portfolio', 
    	array(
    		'hierarchical' => true,
    		'label' => 'Categories',
    		'query_var' => true,
    		'rewrite' => true
    	) 
    );
}


// -------------- Register Slider Post Type -------------- //
add_action( 'init', 'okay_themes_create_slider_post_type' );
function okay_themes_create_slider_post_type() {

	global $okaysocial_options;

	if ( current_theme_supports('okay_themes_slider_support') ) {
		register_post_type( 'okay-slider',
			array(
				'labels' => array(
					'name' => __( 'Slider Items' ),
					'singular_name' => __( 'Slide' )
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'ok-slide'),
				'supports' => array('title','editor','thumbnail','excerpt','custom-fields'),
			)
		);
	}
}


// -------------- Custom Image Gallery -------------- //
add_action( 'init', 'okay_themes_create_gallery' );
function okay_themes_create_gallery() {

	global $okaysocial_options;

	if ( current_theme_supports('okay_themes_gallery_support') ) {
		include_once 'includes/gallery/gallery.php';
	}
}



// -------------- Initialize Metabox Class -------------- //
add_action( 'init', 'be_initialize_cmb_meta_boxes', 9999 );
function be_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) && ( current_theme_supports('okay_themes_metabox_support') ) ) {
		require_once( 'includes/lib/metabox/init.php' );
	}
}