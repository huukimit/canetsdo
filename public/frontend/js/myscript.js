$(document).ready(function(){

	//Mở menu mobile
	$('.menu_xs_sm').click(function () {
    	$('#categories').css("display", "block");
	});

	$('.mobile_menu i').click(function () {
		//Đóng tất cả ul trong menu_mobile lại
		$(this).parent().parent().find("ul").slideUp(300);
		//Thay đổi dấu - thành +
	    $(this).parent().parent().find("i").removeClass("fa-minus-circle").addClass("fa-plus-circle");

	    //Nếu ul chọn đang ở chế độ hiển thị
		if($(this).parent().find("ul").first().is(':visible')){
	    	$(this).parent().find("ul").first().slideUp(300);
	    	$(this).removeClass("fa-minus-circle").addClass("fa-plus-circle");
	    }else{
			$(this).parent().find("ul").first().slideDown(300);
			$(this).removeClass("fa-plus-circle").addClass("fa-minus-circle");
	    }
	});

	//Đóng div menu mobile
	$(".closes").click(function(){
		//alert("closes");return;
		//$(this).parent().parent().parent().find('.menu-xs-sm').toggle(300);
		$('#categories').css("display", "none");
	});

	$( ".cat>ul>li" ).each(function( index ) {
		$(this).eq( 9 ).css( "display", "none" );
	});
	

	

	//Play video
	// $(".bor_play i").on("click", function(){
	// 	$(".sec_video").css("display", "block");
	// 	$("#playVideo")[0].src += "?autoplay=1";
	// });

	$(".bor_play i").click(function(e) {
        $(".sec_video").show();
        $("#playVideo")[0].src += "?autoplay=1";
        e.stopPropagation();
    });

	$(document).click(function(e) {
        if (!$(e.target).is('#playVideo, #playVideo *')) {
            $(".sec_video").hide();
        }
    });

});
	



$(window).resize(function(){
	

});




$(window).bind("load", function() {
	

});





