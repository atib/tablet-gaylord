$(document).ready(function(){
	var pull 		= $('#pull');
	var push_up = $("#push_up");
	menu 		= $('.ordermenu .ordermenu_list');
	menuHeight	= menu.height();

$(pull).on('click', function(e) {
	e.preventDefault();
	menu.slideToggle();
});

$(push_up).on('click', function(e) {
	e.preventDefault();
	menu.slideToggle();
});

$(window).resize(function(){
		var w = $(window).width();
		if(w > 320 && menu.is(':hidden')) {
			menu.removeAttr('style');
		}
	});

	$('.prodAdd a').click(function(){  			
	$('#flash').show().delay(2000).fadeOut('slow');
	});

	$('#add_prod').click(function(){  			
	$('#flash').show().delay(2000).fadeOut(500);
	});

	$('#dec_prod').click(function(){  			
	$('#flash_dec').show().delay(2000).fadeOut(500);
	});

	$('#del_prod').click(function(){  			
	$('#flash_rem').show().delay(2000).fadeOut(500);
	});
});