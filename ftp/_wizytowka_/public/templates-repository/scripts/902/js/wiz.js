$(function() {


    function changeSection() {

        var linkMenu = $('a.linkToSection');

        $(linkMenu).on('click', function (event) {
            event.preventDefault();

            var link = $(this).attr('data-link');

            var menuLeft = $('ul.menuHeader a');
            menuLeft.each(function () {
                if ($(this).attr('data-link') == link) {
                    menuLeft.removeClass('current');
                    $(this).addClass('current');
                }
            });

            var section = $('section');

            section.each(function () {
			
				var obecna = $(this).attr('data-target');
			
				if( $(window).width()<=768 && $(this).attr('data-target') == link){
					section.removeClass('active');
					
					$(this).addClass('active');
				}
			
                else if ($(this).attr('data-target') == link) {
				
					/* animacja sekcji */
					
					/* section.removeClass('active'); */
					
					section.fadeOut(900).removeClass('active');
					
					$(this).fadeIn(100).css({"right":"2000px"}).animate({"right": "0px"}, 500, 'linear').addClass('active');
				}
            });
        });
    }
	
	
	function openMobile(){
	
		$('#mobile-navigation .burger').click(function(event){
			event.preventDefault();
			
			mobNavH = $('#mobile-navigation .menu-list').height();
			mobHeadH = 40;
			
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

    changeSection();

});