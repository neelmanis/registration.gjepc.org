$(document).ready(function(){
	$(".flexnav").flexNav();
	$(window).scroll(function() {
		var scroll = $(window).scrollTop();
		if($(window).width()>600){
			if (scroll > 103) 
			{
			    $("#navigation").addClass("topHeader");
			}
			else {
			    $("#navigation").removeClass("topHeader");
			}
		}
	});
});
