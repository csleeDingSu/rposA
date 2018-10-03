$( 'ul.nav.nav-tabs  a' ).click( function ( e ) {
        e.preventDefault();
        $( this ).tab( 'show' );
		
		var selected_tab = $("ul.nav-tabs li.active a").attr("href");
		$(selected_tab).parent().addClass('div-active');
		
		var selected = $("ul.nav-tabs li.active").hasClass('pass');
		
		if(selected){
			$(selected_tab).parent().addClass('div-pass');
			$(selected_tab).find('.status').html('<a href="#" class="status-pass">马上领取</a>');
			
		} else {
			$(selected_tab).parent().removeClass('div-pass');
			$(selected_tab).find('.status').html('<a href="#" class="status-default">不可领取</a>');
		}
		
      } );

	  $('.radio-primary').click(function(){
		$('.radio-primary').not(this).removeClass('clicked');
		$(this).toggleClass('clicked');
		
		$('.radio-primary').not(this).find( '.fa' ).removeClass('fa-check');
		$(this).find( '.fa' ).toggleClass('fa-check');
		
		if($(this).find('input:radio').val() == $('.select').attr('rel')){
			var place = $('#bet-tabs').find( '.border-active .active' ).attr('rel');
			
			$('.select').html('请选择'+place+'的结果<br />');
			$('.select').attr('rel', '')
			$('.info').html('只能猜一个，猜对了就闯关成功，祝你好运！');

		} else {
			var selected = $(this).find('input:radio').val();
			var info = '';
			
			$('.select').html('你选择了'+selected+'<br />');
			$('.select').attr('rel', selected);
			
			switch (selected) {
				case "冠军【大】":
					info = "如冠军开【4】或【5】或者【6】你就能过关！";
				break;
				
				case "冠军【小】":
					info = "如冠军开【1】或【2】或者【3】你就能过关！";
				break;
				
				case "冠军【单】":
					info = "如冠军开【1】或【3】或者【5】你就能过关！";
				break;
				
				case "冠军【双】":
					info = "如冠军开【2】或【4】或者【6】你就能过关！";
				break;
				
				case "亚军【大】":
					info = "如亚军开【4】或【5】或者【6】你就能过关！";
				break;
				
				case "亚军【小】":
					info = "如亚军开【1】或【2】或者【3】你就能过关！";
				break;
				
				case "亚军【单】":
					info = "如亚军开【1】或【3】或者【5】你就能过关！";
				break;
				
				case "亚军【双】":
					info = "如亚军开【2】或【4】或者【6】你就能过关！";
				break;
				
				case "第三【大】":
					info = "如第三开【4】或【5】或者【6】你就能过关！";
				break;
				
				case "第三【小】":
					info = "如第三开【1】或【2】或者【3】你就能过关！";
				break;
				
				case "第三【单】":
					info = "如第三开【1】或【3】或者【5】你就能过关！";
				break;
				
				case "第三【双】":
					info = "如第三开【2】或【4】或者【6】你就能过关！";
				break;
				
			}
			$('.info').html(info);

		}
	  });

	// Countdown
	function timer(){
		var duration = new Date().getTime() + 60000;
		$('.countdown').countdown(duration, {elapse: true})
		.on('update.countdown', function(event) {
		  var $this = $(this);
		  if (event.elapsed) {
			timer();
		  } else {
			$this.html(event.strftime('<span> %M:%S </span>'));
		  }
		});
	}
	
	function shuffle_result(){
		var classes = ["one", "two", "three", "four", "five", "six"];
		$("#result div.circle").each(function(){
			$(this).removeClass();
			$(this).addClass('circle');
			$(this).addClass( classes.splice( ~~(Math.random()*classes.length), 1 )[0] );
			
		});
	};
				
	( function( $ ) {
		timer();
		shuffle_result();
	} )( jQuery );
	
