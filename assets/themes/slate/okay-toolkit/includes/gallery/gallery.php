<?php

// -------------- Enque Admin Scripts -------------- //

function okay_admin_head($hook) {
  	global $post;

	if( $hook != 'edit.php' && $hook != 'post.php' && $hook != 'post-new.php' )
		return;
	// add js vars
		echo '<script type="text/javascript">
		var okay_ajax = {
			post_id : 0,
			nonce : ""
		};
		okay_ajax.nonce = "' . wp_create_nonce( 'okay-ajax' ) . '";
		okay_ajax.post_id = "' . $post->ID . '";

		</script>';
	wp_enqueue_script( 'okay-admin', plugin_dir_url(__FILE__) . '/gallery-admin.js', array( 'jquery' ), true );	
	wp_enqueue_style( 'gallery-admin-styles', plugin_dir_url(__FILE__) . "/okay-gallery.css", array(), '0.1', 'screen' );
}
add_action('admin_enqueue_scripts', 'okay_admin_head');



// -------------- Add Custom Meta Box -------------- //

function add_gallery_meta_box() {
    
	$screens = array( 'post', 'okay-portfolio' );
    foreach ($screens as $screen) {
        add_meta_box(
            'okay_gallery_meta_box', // $id
	        'Okay Gallery', // $title
	        'show_gallery_meta_box', // $callback
	        $screen, // $page    
	        'normal', // $context
	        'high'); // $priority       
    }

}
add_action('add_meta_boxes', 'add_gallery_meta_box');

function show_gallery_meta_box() {

	global $post;

   	$meta = get_post_meta($post->ID, '_gallery_image_ids', true); ?>

	<p>
		<a href="#" class="button button-primary button-large" id="okay-gallery-button">Add Gallery</a>
		<input type="hidden" name="<?php echo $post->ID; ?>_gallery_image_ids" id="gallery_image_ids" value="<?php echo $meta; ?>" />
	</p>
	<div class="okay-gallery-thumbs">
		<?php 
			
	   // update thumbs
	   $thumbs = explode(',', $meta);
	   $thumbs_output = '';
	   if ($thumbs[0] != '' ) {
	   foreach( $thumbs as $thumb ) {
	       $thumbs_output .= '<li>' . wp_get_attachment_image( $thumb, array(32,32) ) . '</li>';
	   }
	 	}
	   echo $thumbs_output; 
	 
	   ?>
	</div>  
	<script>
		jQuery(document).ready(function($) {

				function loadImages(images) {
		   if( images ){

		       var shortcode = new wp.shortcode({
		           tag:    "gallery",
		           attrs:   { ids: images },
		           type:   "single"
		       });
		       var attachments = wp.media.gallery.attachments( shortcode );
		       var selection = new wp.media.model.Selection( attachments.models, {
		           props:    attachments.props.toJSON(),
		           multiple: true
		       });
		       selection.gallery = attachments.gallery;
		       // Fetch the query"s attachments, and then break ties from the
		       // query to allow for sorting.
		       selection.more().done( function() {
		           // Break ties with the query.
		           selection.props.set({ query: false });
		           selection.unmirror();
		           selection.props.unset("orderby");
		       });

		       return selection;
		   }

		   return false;
			}
			selection = loadImages(<?php echo json_encode($meta); ?>);
					$('#okay-gallery-button').on('click', function() {
			   	 	var button = $(this);
			   	 	id = $('#gallery_image_ids');

						options =
						{
								frame:     'post',
								state:     'gallery-edit',
								title:     wp.media.view.l10n.editGalleryTitle,
								editing:   true,
								multiple:  true,
								selection: selection
						}
						frame = wp.media(options).open();

			     // Tweak views
			     frame.menu.get('view').unset('cancel');
			     frame.menu.get('view').unset('separateCancel');
			     frame.menu.get('view').get('gallery-edit').el.innerHTML = 'Edit Featured Gallery';
			     frame.content.get('view').sidebar.unset('gallery'); // Hide Gallery Settings in sidebar

						// Override insert button
						function overrideGalleryInsert() {
						   frame.toolbar.get('view').set({
						       insert: {
						           style: 'primary',
						           text: 'Save Featured Gallery',
						           click: function() {
						               var models = frame.state().get('library'),
						                   ids = '';
						               models.each( function( attachment ) {
						                   ids += attachment.id + ','
						               });
						               this.el.innerHTML = 'Saving...';

						               $.ajax({
						                   type: 'POST',
						                   url: ajaxurl,
						                   data: {
						                       ids: ids,
						                       action: 'okay_save_custom_gallery_meta',
						                       post_id: okay_ajax.post_id,
						                       nonce: okay_ajax.nonce
						                   },
						                   success: function(){
						                   			selection = loadImages(ids);
						                       $(id).val( ids );
						                       frame.close();
						                   },
						                   dataType: 'html'
						               }).done( function( data ) {
			                   $('.okay-gallery-thumbs').html( data );
			                   if ($(".okay-gallery-thumbs").html()) {
														$("#okay-gallery-button").html("Edit Gallery").removeClass('button-primary');
														}	else {
															$("#okay-gallery-button").html("Add Gallery").addClass('button-primary');
														}
			               		});
						           }
						       }

						   });
						}
						overrideGalleryInsert();

				     frame.on( 'toolbar:render:gallery-edit', function() {
				         overrideGalleryInsert();
				     });
					});
			});

	</script>
	<?php
}


 
// -------------- Save the Meta Fields on Save of the Post -------------- //

function okay_save_custom_gallery_meta() {
	// verify nonce
	if ( !isset($_POST['ids']) || !isset($_POST['nonce']) || !wp_verify_nonce( $_POST['nonce'], 'okay-ajax' ) )
	return;
	
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	$post_id = absint( $_POST['post_id'] );
	$ids = strip_tags(rtrim($_POST['ids'], ','));
	update_post_meta($post_id, '_gallery_image_ids', $ids);
	
	// update thumbs
	$thumbs = explode(',', $ids);
	$thumbs_output = '';
	if ($thumbs[0] != '' ) {
		foreach( $thumbs as $thumb ) {
		   $thumbs_output .= '<li>' . wp_get_attachment_image( $thumb, array(32,32) ) . '</li>';
		}
	}
   echo $thumbs_output;
   die();
}
add_action('wp_ajax_okay_save_custom_gallery_meta', 'okay_save_custom_gallery_meta');
add_action('wp_ajax_nopriv_okay_save_custom_gallery_meta', 'okay_save_custom_gallery_meta');


// -------------- Display gallery -------------- //

function okay_gallery() {
	global $post, $wp_version;

	if ( version_compare( $wp_version, '3.5', '>=' ) ) {
	$image_ids = get_post_meta($post->ID, '_gallery_image_ids', false);
	$image_ids_array = $image_ids[0] . ",";
	$images = explode(',', $image_ids_array, -1);

	} else {
		//find images in the content with "wp-image-{n}" in the class name
		preg_match_all('/<img[^>]?class=["|\'][^"]*wp-image-([0-9]*)[^"]*["|\'][^>]*>/i', get_the_content(), $result);  
		
		$exclude_imgs = $result[1];

		//exclude thumbnail from slider
		if ( get_post_meta($post->ID, 'thumbnail', true ) == 'exclude' ) {
			$feat_img = get_post_thumbnail_id( $post_id );
			$exclude_imgs[] = $feat_img;
		}

		$args = array(
			'order'          => 'ASC',
			'orderby'        => 'date',
			'post_type'      => 'attachment',
			'post_parent'    => $post->ID,
			'exclude'		 => $exclude_imgs,
			'post_mime_type' => 'image',
			'post_status'    => null,
			'numberposts'    => -1,
			'fields'		 => 'ids'
		);
		
		$images = get_posts($args);
	}

	if ($images) {
		
		echo "<div class='gallery-wrap'><div class='flexslider'><ul class='slides'>";
			foreach ($images as $image) {
				if ( is_single() ) {
				echo "<li> <a href='". wp_get_attachment_url($image) ."'>";
				} else {
				echo "<li> <a href='". get_permalink($post->ID) ."'>";
				}	
				echo wp_get_attachment_image($image, 'large-image', false, false);
				echo "</a></li>";
			}
		echo "</ul></div></div>"; 
	}
}