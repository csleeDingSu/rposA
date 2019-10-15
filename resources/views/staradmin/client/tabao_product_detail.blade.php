@extends('layouts.default_app')

@section('title', '挖宝优惠购')

@section('top-css')
    @parent
    <link href="{{ asset('/client/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/client/fontawesome-free-5.5.0-web/css/all.css') }}" >
    <link rel="stylesheet" href="{{ asset('/test/main/css/public.css') }}" />
	<!-- <link rel="stylesheet" href="{{ asset('/test/main/css/module.css') }}" /> -->
	<link rel="stylesheet" href="{{ asset('/test/main/css/style.css') }}" />
	<!-- <link rel="stylesheet" href="{{ asset('/client/css/default.css') }}" /> -->

	<link rel="stylesheet" href="{{ asset('/client/css/flickity.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/clientapp/css/tabao_product_detail.css') }}" />
	
	@if( Agent::is('OS X') )   
      <style>
      .footer
        {
          position: fixed;
		    bottom: 0;
		    width: 100%;
		    display: flex;
		    justify-content: space-between;
		    text-align: justify;
		    background-image: url(/client/images/product-detail-btn-bg.jpg);
		    height: 1.1rem;
		    background-size: contain;
		    background-repeat: round;
        }   
      </style>
    @endif
@endsection

@section('top-navbar')    
@endsection

@section('content')
<input id="hidgoodsId" type="hidden" value="{{$data['goodsId']}}" />
<input id="hidcouponLink" type="hidden" value="{{$data['couponLink']}}" />
<input id="hidusedpoint" type="hidden" value="{{$usedpoint}}" />
<input id="hidlife" type="hidden" value="{{empty($data['life']) ? 0 : $data['life']}}" />

	<div class="infinite-scroll" id="product">
		<div class="header_pr header_goods ">
    		<header class="icon_header">
    			<a href="javascript:history.back()" class="iconfont fa fa-angle-left fa-2x" aria-hidden="true"></a>
        	</header>	
        </div>

        @php ($photourl = empty($data['mainPic']) ? null : $data['mainPic'])
		@php ($photourl = str_replace('_310x310.jpg', '', $photourl))
		@php ($photourl = str_replace('_160x160.jpg', '', $photourl))
		@php ($promoPrice = $data['originalPrice'] - $data['couponPrice'])
        @php ($promoPrice = ($promoPrice > 0) ? $promoPrice : 0)                
		@php ($newPrice = ($promoPrice - 12) )
        @php ($newPrice = ($newPrice > 0) ? $newPrice : 0)
        @php ($life = empty($data['life']) ? 0 : $data['life'])
        @php ($commissionRate = $data['commissionRate'])
        @php ($commissionRate = ($commissionRate > 0) ? (int)$commissionRate : 0)
        @php ($reward = (int)($promoPrice * $commissionRate))
        @php ($sales = ($data['monthSales'] >= 1000) ? number_format(((float)$data['monthSales'] / 10000), 2, '.', '') . '万' : $data['monthSales'] . '件')
		<ul class="list-2">
			<li class="dbox">
				<a class="dbox0 imgBox" href="#">
					<img class="lazy" src="{{$photourl}}">
				</a>
			</li>			    		
			<li class="dbox">
				<div class="dbox1">
					<h2>{{$data['title']}}</h2>
					<div class="line-reward">
						<div class="reward-txt">下单后</div>
						<div class="reward">返{{$reward}}积分</div>
						<div class="btn-reward">怎么返?</div>
						<h3>热销{{$sales}}</h3>
					</div>							
				</div>
			</li>
			<li class="dbox">
				<div class="dbox1 line-price">
					<div class="caption_redeem_angpao">
						<span class="input-txt">如何补贴</span>
						<img src="{{ asset('/client/images/productv2_detail_caption.png') }}" />
					</div>
					<div class="normal-price">
						<span class="cur">￥<span class="price">{{number_format(empty($data['originalPrice']) ? 99 : $data['originalPrice'], 2) + 0}}</span></span>
						<div class="txt">原价</div>
					</div>
					<img class="normal-price-icon-minus" src="{{ asset('/client/images/icon-minus.png') }}" />
                	<div class="voucher-price">
                		<span class="cur">￥<span class="price">{{number_format(empty($data['couponPrice']) ? 99 : $data['couponPrice'],2) + 0}}</span></span>
                		<div class="txt">优惠券</div>
                	</div>
                	<img class="voucher-price-icon-minus" src="{{ asset('/client/images/icon-minus.png') }}" />
                	<div class="draw-price">
                		<span class="cur">￥<span class="price">12</span>
                		<div class="txt">抽奖补贴</div>
                	</div>					
                	<img class="new-price-icon-equal" src="{{ asset('/client/images/icon-equal.png') }}" />
                	<div class="new-price">
                		<span class="new-cur">￥<span class="price">{{$newPrice + 0}}</span></span>
                		<div class="txt">到手价</div>
                	</div>	
				</div>
			</li>
			<li class="dbox reward-bg">		
				<div class="dbox1 reward-desc">
					<div class="title">奖励补贴说明</div>
					<ul>
						<li>抽奖补贴由挖宝官方提供，新用户能免费获得1场次免费抽奖，通过抽奖可获得12元红包。</li>
						<li>用户可通过邀请好友，获得更多抽奖场次，从而获得更多购物红包。</li>
					</ul>				
				</div>
			</li>
			<li class="dbox footer">
					<div id="button-wrapper">
						@if (empty($data['couponLink']))
						<a class="copyBtn"> 
							<div id="btn-copy" class="btn-copy">领取优惠券</div>
						</a>
						@else
						@php ($_url = $data['couponLink'])
						@php ($_url = (str_replace('https://','taobao://',$_url)))
						@php ($_url = (str_replace('http://','taobao://',$_url)))
						<a id="btn-couponlink">
						<!-- <a href="taobao://item.taobao.com/item.htm?id={{$data['goodsId']}}">  -->
						<!-- <a href="https://t.asczwa.com/taobao?backurl={{$_url}}"> -->
							<div id="btn-copy" class="btn-copy">领取优惠券</div>
						</a>
						@endif
						<a href="/arcade">
							<div id="btn-voucher" class="btn-voucher">马上抽奖</div>
						</a>
					</div>
				
				<h4 style="font-size: 0;">优惠券代码 <span id="cut" class="copyvoucher">￥tzFkYnKYZ2R￥</span></h4>

				<img class="product-detail-btn-bg" src="{{ asset('/client/images/product-detail-btn-bg.jpg') }}" />
			</li>
			
			
		</ul>
	</div>

@endsection

@section('footer-javascript')

	<!-- draw rules starts -->
	<div class="modal fade col-md-12" id="draw-rules" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg close-modal" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<div class="modal-title">
								  抽奖补贴说明
								</div>
								<div class="instructions">
									<p>抽奖补贴由挖宝提供，每1次抽奖有98.43%概率获得12元红包，红包可提现，抽奖次数来源说明：</p>
									<p>①新用户注册送1次抽奖。</p>
									<p>②邀请好友注册并认证，可获得1次抽奖，好友邀请别人，你也可以获得1次抽奖。</p>
									<p>③领券下单返积分，1200积分兑换1次抽奖。</p>
								</div>
								<div class="txt-life">你当前拥有 <span class="mylife">{{$life}}</span> 次抽奖机会</div>
								<div class="modal-go-button">
									马上抽奖
								</div>
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

	<!-- reward rules starts -->
	<div class="modal fade col-md-12" id="reward-rules" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg close-modal" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<div class="modal-title">
								  奖励积分说明
								</div>
								<div class="instructions">
									<p>积分是奖励给通过平台领券去淘宝下单的用户，积分可兑换抽奖场次。</p>
									<p>1200积分兑换1场次，抽最高12元红包，系统自动兑换。
									</p>
								</div>
								<div class="modal-close-btn">
									知道了
								</div>
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

	<!-- go invite friend starts -->
	<div class="modal fade col-md-12" id="invite-modal" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg close-modal" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<div class="modal-title">
								  邀请好友抽红包
								</div>
								<div class="instructions">
									<p>邀请1个好友可获得1次抽奖补贴，你的好友能获得1次新人抽奖补贴。你的好友每邀请1个好友，你还可以获得1次抽奖补贴，邀请越多，抽奖补贴越多。</p>
								</div>
								<div class="modal-go-invite">
									去邀请
								</div>
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

	@parent
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	<script>
		
		$(document).ready(function(){
			var usedpoint = $('#hidusedpoint').val();
			var life = $('#hidlife').val();
			if (usedpoint > 0) {
				$('.input-txt').html('邀请奖励');
				$('.caption_redeem_angpao').click( function() {
		        	$('#invite-modal').modal();
		    	});
		    	$('.modal-go-invite').click(function() {
		    		window.location.href = '/share';
		    	});
			} else {
				$('.input-txt').html('如何补贴');
				$('.caption_redeem_angpao').click( function() {
		        	$('#draw-rules').modal();
		    	});
			}

			$('.btn-reward').click(function() {
				$('#reward-rules').modal();
			});

			$('.modal-close-btn').click( function() {
	        	$('.modal').modal('hide');
				$('.modal-backdrop').remove(); 
	    	});

			$('#btn-couponlink').click(function () {
				gettpwd();
			});

			var clipboard = new ClipboardJS('.copyBtn', {
				target: function () {
					return document.querySelector('#cut');
				}
			});

			clipboard.on('success', function (e) {
				console.log(e);
				// $('.btn-product-details').attr('src', '/client/images/btn-copy-code.png');
				$('#btn-copy').css('margin-top', '0.95rem');
				$('.btn-copy').html("<p class='inner_span_copy1' style='margin-top: -0.1rem;'>领取成功</p><p class='inner_span_copy2'>请打开淘宝APP</p>");
				window.location.href = 'taobao://';
			});

			clipboard.on('error', function (e) {
				console.log(e);
				// $('.btn-product-details').attr('src', '/client/images/btn-copy-code.png');
				$('#btn-copy').css('margin-top', '0.95rem');
				$('.btn-copy').html("<p class='inner_span_copy1' style='margin-top: -0.1rem;'>领取成功</p><p class='inner_span_copy2'>请打开淘宝APP</p>");
				window.location.href = 'taobao://';
			});

			$('.draw-price').click( function() {
	        	$('#draw-rules').modal();
	    	});

			if (life <= 0) {
				$('.modal-go-button').html('邀请好友');
				$('.modal-go-button').click( function() {
		        	window.location.href = '/pre-share';
		    	});
			} else {
				$('.modal-go-button').html('马上抽奖');
				$('.modal-go-button').click( function() {
		        	window.location.href = '/arcade';
		    	});	
			}
	    	
	    	
		})

		function gettpwd() {
			var _goodsId = $('#hidgoodsId').val();
			var _hidcouponLink = $('#hidcouponLink').val();

			// console.log(_goodsId);
			// console.log(_hidcouponLink);

			// $('.btn-product-details').attr('src', '/client/images/btn-copy-code.png');
          $('#btn-copy').css('margin-top', '0.95rem');
          $('.btn-copy').html("<p class='inner_span_copy1' style='margin-top: -0.1rem;'>领取优惠券</p><p class='inner_span_copy2'>处理中</p>");

			$.ajax({
		      type: 'GET',
		      url: "/tabao/get-privilege-link?goodsId=" + _goodsId, 
		      contentType: "application/json; charset=utf-8",
		      dataType: "text",
		      error: function (error) {
		          console.log(error);
		          alert(error.responseText);
		          $(".reload").show();
		          $('#btn-copy').css('margin-top','0.97rem');
          		$('#btn-copy').html("领取优惠券");
		      },
		      success: function(data) {
		          // console.log(data);
		          $('#btn-copy').css('margin-top','0.97rem');
	          		$('#btn-copy').html("领取优惠券");

		          if (data.length > 0 && JSON.parse(data).code == 0) {
		          	
		          		// console.log(JSON.parse(data).data.tpwd);
			          // console.log(JSON.parse(data).data.couponClickUrl);
			          // $('#cut').html(JSON.parse(data).data.tpwd);	  
			          _url = JSON.parse(data).data.couponClickUrl;
			          _url = _url.replace('https://','taobao://');
			          _url = _url.replace('http://','taobao://');
			          // console.log(_url);
			          window.location.href = _url;
		          }       
		      }
		  });

		}
		
	</script>
@endsection
