/* Scroll to */

$('a[href^="#"]').click(function(e) {
    e.preventDefault();
    $(window).stop(true).scrollTo(this.hash, {duration: 400, axis: 'y'});
});


/* Menu */

var menuOffset = $('#menu').height() - 3;
$(window).resize(function() {
    menuOffset = $('#menu').height() - 3;
});

if ($(document).width() > 640) {
    $('#menu-wrapper').addClass('open');
    $(window).scroll(function() {
        if ($(document).scrollTop() > 150) {
            $('#menu-wrapper').removeClass('open').css('margin-top', -(menuOffset));
        } else {
            $('#menu-wrapper').addClass('open').css('margin-top', 0);
        }
    });
    $('#menu-trigger').click(function() {
        $('#menu-wrapper').toggleClass('open');
        if ($('#menu-wrapper').hasClass('open')) {
            $('#menu-wrapper').css('margin-top', 0);
        } else {
            $('#menu-wrapper').css('margin-top', -(menuOffset));
        }
    });
    $('#main-menu li').click(function() {
        $('#menu-wrapper').removeClass('open');
        if ($('#menu-wrapper').hasClass('open')) {
            $('#menu-wrapper').css('margin-top', 0);
        } else {
            $('#menu-wrapper').css('margin-top', -(menuOffset));
        }
    });
}

$('#menu-trigger-m').click(function() {
    $('#menu-wrapper, #menu-trigger-m').toggleClass('open');
    $('#modal').toggleClass('on');
});
$('#main-menu li').click(function() {
    $('#menu-wrapper, #menu-trigger-m').removeClass('open');
    $('#modal').removeClass('on');
});