$(document).ready(function() {


	$("#sticky_navigation").find("a").click(function(e) {
		var offsetScroll = -120; //Offset of 20px
		e.preventDefault();
		var section = $(this).attr("href");
		$("html, body").animate({
			scrollTop: $(section).offset().top + offsetScroll
		},1000);
	});
	
	
	$('a.allLink').click(function(e){
        var offsetScroll = -120; //Offset of 20px
        e.preventDefault();
		var section = $(this).attr("href");
		$("html, body").animate({
			scrollTop: $(section).offset().top + offsetScroll
		},1000);
	});
	
	
	// grab the initial top offset of the navigation 
	var sticky_navigation_offset_top = $('#sticky_navigation').offset().top;
	
	// our function that decides weather the navigation bar should have "fixed" css position or not.
	var sticky_navigation = function(){
		var scroll_top = $(window).scrollTop(); // our current vertical position from the top
		
		// if we've scrolled more than the navigation, change its position to fixed to stick to top, otherwise change it back to relative
		if (scroll_top > sticky_navigation_offset_top) { 
			// $('#sticky_navigation').css({ 'position': 'fixed', 'top':0 });
			$('#sticky_navigation').addClass('fixed');
		} else {
			//$('#sticky_navigation').css({ 'position': 'relative' }); 
			$('#sticky_navigation').removeClass('fixed'); 
		}   
	};
	
	// run our function on load
	// sticky_navigation();
	
	// and run it again every time you scroll
	


	function onresize() {

	    var w = $('.row').width();

	    if (w > 700) {

	        $(window).scroll(function () {
	            sticky_navigation();
	        }); 

	    }
	    else {
		
	    }
	}


	$(window).load(onresize);

	$(window).resize(onresize);



	
	
});

$(window).load(function(){
	minh = $($('.blueContent')[0]).height() +50;
	$($('.blueContent')[0]).css('min-height', minh);
});
