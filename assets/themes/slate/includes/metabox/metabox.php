<?php

function be_sample_metaboxes( $meta_boxes ) {
	$prefix = '_cmb_'; // Prefix for all fields
	$meta_boxes[] = array(
		'id' => 'slide_link',
		'title' => 'Slide Link',
		'pages' => array('okay-slider'), // post type
		'context' => 'normal',
		'priority' => 'high',
		//'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Slide Link',
				'desc' => 'Where would you like your slide to link to?',
				'id' => $prefix . 'slide_link',
				'type' => 'text'
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'be_sample_metaboxes' );