var timerInterval = 0;

$(function () {
  
	$('.swiper-container').flickity({
		// options
		draggable: true,
		wrapAround: true,
		pageDots: false,
		initialIndex: 1,
		freeScroll: false,
		contain: true,
	});

	$('.swiper-container').on( 'change.flickity', function( event, index ) {
		if(index == 1) {
			document.getElementById('ifm_wheel').contentWindow.resetTimer();
		}
	});
});