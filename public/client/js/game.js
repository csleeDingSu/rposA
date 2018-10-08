$(function () {
  
	var swiper = new Swiper('.swiper-container', {
		initialSlide: 1,
		navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
		},
	});

	$.post("/api/wallet-detail/66", function(data) {
	    // Do something with the request
	    if(data.success) {
	    	var bet_amount = 0;
		    var balance = parseInt(data.record[0].balance);
		    var level = data.record[0].level;
		    var life = data.record[0].life;
		    var point = parseInt(data.record[0].point);

		    $('#spanBalance').html(balance);
		    $('#divLife').html(life);
		    $('#divPoint').html(point);
		    $('#hidLevel').val(level);

		    $('.speech-bubble').hide();
		    
		    switch (level) {
		    	case 1:
		    		bet_amount = 10;
		    		$('.level-one').show();
		    		break;
		    	case 2:
		    		bet_amount = 30;
		    		$('.level-two').show();
		    		break;
		    	case 3:
		    		bet_amount = 70;
		    		$('.level-three').show();
		    		break;
		    	case 4:
		    		bet_amount = 150;
		    		$('.level-four').show();
		    		break;
		    	case 5:
		    		bet_amount = 310;
		    		$('.level-five').show();
		    		break;
		    	case 6:
		    		bet_amount = 630;
		    		$('.level-six').show();
		    		break;
		    }

		    $('.bet-container').html(bet_amount);
		}
		
	}, 'json');
});