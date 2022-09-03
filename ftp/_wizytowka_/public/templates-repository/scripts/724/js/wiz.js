menuArr = [];
sectionArr = [];

function startPage(){
	menuArr=$('#menu a');
	sectionArr = $('section');
	for (i=0; i<sectionArr.length; i++){
		if (i==0){
			$(sectionArr[i]).css('display', 'block');
			$(sectionArr[i]).addClass('page-active');
			$(menuArr[i]).addClass('is-active')
		} else {
			$(sectionArr[i]).css('display', 'none')
		}
	}
}

function allInOne(){
	if( $(window).width()<=350 ){
		for (i=0; i<sectionArr.length; i++){
			$(sectionArr[i]).css('display', 'block')
		}
	} else {
		for (i=0; i<sectionArr.length; i++){
			if ($(sectionArr[i]).hasClass('page-active')){
				$(sectionArr[i]).css('display', 'block')
			} else {
				$(sectionArr[i]).css('display', 'none')
			}
		}
	}
}

function changePage(){
	$('#menu a').click(function(event){
		if( $(window).width()>350 ){
			event.preventDefault();
			if ( !($(this).hasClass('is-active')) ){
				pageLink = $(this).attr('href');
				for (i=0; i<sectionArr.length; i++){
					if ($(sectionArr[i]).hasClass('page-active')){
						$(sectionArr[i]).removeClass('page-active');
						$(sectionArr[i]).css('display', 'none');
						$(menuArr[i]).removeClass('is-active')
					}
					
					if ($(menuArr[i]).attr('href')==pageLink){
						$(menuArr[i]).addClass('is-active')
					}
					
					$(pageLink).css('display', 'block');
					$(pageLink).addClass('page-active')
					
				}
			}
			
		} else {
			event.preventDefault();
			pageLink = $(this).attr('href');
			pagePos = $(pageLink).offset().top;
			$("html, body").animate({ scrollTop: pagePos }, 500);
			for (i=0; i<sectionArr.length; i++){
				if ($(sectionArr[i]).hasClass('page-active')){
					$(sectionArr[i]).removeClass('page-active');
					$(menuArr[i]).removeClass('is-active')
				}
					
				if ($(menuArr[i]).attr('href')==pageLink){
					$(menuArr[i]).addClass('is-active')
				}
				
				$(pageLink).addClass('page-active')
			}
		}
		
		if ( $(window).width()<=640 ){
			$('#menu').slideToggle(200);
		}
	})
}

function absMen(){
	wW=$(window).width();
	if(wW<=640){
		headH = $('header').height();
		$('#menu').css({
			'top': headH,
		})
	} else {
		$('#menu').removeAttr('style')
	}
}

function openMobMen(){
	$("#burger").click(function(event){
		event.preventDefault();
		$('#menu').slideToggle(200);
	})
}

$(document).ready(function(){
	startPage();
	changePage();
	openMobMen();
	allInOne()
});

$(window).resize(function(){
	absMen();
	allInOne()
});

$(window).load(function(){
	absMen()
});