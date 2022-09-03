$(document).ready(function() {

        $('#about').show();
		$('#offer').hide();
        $('#lokalizacja').hide();
        $('#daneKorespondencyjne').hide();
        $('#daneFirmowe').hide();
        $('#form').hide();
   

    function clickContent() {
	
		$("#wrap img.bg1").first().fadeIn(500);
		
		$('nav ul li.about').addClass("activeNav");
	
	
        $('nav ul li.about').click(function () {
		
			$('nav ul li').removeClass("activeNav");
			$(this).addClass("activeNav");
			

            $('#about').show();
			$('#offer').hide();
            $('#lokalizacja').hide();
            $('#daneKorespondencyjne').hide();
            $('#daneFirmowe').hide();
            $('#form').hide();
			

            $('img.bgfade').fadeOut();
				var dg_H = $(window).height();
				var dg_W = $(window).width();
				$('#wrap').css({ 'height': dg_H, 'width': dg_W });
				
				$("#wrap img.bg1").first().fadeIn(1500);

		    return false;
		   
        });
		
		
		$('nav ul li.offer').click(function () {
		
			$('nav ul li').removeClass("activeNav");
			$(this).addClass("activeNav");
			

            $('#about').hide();
			$('#offer').show();
            $('#lokalizacja').hide();
            $('#daneKorespondencyjne').hide();
            $('#daneFirmowe').hide();
            $('#form').hide();
			

            $('img.bgfade').fadeOut();
				var dg_H = $(window).height();
				var dg_W = $(window).width();
				$('#wrap').css({ 'height': dg_H, 'width': dg_W });
				
				$("#wrap img.bg1").first().fadeIn(1500);

		    return false;
		   
        });
		


        $('nav ul li.lokalizacja').click(function () {
		
			$('nav ul li').removeClass("activeNav");
			$(this).addClass("activeNav");

            $('div#about').hide();
			$('#offer').hide();
            $('div#lokalizacja').show();
            $('div#daneKorespondencyjne').hide();
            $('div#daneFirmowe').hide();
            $('div#form').hide();

			$('img.bgfade').fadeOut();
			var dg_H = $(window).height();
			var dg_W = $(window).width();
			$('#wrap').css({ 'height': dg_H, 'width': dg_W });

			$("#wrap img.bg2").first().fadeIn(1500);

			return false;
		});

        $('nav ul li.daneKorespondencyjne').click(function () {

			$('nav ul li').removeClass("activeNav");
			$(this).addClass("activeNav");
			
            $('div#about').hide();
			$('#offer').hide();
            $('div#lokalizacja').hide();
            $('div#daneKorespondencyjne').show();
            $('div#daneFirmowe').hide();
            $('div#form').hide();

			$('img.bgfade').fadeOut();
				var dg_H = $(window).height();
				var dg_W = $(window).width();
				$('#wrap').css({ 'height': dg_H, 'width': dg_W });
				
				$("#wrap img.bg3").first().fadeIn(1500);
				
			return false;	
				
        });

        $('nav ul li.daneFirmowe').click(function () {
		
			$('nav ul li').removeClass("activeNav");
			$(this).addClass("activeNav");
		
            $('div#about').hide();
			$('#offer').hide();
            $('div#lokalizacja').hide();
            $('div#daneKorespondencyjne').hide();
            $('div#daneFirmowe').show();
            $('div#form').hide();

           
		   $('img.bgfade').fadeOut();
				var dg_H = $(window).height();
				var dg_W = $(window).width();
				$('#wrap').css({ 'height': dg_H, 'width': dg_W });
				
				$("#wrap img.bg4").first().fadeIn(1500);
				
			return false;	
           
        });

        $('nav ul li.form').click(function () {
			
			$('nav ul li').removeClass("activeNav");
			$(this).addClass("activeNav");

            $('div#about').hide();
			$('#offer').hide();
            $('div#lokalizacja').hide();
            $('div#daneKorespondencyjne').hide();
            $('div#daneFirmowe').hide();
            $('div#form').show();

			
			$('img.bgfade').fadeOut();
				var dg_H = $(window).height();
				var dg_W = $(window).width();
				$('#wrap').css({ 'height': dg_H, 'width': dg_W });
				
				$("#wrap img.bg5").first().fadeIn(1500);
				
			return false;	

        });
    }
    clickContent();
	
	
});