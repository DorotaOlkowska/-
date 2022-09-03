$(document).ready(function() {
	
    $('.fancybox').fancybox({
		'transitionIn'	:	'fade',
		'transitionOut'	:	'fade',
		'speedIn'		:	400, 
		'speedOut'		:	400, 
		'autoScale'     :  'true',
        'changeFade'    : 'fast',
        'hideOnOverlayClick' : 	false,
        'overlayOpacity' : 1,

		onStart: function() {
			$('.large-12.columns.steel').addClass('blur'); 
		},

		onClosed: function() {
			$('.large-12.columns.steel').removeClass('blur');
            if( $(this.orig.context).attr('data-show-success') ) {
                location.reload();
                return false;
            }
		}

	});

    $( window ).resize(function() {
        if($(document).height() > $('body').height()) {
            $('#bottom_line').css({'position' : 'fixed'});
        } else {
            $('#bottom_line').css({'position' : 'absolute'});
        }
    });

    $( window ).resize();
});