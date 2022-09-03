$(document).ready(function () { 

	$('#nav').onePageNav({
		changeHash: false
	}); // onePage



    function hideAllMenu() {
     //   $('#trigger-overlay').hide(350);
        $('#nav').hide(200);
    }

    function showAllMenu() {
      //  $('#trigger-overlay').show(550);
        $('#nav').show(200);
    }


    $('#trigger-overlay').on('click', function () {
        hideAllMenu();
    });

    $('.overlay-close').on('click', function () {
        showAllMenu();
    });


    $('.overlay-contentscale ul li a').on('click', function (e) {
		e.preventDefault();
		$(window).scrollTop($($(this).attr("href")).offset().top);
		$('.overlay-contentscale').removeClass('open');
        showAllMenu();
    });

	$('a.allLink').on('click', function (e) {
		e.preventDefault();
		$(window).scrollTop($($(this).attr("href")).offset().top);
	});
	
	
	function reloadMap() {
		$(".linkToSection.map").bind("click", function () {
            setTimeout(function () {
                var center = mapa1.getCenter();
                google.maps.event.trigger(mapa1, "resize");
                mapa1.setCenter(center);
            }, 200);
        });
	}
	
	
	function openMobile(){
	
		$('#mobile-navigation .burger').click(function(event){
			event.preventDefault();
			
			mobNavH = $('#mobile-navigation .menu-list').height();
			mobHeadH = 60;
			
			$('#mobile-navigation ul.menuHeader a.linkToSection').on('click', function() {
					$('#mobile-navigation').animate({
						'height': mobHeadH
					},300, function(){$('#mobile-navigation .burger').removeClass('is-visible')});
			});
			
			
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
	
	
	openMobile();
	
	

}); 

