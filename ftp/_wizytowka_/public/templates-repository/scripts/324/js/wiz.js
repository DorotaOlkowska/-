sectionsArr = [];
navLiArr = [];
navMobLiArr = [];

function readySec(){
	sectionsArr = $('.section-content');
	navLiArr = $('.navigation a');
	navMobLiArr = $('#mobile-navigation .link-to-page');
	$(sectionsArr[0]).css('display', 'block');
}

function changePage(){
	$('.link-to-page').click(function(event){
		event.preventDefault();
		if (!($(this).hasClass('active-page'))){
			
			page = $(this).attr('href');
			for (i=0; i<sectionsArr.length; i++){
				if ($(sectionsArr[i]).hasClass('visible')){
					$(sectionsArr[i]).removeClass('visible');
					$(sectionsArr[i]).css('display', 'none');
				}
				
				if ($(navLiArr[i]).hasClass('active-page')){
					$(navLiArr[i]).removeClass('active-page');
					$(navMobLiArr[i]).removeClass('active-page')
				}
				
				if ($(navMobLiArr[i]).removeClass('active-page')){
					$(navMobLiArr[i]).removeClass('active-page')
				}

			}
			
			$(page).addClass('visible');
			$(page).css('display', 'block');
			
			for (i=0; i<sectionsArr.length; i++){
				if( $(navLiArr[i]).attr('href') == page){
					$(navLiArr[i]).addClass('active-page');
					$(navMobLiArr[i]).addClass('active-page')
				}
			}
            if (typeof mapa1 != 'undefined') {
                var center = mapa1.getCenter();
                google.maps.event.trigger(mapa1, "resize");
                mapa1.setCenter(center);
            }
		}
		
		if( $(window).width()<=648 ){
			mobHeadH = 60;
			$('#mobile-navigation').animate({
				'height': mobHeadH
			},300, function(){$('#mobile-navigation .burger').removeClass('is-visible')})
		}
		
	})
}
function openMobile(){
	$('#mobile-navigation .burger').click(function(event){
		console.log('klika');
		event.preventDefault();
		
		mobNavH = $('#mobile-navigation .menu-list').height();
		mobHeadH = 60;
		
		if($(this).hasClass('is-visible')){
			$('#mobile-navigation').animate({
				'height': mobHeadH
			},300, function(){$('#mobile-navigation .burger').removeClass('is-visible')})
		} else {
			$('#mobile-navigation').animate({
				'height': mobHeadH+mobNavH
			},300, function(){$('#mobile-navigation .burger').addClass('is-visible')})
		}
	})
}

$(document).ready(function(){
	readySec();
	changePage();
	openMobile();
});