$(function(){
	// enable hover text on main images
	$('.home .info-blocks .col-lg-4').mouseenter(function(){
		var idx = $('.home .info-blocks .col-lg-4').index(this);
		var imgHght = $('.home .info-blocks .col-lg-4').outerHeight();
		var imgWidth = $('.home .info-blocks .col-lg-4').outerWidth();
		
		// reset text dimensions
		$('.home .info-blocks .col-lg-4 .hover-text').css({'display':'none'});
		$('.home .info-blocks .col-lg-4 .hover-text').eq(idx).css({'height':imgHght+'px','width':imgWidth+'px','line-height':imgHght+'px','display':'block'});
	});
});