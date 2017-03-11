
$(document).ready(function() {
	var first = true;
	$(window).scroll(function (event) {
	    var scroll = $(window).scrollTop();
	    console.log(scroll);
		    if (scroll >= 1000) {
		    	$('#step_1').removeAttr('hidden').addClass('animated bounceInDown');
		    }
		    if (scroll >= 1200) {
		    	$('#step_2').removeAttr('hidden').addClass('animated fadeInLeftBig');
		    }
		    if (scroll >= 1400) {
		    	$('#step_3').removeAttr('hidden').addClass('animated bounceInDown');
		    }
		    if (scroll >= 1500) {
		    	$('#step_4').removeAttr('hidden').addClass('animated fadeInRightBig');
		    }
	});
});