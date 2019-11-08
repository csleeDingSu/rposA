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
	<link rel="stylesheet" href="{{ asset('/clientapp/css/tabao_product_detail.css?version=1.0.4') }}" />
	
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

		/*iphone X*/
        @media only screen  
          and (device-width : 375px) 
          and (device-height : 812px) 
          and (-webkit-device-pixel-ratio : 3) {
            .footer2 {
				height: 1.5rem;
			}
          }

          /*iPhone 7/8*/ 
          @media only screen 
            and (device-width : 375px) 
            and (device-height : 667px) 
            and (-webkit-device-pixel-ratio : 2) {
              /*do nothing*/
            }

          /*iPhone 6+/6s+/7+/8+*/
          @media only screen 
            and (device-width : 414px) 
            and (device-height : 736px) 
            and (-webkit-device-pixel-ratio : 3) {
              /*do nothing*/
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
		
		@php ($originalPrice = $data['originalPrice'])
		@php ($originalPrice = number_format((float)(empty($originalPrice) ? 0 : $originalPrice), 2, '.', '') + 0)
		@php ($couponPrice = $data['couponPrice'])
		@php ($couponPrice = number_format((float)(empty($couponPrice) ? 0 : $couponPrice), 2, '.', '') + 0)

		@php ($promoPrice = $data['originalPrice'] - $data['couponPrice'])
        @php ($promoPrice = ($promoPrice > 0) ? $promoPrice : 0)                
		<!-- @php ($newPrice = ($promoPrice - 12) ) -->
        <!-- @php ($newPrice = ($newPrice > 0) ? $newPrice : 0) -->
        @php ($newPrice = 0 )
        @php ($life = empty($data['life']) ? 0 : $data['life'])
        @php ($commissionRate = $data['commissionRate'])
        @php ($commissionRate = ($commissionRate > 0) ? (int)$commissionRate : 0)
        @php ($reward = (int)($promoPrice * $commissionRate))
        @php ($hong = $reward / 100) 
        @php ($sales = ($data['monthSales'] >= 1000) ? number_format(((float)$data['monthSales'] / 10000), 2, '.', '') . '万' : $data['monthSales'] . '件')
		@php ($life_needed = ceil($promoPrice / 12))

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
						<div class="reward-txt">奖励<span class="reward"><span class="cur">￥</span>{{$hong}}</span>红包积分</div>
						<div class="btn-reward">怎么奖励?</div>
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
						<span class="cur">￥<span class="price">{{$originalPrice}}</span></span>
						<div class="txt">原价</div>
					</div>
					<img class="normal-price-icon-minus" src="{{ asset('/client/images/icon-minus.png') }}" />
                	<div class="voucher-price">
                		<span class="cur">￥<span class="price">{{$couponPrice}}</span></span>
                		<div class="txt">优惠券</div>
                	</div>
                	<img class="voucher-price-icon-minus" src="{{ asset('/client/images/icon-minus.png') }}" />
                	<div class="draw-price">
                		<span class="cur">￥<span class="price">{{$promoPrice}}</span>
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
					<div class="title-head-spot"></div><div class="title">0元购说明</div>
					<ul>
						<li>本产品来源淘宝，点击“领券购买”即可领券按券后价购买。如果你不想花自己钱，可以去抽奖补贴，每次抽奖最多可获得12元红包。想获得更多抽奖次数，可按下面方式：</li>
						<li><span class="highlight-red">新用户注册、邀请好友、好友邀请别人、领券下单都可以获得抽奖次数</span>，抽奖次数越多，可补贴金额越大，从此购物不花自己钱，全场0元购。</li>
					</ul>				
				</div>
			</li>
			<li class="dbox footer2">
				<div class="footer-wrapper">
				<a>
					<div id="btn-normal-price">
						<p class='line-1'>￥{{$originalPrice}}</p>
						<p class='line-2'>原价购买</p>
					</div>
				</a>
				
				@php ($_url = $data['couponLink'])
				@php ($_url = (str_replace('https://','taobao://',$_url)))
				@php ($_url = (str_replace('http://','taobao://',$_url)))
				<a id="btn-couponlink">
					<div id="btn-copy" class="btn-copy">
						<p class='line-1'>￥{{$promoPrice}}</p>
						<p class='line-2'>领券购买</p>
					</div>
				</a>
				<a href="/arcade">
					<div id="btn-voucher" class="btn-voucher">
						<p class='line-1'>进入抽奖</p>
						<p class='line-2'>赚补贴红包</p>
					</div>
				</a>
				</div>
				<h4 style="font-size: 0;">优惠券代码 <span id="cut" class="copyvoucher">￥tzFkYnKYZ2R￥</span></h4>

			</li>
			
			
		</ul>
	</div>

@endsection

@section('footer-javascript')

	<!-- new draw-rules Modal starts -->
<div class="modal fade col-md-12" id="draw-rules" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg close-modal" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-row">
                  <div class="modal-title">
                    想要<span class="highlight1">{{$promoPrice}}</span>元补贴 需<span class="highlight1">{{$life_needed}}</span>场抽奖
                  </div>
                  <div class="modal-description">
                    <p>抽奖补贴是由挖宝提供，每1场抽奖有98.43％概率获得12元红包补貼，以下方式获得更多抽奖场次。</p>
                  </div>
                  <div class="modal-instructions">
                    <p>邀请好友 <span class="chance">+1场次/人</span></p>
                    <p><span class="small">每邀请1个好友送1场次抽奖</span></p>
                    <a href="/pre-share"><img src="{{asset('clientapp/images/product/btn-action.png')}}"></a>
                 </div>
                 <div class="modal-instructions">
                    <p>好友邀请别人 <span class="chance">+1场次/人</span></p>
                    <p><span class="small">你邀请的好友邀请别人，你能得到1场次/人</span></p>
                    <a href="/pre-share"><img src="{{asset('clientapp/images/product/btn-action.png')}}"></a>
                 </div>
                 <div class="modal-instructions">
                    <p>新人注册和领券下单 <span class="chance">+N场次</span></p>
                    <p><span class="small">用户注册送1次，领券下单返积分兑换场次</span></p>
                    <a href="/arcade"><img src="{{asset('clientapp/images/product/btn-action.png')}}"></a>
                 </div>
                  <div class="modal-summary">
                    <p>你目前拥有 <span class="d">{{$life}}</span> 场次抽奖补贴</p>
                    <a href="/arcade"><div class="btn-go">进入抽奖</div></a>
                  </div>
                </div>
            </div>            
        </div>
        <div class="btn-close-modal">
          <img src="{{ asset('/clientapp/images/product/close.png') }}">
        </div>
    </div>
</div>
<!-- Modal Ends -->

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
			
			$('.caption_redeem_angpao').click( function() {
	        	$('#draw-rules').modal();
	    	});

			$('.btn-reward').click(function() {
				$('#reward-rules').modal();
			});

			$('.modal-close-btn').click( function() {
	        	$('.modal').modal('hide');
				$('.modal-backdrop').remove(); 
	    	});

	    	$('.btn-close-modal').click(function() {
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
				// $('#btn-copy').css('margin-top', '0.95rem');
				// $('.btn-copy').html("<p class='inner_span_copy1' style='margin-top: -0.1rem;'>领取成功</p><p class='inner_span_copy2'>请打开淘宝APP</p>");
				window.location.href = 'taobao://';
			});

			clipboard.on('error', function (e) {
				console.log(e);
				// $('.btn-product-details').attr('src', '/client/images/btn-copy-code.png');
				// $('#btn-copy').css('margin-top', '0.95rem');
				// $('.btn-copy').html("<p class='inner_span_copy1' style='margin-top: -0.1rem;'>领取成功</p><p class='inner_span_copy2'>请打开淘宝APP</p>");
				window.location.href = 'taobao://';
			});

			$('.draw-price').click( function() {
	        	$('#draw-rules').modal();
	    	});
	    	
		})

		function gettpwd() {
			var _goodsId = $('#hidgoodsId').val();
			var _hidcouponLink = $('#hidcouponLink').val();

			// console.log(_goodsId);
			// console.log(_hidcouponLink);

			// $('.btn-product-details').attr('src', '/client/images/btn-copy-code.png');
          // $('#btn-copy').css('margin-top', '0.95rem');
          $('.btn-copy .line-2').html("处理中");

			$.ajax({
		      type: 'GET',
		      url: "/tabao/get-privilege-link?goodsId=" + _goodsId, 
		      contentType: "application/json; charset=utf-8",
		      dataType: "text",
		      error: function (error) {
		          console.log(error);
		          alert(error.responseText);
		          $(".reload").show();
		          // $('#btn-copy').css('margin-top','0.97rem');
          		// $('#btn-copy').html("领取优惠券");
          		$('.btn-copy .line-2').html("领券购买");
		      },
		      success: function(data) {
		          // console.log(data);
		          // $('#btn-copy').css('margin-top','0.97rem');
	          		// $('#btn-copy').html("领取优惠券");
	          		$('.btn-copy .line-2').html("领券购买");

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
