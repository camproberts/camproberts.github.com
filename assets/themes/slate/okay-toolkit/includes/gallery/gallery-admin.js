 jQuery(document).ready(function( $ ) { 
 	function checkPostFormat() {
	  if($('#post-format-gallery').is(":checked")) {
	     $('#okay_gallery_meta_box').css('display', 'block');
	  } else {
	  	$('#okay_gallery_meta_box').css('display', 'none');
	  }
	}
	checkPostFormat();
  $(".post-format").change(function () {
		checkPostFormat();
	});
	if ($(".okay-gallery-thumbs").html()){
		$("#okay-gallery-button").html("Edit Gallery").removeClass('button-primary');
	}	else {
		$("#okay-gallery-button").html("Add Gallery").addClass('button-primary');
	}	
});    
