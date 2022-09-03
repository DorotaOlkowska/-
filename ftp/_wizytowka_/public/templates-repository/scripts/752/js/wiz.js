$(document).ready(function() {
	

    $(window).load(function () {
        $('img.bgfade').hide();
        var dg_H = $(window).height();
        var dg_W = $(window).width();
        $('#wrap').css({ 'height': dg_H, 'width': dg_W });
        function anim() {
            $("#wrap img.bgfade").first().appendTo('#wrap').fadeOut(1500);
            $("#wrap img").first().fadeIn(1500);
            setTimeout(anim, 7000);
        }
        anim();
    });
    //$(window).resize(function () { window.location.href = window.location.href })





    //var rotate = function () {
    //    $("body")
    //      .delay(9000).queue(function () {
    //          $(this).css({
    //              "background-image": "url('images/bg_yellow.jpg')"
    //          });
    //          $(this).dequeue();
    //      })
    //      .delay(9000).queue(function () {
    //          $(this).css({
    //              "background-image": "url('images/bg_blue.jpg')"
    //          });
    //          $(this).dequeue();
    //      })
    //      .delay(9000).queue(function (next) {
    //          $(this).css({
    //              "background-image": "url('images/bg_green.jpg')"
    //          });
    //          $(this).dequeue();
    //          next();
    //      })
    //      .queue(rotate);
    //};

 //   rotate();


    $("nav").find("a").click(function (e) {
        var offsetScroll = -50; //Offset of 20px
        e.preventDefault();
        var section = $(this).attr("href");
        $("html, body").animate({
            scrollTop: $(section).offset().top + offsetScroll
        }, 800);
    });

	
});