<!DOCTYPE HTML>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="format-detection" content="telephone=no" />
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<title>@lang('dingsu.home')</title>
	<link rel="stylesheet" href="{{ asset('/client/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/test/main/css/public.css') }}" />
	<link rel="stylesheet" href="{{ asset('/test/main/css/module.css') }}" />
	<link rel="stylesheet" href="{{ asset('/test/main/css/style.css') }}" />
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha256-UK1EiopXIL+KVhfbFa8xrmAWPeBjMVdvYMYkTAEv/HI=" crossorigin="anonymous" />
	<link rel="stylesheet" href="{{ asset('/client/css/slick-theme.css') }}" />

	<script type="text/javascript" src="{{ asset('/test/main/js/jquery-1.9.1.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>


<script type="text/javascript">
    //这里是微信和qq遮罩提示层
    function isPIA(){
        var u = navigator.userAgent, app = navigator.appVersion;
        var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
        var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
        if(isiOS) {return 1;}
        if(isAndroid) {return 2};
    }
    var bg;
    if (isPIA() == 1) {
        bg = window.location.origin + "/vwechat/images/ios_wx.jpg";
    }else if (isPIA() == 2) {
        bg = window.location.origin + "/vwechat/images/android_wx.jpg";
    }
    // document.writeln("<div id=\"weixinTips\" style=\"display:none;background:rgba(255, 255, 255,1);width:100%;height:100%;position:fixed;left:0;top:0;z-index:9999\"><div id=\"weixinTipsImg\" style=\"background:url("+bg+") top center no-repeat;background-size:100%;width:100%;height:100%\"><\/div><\/div>");
    var ua = navigator.userAgent.toLowerCase();
    //alert(ua);
    function checkDownload() {
        if (ua.indexOf("micromessenger") > -1 || ua.indexOf("qq/") > -1) {
            document.writeln("<div id=\"weixinTips\" style=\"display:block;background:rgba(255, 255, 255,1);width:100%;height:100%;position:fixed;left:0;top:0;z-index:9999\"><div id=\"weixinTipsImg\" style=\"background:url("+bg+") top center no-repeat;background-size:100%;width:100%;height:100%\"><\/div><\/div>");

            // document.getElementById("weixinTips").style.display = "block";
            document.title="请在浏览器中打开...";
            // return false;
        }else{

        	var wabao666_domain = "<?php Print(env('wabao666_domain', 'www.wabao666.com'));?>";
            var sCurrentPathName = window.location.pathname;
            var sNewPathName = sCurrentPathName; //sCurrentPathName.replace("vvregister", "register");
            if (window.location.hostname != wabao666_domain) {
            	window.location.href = window.location.protocol + "//" + wabao666_domain + sNewPathName;	
            }
            // window.location.href = "https://www.wabao666.com" + sNewPathName;
            // var href_ = "https://www.wabao666.com" + sNewPathName;

        }

    }
    checkDownload();
</script>

</head>
<style>
	
	
.isnext{ text-align: center;font-size: .26rem; color: #999; line-height: 1.6em; padding: .15rem 0; }
	
	.header .top li a, .header .top li a:hover, .header .top li a:focus {
			text-decoration: none;
		}
		
	</style>
<body style="background:#efefef">
<input type="hidden" id="page" value="1" />
<input type="hidden" id="max_page" value="{{$vouchers->lastPage()}}" />
<input type="hidden" id="firstwin" value="{{ $firstwin }}" />

	<section class="cardFull card-flex">
		<div class="cardHeader">
			<div class="header">
				<ul class="dbox top">
					
						@if (isset(Auth::Guard('member')->user()->username))
							<a class="login-title" href="/member" style="color: white; font-size: 0.3rem;">{{ Auth::Guard('member')->user()->username }}</a>
							
						@else
						<li class="dbox0">
					  		<a href="/nlogin" style="color: white; font-size: 0.3rem;">@lang('dingsu.login') / @lang('dingsu.register')</a>
					  	</li>
					  	@endif
					  	<!-- <a href="/register"><img src="{{ asset('/test/main/images/register.png') }}"></a> -->
				  						
					<li class="dbox1 logo"><img src="{{ asset('/test/main/images/logo.png') }}"></li>				
					<li class="dbox0"><a href="/search" style="color: white; font-size: 0.3rem;"><img src="{{ asset('/client/images/search_btn.png') }}" style="height: 0.3rem;"> 搜索</a></li>

					
				</ul>
				<div class="main rel">
					<div class="dbox">
						<div class="dbox1 txt">
							{{$current_cat_name = null}}
							@if(isset($category))
								@foreach($category as $cat)

									@if ($cat->id == $cid)
										{{$current_cat_name = $cat->display_name}}
										<a class="on" href="/cs/{{$cat->id}}">{{$cat->display_name}}</a>
										<!-- <a href="/cs/{{$cat->id}}">{{$cat->display_name}}</a> -->
									@else
										<a href="/cs/{{$cat->id}}">{{$cat->display_name}}</a>
									@endif

								    @break($cat->number == 6)
								@endforeach
							@else
								<a class="on">精选</a>
								<a>女装</a>
								<a>男装</a>
								<a>鞋帽</a>
								<a>食饮</a>
								<a>没装</a>
							@endif							
						</div>
						<a class="downIcon dbox0"><img src="{{ asset('/test/main/images/downIcon.png') }}"></a>
					</div>
					<div class="slideMore dn">
						<h2>全部分类<a class="close"><img src="{{ asset('/test/main/images/closeIcon.png') }}"></a></h2>
						<p>
							@foreach($category as $cat)
								@if ($cat->id == $cid)
									<a class="on" href="/cs/{{$cat->id}}">{{$cat->display_name}}</a>
								@else
									<a href="/cs/{{$cat->id}}">{{$cat->display_name}}</a>
								@endif
							@endforeach							
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="cardBody">
			<div class="box">

				@if($cid == env('voucher_featured_id','220'))
					
					<div class="banner" style="background-color: white;">

						<!--<img data-lazy="{{ asset('/test/main/images/demo/banner.png') }}">-->
						

						 @if(isset($banner)) 				
						 @foreach($banner as $bner) 	
						<!--	<img data-lazy="{{env('banner_url', 'https://wabao666.com/banner/') . $bner->banner_image}}"  >		-->
						
						<a href="{{ $bner->banner_url }} "> <img data-lazy="/banner/{{$bner->banner_image}}"  >	</a>
						 @endforeach 				
						 @endif 
					
					</div>

				@endif

				<div class="product" style="margin-top: 0px;">
					<div class="title">
						<span>共有<font color="#f63556">{{ $vouchers->total() }}</font>款产品</span>
						<h2>{{ is_null($current_cat_name) ? "精选" : $current_cat_name }}大额优惠券</h2>
					</div>
					
					<div class="infinite-scroll">
						<ul class="list-2">								
								@include('client.ajaxhome')
						</ul>
						{{ $vouchers->links() }}
						
						<p class="isnext">下拉显示更多...</p>
					</div>
					
				</div>
			</div>
		</div>

		<div class="speech-balloon-home hide">你有{{ isset(Auth::Guard('member')->user()->current_life) ? Auth::Guard('member')->user()->current_life : 0}}次玩赚免单机会，可赚{{ isset(Auth::Guard('member')->user()->current_life) ? Auth::Guard('member')->user()->current_life * 5 : 0}}元</div>
		@include('layouts/footer')

		<!-- 领取优惠券  -->
		<div class="showQuan dflex scaleHide">
			<div class="inBox">
				<img id="showIcon" src="{{ asset('/test/main/images/showIcon.png') }}" class="icon">
				<h2>点击下面复制按钮，打开淘宝APP领券</h2>

				
					<h3 id="cut" class="copyvoucher">￥K8454DFGH45H</h3>
					<a class="cutBtn"><img src="{{ asset('/test/main/images/btn-1.png') }}"></a>
					<h4>如复制不成功，请手指按住优惠卷代码复制。</h4>
				
				
			</div>
		</div>

		<div class="showBao dflex scaleHide">
			<div class="inBox">
				<div class="imgBox">
					<img id="product_img" src="{{ asset('/test/main/images/demo/d-img3.png') }}">
				</div>
				<h2 style="white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis ;" id = 'product_name'>INS网红手表时尚潮流手表女士韩版 抖音时来运转石英表休闲</h2>
				<h3 style="display: none">
					<font id="product_discount_price">优惠价：39元</font><em id = "product_price">淘宝原价：￥360</em>
				</h3>

				<div class="group">
				 	<img src="{{ asset('/test/main/images/icon-2.png') }}" />
					<span><em id = 'voucher_price'>390金币 免费兑换</em></span>
				</div>

				<div class="group" style="text-align: center;">
					<div class="balance">你当前拥有 <em id='current_point'> {{ isset($member_mainledger->current_point) ? number_format($member_mainledger->current_point, 0, ".", "") : 0 }}</em> 金币</div>
				</div>

				<a class="btn" href="/arcade"><img src="{{ asset('/test/main/images/wabao.png') }}"></a>
				<a class="btn" href="/redeem"><div class="btn-redeem">兑换商品</div></a>

			</div>
		</div>

		<div class="showTips dflex scaleHide" id="promotion">
			<div class="inBox">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-body" style="padding:10px !important;">				
						<div class="modal-row">
							<div class="wrapper modal-full-height">
								<div class="modal-card">
									<!-- <div class="instructions">
										 <h2>0元购物攻略</h2>
										玩猜单双游戏，赢金币换<span class="highlight">购物补助金<br />
										（可提现到支付宝）</span>再去购买商品，<br />
										<span class="highlight">补助金最少30元</span>起，任你领不停。<br />
									</div> -->
									<div class="instructions" style="padding:10px 11px 10px 11px !important;">	
										<span style="font-weight: bold;">
											去<img src="{{ asset('/client/images/small-wheel.png') }}" width="15" height="15" /><span class="highlight">玩赚免单</span>赚金币换购物红包(可提现)
										</span>
										<ul style="color: #a8adaa;">
											<li> • 30元、50元、100元任你领！</li>
											<li> • 新人注册就送3次猜猜乐（最多赚45元）</li> 
											<li> • 分享给好友赚更多</li>
										</ul>
										<span style="font-weight: bold;">
											从此购物不花自己钱，<span class="highlight">你购物我帮你买单！</span>
										</span>
									</div>
									<div class="modal-label">
										<div class="icon-coin-wrapper">
											<div class="icon-coin"></div>
										</div>
										<div class="icon-label">您当前拥有
											<span class="modal-point">
											@if (isset($member_mainledger->current_point))
												{{ number_format($member_mainledger->current_point, 0, '.', '') }}
											@else
												0
											@endif
											</span>
											金币
										</div>
									</div>
									<div style="clear: both;"></div>
									<div class="modal-number">你还有
										@if (isset($member_mainledger->current_life))
											{{ number_format($member_mainledger->current_life, 0, '.', '') }}
										@else
											0
										@endif
									次游戏机会 可赚
										@if (isset($member_mainledger->current_life))
											{{ number_format($member_mainledger->current_life * 150, 0, '.', '') }}
										@else
											0
										@endif
									金币</div>
									<a href="/arcade">
										<div class="btn-wabao">去赚金币</div>
									</a>
								</div>
							</div>
						</div>							
					</div>
				</div>
			</div>
			</div>
		</div>
	</section>
	
	

	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha256-NXRS8qVcmZ3dOv3LziwznUHPegFhPZ1F/4inU7uC8h0=" crossorigin="anonymous"></script>
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	<script>
		
		$(document).on('ready', function() {
      
		  $(".banner").slick({
			  autoplay:true,
			  autoplaySpeed:10000,
			  arrows:false,
			  lazyLoad: 'ondemand', // ondemand progressive anticipated
			  infinite: true,
			  adaptiveHeight: false,
			  dots: true,
		  });
		});
		
		
		

		$(document).ready(function(){
		//$(function () {

			var firstwin = $('#firstwin').val();
			console.log(firstwin);

			if(firstwin == 'yes'){
				$(document).click(function() {
					$('.speech-balloon-home').hide();
					$.ajax({
				         url: "/firstwin"
				    });
				});
				
				$('.speech-balloon-home').removeClass('hide').animate({'margin-top': '-1.4rem'}, 500);
			}

			$('.downIcon').click(function () {
				$('.cardHeader').css({ 'z-index': '11' });
				being.wrapShow('.cardBody');
				$('.slideMore').fadeIn(150);
			});

			$('.slideMore .close').click(function () {
			
				$('.slideMore').fadeOut(150);
				being.wrapHide('.cardBody', () => {
					$('.cardHeader').removeAttr('style');
				});
			});
			
			$('.showQuan').click((e) => {
				$('.cutBtn img').attr('src', " {{ asset('/test/main/images/btn-1.png') }} ");
				var target = $(e.target).closest('.inBox').length;
				console.log(target);
				if (target > 0) {
					return;
				} else {
					being.scaleHide('.showQuan');
					being.wrapHide();
				}
			});

			$("body").on("click",".mset a.showvoucher",function(e) {
			//$("body").on("click",".showvoucher",function(){
				$( ".copyvoucher" ).html($(this).data('voucher'));
				var dd = $(this).data('imgurl');
				$("#showIcon").attr("src",dd);
				being.wrapShow();
				being.scaleShow('.showQuan');
			});
			
			$("body").on("click",".mset a.type",function(e) {
				being.wrapShow();
				being.scaleShow('.showTips');
			});
			
			$('.showTips').click((e) => {
				var target = $(e.target).closest('.inBox').length;
				console.log(target);
				if (target > 0) {
					return;
				} else {
					being.scaleHide('.showTips');
					being.wrapHide();
				}
			});

			$("body").on("click",".imgBox",function(){
				// item_id       = $(this).data('tt_id');
				// product_name  = $(this).data('tt_product_name');
				// product_price = $(this).data('tt_product_price');
				// product_img   = $(this).data('tt_product_img');
				// product_discount_price   = $(this).data('tt_product_discount_price');
				// voucher_price = $(this).data('tt_voucher_price');
				// showBao(item_id,product_name,product_price,product_img,product_discount_price,voucher_price);

				// being.wrapShow();
				// being.scaleShow('.showTips');
				$("#showIcon").attr("src",$(this).data('imgurl'));
				
				$( ".copyvoucher" ).html($(this).data('voucher'));
				being.wrapShow();
				being.scaleShow('.showQuan');
			});

			function showBao(item_id,product_name,product_price,product_img,product_discount_price,voucher_price)
			{
				being.wrapShow();
				document.getElementById("product_name").textContent = product_name;
				// $(this).find("#product_name").innerHTML = product_name;
				document.getElementById("product_price").textContent = '淘宝原价：￥' + product_price;
				document.getElementById("product_discount_price").textContent = '优惠价：' + product_discount_price + '元';
				document.getElementById("product_img").src = product_img;
				document.getElementById("voucher_price").textContent = Math.round((product_price - voucher_price) * 10);

				being.scaleShow('.showBao');
			}

			$('.showBao').click((e) => {
				var target = $(e.target).closest('.inBox').length;
				console.log(target);
				if (target > 0) {
					return;
				} else {
					being.scaleHide('.showBao');
					being.wrapHide();
				}
			});

			var clipboard = new ClipboardJS('.cutBtn', {
				target: function () {
					return document.querySelector('#cut');
				}
			});
			clipboard.on('success', function (e) {
				console.log(e);
				$('.cutBtn img').attr('src', " {{ asset('/test/main/images/btn-2.png') }} ");
			});

			clipboard.on('error', function (e) {
				console.log(e);
				$('.cutBtn img').attr('src', " {{ asset('/test/main/images/btn-2.png') }} ");
			});

			being.scrollBottom('.cardBody', '.box', () => {			
				page++;
				var max_page = parseInt($('#max_page').val());
				if(page > max_page) {
					$('#page').val(page);
					$(".isnext").html("@lang('dingsu.end_of_result')");
					$('.isnext').css('padding-bottom', '50px');

				}else{
					getPosts(page);
				}	
			});
		})

		$('ul.pagination').hide();
		
		var page=1;
		
		/*$('.cardBody').on('scroll', function() {
        	if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {            
				//scroll
			}
		})*/
				
		function getPosts(page){
			$.ajax({
				type: "GET",
				url: window.location+"/?page"+page, 
				data: { page: page },
				beforeSend: function(){ 
				},
				complete: function(){ 
				  $('#loading').remove
				},
				success: function(responce) { 
					$('.list-2').append(responce.html);
				}
			 });
		}
		
	</script>

</body>

</html>