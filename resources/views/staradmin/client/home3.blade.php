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
	<link rel="stylesheet" href="{{ asset('/client/unpkg.com/flickity@2/dist/flickity.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/client/fontawesome-free-5.5.0-web/css/all.css') }}" >
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
<script type="text/javascript" src="//js.users.51.la/19985793.js"></script>
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
<input type="hidden" id="initialIndex" value="{{ $cid }}" />

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
					<li class="dbox0"><a href="/newsearch" style="color: white; font-size: 0.3rem;"><img src="{{ asset('/client/images/search_btn.png') }}" style="height: 0.3rem;"> 搜索</a></li>

					
				</ul>
				<div class="main rel">
					<div class="dbox">
						<div class="dbox1 txt">
							<div class="carousel">
							{{$current_cat_name = null}}
							@if(isset($category))
								@foreach($category as $cat)
									
									@if($cat->display_name == '文娱车品' || $cat->display_name == '数码电器')								
										@if ($cat->id == $cid)
											<a class="carousel-cell on is-selected carousel-cell-long" href="/cs/{{$cat->id}}">{{$cat->display_name}}</a>
											@php @$current_cat_name = $cat->display_name @endphp
										@else
											<a class="carousel-cell carousel-cell-long" href="/cs/{{$cat->id}}">{{$cat->display_name}}</a>
										@endif
									@else
										@if ($cat->id == $cid)
											<a class="carousel-cell on is-selected" href="/cs/{{$cat->id}}">{{$cat->display_name}}</a>
											@php @$current_cat_name = $cat->display_name @endphp
										@else
											<a class="carousel-cell" href="/cs/{{$cat->id}}">{{$cat->display_name}}</a>
										@endif
									@endif

								@endforeach
							@else
								<a class="on">精选</a>
								<a class="carousel-cell">男装</a>
								<a class="carousel-cell">鞋帽</a>
								<a class="carousel-cell">女装</a>
								<a class="carousel-cell">食饮</a>
								<a class="carousel-cell">没装</a>
							@endif
							</div>							
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
						<h2>今日{{ is_null($current_cat_name) ? "精选" : $current_cat_name }}销量榜单</h2>
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

		<div class="speech-balloon-home hide">你有{{ isset(Auth::Guard('member')->user()->current_life) ? Auth::Guard('member')->user()->current_life : 0}}次机会，可赚{{ isset(Auth::Guard('member')->user()->current_life) ? Auth::Guard('member')->user()->current_life * 15 : 0}}元免单红包</div>
		@include('layouts/footer')

		<!-- 领取优惠券  -->
		<div class="showQuan dflex scaleHide">
			<div class="inBox" style="padding-bottom: 0.2rem;">
				<img id="showIcon" src="{{ asset('/test/main/images/showIcon.png') }}" class="icon">
				<div class="AfterDiscount">
					<span class="caption1">卷后￥</span>
					<span class="caption2">39</span>
				</div>
				<!-- <h2>点击下面复制按钮，打开淘宝APP领券</h2> -->

				
					<!-- <h3 id="cut" class="copyvoucher">￥K8454DFGH45H</h3> -->
					<div class="div_product_name">Product name</div>
					<div class="div_product_details">
						<span class="span_highlight">优惠卷 ￥<span class="span_voucher_price"></span></span> | 淘宝价 ￥<span class="span_price"></span>
					</div>
					

					<img class="caption_redeem_angpao" src="{{ asset('/client/images/caption_redeem_angpao.png') }}" />
					<div id="button-wrapper">
						<img class="btn-product-details" src="{{ asset('/client/images/btn-redeem.png') }}" />
						<div id="btn-copy"></div>
						<div id="btn-voucher" class="freeVoucherBtn"></div>
					</div>
					<h4 style="font-size: 0;">优惠卷代码 <span id="cut" class="copyvoucher">￥K8454DFGH45H</span></h4>

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
									<div class="instructions">
										<ul>
											<li>
												<img src="/client/images/list-image.png" width="14px" height="18px" />
												<span class="highlight">新人红包</span>
												<img src="/client/images/list-label.png" width="42px" height="14px" /></li>
											<li style="padding-bottom: 10px">注册送2次免单转盘，每次可赚15元，2次可以赚30元。</li>
											<li>
												<img src="/client/images/list-image.png" width="14px" height="18px" />
												<span class="highlight">分享越多 赚越多</span>
												<img src="/client/images/list-label.png" png" width="42px" height="14px" /></li>
											<li>邀请好友注册送1次转盘，你邀请的好友每邀请1个人，你还能获得1次转盘。<br>如果你邀请10个好友，每个好友也邀请10个。你就有110次转盘机会，赚1650元。</li>
										</ul>
									</div>
									<a href="/arcade">
										<div class="btn-wabao">进入幸运转盘</div>
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
	<script src="{{ asset('/client//unpkg.com/flickity@2/dist/flickity.pkgd.min.js') }}"></script>
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

			var initialIndex = $('#initialIndex').val();
			var $carousel = $('.carousel').flickity({
					prevNextButtons: false,
					pageDots: false,
					contain: true,
					initialIndex: initialIndex
				});

			$carousel.on( 'staticClick.flickity', function( event, pointer, cellElement, cellIndex ) {
			  if ( typeof cellIndex == 'number' ) {
			    $carousel.flickity( 'selectCell', cellIndex );
			  }
			});

			//removed not require to show
			// var firstwin = $('#firstwin').val();
			// console.log(firstwin);

			// if(firstwin == 'yes'){
			// 	$(document).click(function() {
			// 		$('.speech-balloon-home').hide();
			// 		$.ajax({
			// 	         url: "/firstwin"
			// 	    });
			// 	});
				
			// 	$('.speech-balloon-home').removeClass('hide').animate({'margin-top': '-1.4rem'}, 500);
			// }

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
				$('.btn-product-details').attr('src', '/client/images/btn-redeem.png');
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
				$( ".caption2" ).html($(this).data('tt_product_discount_price'));
				$( ".div_product_name" ).html($(this).data('tt_product_name'));
				$( ".span_price" ).html($(this).data('tt_product_price'));
				$( ".span_voucher_price" ).html($(this).data('tt_voucher_price'));
				
				being.wrapShow();
				being.scaleShow('.showQuan');
			});

			$('.freeVoucherBtn').click((e) => {
				being.wrapShow();
				being.scaleHide('.showQuan');
				being.scaleShow('.showTips');
			});

			//call from footer
			$('.main-footer').click((e) => {
				being.wrapShow();
				being.scaleHide('.showQuan');
				being.scaleShow('.showTips');
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

				$( ".caption2" ).html($(this).data('tt_product_discount_price'));
				$( ".div_product_name" ).html($(this).data('tt_product_name'));
				$( ".span_price" ).html($(this).data('tt_product_price'));
				$( ".span_voucher_price" ).html($(this).data('tt_voucher_price'));		

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

			var clipboard = new ClipboardJS('#btn-copy', {
				target: function () {
					return document.querySelector('#cut');
				}
			});
			clipboard.on('success', function (e) {
				console.log(e);
				$('.btn-product-details').attr('src', '/client/images/btn-copy-code.png');
			});

			clipboard.on('error', function (e) {
				console.log(e);
				$('.btn-product-details').attr('src', '/client/images/btn-copy-code.png');
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