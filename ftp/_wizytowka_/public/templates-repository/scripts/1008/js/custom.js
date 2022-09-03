/* Menu */

$('#menu-button').click(function() {
    $('#menu-wrapper').toggleClass('open animated-2 bounceInLeft');
});
$('#menu-panel').click(function() {
    $('#menu-wrapper').removeClass('open animated-2 bounceInLeft');
});

$('#menu-panel ul a').click(function(event){
    event.preventDefault();
    $('#menu-panel ul a').removeClass('active');
    $(this).addClass('active');
    var content_selector = this.id;
    var content_split = content_selector.split('-');
    var content_show = '#' + content_split[1];
    $('.pages-single').hide().removeClass('animated bounceInRight');
    $(content_show).show().addClass('animated bounceInRight');
});
