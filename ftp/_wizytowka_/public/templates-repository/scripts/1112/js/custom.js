/* Menu */

$('#menu-trigger').click(function() {
    $('#menu').toggleClass('open');
});
$('#menu-wrapper').click(function() {
    $('#menu').removeClass('open');
});


/* Magellan fix */

$('#menu-wrapper li:last').click(function() {
    $offset = $(window).height() - $('body > .section:last').outerHeight();
    $(document).foundation({"magellan-expedition": { destination_threshold: $offset }});
});
$(window).scroll(function() {
    var scrollHeight = $(document).height();
	var scrollPosition = $(window).height() + $(window).scrollTop();
	if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
       $offset = $(window).height() - $('body > .section:last').outerHeight();
       $(document).foundation({"magellan-expedition": { destination_threshold: $offset }});
   }
});
$('#menu-wrapper li:not(:last)').click(function() {
    $(document).foundation({"magellan-expedition": { destination_threshold: 0 }});
});
var lastScrollTop = 0;
$(window).on('scroll', function() {
    st = $(this).scrollTop();
    if(st < lastScrollTop) {
        $(document).foundation({"magellan-expedition": { destination_threshold: 0 }});
    }
    lastScrollTop = st;
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
        $('#menu-wrapper li a, .chevron-down a').click(function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $($(this).attr("href")).offset().top
            }, 500);
        });
    });

}
