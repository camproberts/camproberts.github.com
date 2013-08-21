jQuery(document).ready(function( $ ) { 
		
	//Tabs
	$('.radar-nav li:first').addClass('current');
	
	$('ul.radar-nav').each(function() {
		$(this).find('li').each(function(i) {
			$(this).click(function(){
				$(this).addClass('current').siblings().removeClass('current')
				.parents('#wpbody').find('div.box').hide().end().find('div.box:eq('+i+')').fadeIn(150);
			});
		});
	});
	
	
	//Icon Option Toggle
	$('#icons-toggle').change(function() {
		
		if ($('#icons-toggle option:selected').val() == 'enabled') {
			$('#show_icons').show();
		} else {
			$('#show_icons').hide();
		}  
	});
	
	if ($('#icons-toggle option:selected').val() == 'disabled') {
		$('#show_icons').hide();
	}
	
});