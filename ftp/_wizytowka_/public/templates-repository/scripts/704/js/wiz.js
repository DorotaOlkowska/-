function clickClick(){
	someClickEv = debounce(function(){
		var currentElement = $(this);

        $('.step .headerSlider').removeClass('active');

        $(currentElement).addClass('active');
	
		var arrowSpan = $(this).find('span.arrowSpan');
        var myelement = $(this).next('.contentSlider');

        $(myelement).toggle("slow", function() {

            if ($(this).css('display') == 'none') {
                $(currentElement).removeClass('active');
            }
            
		});
		
		
        var w = $('.row').width();
        if (w < 980) {
            $(".contentSlider:visible").not(myelement).animate({ height: 'toggle' });				/*.hide(); */
        }
        else {
            $(".contentSlider:visible").not(myelement).animate({ width: 'toggle' });				/*.hide(); */
        }
	}, 600, 1);
	
	$(".step .headerSlider").click(someClickEv);
}

function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		var later = function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};
}
$(document).ready(function() {
	
	clickClick();

    $('.slider .contentSlider').hide(); 
	
	$('.slider .slide1').next('.contentSlider').show(); 
	$('.slider .headerSlider.slide1').addClass('active');

});