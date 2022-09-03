/* Shrinking menu */

$(document).ready(function() {
    $(window).scroll(function() {
        if ($(document).scrollTop() > 150) {
            $('nav').addClass('shrink');
        } else {
            $('nav').removeClass('shrink');
        }
    });
});




/* Magellan fix */

$('#main-menu li:last').click(function() {
    $offset = $(window).height() - $('body > .section:last').outerHeight() - $('footer').outerHeight();
    $(document).foundation({"magellan-expedition": { destination_threshold: $offset }});
});
$(window).scroll(function() {
    var scrollHeight = $(document).height();
	var scrollPosition = $(window).height() + $(window).scrollTop();
	if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
       $offset = $(window).height() - $('body > .section:last').outerHeight() - $('footer').outerHeight();
       console.log($offset);
       $(document).foundation({"magellan-expedition": { destination_threshold: $offset }});
   }
});
$('#main-menu li:not(:last), #main-menu li:not(.offer)').click(function() {
    $(document).foundation({"magellan-expedition": { destination_threshold: 30 }});
});
var lastScrollTop = 0;
$(window).on('scroll', function() {
    st = $(this).scrollTop();
    if(st < lastScrollTop) {
        $(document).foundation({"magellan-expedition": { destination_threshold: 30 }});
    }
    lastScrollTop = st;
});
$('#main-menu li.offer').click(function() {
    $(document).foundation({"magellan-expedition": { destination_threshold: -65 }});
});


/* Parallax */

if($(window).width() > 1024) {
    $window = $(window);
    $('div[data-type="background"]').each(function(){
        var $bgobj = $(this);
        $(window).scroll(function() {
            var yPos = -($window.scrollTop() / $bgobj.data('speed')); 
            var coords = '50% '+ yPos + 'px';
            $bgobj.css({ backgroundPosition: coords });
        });
    });
}


if(window.name == "templateFrame") {

    $(document).ready(function() {
        $('#main-menu li a, .chevron-down a').click(function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $($(this).attr("href")).offset().top
            }, 500);
        });
    });

}

