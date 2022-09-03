function goToPage(){
	menulis = $('#my-menu a span');
	$('.link-pos').click(function(event){
		event.preventDefault();
		pageLink = $(this).attr('href');
		if ($(window).width()>=700) {
			secArr = $('.blockContent');
			for (i=0; i<secArr.length; i++){
				$(secArr[i]).css('display', 'none');
				$(menulis[i]).removeAttr('style')
			}
			
			$(pageLink).css('display', 'block');
			$(this).find('span').css('font-weight', 'bold');
		} else {
			pagePos = $(pageLink).offset().top;
			$('body, html').animate({scrollTop: pagePos})
		}
		
	})
}

menBottom = 0;

function checkOffset(){
	positionmen = $('.empty-men-div').offset().top;
	menBottom = positionmen;
}

function flyingMenu(){
	windowPos = $(window).scrollTop();
	
	if ($(window).width()>648 && windowPos>menBottom){
		$('#my-menu').css({
			'position': 'fixed',
			'top': 0,
			'left': 0,
			'width': '100%',
			'background': 'rgba(0, 0, 0, 0.55)',
			'z-index': 9999,
			'border-bottom': '1px solid rgba(43, 123, 37, 0.3)' 
		});
		if ( !($('#my-menu').hasClass('animate-complete')) ){
			$('#my-menu').addClass('animate-complete')
		}
	} else {
		$('#my-menu').removeAttr('style');
		$('#my-menu .link-pos img').removeAttr('style');
		$('#my-menu').removeClass('animate-complete')
	}
}



/* funkcja sprawdza szerwoko�� strony */
function onresize (){
		
	var w = $('.row').width();

	if(w < 700) {
			
	$('img.all.mobile').show();   
	$('img.all.big').hide();
				
	$('.contDaneFirm').show();
	$('.contKorespond').show();
	$('.contLokali').show();
	$('.contFormula').show();
				
}
	else {
			
	$('img.all.mobile').hide();   
	$('img.all.big').show();   
				
	$('.contDaneFirm').hide();
	$('.contKorespond').hide();
	$('.contLokali').hide();
	$('.contFormula').hide();
				
	} 
}
		


$(document).ready(function() {
	goToPage();
	checkOffset();
	
	onresize()
});

$(window).resize(function(){
	console.log($(window).width());
	checkOffset();
	flyingMenu();
	
	onresize()
});

$(window).scroll(function(){
	flyingMenu()
});













